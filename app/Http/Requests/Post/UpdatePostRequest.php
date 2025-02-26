<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title'   => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'status'  => 'sometimes|required|in:pending,approved,rejected',
            'published_at' => 'nullable|date',
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
