<?php

namespace App\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavbarUser extends Component
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

    }

    public function update(string $id)
    {
        $notif = $this->user->unreadNotifications()->find($id);
        $notif?->markAsRead();
    }

    public function render()
    {
        $countnotif = $this->user->unreadNotifications()->count();
        return view('livewire.navbar-user', [
            'user'       => $this->user,
            'countnotif' => $countnotif,
        ]);
    }
}
