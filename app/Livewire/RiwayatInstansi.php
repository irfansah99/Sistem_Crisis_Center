<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report_instansi;
use Livewire\Component;

class RiwayatInstansi extends Component
{
    public $OpenDetail = null;
    public $status;
    public $catatan_intansi;


    public function ModalDetail($reportId)
    {
        $this->OpenDetail = $reportId;
    }

    public function closeModal()
    {
        $this->OpenDetail = null;
    }
    public function render()
    {
        $instansi = auth('instansi')->user();
        $detail = null;
        $instansi_terkait = null;
        
        if ($this->OpenDetail) {
            $detail = Report_instansi::with('report.user')->find($this->OpenDetail);
        
            if ($detail) {
                $instansi_terkait = Instansi::whereIn('id', [$detail->instansi_id])->get();

            }
        }
        return view('livewire.riwayat-instansi' ,[
            'reports' => Report_instansi::where('instansi_id', $instansi->id)
                ->whereNot('status', 'resolved')
                ->orderBy('updated_at', 'desc')
                ->get(),
            'instansi' => $instansi,
            'detail' => $detail,
            'instansi_terkait' => $instansi_terkait,
        ]);
    }
}
