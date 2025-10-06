<?php

namespace App\Http\Controllers;


use App\Events\ReportInstansiList;
use App\Events\ReportUpdate;
use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use App\Notifications\AdminUpdateLaporan;
use App\Notifications\ReportInstansiCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReportsController extends Controller
{
    public function index()
    {


        return view('admin.reports.index', [
            'judul' => 'Home',

        ]);
    }
    public function show(string $id)
    {
        return view('admin.reports.detail', [
            'judul' => 'Detail  Laporan',
            'id' => $id,
        ]);
    }
    public function update(Request $request, string $id)
    {

        $report = Report::findOrFail($id);
        $admin  = auth('admin')->id();
        $oldData = $report->getOriginal();

        if ($report->status === 'pending') {
            $validated = $request->validate([
                'status'        => 'required|in:reject,verified',
                'catatan_admin' => 'nullable|string',
                'level_krisis'  => 'required|in:rendah,tinggi,sedang,darurat',
            ]);

            $report->update($validated);

            if ($validated['status'] === 'verified') {
                $instansiDipilih = $request->validate([
                    'instansi'   => 'required|array',
                    'instansi.*' => 'exists:instansi,id',
                ])['instansi'];

                foreach ($instansiDipilih as $instansiId) {
                    $reportInstansi = Report_instansi::firstOrCreate(
                        ['report_id' => $id, 'instansi_id' => $instansiId],
                        ['admin_id'  => $admin]
                    );
                    $instansi = Instansi::find($instansiId);
                    Notification::send($instansi, new ReportInstansiCreate($reportInstansi));
                    event(new ReportInstansiList($reportInstansi));
                }
            }
        } else {
            $validated = $request->validate([
                'status'        => 'nullable|in:on_progres,done',
                'catatan_admin' => 'nullable|string',
                'level_krisis'  => 'nullable|in:rendah,tinggi,sedang,darurat',
                'instansi'      => 'nullable|array',
                'instansi.*'    => 'exists:instansi,id',
            ]);

            $report->update($validated);

            foreach ($request->input('instansi', []) as $instansiId) {
                $reportInstansi = Report_instansi::firstOrCreate(
                    ['report_id' => $id, 'instansi_id' => $instansiId],
                    ['admin_id'  => $admin]
                );
                $instansi = Instansi::find($instansiId);
                Notification::send($instansi, new ReportInstansiCreate($reportInstansi));
                event(new ReportInstansiList($reportInstansi));
            }
        }

        $newData = $report->getChanges();

        $report->user->notify(new AdminUpdateLaporan($report, $oldData, $newData));


        event(new ReportUpdate($report));

        return back()->with('success', 'Laporan berhasil diperbarui!');
    }
}
