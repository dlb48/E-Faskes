<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Poliklinik;
use App\Models\Pemeriksaan;
use App\Models\RmeAnamnesa;
use App\Models\RmeDiagnosa;
use App\Models\RmeResepObat;
use App\Models\AssesmenKeperawatan;
use Carbon\Carbon;

class RawatJalanController extends Controller
{
    public function index()
    {
        $antrean = Pendaftaran::with(['pasien', 'poliklinik', 'penjamin'])
            ->whereDate('tanggal_periksa', Carbon::today())
            // Hanya tampilkan yang statusnya belum Batal atau Selesai
            ->whereNotIn('status', ['Batal'])
            ->orderBy('id', 'asc')
            ->get();
            
        $polis = Poliklinik::where('status_aktif', true)->orderBy('nama_poli')->get();
            
        return view('rawat_jalan.index', compact('antrean', 'polis'));
    }

    public function periksa($id)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'poliklinik', 'penjamin'])->findOrFail($id);
        
        // Update status pendaftaran menjadi Diperiksa jika masih Menunggu
        if ($pendaftaran->status === 'Menunggu') {
            $pendaftaran->update(['status' => 'Diperiksa']);
        }

        // Cari atau buat record Pemeriksaan untuk pendaftaran ini
        $pemeriksaan = Pemeriksaan::firstOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'waktu_mulai_periksa' => Carbon::now(),
                'status_periksa' => 'Proses'
            ]
        );
        
        // Buat record Anamnesa kosong jika belum ada
        $anamnesa = RmeAnamnesa::firstOrCreate(['pemeriksaan_id' => $pemeriksaan->id]);
        
        // Ambil riwayat medis pasien sebelumnya
        $riwayatMedis = Pemeriksaan::with(['pendaftaran.poliklinik', 'anamnesa', 'diagnosa', 'resep'])
            ->whereHas('pendaftaran', function ($query) use ($pendaftaran) {
                $query->where('nik_pasien', $pendaftaran->nik_pasien)
                      ->where('id', '!=', $pendaftaran->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Ambil assesmen keperawatan jika sudah ada, atau buat instance baru (tanpa disave) dengan waktu sekarang
        $assesmen = AssesmenKeperawatan::where('pendaftaran_id', $pendaftaran->id)->first();
        if (!$assesmen) {
            $assesmen = new AssesmenKeperawatan([
                'pendaftaran_id' => $pendaftaran->id,
                'tanggal' => Carbon::now()
            ]);
        }
        
        // Ambil riwayat assesmen keperawatan pasien sebelumnya
        $riwayatAssesmen = AssesmenKeperawatan::with('pendaftaran.poliklinik')
            ->whereHas('pendaftaran', function ($query) use ($pendaftaran) {
                $query->where('nik_pasien', $pendaftaran->nik_pasien)
                      ->where('status', '!=', 'Batal');
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('rawat_jalan.periksa', compact('pendaftaran', 'pemeriksaan', 'anamnesa', 'riwayatMedis', 'assesmen', 'riwayatAssesmen'));
    }
    
    public function storeAssesmen(Request $request, $id)
    {
        $request->validate([
            'tekanan_darah' => 'nullable|string',
            'denyut_nadi' => 'nullable|integer',
            'suhu_tubuh' => 'nullable|numeric',
            'frekuensi_napas' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'tanggal' => 'required|date'
        ]);

        // Menggabungkan tanggal dari input form dengan Waktu (Jam/Menit/Detik) saat tombol simpan ditekan
        $waktuSimpanRealTime = Carbon::now()->format('H:i:s');
        $tanggalWaktuTersimpan = $request->tanggal . ' ' . $waktuSimpanRealTime;

        AssesmenKeperawatan::updateOrCreate(
            ['pendaftaran_id' => $id],
            [
                'tanggal' => $tanggalWaktuTersimpan,
                'tekanan_darah' => $request->tekanan_darah,
                'denyut_nadi' => $request->denyut_nadi,
                'frekuensi_napas' => $request->frekuensi_napas,
                'suhu_tubuh' => $request->suhu_tubuh,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
            ]
        );
        
        return redirect()->back()->with('success', 'Data asesmen awal keperawatan berhasil disimpan!');
    }
}
