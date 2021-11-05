<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryIndexRequest extends FormRequest
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
            'category' => ['required', Rule::in(['kuchyne','vestavene_skrine','komercni_prostory','ostatni'])]
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Povinný parametr',
            'category.in' => 'Nevalidní hodnota parametru'
        ];
    }
}
