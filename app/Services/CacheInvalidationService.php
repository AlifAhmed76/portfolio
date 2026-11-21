<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheInvalidationService
{
    public static function invalidateProfile(): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::forget("workspace_{$id}_profile");
        Cache::forget("workspace_{$id}_header");
        Cache::forget("workspace_{$id}_footer");
        Cache::forget("workspace_{$id}_homepage");
    }

    public static function invalidateProjects(?int $projectId = null): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::forget("workspace_{$id}_projects");
        Cache::forget("workspace_{$id}_featured_projects");
        Cache::forget("workspace_{$id}_homepage");
        if ($projectId) {
            Cache::forget("workspace_{$id}_project_{$projectId}");
        }
    }

    public static function invalidateSkills(): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::forget("workspace_{$id}_skills");
        Cache::forget("workspace_{$id}_homepage");
    }

    public static function invalidateServices(): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::forget("workspace_{$id}_services");
        Cache::forget("workspace_{$id}_homepage");
    }

    public static function invalidateSections(): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::forget("workspace_{$id}_sections");
        Cache::forget("workspace_{$id}_homepage");
    }

    public static function invalidateAll(): void
    {
        $id = WorkspaceResolver::currentId() ?? 1;
        Cache::flush();
    }
}

