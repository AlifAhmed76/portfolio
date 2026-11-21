<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'name',
        'email',
        'subject',
        'message',
        'ip_address',
        'status',
    ];

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }
}
