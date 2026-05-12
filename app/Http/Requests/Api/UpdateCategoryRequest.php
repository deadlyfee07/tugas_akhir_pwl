<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id ?? $this->route('category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,'.$id],
            'description' => ['nullable', 'string'],
        ];
    }
}
