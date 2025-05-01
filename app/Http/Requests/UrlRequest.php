<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url'=>'required|string|max:255|unique:urls,original_url'
        ];
    }
    public function messages(): array
    {
        return [
            'url.required'=>'El Url es obligatorio',

            'url.unique'=>'El URL ya esta en uso.',
            
        ];
    }
}
