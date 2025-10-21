<?php

namespace App\Livewire;

use App\Events\UpdateInstansi;
use App\Models\Admin;
use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use App\Notifications\InstansiUpdateLaporan;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class ReportInstansiList extends Component
{
    use WithPagination;
    protected $listeners = ['reportInstansiCreate' => 'handleNewReport'];
    public $selectedReport = false;
    public $update_id = null;
    public $status;
    public $catatan_intansi;
    public $search;

    public function openModal($reportId)
    {
        $this->update_id = $reportId;
        $report = Report_instansi::find($reportId);
        $this->selectedReport = true;
        $this->status = $report->status;
        $this->catatan_intansi = $report->catatan_intansi;
    }



    public function updateReport()
    {
        if ($this->selectedReport) {
            $report = Report_instansi::find($this->update_id);
            $validated = $this->validate([
                'status'        => 'nullable|in:received,on_progress,resolved',
                'catatan_intansi' => 'nullable|string',
            ]);
            if (
                $report->status === $this->status &&
                $report->catatan_intansi === $this->catatan_intansi
            ) {
                $this->dispatch(
                    'sweet-alert',
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'tidak ada perubahan yang dilakukan!.'
                );
                return;
            }

            $report->update($validated);
            $admins = Admin::all();


            Notification::send($admins, new InstansiUpdateLaporan($report));
            event(new UpdateInstansi($report));

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
        $this->selectedReport = false;
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

        $instansi_terkait = null;
        

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
            'instansi_terkait' => $instansi_terkait,
        ]);
    }
}
