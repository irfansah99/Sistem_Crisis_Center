<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaInstansiController extends Controller
{
    public function index(){
        return view('admin.kelola_instansi.index', [
            'judul' => 'Kelola Instansi'
        ]);
    }
}
