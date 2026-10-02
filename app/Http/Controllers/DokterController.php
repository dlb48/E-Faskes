<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pegawai;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with(['pegawai', 'poliklinik'])->latest()->get();
        return view('dokter.index', compact('dokters'));
    }

    public function create()
    {
        // Hanya ambil pegawai yang statusnya aktif dan ada kata "Dokter" di jabatannya
        // atau departemennya Pelayanan Medis yang belum jadi dokter
        $existingDokterNips = Dokter::pluck('nip')->toArray();
        $pegawais = Pegawai::where('status_aktif', true)
            ->where('departemen', 'Pelayanan Medis')
            ->whereNotIn('nip', $existingDokterNips)
            ->get();
            
        $polikliniks = Poliklinik::all();
        
        return view('dokter.create', compact('pegawais', 'polikliniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|unique:dokters,id_dokter',
            'nip' => 'required|unique:dokters,nip|exists:pegawai,nip',
            'no_sip' => 'required',
            'masa_berlaku_sip' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ]);

        Dokter::create([
            'id_dokter' => $request->id_dokter,
            'nip' => $request->nip,
            'no_sip' => $request->no_sip,
            'masa_berlaku_sip' => $request->masa_berlaku_sip,
            'poliklinik_id' => $request->poliklinik_id,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil ditambahkan.');
    }

    public function edit($id_dokter)
    {
        $dokter = Dokter::findOrFail($id_dokter);
        $pegawais = Pegawai::where('nip', $dokter->nip)->get(); // Hanya tampilkan pegawai dia sendiri
        $polikliniks = Poliklinik::all();
        
        return view('dokter.edit', compact('dokter', 'pegawais', 'polikliniks'));
    }

    public function update(Request $request, $id_dokter)
    {
        $dokter = Dokter::findOrFail($id_dokter);
        $request->validate([
            'no_sip' => 'required',
            'masa_berlaku_sip' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ]);

        $dokter->update([
            'no_sip' => $request->no_sip,
            'masa_berlaku_sip' => $request->masa_berlaku_sip,
            'poliklinik_id' => $request->poliklinik_id,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil diubah.');
    }

    public function destroy($id_dokter)
    {
        $dokter = Dokter::findOrFail($id_dokter);
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil dihapus.');
    }
}
