<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'width',
        'height',
        'alt_text',
        'processing_status',
    ];

    protected $appends = ['url'];

    public function attachments(): HasMany
    {
        return $this->hasMany(MediaAttachment::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isReferenced(): bool
    {
        if ($this->attachments()->exists()) {
            return true;
        }

        if (Profile::where('profile_image_id', $this->id)
            ->orWhere('avatar_image_id', $this->id)
            ->orWhere('resume_media_id', $this->id)
            ->exists()) {
            return true;
        }

        if (Project::where('cover_image_id', $this->id)->exists()) {
            return true;
        }

        return false;
    }
}
