<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Poliklinik;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JknAntreanController extends Controller
{
    /**
     * Format response standar BPJS Kesehatan
     */
    private function formatResponse($code, $message, $response = null)
    {
        return response()->json([
            'metadata' => [
                'message' => $message,
                'code' => $code
            ],
            'response' => $response
        ], $code == 200 || $code == 201 ? 200 : $code); // Terkadang BPJS meminta HTTP status 200 meski code 201
    }

    /**
     * Endpoint: Ambil Antrean
     * POST /api/jkn/antrean/ambil
     */
    public function ambilAntrean(Request $request)
    {
        // Validasi format request BPJS
        $validator = Validator::make($request->all(), [
            'nomorkartu' => 'required|string',
            'nik' => 'required|string',
            'kodepoli' => 'required|string',
            'tanggalperiksa' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return $this->formatResponse(201, $validator->errors()->first());
        }

        // Cek Pasien apakah terdaftar di Faskes
        $pasien = Pasien::where('nik', $request->nik)
            ->orWhere('no_kartu_bpjs', $request->nomorkartu)
            ->first();

        if (!$pasien) {
            return $this->formatResponse(201, 'Data Pasien tidak ditemukan di Faskes');
        }

        // Cek Poliklinik
        $poli = Poliklinik::where('kode_poli', $request->kodepoli)->first();
        if (!$poli) {
            return $this->formatResponse(201, 'Poliklinik tidak ditemukan');
        }

        // Generate Kode Booking & No Antrean
        $tanggal = Carbon::parse($request->tanggalperiksa);
        $jumlahHariIni = Pendaftaran::where('kode_poli', $poli->kode_poli)
            ->whereDate('tanggal_periksa', $tanggal)
            ->count();
            
        $no_antrean = $poli->kode_poli . '-' . str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);
        $kode_booking = 'JKN' . $tanggal->format('Ymd') . strtoupper(substr(uniqid(), -4));

        // Simpan pendaftaran
        $pendaftaran = Pendaftaran::create([
            'nik_pasien' => $pasien->nik,
            'kode_poli' => $poli->kode_poli,
            'no_antrean' => $no_antrean,
            'jenis_pasien' => 'BPJS',
            'sumber_daftar' => 'Mobile JKN',
            'kode_booking' => $kode_booking,
            'status' => 'Menunggu',
            'tanggal_periksa' => $tanggal->format('Y-m-d')
        ]);

        // Response sukses standard BPJS
        $responseData = [
            'nomorantrean' => $no_antrean,
            'kodebooking' => $kode_booking,
            'jenisantrean' => 1,
            'estimasidilayani' => $tanggal->timestamp * 1000, // Format milisecond epoch BPJS
            'namapoli' => $poli->nama_poli,
            'namadokter' => 'Dokter Umum' // Harusnya dinamis jika dikirim kodedokter
        ];

        return $this->formatResponse(200, 'Ok', $responseData);
    }

    /**
     * Endpoint: Batal Antrean
     * POST /api/jkn/antrean/batal
     */
    public function batalAntrean(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodebooking' => 'required|string',
            'keterangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->formatResponse(201, $validator->errors()->first());
        }

        $pendaftaran = Pendaftaran::where('kode_booking', $request->kodebooking)->first();

        if (!$pendaftaran) {
            return $this->formatResponse(201, 'Antrean tidak ditemukan');
        }

        if ($pendaftaran->status == 'Batal' || $pendaftaran->status == 'Selesai') {
            return $this->formatResponse(201, 'Antrean sudah dibatalkan atau selesai');
        }

        $pendaftaran->update(['status' => 'Batal']);

        return $this->formatResponse(200, 'Ok');
    }
}
