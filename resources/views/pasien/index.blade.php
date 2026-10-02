@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Data Pasien</h1>
        <span class="bg-brand-100 text-brand-700 py-1 px-3 rounded-full text-xs font-bold border border-brand-200">
            {{ $pasiens->count() }} Total
        </span>
    </div>
</div>

@if(session('success'))
<div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
    <i class="fa-solid fa-circle-check text-green-500 text-xl mr-3"></i>
    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

<!-- Form Pembungkus untuk Hapus Data -->
<form id="actionForm" method="POST" action="">
    @csrf
    <input type="hidden" name="_method" id="formMethod" value="">

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-2">
        <div class="overflow-auto max-h-[calc(100vh-250px)] relative">
            <table class="min-w-full border-collapse border border-slate-300 text-xs">
                <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No. RM</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Pasien</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">NIK</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Penjamin</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No BPJS</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">L/P</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Tempat, Tgl Lahir</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Gol. Darah</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Agama</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Status</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Pendidikan</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Pekerjaan</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Ibu</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Alamat Lengkap</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No Telepon</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Penanggung Jawab</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($pasiens as $p)
                    <tr class="hover:bg-brand-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_{{ $p->nik }}').click();">
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-center">
                            <input type="radio" name="selected_pasien" id="radio_{{ $p->nik }}" value="{{ $p->nik }}" class="w-4 h-4 text-brand-600 focus:ring-brand-500 cursor-pointer" onchange="enableButtons('{{ $p->nik }}')">
                        </td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap font-mono text-slate-900 font-medium">{{ $p->no_rm }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap font-bold text-slate-900">{{ $p->nama }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700 font-mono">{{ $p->nik }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-center">
                            @if($p->jenis_pasien == 'BPJS')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">BPJS</span>
                            @else
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">UMUM</span>
                            @endif
                        </td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700 font-mono">{{ $p->no_kartu_bpjs ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-center text-slate-700">{{ $p->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">
                            {{ $p->tempat_lahir ?? '-' }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }} 
                            <span class="text-xs text-slate-500">({{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} th)</span>
                        </td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-center text-slate-700">{{ $p->golongan_darah ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->agama ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->status_pernikahan ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->pendidikan ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->pekerjaan ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->nama_ibu_kandung ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700 text-sm">
                            {{ $p->alamat ?? '-' }} 
                            {{ $p->rt ? 'RT '.$p->rt : '' }}{{ $p->rw ? '/RW '.$p->rw : '' }},
                            {{ $p->desa ?? '-' }}, {{ $p->kecamatan ?? '-' }}, {{ $p->kabupaten ?? '-' }}, {{ $p->provinsi ?? '-' }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700">{{ $p->no_telepon ?? '-' }}</td>
                        <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-slate-700 text-sm">
                            {{ $p->nama_penanggung_jawab ?? '-' }} 
                            @if($p->hubungan_penanggung_jawab) ({{ $p->hubungan_penanggung_jawab }}) @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16" class="px-4 py-8 text-center text-slate-500 border border-slate-300">
                            <i class="fa-solid fa-users text-3xl mb-3 text-slate-300 block"></i>
                            Belum ada data pasien tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button Bar Bawah (Fixed di Bawah Layar) -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] transition-all" id="buttonBar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Kiri: Kotak Pencarian & Info -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full md:w-auto">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari data (nama, desa, dll)..." class="pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 w-full transition-all bg-slate-50">
                </div>
                
                <div class="text-xs text-slate-500 hidden lg:flex items-center">
                    <i class="fa-solid fa-circle-info mr-1.5 text-brand-500"></i>
                    <span id="selectionText">Pilih data untuk diubah/dihapus.</span>
                </div>
            </div>
            
            <!-- Kanan: Tombol CRUD -->
            <div class="flex items-center gap-2 overflow-x-auto shrink-0 pb-1 md:pb-0">
                <a href="{{ route('pasien.create') }}" class="whitespace-nowrap bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-plus mr-1.5"></i> Tambah
                </a>
                
                <div class="h-6 w-px bg-slate-300 mx-1 hidden sm:block"></div>
                
                <button type="button" id="btnUbah" disabled onclick="doEdit()" class="whitespace-nowrap disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-amber-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                    <i class="fa-solid fa-pen-to-square mr-1.5"></i> Ubah
                </button>
                
                <button type="button" id="btnHapus" disabled onclick="doDelete()" class="whitespace-nowrap disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                    <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus
                </button>
            </div>
            
        </div>
    </div>
</form>

<!-- Script Logic untuk Tombol -->
<script>
    let selectedId = null;

    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector("tbody");
        const rows = tbody.querySelectorAll("tr");

        rows.forEach(row => {
            // Lewati baris "Belum ada data tersimpan"
            if (row.cells.length === 1) return;
            
            const textContent = row.textContent.toLowerCase();
            if (textContent.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function enableButtons(id) {
        selectedId = id;
        document.getElementById('btnUbah').disabled = false;
        document.getElementById('btnHapus').disabled = false;
        
        // Highlight active row & Update selection text
        const radios = document.querySelectorAll('input[name="selected_pasien"]');
        let patientName = '';
        
        radios.forEach(radio => {
            const row = radio.closest('tr');
            if (radio.checked) {
                row.classList.add('bg-brand-50');
                // Ambil nama dari kolom tabel ke-3 (index 3)
                patientName = row.cells[3].innerText.trim();
            } else {
                row.classList.remove('bg-brand-50');
            }
        });
        
        document.getElementById('selectionText').innerHTML = `Data terpilih: <strong class="text-slate-800">${patientName}</strong>`;
        document.getElementById('buttonBar').classList.add('border-brand-300', 'ring-1', 'ring-brand-200');
    }

    function doEdit() {
        if (!selectedId) return;
        // Arahkan ke halaman edit
        window.location.href = `/pasien/${selectedId}/edit`;
    }

    function doDelete() {
        if (!selectedId) return;
        if (confirm('Yakin ingin menghapus data pasien ini? Tindakan ini tidak dapat dibatalkan.')) {
            const form = document.getElementById('actionForm');
            form.action = `/pasien/${selectedId}`;
            document.getElementById('formMethod').value = 'DELETE';
            form.submit();
        }
    }
</script>
@endsection
