<?php

namespace App\Http\Controllers;

use App\Models\TenagaMedis;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class TenagaMedisController extends Controller
{
    public function index()
    {
        $tenaga_medis = TenagaMedis::with('poliklinik')->latest()->get();
        return view('tenaga-medis.index', compact('tenaga_medis'));
    }

    public function create()
    {
        $polikliniks = Poliklinik::where('status_aktif', true)->get();
        return view('tenaga-medis.create', compact('polikliniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tenaga_medis' => 'required|unique:tenaga_medis,kode_tenaga_medis',
            'nama_lengkap' => 'required',
            'profesi' => 'required',
        ]);

        TenagaMedis::create([
            'kode_tenaga_medis' => $request->kode_tenaga_medis,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_sip' => $request->no_sip,
            'profesi' => $request->profesi,
            'spesialisasi' => $request->spesialisasi,
            'no_telepon' => $request->no_telepon,
            'poliklinik_id' => $request->poliklinik_id,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('tenaga-medis.index')->with('success', 'Data Tenaga Medis berhasil ditambahkan.');
    }

    public function edit(TenagaMedis $tenagaMedi)
    {
        $polikliniks = Poliklinik::where('status_aktif', true)->get();
        return view('tenaga-medis.edit', ['tenaga_medis' => $tenagaMedi, 'polikliniks' => $polikliniks]);
    }

    public function update(Request $request, TenagaMedis $tenagaMedi)
    {
        $request->validate([
            'kode_tenaga_medis' => 'required|unique:tenaga_medis,kode_tenaga_medis,' . $tenagaMedi->id,
            'nama_lengkap' => 'required',
            'profesi' => 'required',
        ]);

        $tenagaMedi->update([
            'kode_tenaga_medis' => $request->kode_tenaga_medis,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_sip' => $request->no_sip,
            'profesi' => $request->profesi,
            'spesialisasi' => $request->spesialisasi,
            'no_telepon' => $request->no_telepon,
            'poliklinik_id' => $request->poliklinik_id,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('tenaga-medis.index')->with('success', 'Data Tenaga Medis berhasil diubah.');
    }

    public function destroy(TenagaMedis $tenagaMedi)
    {
        $tenagaMedi->delete();
        return redirect()->route('tenaga-medis.index')->with('success', 'Data Tenaga Medis berhasil dihapus.');
    }
}
