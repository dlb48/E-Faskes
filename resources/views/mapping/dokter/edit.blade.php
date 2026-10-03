@extends('layouts.app')

@section('title', 'Ubah Mapping Dokter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('mapping.dokter') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Ubah Mapping Dokter BPJS</h1>
            <p class="text-sm text-slate-500 mt-1">Ubah referensi dokter BPJS untuk dokter lokal ini</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('mapping.dokter.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="flex flex-col md:flex-row items-center gap-6 w-full">
                <!-- Box 1: Dokter Lokal -->
                <div class="bg-indigo-50/50 p-5 rounded-xl border border-indigo-100 flex-1 w-full opacity-80 cursor-not-allowed">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <h3 class="font-bold text-indigo-900">Data Faskes (Lokal)</h3>
                    </div>
                    
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dokter Lokal</label>
                    <input type="hidden" name="id_dokter_lokal" value="{{ $dokter->id_dokter }}">
                    <input type="text" disabled value="{{ $dokter->pegawai->nama_lengkap ?? 'Tanpa Nama' }} ({{ $dokter->poliklinik->nama_poli ?? 'Tanpa Poli' }})" class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-100 text-slate-600 font-medium">
                    <p class="text-xs text-slate-500 mt-2">Data faskes tidak dapat diubah dari menu ini.</p>
                </div>

                <!-- Ikon Panah -->
                <div class="hidden md:flex shrink-0 items-center justify-center z-10">
                    <div class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm text-slate-400">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </div>
                </div>

                <!-- Box 2: Dokter BPJS -->
                <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 flex-1 w-full">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-satellite-dish"></i>
                        </div>
                        <h3 class="font-bold text-blue-900">Referensi BPJS Pusat</h3>
                    </div>
                    
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dokter BPJS Terpilih</label>
                    <!-- Hidden input to store the actual code -->
                    <input type="hidden" name="kode_dokter_bpjs" id="kode_dokter_bpjs" value="{{ $dokter->kode_bpjs }}" required>
                    <!-- Readonly input for display -->
                    <input type="text" id="nama_dokter_bpjs" readonly placeholder="Belum ada referensi BPJS yang dipilih" class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-100 text-slate-600 font-medium cursor-not-allowed focus:outline-none text-center">
                    
                    <button type="button" onclick="openModalBpjs()" class="w-full mt-3 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center justify-center gap-2 font-medium">
                        <i class="fa-solid fa-search"></i> Cari Referensi BPJS
                    </button>
                    <p class="text-xs text-center text-slate-500 mt-2">Klik tombol di atas untuk mencari data dari server BPJS.</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('mapping.dokter') }}" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pencarian BPJS -->
