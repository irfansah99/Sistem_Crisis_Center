<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Notifications\EmailAdmminVerified;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditProfilAdmin extends Component
{
    use WithFileUploads;
    public $name, $email, $phone, $image, $password, $password_confirmation;

    public $OpenVerifikasi = false;
    public $Openkirimulang = false;
    public $otp;
    public $oldImagePath; 

    public function mount()
    {
        $id = Auth::user('admin')->id;
        $admin = Admin::findOrFail($id);
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->oldImagePath = $admin->image; 

        if (session('admin_id_verif')) {
            $this->OpenVerifikasi = true;
        }
        if (
            $admin->email_verified_at === null &&
            $admin->otp_expires_at !== null &&
            Carbon::now()->gt($admin->otp_expires_at)
        ) {
            $this->Openkirimulang = true;
        }
    }


        public function update()
        {
            $id = Auth::user('admin')->id;
            $admin = admin::findOrFail($id);

            $rules = [
                'name'     => 'required|min:5',
                'email'    => [
                    'required',
                    'email',
                    Rule::unique('users', 'email'),
                    Rule::unique('admins', 'email')->ignore($id),
                    Rule::unique('instansi', 'email'),
                ],
                'phone'    => 'required|digits_between:10,15',
                'password' => 'nullable|min:6|confirmed',
                'image'    => 'nullable|image|file|max:2048',
            ];
            $validatedData = $this->validate($rules);
            $emailChanged = $validatedData['email'] !== $admin->email;

            if (!empty($this->password)) {
                $validatedData['password'] = Hash::make($this->password);
            } else {
                unset($validatedData['password']);
            }
    

            if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                if (!empty($admin->image)) {
                    Storage::disk('public')->delete($admin->image);
                }
            
                $validatedData['image'] = $this->image->store('admin_images', 'public');
            } else {
                unset($validatedData['image']);
            }
            
            if ($emailChanged) {
                $otp = rand(100000, 999999);
                $expiresAt = now()->addMinutes(5);

                $admin->update([
                    'otp' => Hash::make($otp),
                    'otp_expires_at' => $expiresAt,
                    'email_verified_at' => null,
                    'email' => $this->email,
                ]);


                $admin->notify(new EmailAdmminVerified($otp));

                session(['admin_id_verif' => $admin->id]);

                return $this->OpenVerifikasi = true;
            }

            $admin->update($validatedData);
            return redirect()->route('admin.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
        }
    public function verifikasi()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        $admin = Admin::find($this->id ?? session('admin_id_verif'));

        if (!$admin) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi sudah habis. Silakan ke halaman login untuk mendapat verifikasi ulang.');
        }

        if (Carbon::now()->gt($admin->otp_expires_at)) {
            $this->Openkirimulang = true;
            return back()->with('error', 'Waktu OTP telah habis. Silakan minta ulang kode verifikasi.');
        }

        if (!Hash::check($this->otp, $admin->otp)) {
            return back()->with('error', 'Kode OTP yang kamu masukkan salah.');
        }

        $admin->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        session()->forget('admin_id_verif');

        return redirect()->route('admin.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
    }
    public function KirimUlang()
    {
        $admin = Admin::find($this->id ?? session('admin_id_verif'));

        if (!$admin) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi telah habis. Silakan daftar ulang.');
        }

        if ($admin->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email kamu sudah diverifikasi.');
        }
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $admin->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => $expiresAt,
        ]);

        $admin->notify(new EmailAdmminVerified($otp));

        session(['admin_id_verif' => $admin->id]);
        $this->Openkirimulang = false;
        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email kamu.');
    }
    public function render()
    {
        $id = Auth::user('admin')->id;
        return view('livewire.edit-profil-admin', [
            'edit'=> Admin::findOrFail($id)
        ]);
    }
}
