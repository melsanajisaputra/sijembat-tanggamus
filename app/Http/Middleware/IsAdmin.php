<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ pastikan user login dan role-nya admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // kalau bukan admin, kirim 403
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // ✅ wajib return response
        return $next($request);
    }
}
