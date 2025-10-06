<?php

namespace App\Livewire\User;

use App\Events\ReportCreated;
use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Report;
use App\Notifications\UserCreateLaporan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CreateReport extends Component
{
    use WithFileUploads;

    public $judul, $deskripsi, $kategori, $lokasi, $foto;

    public function render()
    {
        return view('livewire.user.create-report');
    }

    public function simpan()
    {
        $user = Auth::user();

        $rules = [
            'judul'     => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'kategori'  => 'required|in:Bencana Alam,Kebakaran,Kriminalitas,Kecelakaan',
            'lokasi'    => 'required',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        
        $validated = $this->validate($rules);
        
        $validated['user_id'] = $user->id;
        
        if ($this->foto) {
            $validated['foto'] = $this->foto->store('laporan', 'public');
        }
        
        $report = Report::create($validated);
        $admins = Admin::all();


        Notification::send($admins, new UserCreateLaporan($report));
        event(new ReportCreated($report));

        return redirect(route('beranda.index'))->with('success', 'Laporan berhasil dikirim!');

        

    }        
}

