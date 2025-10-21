<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;

class Reportlist extends Component
{
    use WithPagination;
    protected $listeners = ['reportAdded' => '$refresh'];
    public $search;
    public function render()
    {
        if (!empty($this->search)) {
            $report = Report::where('deskripsi', 'like', '%' . $this->search . '%')
                ->whereNotin('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $report = Report::whereNotin('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.report-list', [
            'reports' => $report,
        ]);
    }
}
