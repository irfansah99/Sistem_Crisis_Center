<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailUserVerivied;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('registrasi.index', [
            'judul' => 'Register',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $validatedData['otp'] = Hash::make($otp);
        $validatedData['otp_expires_at'] = $expiresAt;
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $user->notify(new EmailUserVerivied($otp));

        session(['user_id_verif' => $user->id]);

        return redirect()->route('verifikasi_email')
            ->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
    }


    public function HalamanVerifikasi()
    {
        return view('registrasi.verifikasi_email', [
            'judul' => "Verifikasi Email",
        ]);
    }

    public function Verifikasi(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::find(session('user_id_verif'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi sudah habis. Silakan daftar ulang.');
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Waktu OTP telah habis. Silakan minta ulang kode verifikasi.');
        }

        if (!Hash::check($request->otp, $user->otp)) {
            return back()->with('error', 'Kode OTP yang kamu masukkan salah.');
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        session()->forget('user_id_verif');

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function KirimUlang()
    {
        $user = User::find(session('user_id_verif'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi telah habis. Silakan daftar ulang.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email kamu sudah diverifikasi.');
        }

        if (now() < $user->otp_expires_at) {
            return;
        }
        
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $user->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => $expiresAt,
        ]);

        $user->notify(new EmailUserVerivied($otp));

        session(['user_id_verif' => $user->id]);

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email kamu.');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
