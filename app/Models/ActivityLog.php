<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use App\Services\WorkspaceResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory, BelongsToWorkspace;

    public $timestamps = false;

    protected $fillable = [
        'workspace_id',
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'metadata',
        'ip_hash',
        'created_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, ?array $metadata = null, ?Model $subject = null): self
    {
        $ip = request()?->ip();
        $ipHash = $ip ? hash('sha256', $ip) : null;
        $user = Auth::user();
        $workspaceId = $user?->workspace_id ?? WorkspaceResolver::currentId();

        return static::create([
            'workspace_id' => $workspaceId,
            'user_id' => $user?->id,
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'metadata' => $metadata,
            'ip_hash' => $ipHash,
            'created_at' => now(),
        ]);
    }
}
