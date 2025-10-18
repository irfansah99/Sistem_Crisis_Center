<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ReportlistUser extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed',
        'reportUpdated' => '$refresh',
    ];
    public $OpenDetail;
    public $deletid;
    public $search;


    public function OpenModal($reportid)
    {
        $this->OpenDetail = $reportid;
    }
    public function CloseModal()
    {
        $this->OpenDetail = null;
    }

    public function confirmDelete($id)
    {
        $this->deletid = $id;
        $this->dispatch(
            'sweet-alert',
            type: 'confirm',
            icon: 'warning',
            title: 'Yakin ingin menghapus laporan?',
            text: 'Data ini tidak bisa dikembalikan!',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            jenis: 'deletereport', 
            id: $id
        );
    }


    public function deleteConfirmed()
    {
        Report::findOrFail($this->deletid)->delete();

        $this->dispatch(
            'sweet-alert',
            icon: 'success',
            title: 'Berhasil',
            text: 'Laporan dihapus.'
        );
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
                ->whereNot('status', 'done')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $report = Report::where('user_id', $user->id)
                ->whereNot('status', 'done')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        

        return view('livewire.reportlist-user', [
            'judul' => 'Home',
            'user' => $user,
            'index' => $report,
            'detail' => $detail,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}
