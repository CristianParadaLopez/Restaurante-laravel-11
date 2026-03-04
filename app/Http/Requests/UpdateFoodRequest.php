<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends FormRequest
{
    public function authorize()
{
    return true;
}
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string|max:500',
            'proteins' => 'nullable|string|max:255',
            'calories' => 'nullable|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
