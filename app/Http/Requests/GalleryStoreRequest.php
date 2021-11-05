<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required,integer',
            'title' => ['required', 'max:64', Rule::unique('galleries')],
            'category' => ['required', Rule::in([1, 2, 3, 4])],
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Povinný parametr',
            'id.integer' => 'Nevalidní hodnota parametru',
            'title.unique' => 'Galerie s daným názvem již existuje',
            'title.required' => 'Povinné pole',
            'title.max' => 'Název galerie nemůže být delší než 64 znaků',
            'category.required' => 'Povinné pole',
            'category.in' => 'Nevalidní hodnota',
            'thumbnail.required' => 'Povinné pole',
            'thumbnail.image' => 'Soubor musí být obrázek typu: jpeg, jpg nebo png',
            'thumbnail.mimes' => 'Soubor musí být obrázek typu: jpeg, jpg nebo png',
            'images.required' => 'Povinné pole',
            'images.array' => 'Nevalidní hodnota',
            'images.*.required' => 'Povinné pole',
            'images.*.image' => 'Soubory musí být obrázky typu: jpeg, jpg nebo png',
            'images.*.mimes' => 'Soubory musí být obrázky typu: jpeg, jpg nebo png',
        ];
    }
}
