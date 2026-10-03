<?php

namespace App\Services;

use App\Models\PengaturanBpjs;
use Illuminate\Support\Facades\Http;

class BpjsService
{
    protected $pengaturan;

    public function __construct()
    {
        $this->pengaturan = PengaturanBpjs::first();
    }

    protected function generateHeaders()
    {
        if (!$this->pengaturan) {
            throw new \Exception("Pengaturan BPJS belum dikonfigurasi.");
        }

        $consId = $this->pengaturan->cons_id;
        $secretKey = $this->pengaturan->secret_key;
        $userKey = $this->pengaturan->user_key;

        date_default_timezone_set("UTC");
        $tStamp = strval(time() - strtotime("1970-01-01 00:00:00"));
        $signature = hash_hmac("sha256", $consId . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);

        $headers = [
            "X-cons-id" => $consId,
            "X-timestamp" => $tStamp,
            "X-signature" => $encodedSignature,
            "Accept" => "application/json",
        ];

        if ($userKey) {
            $headers["user_key"] = $userKey;
        }

        return $headers;
    }

    public function getReferensiPoli()
    {
        if (!$this->pengaturan) {
            return ["metadata" => ["code" => 500, "message" => "Pengaturan BPJS belum disetting"]];
        }

        // Endpoint Antrean JKN untuk referensi poli: /ref/poli
        $url = rtrim($this->pengaturan->base_url, "/") . "/ref/poli";
        
        try {
            $response = Http::withHeaders($this->generateHeaders())->get($url);
            return $response->json();
        } catch (\Exception $e) {
            return ["metadata" => ["code" => 500, "message" => "Koneksi ke server BPJS gagal: " . $e->getMessage()]];
        }
    }

    public function getReferensiDokter()
    {
        if (!$this->pengaturan) {
            return ["metadata" => ["code" => 500, "message" => "Pengaturan BPJS belum disetting"]];
        }

        // Endpoint Antrean JKN untuk referensi dokter: /ref/dokter
        $url = rtrim($this->pengaturan->base_url, "/") . "/ref/dokter";
        
        try {
            $response = Http::withHeaders($this->generateHeaders())->get($url);
            return $response->json();
        } catch (\Exception $e) {
            return ["metadata" => ["code" => 500, "message" => "Koneksi ke server BPJS gagal: " . $e->getMessage()]];
        }
    }
}
