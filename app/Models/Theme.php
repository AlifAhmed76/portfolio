<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'version',
        'manifest_json',
        'preview_media_id',
        'status',
    ];

    protected $casts = [
        'manifest_json' => 'array',
    ];

    public function previewMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'preview_media_id');
    }

    public function workspaceThemes(): HasMany
    {
        return $this->hasMany(WorkspaceTheme::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(ThemeSetting::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ThemeRevision::class);
    }
}
