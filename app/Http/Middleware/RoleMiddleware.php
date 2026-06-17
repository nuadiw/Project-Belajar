<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
        return redirect('login');
    }

    // Cek apakah role user ada di dalam daftar role yang diizinkan (parameter $roles)
    if (in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }

    // Jika tidak punya akses
    abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
