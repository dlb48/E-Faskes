@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
<div class="max-w-7xl mx-auto pb-20">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Tempat Sampah</h1>
    </div>

    <!-- Form Pembungkus untuk Restore/Force Delete -->
    <form id="actionForm" method="POST" action="" novalidate>
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="">

        <!-- Data Pasien -->
        @if($data['pasien']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-users mr-2 text-slate-400"></i> Pasien ({{ $data['pasien']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">NIK</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['pasien'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_pasien_{{ $d->nik }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="radio" name="selected_d" id="radio_pasien_{{ $d->nik }}" value="{{ $d->nik }}" 
                                       class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                       onclick="enableButtons('pasien', '{{ $d->nik }}', '{{ addslashes($d->nama_pasien) }}'); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->nik }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_pasien }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Pegawai -->
        @if($data['pegawai']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-tie mr-2 text-slate-400"></i> Pegawai ({{ $data['pegawai']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">NIP</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Lengkap</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['pegawai'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_pegawai_{{ $d->nip }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="radio" name="selected_d" id="radio_pegawai_{{ $d->nip }}" value="{{ $d->nip }}" 
                                       class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                       onclick="enableButtons('pegawai', '{{ $d->nip }}', '{{ addslashes($d->nama_lengkap) }}'); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->nip }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_lengkap }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Dokter -->
        @if($data['dokter']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-doctor mr-2 text-slate-400"></i> Dokter ({{ $data['dokter']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Dokter</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['dokter'] as $d)
                        @php $name = $d->pegawai ? $d->pegawai->nama_lengkap : $d->nip; @endphp
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_dokter_{{ $d->id_dokter }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="radio" name="selected_d" id="radio_dokter_{{ $d->id_dokter }}" value="{{ $d->id_dokter }}" 
                                       class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                       onclick="enableButtons('dokter', '{{ $d->id_dokter }}', '{{ addslashes($name) }}'); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_dokter }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Perawat -->
        @if($data['perawat']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-nurse mr-2 text-slate-400"></i> Perawat ({{ $data['perawat']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Perawat</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['perawat'] as $d)
                        @php $name = $d->pegawai ? $d->pegawai->nama_lengkap : $d->nip; @endphp
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_perawat_{{ $d->id_perawat }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="radio" name="selected_d" id="radio_perawat_{{ $d->id_perawat }}" value="{{ $d->id_perawat }}" 
                                       class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                       onclick="enableButtons('perawat', '{{ $d->id_perawat }}', '{{ addslashes($name) }}'); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_perawat }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Poliklinik -->
        @if($data['poliklinik']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-house-medical mr-2 text-slate-400"></i> Poliklinik ({{ $data['poliklinik']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Kode Poli</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Poli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['poliklinik'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_poliklinik_{{ $d->kode_poli }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="radio" name="selected_d" id="radio_poliklinik_{{ $d->kode_poli }}" value="{{ $d->kode_poli }}" 
                                       class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                       onclick="enableButtons('poliklinik', '{{ $d->kode_poli }}', '{{ addslashes($d->nama_poli) }}'); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->kode_poli }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_poli }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Button Bar Bawah (Action Bar) -->
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <div class="text-xs text-slate-500 flex items-center">
                    <i class="fa-solid fa-circle-info mr-1.5 text-brand-500"></i>
                    <span id="selectionText">Pilih satu data untuk dipulihkan atau dihapus permanen.</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <button type="button" id="btnPulihkan" disabled onclick="doRestore()" class="disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i> Pulihkan
                    </button>
                    
                    <button type="button" id="btnHapus" disabled onclick="doForceDelete()" class="disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                        <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus Permanen
                    </button>
                </div>
                
            </div>
        </div>
    </form>

    @if($data['pasien']->count() == 0 && $data['pegawai']->count() == 0 && $data['dokter']->count() == 0 && $data['perawat']->count() == 0 && $data['poliklinik']->count() == 0)
    <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-slate-200">
        <i class="fa-solid fa-trash-can-arrow-up text-5xl text-slate-300 mb-4 block"></i>
        <h3 class="text-xl font-bold text-slate-700">Tempat Sampah Kosong</h3>
        <p class="text-slate-500 mt-2">Tidak ada data yang dihapus saat ini.</p>
    </div>
    @endif
</div>

<script>
    let selectedType = null;
    let selectedId = null;

    function enableButtons(type, id, name) {
        selectedType = type;
        selectedId = id;
        
        document.getElementById('btnPulihkan').disabled = false;
        document.getElementById('btnHapus').disabled = false;
        
        document.getElementById('selectionText').innerHTML = `Terpilih: <strong class="capitalize">${type}</strong> - <strong>${name}</strong>`;
        
        // Hapus highlight dari semua baris
        document.querySelectorAll('tr').forEach(tr => tr.classList.remove('bg-blue-50'));
        
        // Highlight baris yang dipilih
        const selectedRadio = document.getElementById('radio_' + type + '_' + id);
        if (selectedRadio) {
            selectedRadio.closest('tr').classList.add('bg-blue-50');
        }
    }

    function doRestore() {
        if (!selectedId || !selectedType) return;
        
        const form = document.getElementById('actionForm');
        form.action = `/sampah/${selectedType}/${selectedId}/restore`;
        document.getElementById('formMethod').value = 'POST';
        form.submit();
    }

    function doForceDelete() {
        if (!selectedId || !selectedType) return;
        
        Swal.fire({
            title: 'Hapus Permanen?',
            text: 'Data yang dihapus permanen tidak dapat dikembalikan! Sistem akan membatalkan penghapusan otomatis jika data masih terhubung dengan tabel lain.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('actionForm');
                form.action = `/sampah/${selectedType}/${selectedId}`;
                document.getElementById('formMethod').value = 'DELETE';
                form.submit();
            }
        });
    }
</script>
@endsection

