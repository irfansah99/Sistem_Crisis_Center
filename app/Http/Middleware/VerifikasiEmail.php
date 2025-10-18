<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class VerifikasiEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->email_verified_at === null) {
            return redirect()->route('profil.edit')
                ->with('warning', 'Harap verifikasi email Anda terlebih dahulu sebelum melanjutkan.');
        }
        return $next($request);
    }
}
