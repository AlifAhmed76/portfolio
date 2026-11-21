<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodeFile extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'relative_path',
        'file_type',
        'current_hash',
        'last_modified_by',
    ];

    public function revisions(): HasMany
    {
        return $this->hasMany(CodeRevision::class)->orderByDesc('revision_number');
    }

    public function lastModifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by');
    }
}
