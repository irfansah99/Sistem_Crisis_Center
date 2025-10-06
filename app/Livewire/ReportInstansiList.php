<?php

namespace App\Livewire;

use App\Events\UpdateInstansi;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Report_instansi;
use App\Notifications\InstansiUpdateLaporan;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ReportInstansiList extends Component
{
    protected $listeners = ['reportInstansiCreate' => 'handleNewReport'];
    public $selectedReport = null;
    public $OpenDetail = null;
    public $status;
    public $catatan_intansi;

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
        
        
        return view('livewire.report-instansi-list', [
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
