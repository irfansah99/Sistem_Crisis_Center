<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report_instansi;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatInstansi extends Component
{
    public $OpenDetail = null;
    public $status;
    public $catatan_intansi;
    public $search;
    use WithPagination;

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
        if (!empty($this->search)) {
            $report = Report_instansi::where('instansi_id', $instansi->id)->whereHas('report', function ($query) {
                $query->where('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->where('status', 'resolved')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        }else{
            $report = Report_instansi::where('instansi_id', $instansi->id)
                ->where('status', 'resolved')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.riwayat-instansi' ,[
            'reports' => $report 

        ]);
    }
}
