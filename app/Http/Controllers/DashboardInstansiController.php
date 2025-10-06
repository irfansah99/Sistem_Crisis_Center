<?php

namespace App\Http\Controllers;

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
        

        $report = Report_instansi::with('user')->findOrFail($id);
        return view('instansi.dashboard.detail', [
            'judul' => 'Detail  Laporan',
            'index'  => $report,

        ]);
    }
}
