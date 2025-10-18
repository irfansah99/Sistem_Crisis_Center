<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $id = Auth::user()->id;


        $user = User::findOrFail($id);
        return view('user/profil/edit', [
            'judul' => 'Edit Profil',
            'edit' =>  $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Auth::user()->id;

        $user = User::findOrFail($id);

        $rules = [
            'name'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email,' . $id . ',id',
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'nullable|min:6|confirmed',
            'image'    => 'nullable|image|file|max:2048',
        ];

        $validatedData = $request->validate($rules);
        $emailChanged = $validatedData['email'] !== $user->email;

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        if ($request->file('image')) {
            if ($request->fotoold) {
                Storage::delete($request->fotoold);
            }
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        // 🔹 Kalau email berubah → reset verifikasi dan kirim ulang OTP
        if ($emailChanged) {
            $validatedData['email_verified_at'] = null;
            $user->update($validatedData);

            // Simpan ID user ke session agar halaman verifikasi tahu siapa yang diverifikasi
            session(['user_id_verif' => $user->id]);

            // Panggil fungsi kirim ulang OTP dari RegisterController
            app(RegisterController::class)->KirimUlang();

            // Logout supaya tidak bisa akses halaman lain sebelum verifikasi
            Auth::logout();

            // Redirect ke halaman verifikasi email
            return redirect()
                ->route('verifikasi_email')
                ->with('info', 'Kami telah mengirim kode OTP ke email baru kamu. Silakan verifikasi terlebih dahulu.');
        }

        // 🔹 Jika email tidak berubah → update biasa
        $user->update($validatedData);

        return redirect()->route('beranda.index')->with('success', 'Profil berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
