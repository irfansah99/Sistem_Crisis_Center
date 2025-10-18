<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaAdmin extends Component
{
    use WithPagination;
    public $id;
    public $Open = false;
    public $deletid;
    public $rolebaru;
    public $OpenTambah = false;
    public $name, $email, $phone, $password, $password_confirmation;
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
            'name'     => 'required|min:5',
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
        Admin::create($validatedData);
        $this->dispatch(
            'sweet-alert',
            icon: 'success',
            title: 'Berhasil',
            text: 'akun telah ditambahkan.'
        );
        $this->OpenTambah = false;
    }
    public function updateRole($id, $role)
    {
        $this->rolebaru = $role;
        $this->id = $id;
        $this->dispatch(
            'sweet-alert',
            type: 'confirm',
            icon: 'warning',
            title: 'Yakin ingin memperbarui role?',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal',
            jenis: 'perbaruiakun',
            id: $id
        );
    }
    public function updateconfirm()
    {
        $admin = Admin::findOrFail($this->id);
        $admin->update(['role' => $this->rolebaru]);
        $this->dispatch(
            'sweet-alert',
            icon: 'success',
            title: 'Berhasil',
            text: 'role telah diperbarui.'
        );
        $this->Open = false;
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
        Admin::findOrFail($this->deletid)->delete();

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
            $admin = Admin::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $admin = Admin::orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.kelola-admin', [
            'admin' => $admin,
            'detail' => Admin::find($this->id),
        ]);
    }
}
