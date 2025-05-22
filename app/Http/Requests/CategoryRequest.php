<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users (adjust if needed)
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string','regex:/^[a-zA-Z\s]+$/'],
            'description' => ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ' Name Required',
            'name.regex'    => 'Only letters and spaces are allowed for the category name.',
            'description.required' => 'Description Required',
        ];
    }
}
