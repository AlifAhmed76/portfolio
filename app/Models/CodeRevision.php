<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeRevision extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code_file_id',
        'revision_number',
        'content',
        'hash',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function codeFile(): BelongsTo
    {
        return $this->belongsTo(CodeFile::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
