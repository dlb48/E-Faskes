<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Poliklinik;
use App\Models\Pemeriksaan;
use App\Models\RmePemeriksaanDokter;
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

        return view('rawat_jalan.assesmen', compact('pendaftaran', 'pemeriksaan', 'assesmen', 'riwayatAssesmen'));
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
            'lingkar_perut' => 'nullable|numeric',
            'skala_nyeri' => 'nullable|integer|min:0|max:10',
            'resiko_jatuh' => 'nullable|string',
            'riwayat_alergi' => 'nullable|string',
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
                'lingkar_perut' => $request->lingkar_perut,
                'skala_nyeri' => $request->skala_nyeri,
                'resiko_jatuh' => $request->resiko_jatuh,
                'riwayat_alergi' => $request->riwayat_alergi,
            ]
        );
        
        return redirect()->back()->with('success', 'Data asesmen awal keperawatan berhasil disimpan!');
    }

    public function anamnesa($id)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'poliklinik', 'penjamin'])->findOrFail($id);
        
        $pemeriksaan = Pemeriksaan::firstOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'waktu_mulai_periksa' => Carbon::now(),
                'status_periksa' => 'Proses'
            ]
        );
        
        // Ambil riwayat medis pasien (Hanya Kunjungan yang Sudah Diperiksa Dokter)
        $riwayatMedis = Pendaftaran::with(['poliklinik', 'pemeriksaanDokter'])
            ->where('nik_pasien', $pendaftaran->nik_pasien)
            ->has('pemeriksaanDokter')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Ambil atau buat Pemeriksaan Dokter baru di memori
        $pemeriksaanDokter = RmePemeriksaanDokter::where('pendaftaran_id', $pendaftaran->id)->first();
        if (!$pemeriksaanDokter) {
            $pemeriksaanDokter = new RmePemeriksaanDokter(['pendaftaran_id' => $pendaftaran->id]);
        }

        return view('rawat_jalan.anamnesa', compact('pendaftaran', 'pemeriksaan', 'pemeriksaanDokter', 'riwayatMedis'));
    }

    public function storeAnamnesa(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pemeriksaan = Pemeriksaan::where('pendaftaran_id', $id)->firstOrFail();

        $waktuSimpanRealTime = Carbon::now()->format('H:i:s');
        $tanggalWaktuTersimpan = $request->tanggal ? $request->tanggal . ' ' . $waktuSimpanRealTime : Carbon::now();

        // Simpan Anamnesa & Diagnosa ke satu tabel
        RmePemeriksaanDokter::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'tanggal' => $tanggalWaktuTersimpan,
                'keluhan_utama' => $request->keluhan_utama,
                'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                'riwayat_penyakit_dahulu' => $request->riwayat_penyakit_dahulu,
                'riwayat_alergi' => $request->riwayat_alergi,
                'kesadaran' => $request->kesadaran,
                'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
                'status_kasus' => $request->status_kasus,
                'kode_icd10' => $request->kode_icd10,
                'nama_diagnosa' => $request->nama_diagnosa,
                'kode_icd10_sekunder' => $request->kode_icd10_sekunder,
                'nama_diagnosa_sekunder' => $request->nama_diagnosa_sekunder,
                'keterangan_diagnosa' => $request->keterangan_diagnosa,
            ]
        );

        return redirect()->back()->with('success', 'Data Anamnesa & Diagnosa Dokter berhasil disimpan!');
    }
}
