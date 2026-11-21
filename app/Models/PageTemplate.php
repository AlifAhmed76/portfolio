<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'theme_id',
        'schema_json',
        'is_system',
        'version',
    ];

    protected $casts = [
        'schema_json' => 'array',
        'is_system' => 'boolean',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
