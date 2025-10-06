<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilAdmincontroller extends Controller
{
    public function edit()
    {
        $id = auth('admin')->user()->id;

        $admin = Admin::findOrFail($id);
        return view('admin/profil/edit', [
            'judul' => 'Edit Profil',
            'edit' =>  $admin
        ]);
    }

    public function update(Request $request)
    {
        $id = auth('admin')->user()->id;
        $admin = Admin::findOrFail($id);

        $rules = [
            'name'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email,' . $id . ',id',
            'phone'    => 'required|digits_between:10,15',
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
            $validatedData['image'] = $request->file('image')->store('admin_images', 'public');
        }

        $admin->update($validatedData);

        return redirect()->route('admin.dashboard.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
