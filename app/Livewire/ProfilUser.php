<?php

namespace App\Livewire;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfilUser extends Component
{
    protected $listeners = ['notifikasiuser' => '$refresh'];
    public $showDropdown;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function ClearAll()
    {
        $this->user->unreadNotifications()->update([
            'read_at' => Carbon::now(),
        ]);
        $this->showDropdown = '';
    }

    public function update(string $id)
    {
        $notif = $this->user->unreadNotifications()->find($id);
        $notif?->markAsRead();
    }

    public function render()
    {
        $countnotif = $this->user->unreadNotifications()->count();

        return view('livewire.profil-user', [
            'user'       => $this->user,
            'countnotif' => $countnotif,
        ]);
    }
}
