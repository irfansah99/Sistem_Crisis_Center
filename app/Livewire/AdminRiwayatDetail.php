<?php

namespace App\Livewire;

use App\Models\Report;
use App\Models\Report_instansi;
use Livewire\Component;

class AdminRiwayatDetail extends Component
{
    public $id;
    public $id_detail;
    public $Modal;
    public function mount($id)
    {
        $this->id = $id;
    }

    public function OpenModal($id){
        $this->id_detail = $id;
        $this->Modal = true;
    }
    public function closeDetail()
    {
        $this->Modal = false;
        $this->id_detail = '';
    }
    public function render()
    {
        $instansi_detail = null;
        if ($this->Modal) {
            $instansi_detail = Report_instansi::find($this->id_detail);
        }
        $instansi_terkait = Report_instansi::where('report_id', $this->id)->orderBy('created_at', 'asc')->get();
        $report_detail = Report::with('user')->findOrFail($this->id);
        return view('livewire.admin-riwayat-detail',[
            'detail' => $report_detail,
            'instansi_terkait' => $instansi_terkait,
            'detail_instansi' => $instansi_detail,
        ]);
    }
}
