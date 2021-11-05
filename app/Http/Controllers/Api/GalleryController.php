<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryDeleteRequest;
use App\Http\Requests\GalleryIndexRequest;
use App\Http\Requests\GalleryStoreRequest;
use App\Http\Requests\GalleryUpdateRequest;
use App\Http\Resources\AdminResources\GalleryEditResource;
use App\Http\Resources\AdminResources\GalleryListResource;
use App\Http\Resources\PublicResources\GalleryShowResource;
use App\Http\Resources\PublicResources\GalleryIndexResource;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\Utils\DateTime;
use Throwable;

class GalleryController extends Controller
{

    public function list()
    {
        try {

            return GalleryListResource::collection(Gallery::with(
                ['user', 'category', 'images' => function ($query) {
                    $query->where('thumbnail', 1);
                }])->orderBy('created_at', 'DESC')->get());

        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Chyba při získávání seznamu galerií'], 500);

        }
    }

    public function index(GalleryIndexRequest $request)
    {
        try {

            $category = $request->query('category');

            $galleries = Gallery::with(
                ['category', 'images' => function ($query) {
                    $query->where('thumbnail', 1);
                }])->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);

            })->orderBy('created_at', 'DESC')->get();

            if ($galleries->isNotEmpty()) {

                return GalleryIndexResource::collection($galleries);

            } else {

                return response()->json(['message' => 'Neexistují galerie s danou kategorií'], 404);

            }
        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Chyba při získávání galerií'], 500);

        }
    }

    public function store(GalleryStoreRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = Auth::id();
            $slug = Str::slug($request->title);

            $gallery = new Gallery([
                'user_id' => $user,
                'category_id' => $request->category,
                'title' => $request->title,
                'slug' => $slug
            ]);

            $gallery->save();

        } catch (Throwable $e) {

            DB::rollback();

            report($e);

            return response()->json(['message' => 'Chyba při vytváření galerie'], 500);

        }
        try {

            $imagesToSave = array();
            $thumbnail_file = $request->file('thumbnail');
            $imagesToSave[] = new Image([
                'user_id' => $user,
                'original_name' => $thumbnail_file->getClientOriginalName(),
                'path' => $thumbnail_file->store("images/galleries/$gallery->id", 'public'),
                'extension' => $thumbnail_file->extension(),
                'size' => $thumbnail_file->getSize(),
                'thumbnail' => true
            ]);

            foreach ($request->file('images') as $image) {

                $path = $image->store("images/galleries/$gallery->id", 'public');

                $imagesToSave[] = new Image([
                    'user_id' => $user,
                    'original_name' => $image->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $image->extension(),
                    'size' => $image->getSize(),
                    'thumbnail' => false
                ]);
            }
            $gallery->images()->saveMany($imagesToSave);

            DB::commit();

            return response()->json([
                'message' => 'Galerie vytvořena',
                'slug' => $slug
            ]);

        } catch (Throwable $e) {

            Storage::deleteDirectory("public/images/galleries/$gallery->id");

            DB::rollback();

            report($e);

            return response()->json(['message' => 'Chyba při vytváření galerie'], 500);

        }
    }

    public function show($slug)
    {
        try {

            return new GalleryShowResource(Gallery::with(['images','category'])->where('slug', $slug)->firstOrFail());

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Galerie nenalezena'], 404);

        }
    }

    public function edit($id)
    {
        try {

            return new GalleryEditResource(Gallery::where('id', $id)->with(['category', 'images'])->firstorfail());

        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Galerie nenalezena'], 404);

        }
    }

    public function update(GalleryUpdateRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = Auth::id();
            $slug = Str::slug($request->title);

            $gallery = Gallery::where('id', $request->id)->firstorfail();

            $updated_at = new DateTime($gallery->updated_at);
            $fetched_at = new DateTime($request->fetchedAt);

            if($updated_at > $fetched_at){

                DB::rollback();

                return response()->json([
                    'code' => 'DATA_CHANGED',
                    'message' => 'Galerie byla změněna'
                ], 400);
            }

            $gallery->user_id = $user;
            $gallery->title = $request->title;
            $gallery->category_id = $request->category;
            $gallery->slug = $slug;
            $gallery->save();


        } catch (Throwable $e) {

            DB::rollback();

            report($e);

            return response()->json(['message' => 'Galerie nenalezena'], 404);

        }

        if ($request->file('thumbnail')) {

            try {

                $thumbnail = $gallery->images()->where('thumbnail', '=', 1)->firstorfail();
                $current_thumbnail_path = $thumbnail->path;

                Storage::delete($current_thumbnail_path);

                $thumbnail_file = $request->file('thumbnail');
                $path = $thumbnail_file->store("images/galleries/$request->id", 'public');

                $thumbnail->user_id = $user;
                $thumbnail->original_name = $thumbnail_file->getClientOriginalName();
                $thumbnail->path = $path;
                $thumbnail->extension = $thumbnail_file->extension();
                $thumbnail->size = $thumbnail_file->getSize();
                $thumbnail->save();

            } catch (Throwable $e) {

                DB::rollback();

                report($e);

                return response()->json(['message' => 'Chyba při ukládání náhledového obrázku'], 500);

            }

        }

        try {

            $images = DB::table('images')->where([
                'gallery_id' => $request->id,
                'thumbnail' => 0,
            ])->selectRaw('CAST(id as CHAR(50)) as id, path')->get()->toArray();

        } catch (Throwable $e) {

            DB::rollback();

            report($e);

            return response()->json(['message' => 'Chyba při ukládání obrázků'], 500);

        }

        if ($request->file('images')) {

            try {

                $imagesToSave = array();

                foreach ($request->file('images') as $image) {

                    $path = $image->store("images/galleries/$request->id", 'public');

                    $imagesToSave[] = new Image([
                        'user_id' => $user,
                        'original_name' => $image->getClientOriginalName(),
                        'path' => $path,
                        'extension' => $image->extension(),
                        'size' => $image->getSize(),
                        'thumbnails' => false
                    ]);
                }

                $gallery->images()->saveMany($imagesToSave);

            } catch (Throwable $e) {

                DB::rollback();

                report($e);

                $imagesPaths = array_column($imagesToSave, 'path');

                foreach ($imagesPaths as $path) {

                    Storage::delete("public/$path");

                }

                return response()->json(['message' => 'Chyba při ukládání obrázků'], 500);

            }

        }

        try {

            $originalImagesIds = array_column($images, 'id');

            if ($originalImagesIds !== $request->originalImagesIds) {

                $originalImagesPaths = array_column($images, 'path');
                $imagesToDelete = array_diff($originalImagesIds, $request->originalImagesIds);

                foreach ($imagesToDelete as $key => $value) {
                    Storage::delete($originalImagesPaths[$key]);
                }

                $gallery->images()->whereIn('id', $imagesToDelete)->delete();

            }

            DB::commit();

            return response()->json([
                'message' => 'Galerie byla aktualizována',
                'slug' => $slug
            ]);

        } catch (Throwable $e) {

            DB::rollback();

            report($e);

            return response()->json(['message' => 'Chyba při aktualizování obrázků galerie'], 500);

        }

    }

    public function destroy(GalleryDeleteRequest $request)
    {
        try {

            Storage::deleteDirectory("public/images/galleries/$request->id");

            Gallery::where('id', $request->id)->firstOrFail()->delete();

            return response()->json(['message' => 'Galerie byla smazána']);

        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Došlo k chybě při mazání galerie'], 500);

        }
    }
}
