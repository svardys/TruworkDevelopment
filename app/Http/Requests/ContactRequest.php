<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            'name' => 'required|alpha',
            'surname' => 'required|alpha',
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Povinné pole',
            'name.alpha' => 'Nepovolenné znaky',
            'surname.required' => 'Povinné pole',
            'surname.alpha' => 'Nepovolenné znaky',
            'email.required' => 'Povinné pole',
            'email.email' => 'Nevalidní email',
            'phone.required' => 'Povinné pole',
            'phone.string' => 'Nepovolenné znaky',
            'subject.required' => 'Povinné pole',
            'subject.string' => 'Nepovolenné znaky',
            'message.required' => 'Povinné pole',
            'message.string' => 'Nepovolenné znaky',
            'message.max' => 'Maximální počet znaků je: 500',
        ];
    }
}
