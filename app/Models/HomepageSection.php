<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'section_key',
        'title',
        'content_json',
        'is_enabled',
        'sort_order',
    ];

    protected $casts = [
        'content_json' => 'array',
        'is_enabled' => 'boolean',
        'sort_order' => 'integer',
    ];
}
