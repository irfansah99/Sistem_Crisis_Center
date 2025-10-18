<?php

namespace App\Livewire;

use App\Events\UpdateInstansi;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Report_instansi;
use App\Notifications\InstansiUpdateLaporan;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class ReportInstansiList extends Component
{
    use WithPagination;
    protected $listeners = ['reportInstansiCreate' => 'handleNewReport'];
    public $selectedReport = null;
    public $OpenDetail = null;
    public $status;
    public $catatan_intansi;
    public $search;
    public function openModal($reportId)
    {
        $report = Report_instansi::find($reportId);
        $this->selectedReport = $report;
        $this->status = $report->status;
        $this->catatan_intansi = $report->catatan_intansi;
    }

    public function ModalDetail($reportId)
    {
        $this->OpenDetail = $reportId;
    }

    public function updateReport()
    {
        if ($this->selectedReport) {
            $this->selectedReport->update([
                'status' => $this->status,
                'catatan_intansi' => $this->catatan_intansi,

            ]);
            $admins = Admin::all();


            Notification::send($admins, new InstansiUpdateLaporan($this->selectedReport));
            event(new UpdateInstansi($this->selectedReport));

            $this->dispatch(
                'sweet-alert',
                icon: 'success',
                title: 'Success',
                text: 'Laporan berhasil diperbarui.'
            );
            $this->closeModal();
        }
    }


    public function closeModal()
    {
        $this->selectedReport = null;
        $this->OpenDetail = null;
    }

    public function handleNewReport($data = null)
    {
        $instansi = auth('instansi')->user();

        if ($data && isset($data['instansi_id']) && $data['instansi_id'] == $instansi->id) {
            $this->emitSelf('$refresh');
        }
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
        if (!empty($this->search)) {
            $report = Report_instansi::where('instansi_id', $instansi->id)->whereHas('report', function ($query) {
                $query->where('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->whereNot('status', 'resolved')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        }else{
            $report = Report_instansi::where('instansi_id', $instansi->id)
                ->whereNot('status', 'resolved')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }
        
        return view('livewire.report-instansi-list', [
            'reports' => $report,
            'instansi' => $instansi,
            'detail' => $detail,
            'instansi_terkait' => $instansi_terkait,
        ]);
    }
}
