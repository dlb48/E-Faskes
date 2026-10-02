<?php

namespace App\Http\Controllers;

use App\Models\Perawat;
use App\Models\Pegawai;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index()
    {
        $perawats = Perawat::with(['pegawai', 'poliklinik'])->latest()->get();
        return view('perawat.index', compact('perawats'));
    }

    public function create()
    {
        $existingPerawatNips = Perawat::pluck('nip')->toArray();
        $pegawais = Pegawai::where('status_aktif', true)
            ->where('departemen', 'Pelayanan Medis')
            ->whereNotIn('nip', $existingPerawatNips)
            ->get();
            
        $polikliniks = Poliklinik::all();
        
        return view('perawat.create', compact('pegawais', 'polikliniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_perawat' => 'required|unique:perawats,id_perawat|unique:dokters,id_dokter',
            'nip' => 'required|unique:perawats,nip|unique:dokters,nip|exists:pegawai,nip',
            'no_str' => 'required',
            'masa_berlaku_str' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ], [
            'id_perawat.unique' => 'Kode ini sudah digunakan oleh Dokter atau Perawat lain.',
            'nip.unique' => 'Pegawai ini sudah didaftarkan sebagai Dokter atau Perawat.',
        ]);

        Perawat::create([
            'id_perawat' => $request->id_perawat,
            'nip' => $request->nip,
            'no_str' => $request->no_str,
            'masa_berlaku_str' => $request->masa_berlaku_str,
            'poliklinik_id' => $request->poliklinik_id,
        ]);

        return redirect()->route('perawat.index')->with('success', 'Data Perawat berhasil ditambahkan.');
    }

    public function edit($id_perawat)
    {
        $perawat = Perawat::findOrFail($id_perawat);
        $pegawais = Pegawai::where('nip', $perawat->nip)->get(); 
        $polikliniks = Poliklinik::all();
        
        return view('perawat.edit', compact('perawat', 'pegawais', 'polikliniks'));
    }

    public function update(Request $request, $id_perawat)
    {
        $perawat = Perawat::findOrFail($id_perawat);
        $request->validate([
            'no_str' => 'required',
            'masa_berlaku_str' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ]);

        $perawat->update([
            'no_str' => $request->no_str,
            'masa_berlaku_str' => $request->masa_berlaku_str,
            'poliklinik_id' => $request->poliklinik_id,
        ]);

        return redirect()->route('perawat.index')->with('success', 'Data Perawat berhasil diubah.');
    }

    public function destroy($id_perawat)
    {
        $perawat = Perawat::findOrFail($id_perawat);
        $perawat->delete();
        return redirect()->route('perawat.index')->with('success', 'Data Perawat berhasil dihapus.');
    }
}
