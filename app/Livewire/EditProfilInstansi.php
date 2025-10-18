<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Notifications\EmailInstansiVerified;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfilInstansi extends Component
{
    use WithFileUploads;
    public $nama_instansi, $email, $phone, $image, $password, $password_confirmation;

    public $OpenVerifikasi = false;
    public $Openkirimulang = false;
    public $otp;
    public $oldImagePath; 

    public function mount()
    {
        $id = Auth::user('instansi')->id;
        $instansi = Instansi::findOrFail($id);
        $this->nama_instansi = $instansi->nama_instansi;
        $this->email = $instansi->email;
        $this->phone = $instansi->phone;
        $this->oldImagePath = $instansi->image; 

        if (session('instansi_id_verif')) {
            $this->OpenVerifikasi = true;
        }
        if (
            $instansi->email_verified_at === null &&
            $instansi->otp_expires_at !== null &&
            Carbon::now()->gt($instansi->otp_expires_at)
        ) {
            $this->Openkirimulang = true;
        }
        
    }   


        public function update()
        {
            $id = Auth::user('instansi')->id;
            $instansi = Instansi::findOrFail($id);

            $rules = [
                'nama_instansi'     => 'required|min:5',
                'email'    => [
                    'required',
                    'email',
                    Rule::unique('users', 'email'),
                    Rule::unique('admins', 'email'),
                    Rule::unique('instansi', 'email')->ignore($id),
                ],
                'phone'    => 'required|digits_between:10,15',
                'password' => 'nullable|min:6|confirmed',
                'image'    => 'nullable|image|file|max:2048',
            ];
            $validatedData = $this->validate($rules);
            $emailChanged = $validatedData['email'] !== $instansi->email;

            if (!empty($this->password)) {
                $validatedData['password'] = Hash::make($this->password);
            } else {
                unset($validatedData['password']);
            }
    

            if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                if (!empty($instansi->image)) {
                    Storage::disk('public')->delete($instansi->image);
                }
            
                $validatedData['image'] = $this->image->store('instansi_images', 'public');
            } else {
                unset($validatedData['image']);
            }
            
            if ($emailChanged) {
                $otp = rand(100000, 999999);
                $expiresAt = now()->addMinutes(5);

                $instansi->update([
                    'otp' => Hash::make($otp),
                    'otp_expires_at' => $expiresAt,
                    'email_verified_at' => null,
                    'email' => $this->email,
                ]);


                $instansi->notify(new EmailInstansiVerified($otp));

                session(['instansi_id_verif' => $instansi->id]);

                return $this->OpenVerifikasi = true;
            }

            $instansi->update($validatedData);
            return redirect()->route('instansi.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
        }
    public function verifikasi()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        $instansi = Instansi::find($this->id ?? session('instansi_id_verif'));

        if (!$instansi) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi sudah habis. Silakan ke halaman login untuk mendapat verifikasi ulang.');
        }

        if (Carbon::now()->gt($instansi->otp_expires_at)) {
            $this->Openkirimulang = true;
            return back()->with('error', 'Waktu OTP telah habis. Silakan minta ulang kode verifikasi.');
        }

        if (!Hash::check($this->otp, $instansi->otp)) {
            return back()->with('error', 'Kode OTP yang kamu masukkan salah.');
        }

        $instansi->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        session()->forget('instansi_id_verif');

        return redirect()->route('instansi.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
    }
    public function KirimUlang()
    {
        $instansi = Instansi::find($this->id ?? session('instansi_id_verif'));

        if (!$instansi) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi telah habis. Silakan daftar ulang.');
        }

        if ($instansi->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email kamu sudah diverifikasi.');
        }
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $instansi->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => $expiresAt,
        ]);

        $instansi->notify(new EmailInstansiVerified($otp));

        session(['instansi_id_verif' => $instansi->id]);
        $this->Openkirimulang = false;
        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email kamu.');
    }
    public function render()
    {
        $id = Auth::user('instansi')->id;
        return view('livewire.edit-profil-instansi', [
            'edit'=> Instansi::findOrFail($id)
        ]);
    }
}
