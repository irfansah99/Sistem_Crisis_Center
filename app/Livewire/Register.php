<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\EmailUserVerivied;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class Register extends Component
{
    public $name, $email, $phone, $address, $password, $password_confirmation;
    public $id, $otp;
    public $OpenVerifikasi;
    public $Openkirimulang = false;
    public $email_new;
    public $lagiupdate = false;

    public function create()
    {
        $validatedData = $this->validate([
            'name'     => 'required|min:5',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email'),
                Rule::unique('admins', 'email'),
                Rule::unique('instansi', 'email'),
            ],
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
        $this->id = $user->id;
        $this->email_new = $user->email;

        $user->notify(new EmailUserVerivied($otp));

        session(['user_id_verif' => $user->id]);

        $this->OpenVerifikasi = "Open";
    }
    public function mount()
    {
        $this->id = session('user_id_verif');

        if ($this->id) {
            $this->OpenVerifikasi = "Open";
            $user = User::findOrFail($this->id);
            $this->email_new = $user->email;
        }
    }
    public function verifikasi()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::find($this->id ?? session('user_id_verif'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi sudah habis. Silakan ke halaman login untuk mendapat verifikasi ulang.');
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            $this->Openkirimulang = true;
            return back()->with('error', 'Waktu OTP telah habis. Silakan minta ulang kode verifikasi.');
        }

        if (!Hash::check($this->otp, $user->otp)) {
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
    public function isiulang()
    {
        $id = session('user_id_verif');

        if (!$id) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi sudah habis, silakan daftar ulang.');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('register')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $this->id = $user->id;
        $this->OpenVerifikasi = null;
        $this->lagiupdate = true;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->dispatch(
            'sweet-alert',
            icon: 'info',
            title: 'Silakan perbarui data kamu sebelum kirim ulang verifikasi.'
        );
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name'     => 'required|min:5',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
                Rule::unique('admins', 'email'),
                Rule::unique('instansi', 'email'),
            ],
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'nullable|min:6|confirmed',
        ]);
        if (!empty($this->password)) {
            $validatedData['password'] = Hash::make($this->password);
        } else {
            unset($validatedData['password']);
        }
        $user = User::findOrFail($this->id);
        $emailChanged = $validatedData['email'] !== $user->email;
        if ($emailChanged) {
            $otp = rand(100000, 999999);
            $expiresAt = now()->addMinutes(5);
    
            $validatedData['otp'] = Hash::make($otp);
            $validatedData['otp_expires_at'] = $expiresAt;
            $validatedData['email_verified_at'] = null;
            $this->email_new = $user->name;
            $user->notify(new EmailUserVerivied($otp));

        }

        $user->update($validatedData);


        session(['user_id_verif' => $user->id]);
        $this->OpenVerifikasi = "Open";
    }
    public function KirimUlang()
    {
        $user = User::find($this->id ?? session('user_id_verif'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi telah habis. Silakan daftar ulang.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email kamu sudah diverifikasi.');
        }
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $user->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => $expiresAt,
        ]);

        $user->notify(new EmailUserVerivied($otp));

        session(['user_id_verif' => $user->id]);
        $this->Openkirimulang = false;
        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email kamu.');
    }
    public function render()
    {
        return view('livewire.register');
    }
}
