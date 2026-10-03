<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Dokter;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with(['dokter.pegawai', 'poliklinik'])->orderBy('hari')->orderBy('jam_mulai')->get();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::with('pegawai')->get();
        $polikliniks = Poliklinik::all();
        return view('jadwal.create', compact('dokters', 'polikliniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:dokters,id_dokter',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
            'hari' => 'required|integer|min:1|max:7',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:0',
            'status_aktif' => 'required|boolean',
        ]);

        // Check for schedule conflict
        $conflict = JadwalDokter::where('id_dokter', $request->id_dokter)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->first();

        if ($conflict) {
            return back()->withInput()->with('error', 'Dokter ini sudah memiliki jadwal pada hari dan jam yang bersinggungan.');
        }

        JadwalDokter::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal Dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $dokters = Dokter::with('pegawai')->get();
        $polikliniks = Poliklinik::all();
        
        return view('jadwal.edit', compact('jadwal', 'dokters', 'polikliniks'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        
        $request->validate([
            'id_dokter' => 'required|exists:dokters,id_dokter',
            'poliklinik_id' => 'required|exists:poliklinik,kode_poli',
            'hari' => 'required|integer|min:1|max:7',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kuota' => 'required|integer|min:0',
            'status_aktif' => 'required|boolean',
        ]);

        // Check for schedule conflict excluding current ID
        $conflict = JadwalDokter::where('id', '!=', $id)
            ->where('id_dokter', $request->id_dokter)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->first();

        if ($conflict) {
            return back()->withInput()->with('error', 'Dokter ini sudah memiliki jadwal pada hari dan jam yang bersinggungan.');
        }

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal Dokter berhasil diubah.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal Dokter berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data jadwal yang dipilih.');
        }

        JadwalDokter::whereIn('id', $ids)->delete();
        return redirect()->route('jadwal.index')->with('success', count($ids) . ' Jadwal Dokter berhasil dihapus.');
    }
}

