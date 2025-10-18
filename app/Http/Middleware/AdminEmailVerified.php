<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user('admin')->email_verified_at === null) {
            return redirect()->route('admin.profil.edit')
                ->with('warning', 'Harap verifikasi email Anda terlebih dahulu sebelum melanjutkan.');
        }
        return $next($request);
    }
}
