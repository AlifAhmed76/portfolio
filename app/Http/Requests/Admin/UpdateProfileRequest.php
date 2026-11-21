<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255', 'not_regex:/\bSr\.?\b/i'],
            'headline' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'profile_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'avatar_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'resume_media_id' => ['nullable', 'integer', 'exists:media,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'designation.not_regex' => 'The designation must not contain "Sr." per specification guidelines.',
        ];
    }
}
