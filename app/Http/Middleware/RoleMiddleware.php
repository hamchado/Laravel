<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        $userRole = $request->user()->role?->name;

        // ayham has access to everything
        if ($userRole === 'ayham') {
            return $next($request);
        }

        if (!in_array($userRole, $roles)) {
            abort(403, 'ليس لديك صلاحية الوصول لهذه الصفحة');
        }

        return $next($request);
    }
}
