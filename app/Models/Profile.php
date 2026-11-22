<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'name',
        'designation',
        'headline',
        'bio',
        'profile_image_id',
        'avatar_image_id',
        'resume_media_id',
    ];

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'avatar_image_id');
    }

    public function profileImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'profile_image_id');
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'resume_media_id');
    }
}
