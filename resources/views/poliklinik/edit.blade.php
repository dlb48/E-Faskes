@extends('layouts.app')

@section('title', 'Ubah Data Poliklinik')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('poliklinik.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Ubah Data Poliklinik</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
        <div class="flex items-center mb-2">
            <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
            <span class="text-red-800 font-bold text-sm">Terdapat kesalahan pengisian:</span>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-stethoscope text-amber-500 mr-2"></i>Informasi Poliklinik</h2>
        </div>
        
        <form novalidate action="{{ route('poliklinik.update', $poliklinik->kode_poli) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Poli <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_poli" value="{{ old('kode_poli', $poliklinik->kode_poli) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <p class="text-xs text-slate-500 mt-1">Gunakan kode standar BPJS jika memungkinkan. Perubahan ID akan disinkronkan (Cascade).</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Poliklinik <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_poli" value="{{ old('nama_poli', $poliklinik->nama_poli) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">{{ old('deskripsi', $poliklinik->deskripsi) }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Poli <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ old('status_aktif', $poliklinik->status_aktif) ? 'border-brand-300 bg-brand-50' : '' }}">
                            <input type="radio" name="status_aktif" value="1" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500" {{ old('status_aktif', $poliklinik->status_aktif) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ !old('status_aktif', $poliklinik->status_aktif) ? 'border-red-300 bg-red-50' : '' }}">
                            <input type="radio" name="status_aktif" value="0" class="w-4 h-4 text-red-600 border-slate-300 focus:ring-red-500" {{ !old('status_aktif', $poliklinik->status_aktif) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">Tidak Aktif</span>
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Jika dinonaktifkan, poli ini tidak akan muncul di opsi pendaftaran pasien.</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('poliklinik.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


