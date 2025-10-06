<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('registrasi' , [
            'judul' => 'Register',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|min:5',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits_between:10,15',
            'address'  => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        
    
        $validatedData['password'] = bcrypt($validatedData['password']);
    
        User::create($validatedData);
    
        return redirect()->route('login')->with('success', 'Registrasi Berhasil!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
