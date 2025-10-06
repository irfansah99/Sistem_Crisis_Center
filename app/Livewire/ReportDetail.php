<?php

namespace App\Livewire;

use App\Events\ReportInstansiList;
use App\Events\ReportUpdate;
use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use App\Notifications\AdminUpdateLaporan;
use App\Notifications\ReportInstansiCreate;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;


class ReportDetail extends Component
{

    protected $listeners = ['reportInstansiUpdated' => '$refresh'];
    public $id;
    public $openModal;
    public $level_krisis;
    public $status;
    public $instansi = [];

    public $catatan_admin;
    public function mount(string $id)
    {
        $this->id = $id;
    }
    public function Edit(string $id)
    {
        $report = Report::find($id);
        $this->openModal = $report;
        $this->status = $report->status;
        $this->level_krisis = $report->level_krisis;
        $this->catatan_admin = $report->catatan_admin;
    }
    public function update()
    {

        $report = Report::findOrFail($this->id);
        $admin  = auth('admin')->id();
        $oldData = $report->getOriginal();

        if ($report->status === 'pending') {
            $validated = $this->validate([
                'status'        => 'required|in:verified,reject',
                'catatan_admin' => 'nullable|string',
                'level_krisis'  => 'required|in:rendah,tinggi,sedang,darurat',
                'instansi'      => 'required|array',
                'instansi.*'    => 'exists:instansi,id',
            ]);

            $report->update($validated);

            foreach ($this->instansi as $instansiId) {
                $instansiId = (int) $instansiId; 
                $reportInstansi = Report_instansi::firstOrCreate(
                    ['report_id' => $report->id, 'instansi_id' => $instansiId],
                    ['admin_id'  => $admin]
                );

                $instansi = Instansi::find($instansiId);
                Notification::send($instansi, new ReportInstansiCreate($reportInstansi));
                event(new ReportInstansiList($reportInstansi));
            }
        } else {
            $validated = $this->validate([
                'status'        => 'nullable|in:verified,on_progres,done',
                'catatan_admin' => 'nullable|string',
                'level_krisis'  => 'nullable|in:rendah,tinggi,sedang,darurat',
            ]);
            $report->update($validated);
            if ($this->instansi) {
                foreach ($this->instansi as $instansiId) {
                    $instansiId = (int) $instansiId; 
                    $reportInstansi = Report_instansi::firstOrCreate(
                        ['report_id' => $report->id, 'instansi_id' => $instansiId],
                        ['admin_id'  => $admin]
                    );
    
                    $instansi = Instansi::find($instansiId);
                    Notification::send($instansi, new ReportInstansiCreate($reportInstansi));
                    event(new ReportInstansiList($reportInstansi));
                }
            }
        }

        $newData = $report->getChanges();

        $report->user->notify(new AdminUpdateLaporan($report, $oldData, $newData));

        event(new ReportUpdate($report));
        $this->dispatch('sweet-alert', 
        icon: 'success',
        title: 'Success',
        text: 'Laporan berhasil diperbarui.'
    );

        

        $this->openModal = '';
    }
    public function closeModal(){
        $this->openModal = '';
    }
    public function render()
    {
        $instansi_terkait = Report_instansi::where('report_id', $this->id)->pluck('instansi_id');
        $report = Report::with('user')->findOrFail($this->id);

        return view('livewire.report-detail', [
            'judul' => 'Detail Laporan',
            'index' => $report,
            'instansi' => Instansi::all(),
            'instansi_terkait' => Report_instansi::where('report_id', $this->id)->get(),
            'tambah_instansi' => Instansi::whereNotIn('id', $instansi_terkait)->get(),
        ]);
    }
}
