<?php

namespace App\Http\Middleware;

use App\Services\WorkspaceResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveWorkspace
{
    public function handle(Request $request, Closure $next): Response
    {
        WorkspaceResolver::resolve();

        return $next($request);
    }
}
