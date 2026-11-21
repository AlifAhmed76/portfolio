<?php

namespace App\Http\Middleware;

use App\Services\WorkspaceResolver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('admin.login'));
        }

        $user = Auth::user();

        if (! $user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account is deactivated. Please contact the administrator.',
            ]);
        }

        if (! $user->isAdmin()) {
            abort(403, 'Unauthorized access to the administration area.');
        }

        WorkspaceResolver::resolve();

        return $next($request);
    }
}
