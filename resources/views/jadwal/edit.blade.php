@extends('layouts.app')

@section('title', 'Ubah Jadwal Dokter')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('jadwal.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-brand-600 transition-colors shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Ubah Jadwal Praktik</h1>
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
    
    @if(session('error'))
    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
        <div class="flex items-center">
            <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
            <span class="text-red-800 font-bold text-sm">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex justify-between items-center">
            <h2 class="font-semibold text-slate-800"><i class="fa-regular fa-calendar-check text-brand-500 mr-2"></i>Form Jadwal Praktik</h2>
            <span class="text-xs bg-slate-200 text-slate-600 px-2 py-1 rounded font-mono">ID: {{ $jadwal->id }}</span>
        </div>
        
        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" class="p-6" id="formUpdate" novalidate>
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Dokter <span class="text-red-500">*</span></label>
                    <select name="id_dokter" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-slate-50 text-slate-500" readonly>
                        <option value="{{ $jadwal->id_dokter }}">{{ $jadwal->id_dokter }} - {{ $jadwal->dokter->pegawai->nama_lengkap ?? '' }}</option>
                    </select>
                    <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-info-circle mr-1"></i>Dokter tidak dapat diubah. Buat jadwal baru jika ini dokter yang berbeda.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Poliklinik <span class="text-red-500">*</span></label>
                    <select name="poliklinik_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($polikliniks as $poli)
                            <option value="{{ $poli->kode_poli }}" {{ old('poliklinik_id', $jadwal->poliklinik_id) == $poli->kode_poli ? 'selected' : '' }}>
                                {{ $poli->nama_poli }} ({{ $poli->kode_poli }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 border-t border-slate-200 pt-4 mt-2">
                    <h3 class="font-bold text-slate-800 mb-4 text-sm"><i class="fa-regular fa-clock text-brand-500 mr-2"></i>Waktu Praktik</h3>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Hari --</option>
                        <option value="1" {{ old('hari', $jadwal->hari) == '1' ? 'selected' : '' }}>Senin</option>
                        <option value="2" {{ old('hari', $jadwal->hari) == '2' ? 'selected' : '' }}>Selasa</option>
                        <option value="3" {{ old('hari', $jadwal->hari) == '3' ? 'selected' : '' }}>Rabu</option>
                        <option value="4" {{ old('hari', $jadwal->hari) == '4' ? 'selected' : '' }}>Kamis</option>
                        <option value="5" {{ old('hari', $jadwal->hari) == '5' ? 'selected' : '' }}>Jumat</option>
                        <option value="6" {{ old('hari', $jadwal->hari) == '6' ? 'selected' : '' }}>Sabtu</option>
                        <option value="7" {{ old('hari', $jadwal->hari) == '7' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kuota Pasien <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="kuota" value="{{ old('kuota', $jadwal->kuota) }}" min="0" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <div class="absolute right-3 top-2 text-xs text-slate-400 font-medium">Orang (0 = Tanpa Batas)</div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div class="md:col-span-2 mt-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Jadwal <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ old('status_aktif', $jadwal->status_aktif) == '1' ? 'border-brand-300 bg-brand-50' : '' }}">
                            <input type="radio" name="status_aktif" value="1" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500" {{ old('status_aktif', $jadwal->status_aktif) == '1' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">Jadwal Aktif (Buka)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ old('status_aktif', $jadwal->status_aktif) == '0' ? 'border-red-300 bg-red-50' : '' }}">
                            <input type="radio" name="status_aktif" value="0" class="w-4 h-4 text-red-600 border-slate-300 focus:ring-red-500" {{ old('status_aktif', $jadwal->status_aktif) == '0' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">Tutup / Libur Sementara</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Fixed action buttons -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-end gap-3">
            <a href="{{ route('jadwal.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" form="formUpdate" class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Perbarui Jadwal
            </button>
        </div>
    </div>
</div>

<script>
    // Style active radio button container
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[type="radio"]').forEach(r => {
                const label = r.closest('label');
                if (r.checked) {
                    if(r.value === '1') {
                        label.classList.add('border-brand-300', 'bg-brand-50');
                    } else {
                        label.classList.add('border-red-300', 'bg-red-50');
                    }
                } else {
                    label.classList.remove('border-brand-300', 'bg-brand-50', 'border-red-300', 'bg-red-50');
                }
            });
        });
    });
</script>
@endsection