<div id="modalBpjs" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModalBpjs()"></div>
    
    <!-- Modal Content -->
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl relative z-10 flex flex-col max-h-[90vh] mx-4">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50 rounded-t-xl">
            <h3 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-search text-brand-600 mr-2"></i> Cari Referensi Dokter BPJS</h3>
            <button type="button" onclick="closeModalBpjs()" class="text-slate-400 hover:text-rose-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6 flex-1 overflow-hidden flex flex-col">
            <div class="flex gap-2 mb-4">
                <input type="text" id="inputSearchBpjs" placeholder="Ketik nama dokter (minimal 3 huruf)..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" onkeypress="if(event.key === 'Enter') { event.preventDefault(); executeSearchBpjs(); }">
                <button type="button" onclick="executeSearchBpjs()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
            </div>
            
            <div class="bg-blue-50 text-blue-800 text-xs px-3 py-2 rounded-lg mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i> Pencarian akan dilakukan langsung ke server BPJS Kesehatan.
            </div>

            <!-- Area Hasil -->
            <div class="border border-slate-200 rounded-lg overflow-hidden flex-1 flex flex-col min-h-[250px]">
                <div class="overflow-y-auto flex-1 bg-slate-50 relative" id="resultContainerBpjs">
                    <!-- Default State -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400" id="emptyStateBpjs">
                        <i class="fa-solid fa-satellite-dish text-4xl mb-3 text-slate-300"></i>
                        <p class="text-sm">Ketik kata kunci dan klik Cari untuk memunculkan data.</p>
                    </div>
                    
                    <!-- Loading State -->
                    <div class="absolute inset-0 flex-col items-center justify-center text-brand-600 hidden" id="loadingStateBpjs">
                        <i class="fa-solid fa-circle-notch fa-spin text-4xl mb-3"></i>
                        <p class="text-sm font-medium animate-pulse">Menarik data dari BPJS...</p>
                    </div>

                    <!-- List Hasil -->
                    <ul class="divide-y divide-slate-200 bg-white hidden" id="listResultBpjs">
                        <!-- Items appended here via JS -->
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl flex justify-end">
            <button type="button" onclick="closeModalBpjs()" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Modal Logic
    const modalBpjs = document.getElementById("modalBpjs");
    const inputSearch = document.getElementById("inputSearchBpjs");
    const emptyState = document.getElementById("emptyStateBpjs");
    const loadingState = document.getElementById("loadingStateBpjs");
    const listResult = document.getElementById("listResultBpjs");

    function openModalBpjs() {
        modalBpjs.classList.remove("hidden");
        modalBpjs.classList.add("flex");
        inputSearch.focus();
    }

    function closeModalBpjs() {
        modalBpjs.classList.add("hidden");
        modalBpjs.classList.remove("flex");
    }

    function executeSearchBpjs() {
        const keyword = inputSearch.value.trim();
        
        if (keyword.length < 3) {
            Swal.fire("Peringatan", "Minimal masukkan 3 huruf untuk mencari.", "warning");
            return;
        }

        emptyState.classList.add("hidden");
        listResult.classList.add("hidden");
        loadingState.classList.remove("hidden");
        loadingState.classList.add("flex");
        listResult.innerHTML = "";

        fetch(`/mapping/dokter/search-bpjs?keyword=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(res => {
                loadingState.classList.remove("flex");
                loadingState.classList.add("hidden");
                
                if(res.success && res.data.length > 0) {
                    res.data.forEach(item => {
                        const li = document.createElement("li");
                        li.className = "p-4 hover:bg-blue-50 cursor-pointer transition-colors flex items-center justify-between group";
                        li.innerHTML = `
                            <div>
                                <div class="font-bold text-slate-800 text-sm mb-1">${item.kddokter} - ${item.nmdokter}</div>
                                <div class="text-xs text-slate-500">Dokter BPJS JKN</div>
                            </div>
                            <button type="button" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded text-xs font-semibold group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                Pilih
                            </button>
                        `;
                        
                        li.addEventListener("click", () => {
                            pilihReferensiBpjs(item.kddokter, item.nmdokter);
                        });
                        
                        listResult.appendChild(li);
                    });
                    listResult.classList.remove("hidden");
                } else {
                    emptyState.innerHTML = `<i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300"></i><p class="text-sm">Data referensi tidak ditemukan.</p>`;
                    emptyState.classList.remove("hidden");
                }
            })
            .catch(err => {
                loadingState.classList.remove("flex");
                loadingState.classList.add("hidden");
                Swal.fire("Error", "Terjadi kesalahan saat menghubungi server BPJS.", "error");
                emptyState.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-4xl mb-3 text-rose-300"></i><p class="text-sm text-rose-500">Gagal menarik data.</p>`;
                emptyState.classList.remove("hidden");
            });
    }

    function pilihReferensiBpjs(kode, nama) {
        document.getElementById("kode_dokter_bpjs").value = kode;
        document.getElementById("nama_dokter_bpjs").value = `${kode} - ${nama}`;
        
        const inputVisual = document.getElementById("nama_dokter_bpjs");
        inputVisual.classList.add("ring-2", "ring-green-500", "bg-green-50");
        setTimeout(() => {
            inputVisual.classList.remove("ring-2", "ring-green-500", "bg-green-50");
        }, 1000);
        
        closeModalBpjs();
    }

    document.addEventListener("DOMContentLoaded", () => {
        const initialVal = document.getElementById("kode_dokter_bpjs").value;
        if(initialVal) {
            document.getElementById("nama_dokter_bpjs").value = initialVal + " (Kode BPJS)";
        }
    });
</script>

@endsection




