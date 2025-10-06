<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilInstansicontroller extends Controller
{
    public function edit()
    {
        $id = auth('instansi')->user()->id;

        $instansi = Instansi::findOrFail($id);
        return view('instansi/profil/edit', [
            'judul' => 'Edit Profil',
            'edit' =>  $instansi
        ]);
    }

    public function update(Request $request)
    {
        $id = auth('instansi')->user()->id;
        $instansi = Instansi::findOrFail($id);

        $rules = [
            'nama_instansi'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email,' . $id . ',id',
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'nullable|min:6|confirmed',
            'image'    => 'nullable|image|file|max:2048',
        ];

        $validatedData = $request->validate($rules);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }

        if ($request->file('image')) {
            if ($request->fotoold) {
                Storage::delete($request->fotoold);
            }
            $validatedData['image'] = $request->file('image')->store('instansi_images', 'public');
        }

        $instansi->update($validatedData);

        return redirect()->route('instansi.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
    }
}

