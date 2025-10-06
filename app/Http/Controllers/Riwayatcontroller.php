<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Riwayatcontroller extends Controller
{
    public function index()
    {
        return view('user.riwayat.index', [
            'judul' => 'Riwayat Laporan',
        ]);
    }
}