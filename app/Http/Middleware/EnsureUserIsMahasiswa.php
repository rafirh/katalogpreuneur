<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMahasiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->isMahasiswa()) {
            abort(403, 'Halaman ini hanya dapat diakses mahasiswa penjual.');
        }

        return $next($request);
    }
}
