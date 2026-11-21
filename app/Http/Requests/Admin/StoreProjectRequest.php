<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255',
                Rule::unique('projects', 'slug')->ignore($projectId),
            ],
            'category_id' => ['nullable', 'integer', 'exists:project_categories,id'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'cover_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['integer', 'exists:skills,id'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'implementation' => ['nullable', 'string'],
            'outcome' => ['nullable', 'string'],
            'links' => ['nullable', 'array'],
            'links.*.link_type' => ['required_with:links.*.url', 'string', 'in:live,github,demo,doc,external'],
            'links.*.label' => ['required_with:links.*.url', 'string', 'max:100'],
            'links.*.url' => ['required_with:links.*.label', 'url', 'max:500'],
        ];
    }
}
