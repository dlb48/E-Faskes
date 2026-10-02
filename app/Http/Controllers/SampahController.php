<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pegawai;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Poliklinik;
use Illuminate\Database\QueryException;

class SampahController extends Controller
{
    public function index()
    {
        $data = [
            'pasien' => Pasien::onlyTrashed()->get(),
            'pegawai' => Pegawai::onlyTrashed()->get(),
            'dokter' => Dokter::onlyTrashed()->with('pegawai')->get(),
            'perawat' => Perawat::onlyTrashed()->with('pegawai')->get(),
            'poliklinik' => Poliklinik::onlyTrashed()->get(),
        ];
        return view('sampah.index', compact('data'));
    }

    private function getModel($type) {
        return match($type) {
            'pasien' => new Pasien,
            'pegawai' => new Pegawai,
            'dokter' => new Dokter,
            'perawat' => new Perawat,
            'poliklinik' => new Poliklinik,
            default => abort(404),
        };
    }

    public function restore($type, $id)
    {
        $model = $this->getModel($type);
        $record = $model->onlyTrashed()->findOrFail($id);
        $record->restore();
        return redirect()->back()->with('success', 'Data berhasil dipulihkan dari tempat sampah.');
    }

    public function forceDelete($type, $id)
    {
        $model = $this->getModel($type);
        $record = $model->onlyTrashed()->findOrFail($id);
        
        try {
            $record->forceDelete();
            return redirect()->back()->with('success', 'Data berhasil dihapus permanen.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Data tidak bisa dihapus permanen karena masih terhubung dengan catatan di tabel lain!');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan database: ' . $e->getMessage());
        }
    }
}
