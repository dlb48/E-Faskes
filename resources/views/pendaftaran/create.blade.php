@extends('layouts.app')

@section('title', 'Buat Antrean Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pendaftaran.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat Antrean</h1>
            <p class="text-sm text-slate-500 mt-1">Mendaftarkan pasien yang sudah terdaftar ke antrean poliklinik</p>
        </div>
    </div>

    <!-- Cari Pasien -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Cari Data Pasien</h3>
        <form action="{{ route('pendaftaran.create') }}" method="GET" class="flex gap-3" novalidate>
            <input type="text" name="search" value="{{ $search }}" placeholder="Ketik NIK, Nama, atau No. RM..." class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
            <button type="submit" class="px-5 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900 shadow-sm transition-colors">
                Cari
            </button>
            <a href="{{ route('pasien.create') }}" class="px-5 py-2 border border-brand-500 text-brand-600 rounded-lg text-sm font-medium hover:bg-brand-50 transition-colors">
                + Pasien Baru
            </a>
        </form>
    </div>

    <!-- Form Pendaftaran -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('pendaftaran.store') }}" method="POST" class="p-6" novalidate>
            @csrf
            
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">1. Pilih Pasien</h3>
            <div class="mb-8 max-h-60 overflow-y-auto border border-slate-200 rounded-lg">
                @forelse($pasiens as $pasien)
                <label class="flex items-start p-4 border-b border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors last:border-0">
                    <div class="flex-shrink-0 mt-0.5">
                        <input type="radio" name="nik_pasien" value="{{ $pasien->nik }}" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required {{ count($pasiens) == 1 ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="block text-sm font-bold text-slate-900">{{ $pasien->nama }}</span>
                            <span class="block text-xs font-mono text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $pasien->no_rm }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">NIK: {{ $pasien->nik }} | BPJS: {{ $pasien->no_kartu_bpjs ?? '-' }}</div>
                    </div>
                </label>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <i class="fa-solid fa-user-xmark text-3xl mb-3 text-slate-300 block"></i>
                    Data pasien tidak ditemukan. Silakan tambahkan pasien baru terlebih dahulu.
                </div>
                @endforelse
            </div>

            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">2. Informasi Antrean</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <!-- Jenis Pasien -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Layanan</label>
                    <select name="jenis_pasien" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white">
                        <option value="Umum">Umum (Mandiri/Pribadi)</option>
                        <option value="BPJS">BPJS Kesehatan</option>
                    </select>
                </div>

                <!-- Poli Tujuan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Poliklinik Tujuan</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                        @foreach($polikliniks as $poli)
                        <label class="relative flex items-center justify-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="kode_poli" value="{{ $poli->kode_poli }}" class="absolute h-0 w-0 opacity-0 peer" required>
                            <div class="peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-1 peer-checked:ring-brand-500 absolute inset-0 rounded-xl transition-all"></div>
                            <div class="relative z-10 text-center">
                                <div class="text-brand-600 mb-1"><i class="fa-solid fa-stethoscope text-xl"></i></div>
                                <span class="block text-sm font-medium text-slate-800">{{ $poli->nama_poli }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 shadow-sm flex items-center transition-colors" {{ count($pasiens) == 0 ? 'disabled' : '' }}>
                    <i class="fa-solid fa-ticket mr-2"></i> Cetak Antrean
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
