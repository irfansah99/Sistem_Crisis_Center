<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\EmailUserVerivied;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfilUser extends Component
{
    use WithFileUploads;
    public $name, $email, $phone, $address, $image, $password, $password_confirmation;

    public $OpenVerifikasi = false;
    public $Openkirimulang = false;
    public $otp;
    public $oldImagePath;
    public function mount()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->oldImagePath = $user->image;

        if (session('user_id_verif')) {
            $this->OpenVerifikasi = true;
        }
    }


    public function update()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $rules = [
            'name'     => 'required|min:5',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
                Rule::unique('admins', 'email'),
                Rule::unique('instansi', 'email'),
            ],
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'nullable|min:6|confirmed',
            'image'    => 'nullable|image|file|max:2048',
        ];

        $validatedData = $this->validate($rules);
        $emailChanged = $validatedData['email'] !== $user->email;

        if (!empty($this->password)) {
            $validatedData['password'] = Hash::make($this->password);
        } else {
            unset($validatedData['password']);
        }


        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            if (!empty($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $validatedData['image'] = $this->image->store('user_images', 'public');
        } else {
            unset($validatedData['image']);
        }

        if ($emailChanged) {
            $otp = rand(100000, 999999);
            $expiresAt = now()->addMinutes(5);

            $user->update([
                'otp' => Hash::make($otp),
                'otp_expires_at' => $expiresAt,
                'email_verified_at' => null,
                'email' => $this->email,
            ]);


            $user->notify(new EmailUserVerivied($otp));

            session(['user_id_verif' => $user->id]);

            return $this->OpenVerifikasi = true;
        }

        $user->update($validatedData);
        return redirect()->route('beranda.index')->with('success', 'Profil berhasil diperbarui!');
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

        return redirect()->route('beranda.index')->with('success', 'Profil berhasil diperbarui!');
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
        $id = Auth::user()->id;
        return view('livewire.edit-profil-user', [
            'edit' => User::findOrFail($id)
        ]);
    }
}
