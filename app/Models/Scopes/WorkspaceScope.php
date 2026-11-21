<?php

namespace App\Models\Scopes;

use App\Services\WorkspaceResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WorkspaceScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $workspaceId = WorkspaceResolver::current()?->id;
        if ($workspaceId !== null) {
            $builder->where($model->getTable().'.workspace_id', $workspaceId);
        }
    }
}
