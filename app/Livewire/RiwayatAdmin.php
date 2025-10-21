<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatAdmin extends Component
{
    public $OpenDetail;
    use WithPagination;
    public $search;


    public function OpenModal($reportid)
    {
        $this->OpenDetail = $reportid;
    }
    public function CloseModal()
    {
        $this->OpenDetail = null;
    }
    public function render()
    {
        $report_detail = null;
        $instansi_terkait = null;
        if ($this->OpenDetail) {
            $instansi_terkait = Report_instansi::where('report_id', $this->OpenDetail)->orderBy('created_at', 'asc')->get();
            $report_detail = Report::with('user')->findOrFail($this->OpenDetail);
        }
        if (!empty($this->search)) {
            $report = Report::where('deskripsi', 'like', '%' . $this->search . '%')
            ->whereIn('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $report = Report::whereIn('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.riwayat-admin', [
            'reports' => $report,
            'detail' => $report_detail,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}
