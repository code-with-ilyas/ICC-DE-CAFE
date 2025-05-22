<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Select a Category',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Product Name  Required',
            'name.string' => 'Product name must be text.',
            'name.max' => 'Product name cannot be longer than 100 characters.',
            'description.required' => 'Description Required',
            'price.required' => 'Price  Required.',
            'price.numeric' => 'Product price must be a valid number.',
            'price.min' => 'Product price cannot be negative.',
            'is_available.boolean' => 'Availability must be true or false.',
        ];
    }
}
