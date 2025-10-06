<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReportlistUser extends Component
{
    protected $listeners = ['reportUpdated' => '$refresh'];
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
        $detail = null;
        $instansi_terkait = null;
        if ($this->OpenDetail) {
            $detail = Report::with('user')->findOrFail($this->OpenDetail);
            if ($detail) {
                $instansi_terkait = Instansi::whereIn(
                    'id',
                    Report_instansi::where('report_id', $detail->id)->pluck('instansi_id')
                )->get();
            }
        }
    
        $user = Auth::user();
        $report = Report::where('user_id', $user->id)->whereNot('status', 'done')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('livewire.reportlist-user', [
            'judul' => 'Home',
            'user' => $user,
            'index' => $report,
            'detail' => $detail,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}
