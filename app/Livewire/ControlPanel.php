<?php

namespace App\Livewire;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Report;
use Livewire\Component;

class ControlPanel extends Component
{
    protected $listeners = ['reportAdded' => '$refresh'];

    public function render()
    {
        return view('livewire.control-panel', [
            'admin' => Admin::count(),
            'instansi' => Instansi::count(),
            'report' => Report::where('status', '!=', 'done')->count(),
            'riwayat' => Report::where('status', 'done')->count(),
        ]);
        
    }
}
