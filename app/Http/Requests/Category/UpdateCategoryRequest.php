<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:255|unique:categories,name,' . $this->category,
            'description' => 'nullable|string',
        ];
    }
}
