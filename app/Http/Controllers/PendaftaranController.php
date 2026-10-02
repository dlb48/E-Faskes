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
        $antrean = Pendaftaran::with(['pasien', 'poliklinik'])
            ->whereDate('tanggal_periksa', Carbon::today())
            ->orderBy('id', 'asc')
            ->get();
            
        return view('pendaftaran.index', compact('antrean'));
    }

    public function create(Request $request)
    {
        // Untuk pencarian pasien berdasarkan NIK atau No RM
        $search = $request->query('search');
        if ($search) {
            $pasiens = Pasien::where('nama', 'like', "%{$search}%")
                ->orWhere('no_rm', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->get();
        } else {
            // Tampilkan 5 pasien terbaru secara default
            $pasiens = Pasien::latest()->take(5)->get();
        }
        
        $polikliniks = Poliklinik::all();
        return view('pendaftaran.create', compact('polikliniks', 'pasiens', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik_pasien' => 'required|exists:pasien,nik',
            'kode_poli' => 'required|exists:poliklinik,kode_poli',
            'jenis_pasien' => 'required|in:Umum,BPJS'
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
            'jenis_pasien' => $request->jenis_pasien,
            'sumber_daftar' => 'On-Site',
            'status' => 'Menunggu',
            'tanggal_periksa' => Carbon::today()
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Berhasil mendaftarkan antrean: ' . $no_antrean);
    }
}
