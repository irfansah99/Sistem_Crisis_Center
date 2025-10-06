<?php

namespace App\Http\Controllers;

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
    public function show(string $id){
        $detail = Report_instansi::with('report')->findOrFail($id);

        return view('instansi.riwayat.detail', [
            'judul' => 'Detail Laporan',
            'detail' => $detail,
        ]);
    }
}
