<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeranMiddleware
{
public function handle(Request $request, Closure $next, ...$roles): Response
{
    $user = auth()->user();

    // Flatten roles jika menggunakan format pipe (|)
    $allowedRoles = [];
    foreach ($roles as $role) {
        if (str_contains($role, '|')) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        } else {
            $allowedRoles[] = $role;
        }
    }

    if (!$user || !in_array($user->peran, $allowedRoles)) {
        abort(403, 'Akses ditolak');
    }

    return $next($request);
}

}
