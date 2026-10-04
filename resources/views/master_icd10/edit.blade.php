@extends('layouts.app')

@section('title', 'Ubah Data ICD-10')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('icd10.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Ubah Data ICD-10</h1>
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
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-book-medical text-amber-500 mr-2"></i>Informasi ICD-10</h2>
        </div>
        
        <form novalidate action="{{ route('icd10.update', $icd->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode ICD-10 <span class="text-red-500">*</span></label>
                    <input type="text" value="{{ $icd->kode_icd10 }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-slate-100 cursor-not-allowed" readonly>
                    <p class="text-xs text-slate-500 mt-1">Kode ICD-10 standar tidak dapat diubah setelah disimpan.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Diagnosa <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_diagnosa" value="{{ old('nama_diagnosa', $icd->nama_diagnosa) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('icd10.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
