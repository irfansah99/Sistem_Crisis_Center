<?php

namespace App\Http\Controllers;

use App\Events\ReportCreated;
use App\Models\Report;
use App\Models\Tagihan;
use App\Models\Tarif;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $report = Report::where('user_id', $user->id)->whereNot('status', 'done')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.beranda.index', [
            'judul' => 'Home',
            'user' => $user,
            'index' => $report,

        ]);
    }

    public function create()
    {
        return view('user.beranda.create', [
            'judul' => 'Buat Laporan'
        ]);
    }
    public function store(Request $request)
    {
        $user = auth()->user();

        $pendingReport = Report::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingReport) {
            return redirect()->route('beranda.index')
                ->with('error', 'Laporan tidak dikirim! Anda masih punya laporan pending.');
        }

        $validatedData = $request->validate([
            'judul'     => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'kategori' => 'required|in:Bencana Alam,Kebakaran,Kriminalitas,Kecelakaan',
            'lokasi'    => 'required',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validatedData['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('laporan', 'public');
        }

        Report::create($validatedData);


        return redirect()->route('beranda.index')->with('success', 'Laporan berhasil dikirim!');
    }
    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        return view('user.detail.index' ,[
            'judul' => 'Detail  Laporan',
            'index'  => $report,
        ]);
    }
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);

        if ($report->status === "pending") {
            $report->delete();
            event(new ReportCreated($report));
            return redirect()->route('beranda.index')->with('success', 'Laporan berhasil dihapus!');
        }
        return redirect()->route('beranda.index')->with('error', 'Laporan sudah diverifikasi dan tidak bisa dihapus!');
    }
}
