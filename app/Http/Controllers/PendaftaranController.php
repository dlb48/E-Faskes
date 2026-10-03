<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        $antrean = Pendaftaran::with(['pasien', 'poliklinik', 'penjamin'])
            ->whereDate('tanggal_periksa', Carbon::today())
            ->orderBy('id', 'asc')
            ->get();
            
        return view('pendaftaran.index', compact('antrean'));
    }

    public function create(Request $request)
    {
        $search = $request->input('search');
        
        $pasiens = Pasien::when($search, function($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')
          ->paginate(5);
          
        if ($request->ajax()) {
            return view('pendaftaran._pasien_list', compact('pasiens', 'search'));
        }

        $polikliniks = Poliklinik::where('status_aktif', true)->get();
        $penjamins = \App\Models\Penjamin::orderBy('nama_penjamin', 'asc')->get();
        return view('pendaftaran.create', compact('polikliniks', 'pasiens', 'search', 'penjamins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik_pasien' => 'required|exists:pasien,nik',
            'kode_poli' => 'required|exists:poliklinik,kode_poli',
            'id_penjamin' => 'required|exists:penjamins,id_penjamin'
        ]);

        $poliklinik = Poliklinik::find($request->kode_poli);
        $jumlahHariIni = Pendaftaran::where('kode_poli', $poliklinik->kode_poli)
            ->whereDate('tanggal_periksa', Carbon::today())
            ->count();
            
        $no_antrean = $poliklinik->kode_poli . '-' . str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);

        Pendaftaran::create([
            'nik_pasien' => $request->nik_pasien,
            'kode_poli' => $poliklinik->kode_poli,
            'no_antrean' => $no_antrean,
            'id_penjamin' => $request->id_penjamin,
            'sumber_daftar' => 'On-Site',
            'status' => 'Menunggu',
            'tanggal_periksa' => Carbon::today()
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Berhasil mendaftarkan antrean: ' . $no_antrean);
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::with('pasien')->findOrFail($id);
        $polikliniks = Poliklinik::where('status_aktif', true)->get();
        $penjamins = \App\Models\Penjamin::orderBy('nama_penjamin', 'asc')->get();
        return view('pendaftaran.edit', compact('pendaftaran', 'polikliniks', 'penjamins'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_poli' => 'required|exists:poliklinik,kode_poli',
            'id_penjamin' => 'required|exists:penjamins,id_penjamin'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $dataToUpdate = [
            'kode_poli' => $request->kode_poli,
            'id_penjamin' => $request->id_penjamin
        ];

        // Jika poli berubah, buat nomor antrean baru
        if ($pendaftaran->kode_poli !== $request->kode_poli) {
            $poliklinik = Poliklinik::find($request->kode_poli);
            
            // Hitung antrean di poli tujuan pada hari yang sama
            $jumlahHariIni = Pendaftaran::where('kode_poli', $poliklinik->kode_poli)
                ->whereDate('tanggal_periksa', $pendaftaran->tanggal_periksa)
                ->count();
                
            $dataToUpdate['no_antrean'] = $poliklinik->kode_poli . '-' . str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);
        }
        
        $pendaftaran->update($dataToUpdate);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Berhasil memperbarui antrean: ' . $pendaftaran->no_antrean);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('selected_ids');
        
        if (empty($ids)) {
            return redirect()->route('pendaftaran.index')->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }
        
        // Hapus antrean terpilih
        Pendaftaran::whereIn('id', $ids)->delete();
        
        return redirect()->route('pendaftaran.index')->with('success', count($ids) . ' antrean berhasil dihapus.');
    }
}



