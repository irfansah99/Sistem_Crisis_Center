<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Livewire\Component;

class RiwayatAdmin extends Component
{
    public $OpenDetail;

    public function OpenModal($reportid)
    {
        $this->OpenDetail = $reportid;
    }
    public function CloseModal(){
        $this->OpenDetail= null;
    }
    public function render()
    {
        $report = null;
        $instansi_terkait = null;
        if ($this->OpenDetail) {
            $instansi_terkait = Report_instansi::where('report_id', $this->OpenDetail)->orderBy('created_at' ,'asc')->get();
            $report = Report::with('user')->findOrFail($this->OpenDetail);
        }

        return view('livewire.riwayat-admin',[
            'reports' => Report::where('status', 'done')
            ->orderBy('updated_at', 'desc')
            ->get(),
            'detail' => $report,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}
