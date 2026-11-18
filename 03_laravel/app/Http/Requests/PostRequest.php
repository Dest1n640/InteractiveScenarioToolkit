<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        $required = $this->isMethod('PATCH') ? 'sometimes|required' : 'required';

        return [
            'category_id' => "$required|integer|exists:categories,id",
            'title' => "$required|string|max:255",
            'body' => "$required|string",
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }

    public function tagIds(): ?array
    {
        return $this->validated('tags', $this->isMethod('PATCH') ? null : []);
    }
}
