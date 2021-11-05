<?php

use App\Http\Controllers\Api\GalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/galleries', [GalleryController::class, 'list']);
    Route::get('/admin/galleries/{id}', [GalleryController::class, 'edit']);
    Route::post('/admin/galleries', [GalleryController::class, 'store']);
    Route::post('/admin/galleries/edit/{id}', [GalleryController::class, 'update']);
    Route::delete('/admin/galleries/{id}',[GalleryController::class, 'destroy']);
});

Route::get('/galleries',[GalleryController::class,'index']);
Route::get('/galleries/{slug}',[GalleryController::class,'show']);

Route::middleware(['throttle:contact'])->group(function () {
    Route::post('/contact', [ContactController::class, 'contact']);
});


