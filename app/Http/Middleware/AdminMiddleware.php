<?php

namespace App\Http\Middleware;

use Closure;
// Pastikan tidak ada typo di baris bawah ini
use Illuminate\Http\Request; 
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan Auth::check() untuk lebih stabil
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses khusus admin');
        }

        return $next($request);
    }
}