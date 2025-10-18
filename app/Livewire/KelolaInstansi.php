<?php

namespace App\Livewire;

use App\Models\Instansi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaInstansi extends Component
{ 
    use WithPagination;
    public $id;
    public $Open = false;
    public $deletid;
    public $rolebaru;
    public $OpenTambah = false;
    public $nama_instansi , $jenis , $email, $phone, $password, $password_confirmation;
    public $search;

    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed',
        'updateconfirm' => 'updateconfirm',
    ];
    public function OpenModal($id)
    {
        $this->id = $id;
        $this->Open = true;
    }
    public function Tammbah()
    {
        $this->OpenTambah = true;
    }
    public function create()
    {
        $validatedData = $this->validate([
            'nama_instansi'     => 'required|min:5',
            'jenis' => 'required|in:Keamanan & Ketertiban,Kesehatan,Kebakaran,Penanggulangan Bencana,Sosial & Kemanusiaan,Transportasi & Kecelakaan,Lingkungan & Kebersihan',
            'email'    => [
                'required',
                'email',
                Rule::unique('users', 'email'),
                Rule::unique('admins', 'email'),
                Rule::unique('instansi', 'email'),
            ],
            'phone'    => 'required|digits_between:10,15',
            'password' => 'required|min:6|confirmed',
        ]);


        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['email_verified_at'] = Carbon::now();
        Instansi::create($validatedData);
        $this->dispatch(
            'sweet-alert',
            icon: 'success',
            title: 'Berhasil',
            text: 'akun telah ditambahkan.'
        );
        $this->OpenTambah = false;
    }
   

    public function deleteUser($id)
    {
        $this->deletid = $id;
        $this->dispatch(
            'sweet-alert',
            type: 'confirm',
            icon: 'warning',
            title: 'Yakin ingin menghapus akun?',
            text: 'Data ini tidak bisa dikembalikan!',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            jenis: 'deletereport',
            id: $id
        );
    }
    public function deleteConfirmed()
    {
        Instansi::findOrFail($this->deletid)->delete();

        $this->dispatch(
            'sweet-alert',
            icon: 'success',
            title: 'Berhasil',
            text: 'Akun dihapus.'
        );
        $this->Open = false;
    }

    public function back()
    {
        $this->Open = false;
    }
    public function tutup()
    {
        $this->OpenTambah = false;
    }


    public function render()
    {
        if (!empty($this->search)) {
            $instansi = Instansi::where('nama_instansi', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $instansi = Instansi::orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.kelola-instansi',[
            'instansi' => $instansi,
            'detail' => Instansi::find($this->id),
        ]);
    }
}
