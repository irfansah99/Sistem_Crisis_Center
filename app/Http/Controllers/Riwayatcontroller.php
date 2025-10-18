<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Report;
use App\Models\Report_instansi;
use Illuminate\Http\Request;

class Riwayatcontroller extends Controller
{
    public function index()
    {
        return view('user.riwayat.index', [
            'judul' => 'Riwayat Laporan',
        ]);
    }

    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        $instansi_terkait = Instansi::whereIn(
            'id',
            Report_instansi::where('report_id', $report->id)->pluck('instansi_id')
        )->get();
        return view('user.riwayat.detail' ,[
            'judul' => 'Detail  Laporan',
            'index'  => $report,
            'instansi_terkait' => $instansi_terkait
        ]);
    }
}