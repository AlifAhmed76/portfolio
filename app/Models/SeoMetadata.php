<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMetadata extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $table = 'seo_metadata';

    protected $fillable = [
        'workspace_id',
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_image_id',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
