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
        $pegawais = Pegawai::with('jabatanData')->where('status_aktif', true)
            ->whereNotIn('nip', $existingDokterNips)
            ->get();
            
        $polikliniks = Poliklinik::where('status_aktif', 1)->get();
        
        return view('dokter.create', compact('pegawais', 'polikliniks'));
    }

    public function store(Request $request)
    {
        // Auto-generate ID if empty (checkbox was checked)
        if (empty($request->id_dokter)) {
            $last = Dokter::withTrashed()->orderBy('id_dokter', 'desc')->first();
            if ($last && preg_match('/^DOK-(\d+)$/', $last->id_dokter, $matches)) {
                $nextId = (int)$matches[1] + 1;
                $request->merge(['id_dokter' => 'DOK-' . str_pad($nextId, 3, '0', STR_PAD_LEFT)]);
            } else {
                $request->merge(['id_dokter' => 'DOK-001']);
            }
        }

        $request->validate([
            'id_dokter' => 'required|unique:dokters,id_dokter|unique:perawats,id_perawat',
            'nip' => 'required|unique:dokters,nip|unique:perawats,nip|exists:pegawai,nip',
            'no_sip' => 'required',
            'masa_berlaku_sip' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ], [
            'id_dokter.unique' => 'Kode ini sudah digunakan oleh Dokter atau Perawat lain.',
            'nip.unique' => 'Pegawai ini sudah didaftarkan sebagai Dokter atau Perawat.',
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
        $polikliniks = Poliklinik::where('status_aktif', 1)->get();
        
        return view('dokter.edit', compact('dokter', 'pegawais', 'polikliniks'));
    }

    public function update(Request $request, $id_dokter)
    {
        $dokter = Dokter::findOrFail($id_dokter);
        $request->validate([
            'id_dokter' => 'required|unique:dokters,id_dokter,' . $dokter->id_dokter . ',id_dokter|unique:perawats,id_perawat',
            'nip' => 'required|unique:dokters,nip,' . $dokter->id_dokter . ',id_dokter|unique:perawats,nip|exists:pegawai,nip',
            'no_sip' => 'required',
            'masa_berlaku_sip' => 'required|date',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
        ]);

        $dokter->update([
            'id_dokter' => $request->id_dokter,
            'nip' => $request->nip,
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


