<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Report_instansi;
use Illuminate\Http\Request;

class DashboardInstansiController extends Controller
{
    public function index()
    {
        return view('instansi.dashboard.index', [
            'judul' => 'Home',

        ]);
    }

    public function show(string $id)
    {
    
        $report = Report_instansi::with('report.user')->findOrFail($id);
        $instansi_terkait = Instansi::where('id', $report->instansi_id)->orderBy('created_at', 'asc')->get();
        return view('instansi.dashboard.detail', [
            'judul' => 'Detail  Laporan',
            'detail'  => $report,
            'instansi_terkait' => $instansi_terkait,

        ]);
    }
}
