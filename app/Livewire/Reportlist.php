<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;

class Reportlist extends Component
{
    protected $listeners = ['reportAdded' => '$refresh'];

    public function render()
    {
        return view('livewire.report-list', [
            'reports' => Report::whereNot('status', 'done')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }
}
