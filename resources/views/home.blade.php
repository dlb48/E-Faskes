@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="w-full">
    
    <!-- Combo Box Utama diletakkan di bawah menu bar (full width) -->
    <div class="w-full relative mb-6">
        <select id="groupSelect" onchange="showGroup(this.value)" class="block w-full pl-4 pr-10 py-2.5 text-slate-700 font-bold border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-lg shadow-sm bg-white cursor-pointer appearance-none transition-all hover:border-brand-300">
            <option value="" class="text-slate-400">-- Pilih Kelompok Menu / Tampilan Layar Kosong --</option>
            <option value="group1">Layanan & Operasional</option>
            <option value="group2">Master Data</option>
            <option value="group3">Kepegawaian</option>
            <option value="group4">Farmasi & Keuangan</option>
            <option value="group5">Pengaturan</option>
            <option value="group6">Bridging BPJS</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
            <i class="fa-solid fa-chevron-down text-sm"></i>
        </div>
    </div>

    <!-- Container Menus -->
    <div id="menusContainer" class="mt-4 transition-all duration-300">
        
        <!-- Kelompok 1: Layanan & Operasional -->
        <div id="group1" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-stethoscope text-blue-500 mr-2"></i> Layanan & Operasional</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <a href="{{ route('pendaftaran.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-clipboard-user text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Pendaftaran</span>
                </a>
                <a href="{{ route('rawat_jalan.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-stethoscope text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Rawat Jalan</span>
                </a>
                <a href="#" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-bed-pulse text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Rawat Inap</span>
                </a>
            </div>
        </div>

        <!-- Kelompok 2: Master Data -->
        <div id="group2" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-database text-emerald-500 mr-2"></i> Master Data</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <a href="{{ route('penjamin.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-emerald-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-emerald-50 transition-colors shrink-0">
                        <i class="fa-solid fa-hand-holding-dollar text-slate-400 group-hover:text-emerald-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-emerald-700 text-sm">Penjamin</span>
                </a>
                <a href="{{ route('jadwal.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-emerald-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-emerald-50 transition-colors shrink-0">
                        <i class="fa-solid fa-calendar-check text-slate-400 group-hover:text-emerald-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-emerald-700 text-sm">Jadwal Dokter</span>
                </a>
                <a href="{{ route('poliklinik.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-emerald-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-emerald-50 transition-colors shrink-0">
                        <i class="fa-solid fa-house-medical text-slate-400 group-hover:text-emerald-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-emerald-700 text-sm">Poliklinik</span>
                </a>
                <a href="{{ route('pasien.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-emerald-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-emerald-50 transition-colors shrink-0">
                        <i class="fa-solid fa-users text-slate-400 group-hover:text-emerald-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-emerald-700 text-sm">Data Pasien</span>
                </a>
                <a href="{{ route('icd10.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-emerald-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-emerald-50 transition-colors shrink-0">
                        <i class="fa-solid fa-book-medical text-slate-400 group-hover:text-emerald-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-emerald-700 text-sm">ICD-10</span>
                </a>
            </div>
        </div>

        <!-- Kelompok 3: Kepegawaian -->
        <div id="group3" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-id-card-clip text-indigo-500 mr-2"></i> Kepegawaian</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <a href="{{ route('jabatan.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-indigo-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 transition-colors shrink-0">
                        <i class="fa-solid fa-id-badge text-slate-400 group-hover:text-indigo-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-indigo-700 text-sm">Jabatan</span>
                </a>
                <a href="{{ route('departemen.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-indigo-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 transition-colors shrink-0">
                        <i class="fa-solid fa-building-user text-slate-400 group-hover:text-indigo-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-indigo-700 text-sm">Departemen</span>
                </a>
                <a href="{{ route('pegawai.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-indigo-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 transition-colors shrink-0">
                        <i class="fa-solid fa-user-tie text-slate-400 group-hover:text-indigo-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-indigo-700 text-sm">Pegawai</span>
                </a>
                <a href="{{ route('dokter.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-indigo-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 transition-colors shrink-0">
                        <i class="fa-solid fa-user-doctor text-slate-400 group-hover:text-indigo-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-indigo-700 text-sm">Dokter</span>
                </a>
                <a href="{{ route('perawat.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-indigo-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 transition-colors shrink-0">
                        <i class="fa-solid fa-user-nurse text-slate-400 group-hover:text-indigo-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-indigo-700 text-sm">Perawat</span>
                </a>
            </div>
        </div>

        <!-- Kelompok 4: Farmasi & Keuangan -->
        <div id="group4" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-pills text-amber-500 mr-2"></i> Farmasi & Keuangan</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <a href="#" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-amber-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-amber-50 transition-colors shrink-0">
                        <i class="fa-solid fa-prescription-bottle-medical text-slate-400 group-hover:text-amber-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-amber-700 text-sm">Apotek</span>
                </a>
                <a href="#" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-amber-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-amber-50 transition-colors shrink-0">
                        <i class="fa-solid fa-cash-register text-slate-400 group-hover:text-amber-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-amber-700 text-sm">Kasir</span>
                </a>
            </div>
        </div>

        <!-- Kelompok 6: Bridging BPJS -->
        <div id="group6" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-bridge text-blue-500 mr-2"></i> Bridging BPJS</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                
                <a href="{{ route('mapping.dokter') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-user-doctor text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Mapping Dokter</span>
                </a>

                <a href="{{ route('mapping.poli') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-house-medical text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Mapping Poli</span>
                </a>

                <a href="{{ route('pengaturan.bpjs.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-blue-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-blue-50 transition-colors shrink-0">
                        <i class="fa-solid fa-satellite-dish text-slate-400 group-hover:text-blue-600 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-blue-700 text-sm">Bridging JKN v2</span>
                </a>

            </div>
        </div>

        <!-- Kelompok 5: Pengaturan -->
        <div id="group5" class="menu-group hidden fade-in">
            <div class="mb-4 border-b border-slate-200 pb-2">
                <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-gear text-slate-500 mr-2"></i> Pengaturan</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <a href="{{ route('sampah.index') }}" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-slate-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-trash-can text-slate-400 group-hover:text-slate-700 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-slate-900 text-sm">Sampah</span>
                </a>
                <a href="#" class="flex items-center p-3 border border-slate-200 rounded-lg hover:border-slate-400 hover:shadow-sm transition-all group bg-white">
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-desktop text-slate-400 group-hover:text-slate-700 text-lg transition-colors"></i>
                    </div>
                    <span class="font-semibold text-slate-700 group-hover:text-slate-900 text-sm">Aplikasi</span>
                </a>
</div>
        </div>
        
    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function showGroup(groupId) {
        // Sembunyikan semua grup
        document.querySelectorAll('.menu-group').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Tampilkan grup yang dipilih
        if (groupId) {
            document.getElementById(groupId).classList.remove('hidden');
            // Simpan pilihan terakhir ke memori peramban (localStorage)
            localStorage.setItem('last_active_group', groupId);
        } else {
            // Hapus ingatan jika pilih "Pilih Kelompok Menu..."
            localStorage.removeItem('last_active_group');
        }
    }
    
    // Inisialisasi status awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        // Cek apakah ada ingatan kelompok terakhir yang dibuka
        const savedGroup = localStorage.getItem('last_active_group');
        const groupSelect = document.getElementById('groupSelect');
        
        if (savedGroup && document.getElementById(savedGroup)) {
            // Jika ada, otomatis pilih dan tampilkan
            groupSelect.value = savedGroup;
            showGroup(savedGroup);
        } else {
            // Jika tidak ada, kosongkan
            groupSelect.value = '';
        }
    });
</script>
@endsection















