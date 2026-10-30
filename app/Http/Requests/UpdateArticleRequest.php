<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content'     => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'tags'        => ['nullable', 'string'], 
        ];
    }
}