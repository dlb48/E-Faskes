<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pegawai;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Poliklinik;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Penjamin;
use App\Models\MasterIcd10;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index()
    {
        $data = [
            'pasien' => Pasien::onlyTrashed()->get(),
            'pegawai' => Pegawai::onlyTrashed()->with(['departemen', 'jabatanData'])->get(),
            'dokter' => Dokter::onlyTrashed()->with('pegawai')->get(),
            'perawat' => Perawat::onlyTrashed()->with('pegawai')->get(),
            'poliklinik' => Poliklinik::onlyTrashed()->get(),
            'departemen' => Departemen::onlyTrashed()->get(),
            'jabatan' => Jabatan::onlyTrashed()->get(),
            'penjamin' => Penjamin::onlyTrashed()->get(),
            'icd10' => MasterIcd10::onlyTrashed()->get(),
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
            'departemen' => new Departemen,
            'jabatan' => new Jabatan,
            'penjamin' => new Penjamin,
            'icd10' => new MasterIcd10,
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

    public function restoreBulk(Request $request)
    {
        $items = $request->input('selected_items', []);
        if (empty($items)) return back()->with('error', 'Tidak ada data terpilih.');
        
        $count = 0;
        foreach ($items as $item) {
            list($type, $id) = explode('|', $item);
            $model = $this->getModel($type);
            $record = $model->onlyTrashed()->find($id);
            if ($record) {
                $record->restore();
                $count++;
            }
        }
        return back()->with('success', $count . ' Data berhasil dipulihkan.');
    }

    public function forceDeleteBulk(Request $request)
    {
        $items = $request->input('selected_items', []);
        if (empty($items)) return back()->with('error', 'Tidak ada data terpilih.');
        
        $count = 0;
        $errors = 0;
        foreach ($items as $item) {
            list($type, $id) = explode('|', $item);
            $model = $this->getModel($type);
            $record = $model->onlyTrashed()->find($id);
            if ($record) {
                try {
                    $record->forceDelete();
                    $count++;
                } catch (QueryException $e) {
                    $errors++;
                }
            }
        }
        
        $msg = $count . ' Data berhasil dihapus permanen.';
        if ($errors > 0) {
            $msg .= ' (' . $errors . ' data gagal dihapus karena terhubung tabel lain).';
        }
        
        return back()->with('success', $msg);
    }
}



