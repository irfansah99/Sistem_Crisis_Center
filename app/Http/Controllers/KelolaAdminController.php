<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaAdminController extends Controller
{
    public function index()
    {
        return view('admin.kelola_admin.index', [
            'judul' => "Kelola Admin"
        ]);
    }
}
