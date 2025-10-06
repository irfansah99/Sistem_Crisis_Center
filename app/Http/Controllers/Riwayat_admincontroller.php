<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class Riwayat_admincontroller extends Controller
{
    public function index()
    {
        return view('admin.riwayat.index', [
            'judul' => 'Riwayat Laporan',
        ]);
    }
}
