<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Illuminate\Http\Request;

class RiwayatinstansiController extends Controller
{
    public function index()
    {
        $instansi = auth('instansi')->user();
        $report = Report_instansi::where('instansi_id', $instansi->id)->where('status','resolved')->orderBy('updated_at','desc')->get();
        return view('instansi.riwayat.index', [
            'judul' => 'Riwayat Laporan',
            'report' => $report,
        ]);
    }
    public function show(string $id)
    {
    
        $report = Report_instansi::with('report.user')->findOrFail($id);
        $instansi_terkait = Instansi::where('id', $report->instansi_id)->orderBy('created_at', 'asc')->get();
        return view('instansi.riwayat.detail', [
            'judul' => 'Detail  Laporan',
            'detail'  => $report,
            'instansi_terkait' => $instansi_terkait,

        ]);
    }
}
