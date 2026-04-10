<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $role = session('active_role', auth()->user()->role);

        if (!in_array($role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
