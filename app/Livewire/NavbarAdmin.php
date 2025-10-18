<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class NavbarAdmin extends Component
{
    protected $listeners = ['reportAdded','$refresh'];
    public $showDropdown;
    public $admin;

    public function mount()
    {
        $this->admin = auth('admin')->user();
    }
    public function ClearAll()
    {
        $this->admin->unreadNotifications()->update([
            'read_at' => Carbon::now(),
        ]);
    }

    public function update(string $id)
    {
        $notif = $this->admin->unreadNotifications()->find($id);
        $notif?->markAsRead();
    }
    public function render()
    {
        $countnotif = $this->admin->unreadNotifications()->count();
        return view('livewire.navbar-admin', [
            'admin'       => $this->admin,
            'countnotif' => $countnotif,
        ]);
    }
}
