
@extends('layouts.app')

@section('title', 'Buat Antrean Baru')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('pendaftaran.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Buat Antrean</h1>
                <p class="text-sm text-slate-500 mt-1">Pendaftaran pasien ke antrean poliklinik</p>
            </div>
        </div>
        <div>
            <a href="{{ route('pasien.create') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 shadow-sm transition-colors flex items-center">
                <i class="fa-solid fa-user-plus mr-2"></i> Pasien Baru
            </a>
        </div>
    </div>

    <form action="{{ route('pendaftaran.store') }}" method="POST" id="mainForm" novalidate>
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Kolom Kiri: Cari & Pilih Pasien -->
            <div class="lg:col-span-4 flex flex-col h-[calc(100vh-220px)]">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center justify-between gap-3 h-[60px]">
                        <h3 class="text-sm font-bold text-slate-800 flex-shrink-0"><i class="fa-solid fa-magnifying-glass mr-2 text-brand-500"></i> Cari Pasien</h3>
                        <div class="relative w-full max-w-[220px]">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                <i class="fa-solid fa-search text-slate-400 text-xs"></i>
                            </div>
                            <input type="text" id="searchInput" autofocus onkeyup="filterPasien()" placeholder="Ketik NIK, Nama..." class="w-full pl-8 pr-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-brand-500 bg-white transition-all">
                        </div>
                    </div>

                    <!-- Wrapper List Pasien & Pagination -->
                    <div id="pasienListWrapper" class="flex flex-col flex-1 overflow-hidden relative">
                        <!-- Loading Overlay -->
                        <div id="loadingOverlay" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-10 flex items-center justify-center hidden">
                            <i class="fa-solid fa-spinner fa-spin text-2xl text-brand-500"></i>
                        </div>
                        
                        @include('pendaftaran._pasien_list')
                    </div>

                </div>
            </div>

            <!-- Kolom Kanan: Poliklinik & Simpan -->
            <div class="lg:col-span-8 flex flex-col h-[calc(100vh-220px)]">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center h-[60px]">
                        <h3 class="text-sm font-bold text-slate-800"><i class="fa-solid fa-stethoscope mr-2 text-brand-500"></i> Informasi Layanan</h3>
                    </div>

                    <div class="flex-1 overflow-y-auto p-5">
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Penjamin <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach($penjamins as $penj)
                                <label class="flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="id_penjamin" value="{{ $penj->id_penjamin }}" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required>
                                    <span class="ml-2 text-sm font-medium text-slate-700">{{ $penj->nama_penjamin }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Poliklinik Tujuan <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                                @foreach($polikliniks as $poli)
                                <label class="relative flex items-center justify-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="kode_poli" value="{{ $poli->kode_poli }}" class="absolute h-0 w-0 opacity-0 peer" required>
                                    <div class="peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-1 peer-checked:ring-brand-500 absolute inset-0 rounded-xl transition-all"></div>
                                    <div class="relative z-10 text-center">
                                        <div class="text-brand-600 mb-1"><i class="fa-solid fa-user-doctor text-xl"></i></div>
                                        <span class="block text-[13px] font-bold text-slate-700">{{ $poli->nama_poli }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="px-4 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-end h-[60px]">
                        <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-lg text-sm font-bold hover:bg-brand-700 shadow-sm flex items-center transition-all disabled:opacity-50" id="btnSubmitMain">
                            <i class="fa-solid fa-print mr-2"></i> Cetak Antrean
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>


@endsection

@section('scripts')
<script>
    let searchTimeout;
    
    function filterPasien() {
        clearTimeout(searchTimeout);
        const filter = document.getElementById("searchInput").value;
        const loadingOverlay = document.getElementById("loadingOverlay");
        
        searchTimeout = setTimeout(() => {
            loadingOverlay.classList.remove("hidden");
            
            fetch(`{{ route('pendaftaran.create') }}?search=${filter}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById("pasienListWrapper").innerHTML = `
                    <div id="loadingOverlay" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-10 flex items-center justify-center hidden">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-brand-500"></i>
                    </div>
                    ${html}
                `;
            })
            .catch(error => console.error("Error fetching data:", error));
        }, 300); // 300ms debounce
    }
    
    // Tangani klik pagination secara AJAX (Event Delegation)
    document.addEventListener("click", function(e) {
        // Cek apakah yang diklik adalah link pagination
        const paginationLink = e.target.closest(".pasien-pagination a");
        if (paginationLink) {
            e.preventDefault(); // Mencegah pindah halaman
            
            const url = paginationLink.getAttribute("href");
            const loadingOverlay = document.getElementById("loadingOverlay");
            
            if (loadingOverlay) loadingOverlay.classList.remove("hidden");
            
            fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById("pasienListWrapper").innerHTML = `
                    <div id="loadingOverlay" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-10 flex items-center justify-center hidden">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-brand-500"></i>
                    </div>
                    ${html}
                `;
            })
            .catch(error => console.error("Error fetching data:", error));
        }
    });


</script>
@endsection







