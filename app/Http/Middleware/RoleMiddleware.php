<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // Cek apakah user sudah login
        if (!$user) {
            abort(401, 'Anda harus login terlebih dahulu');
        }

        // Parse roles - Laravel mengirim 'admin|superadmin' sebagai satu parameter
        $allowedRoles = [];
        foreach ($roles as $role) {
            // Jika role mengandung |, split menjadi array
            if (strpos($role, '|') !== false) {
                $allowedRoles = array_merge($allowedRoles, explode('|', $role));
            } else {
                $allowedRoles[] = $role;
            }
        }

        // Cek apakah user memiliki role yang diizinkan
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}