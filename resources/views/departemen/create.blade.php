@extends('layouts.app')

@section('title', 'Tambah Departemen Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('departemen.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Tambah Data Departemen</h1>
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
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-building-user text-brand-500 mr-2"></i>Informasi Departemen</h2>
        </div>
        
        <form action="{{ route('departemen.store') }}" method="POST" class="p-6" novalidate>
            @csrf
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-semibold text-slate-700">ID Departemen <span class="text-red-500">*</span></label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="auto_id" checked class="form-checkbox h-4 w-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500 transition duration-150 ease-in-out" onchange="toggleIdInput()">
                            <span class="ml-2 text-xs font-medium text-slate-600">Buat Otomatis (Auto-Generate)</span>
                        </label>
                    </div>
                    <input type="text" id="id_departemen" name="id_departemen" value="{{ old('id_departemen') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-slate-100 cursor-not-allowed" placeholder="Otomatis (Misal: DPT-007)" readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_departemen" value="{{ old('nama_departemen') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Contoh: Keuangan, HRD, Pelayanan Medis">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Penjelasan singkat tentang departemen ini...">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('departemen.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleIdInput() {
        const checkbox = document.getElementById('auto_id');
        const input = document.getElementById('id_departemen');
        
        if (checkbox.checked) {
            input.readOnly = true;
            input.classList.add('bg-slate-100', 'cursor-not-allowed');
            input.value = '';
            input.placeholder = 'Otomatis (Misal: DPT-007)';
        } else {
            input.readOnly = false;
            input.classList.remove('bg-slate-100', 'cursor-not-allowed');
            input.placeholder = 'Ketik ID Departemen (Misal: DPT-007)';
            input.focus();
        }
    }

    // Run on load in case of validation error (old input)
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('id_departemen');
        const checkbox = document.getElementById('auto_id');
        if (input.value.trim() !== '') {
            checkbox.checked = false;
            toggleIdInput();
        }
    });
</script>
@endsection
