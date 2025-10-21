<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatUser extends Component
{
    use WithPagination;
    public $OpenDetail;
    public $search;
    
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
        if (!empty($this->search)) {
            $report = Report::where('user_id', $user->id)
                ->where('deskripsi', 'like', '%' . $this->search . '%')
                ->whereIn('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $report = Report::where('user_id', $user->id)
            ->whereIn('status', ['done', 'reject'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.riwayat-user', [
            'judul' => 'Home',
            'user' => $user,
            'index' => $report,
            'detail' => $detail,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}
