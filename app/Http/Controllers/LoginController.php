<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'judul' => 'Login'
        ]);
    }
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user(); 
            if ($admin && $admin->email_verified_at === null) {
                session(['admin_id_verif' => $admin->id]); 
            }
            return redirect()->intended('/admin/dashboard');
        }
        if (Auth::guard('instansi')->attempt($credentials)) {
            $request->session()->regenerate();
            $instansi = Auth::guard('instansi')->user(); 
            if ($instansi && $instansi->email_verified_at === null) {
                session(['instansi_id_verif' => $instansi->id]); 
            }
            return redirect()->intended('/instansi/dashboard');
        }
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            if ($user->email_verified_at) {
                $request->session()->regenerate();
                return redirect()->intended('/beranda');
            } else {
                Auth::logout();
                session(['user_id_verif' => $user->id]);
                app(RegisterController::class)->KirimUlang();
                return redirect()->route('register.index')->with('info', 'Silakan verifikasi email terlebih dahulu.');
            }
        }



        return back()->with('loginerror', 'Login gagal, email atau password salah.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
