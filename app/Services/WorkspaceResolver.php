<?php

namespace App\Services;

use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class WorkspaceResolver
{
    public static function resolve(): ?Workspace
    {
        if (! Schema::hasTable('workspaces')) {
            return null;
        }

        // 1. If an authenticated user belongs to a workspace, scope to their workspace
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->workspace_id) {
                $workspace = Workspace::find($user->workspace_id);
                if ($workspace) {
                    return $workspace;
                }
            }
        }

        // 2. Default workspace resolution for public requests or platform owner
        return Workspace::where('slug', 'default')
            ->orWhere('status', 'active')
            ->orderBy('id', 'asc')
            ->first();
    }

    public static function currentId(): ?int
    {
        return static::current()?->id;
    }

    // Explicit override support for tests/multi-tenant context switches
    protected static ?Workspace $explicitWorkspace = null;

    public static function setCurrent(?Workspace $workspace): void
    {
        static::$explicitWorkspace = $workspace;
    }

    public static function clear(): void
    {
        static::$explicitWorkspace = null;
    }

    public static function current(): ?Workspace
    {
        return static::$explicitWorkspace ?? static::resolve();
    }
}
