<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class NavbarInstansi extends Component
{
    protected $listeners = ['reportInstansiNotif' => 'handleNewReport'];
    public $showDropdown;
    public $instansi;

    public function mount()
    {
        $this->instansi = auth('instansi')->user();
    }
    public function ClearAll()
    {
        $this->instansi->unreadNotifications()->update([
            'read_at' => Carbon::now(),
        ]);
    }

    public function update(string $id)
    {
        $notif = $this->instansi->unreadNotifications()->find($id);
        $notif?->markAsRead();
    }
    public function handleNewReport($data = null)
    {
        $instansi = auth('instansi')->user();

        if ($data && isset($data['instansi_id']) && $data['instansi_id'] == $instansi->id) {
            $this->emitSelf('$refresh');
        }
    }
    public function render()
    {
        $countnotif = $this->instansi->unreadNotifications()->count();
        return view('livewire.navbar-instansi', [
            'instansi'       => $this->instansi,
            'countnotif' => $countnotif,
        ]);
    }
}
