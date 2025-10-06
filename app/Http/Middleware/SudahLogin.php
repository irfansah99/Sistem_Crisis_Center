<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class SudahLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            return redirect('/beranda');
        }

        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
        if (Auth::guard('instansi')->check()) {
            return redirect('/instansi/dashboard');
        }
        return $next($request);
    }
}
