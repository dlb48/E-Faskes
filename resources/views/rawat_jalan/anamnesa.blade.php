@extends('layouts.app')

@section('title', 'Anamnesa & Diagnosa: ' . $pendaftaran->pasien->nama)

@section('content')
<!-- FULL SCREEN LAYOUT CONTAINER -->
<div class="flex h-[calc(100vh-4rem)] -mx-6 -mt-6 -mb-4 bg-slate-50 text-sm border-t border-slate-200">
    
    <!-- SIDEBAR KIRI -->
    <div class="w-64 bg-white border-r border-slate-200 flex flex-col shrink-0 z-10">
        <!-- Info Pasien (Data Pasien) -->
        <div class="p-5 border-b border-slate-200 bg-white">
            <h3 class="font-semibold text-slate-900 text-base leading-tight">{{ $pendaftaran->pasien->nama }}</h3>
            <p class="text-xs text-slate-500 mt-2">RM: <span class="font-bold text-slate-700">{{ $pendaftaran->pasien->no_rm ?? '-' }}</span></p>
            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($pendaftaran->pasien->tanggal_lahir)->age }} Thn &bull; {{ $pendaftaran->pasien->jenis_kelamin }}</p>
            <div class="mt-3">
                 <span class="px-2.5 py-1 {{ $pendaftaran->penjamin && str_contains(strtolower($pendaftaran->penjamin->nama_penjamin), 'bpjs') ? 'bg-sky-100 text-sky-900' : 'bg-slate-100 text-slate-700' }} text-[11px] font-bold rounded-md uppercase tracking-wide">
                    {{ $pendaftaran->penjamin ? $pendaftaran->penjamin->nama_penjamin : 'UMUM' }}
                </span>
            </div>
        </div>

        <!-- Daftar Menu -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <a href="{{ route('rawat_jalan.assesmen', $pendaftaran->id) }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-user-nurse w-5 text-center mr-2 text-slate-400"></i> 1. Asesmen Awal<br>Keperawatan
            </a>
            <a href="{{ route('rawat_jalan.anamnesa', $pendaftaran->id) }}" class="flex items-center px-4 py-3 bg-brand-50 text-brand-700 border border-brand-100 font-bold text-[11px] rounded-lg shadow-sm leading-tight">
                <i class="fa-solid fa-user-doctor w-5 text-center mr-2"></i> 2. Anamnesa &<br>Diagnosa
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-syringe w-5 text-center mr-2 text-slate-400"></i> 3. Tindakan
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-microscope w-5 text-center mr-2 text-slate-400"></i> 4. Pemeriksaan<br>Penunjang
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-pills w-5 text-center mr-2 text-slate-400"></i> 5. Resep Dokter
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-notes-medical w-5 text-center mr-2 text-slate-400"></i> 6. Catatan Dokter
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center mr-2 text-slate-400"></i> 7. Riwayat Pasien
            </a>
        </nav>
        
        <!-- Tombol Kembali -->
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            <a href="{{ route('rawat_jalan.index') }}" class="w-full flex items-center justify-center px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-300 hover:bg-slate-100 rounded-lg transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA KANAN -->
    <div class="flex-1 flex flex-col relative min-w-0">
        
        <!-- JUDUL HEADER -->
        <div class="px-6 py-4 bg-white border-b border-slate-200 shrink-0 z-10">
            <h1 class="text-xl font-bold text-slate-900 leading-tight flex items-center"><i class="fa-solid fa-user-doctor mr-2.5 text-brand-500"></i> Anamnesa & Diagnosa</h1>
            <p class="text-xs text-slate-500 mt-1">Catat keluhan, riwayat penyakit, alergi, dan diagnosa (ICD-10).</p>
        </div>

        <!-- AREA SCROLL KONTEN TENGAH -->
        <div class="flex-1 overflow-y-auto p-6">
            
            <!-- TABEL RIWAYAT MEDIS TERSIMPAN -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-6">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center rounded-t-xl">
                    <h2 class="font-bold text-slate-700 text-xs flex items-center">
                        <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-400"></i> Data Anamnesa & Diagnosa
                    </h2>
                    <span class="text-[10px] text-slate-500 font-medium bg-slate-200 px-2 py-0.5 rounded-full">Total: {{ $riwayatMedis->count() }} Data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-slate-300 text-xs" id="dataTable">
                        <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase w-10 text-center">No</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Tanggal / Waktu</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Poli</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Keluhan Utama</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">RPS & RPD</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Fisik & Alergi</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Kasus</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Kesadaran</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Diagnosa (ICD-10)</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Plan / Ket</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($riwayatMedis as $idx => $rw)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border border-slate-300 px-3 py-2 text-center text-slate-500">{{ $idx + 1 }}</td>
                                <td class="border border-slate-300 px-3 py-2 whitespace-nowrap font-medium">{{ $rw->pemeriksaanDokter && $rw->pemeriksaanDokter->tanggal ? \Carbon\Carbon::parse($rw->pemeriksaanDokter->tanggal)->format('d M Y H:i') : \Carbon\Carbon::parse($rw->created_at)->format('d M Y H:i') }}</td>
                                <td class="border border-slate-300 px-3 py-2 whitespace-nowrap">{{ $rw->poliklinik->nama_poli ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 truncate max-w-[150px]" title="{{ $rw->pemeriksaanDokter->keluhan_utama ?? '' }}">{{ $rw->pemeriksaanDokter->keluhan_utama ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 truncate max-w-[150px]" title="RPS: {{ $rw->pemeriksaanDokter->riwayat_penyakit_sekarang ?? '-' }} | RPD: {{ $rw->pemeriksaanDokter->riwayat_penyakit_dahulu ?? '-' }}">
                                    <span class="text-xs text-slate-400 block">S:</span> {{ $rw->pemeriksaanDokter->riwayat_penyakit_sekarang ?? '-' }}
                                    <span class="text-xs text-slate-400 block mt-1">D:</span> {{ $rw->pemeriksaanDokter->riwayat_penyakit_dahulu ?? '-' }}
                                </td>
                                <td class="border border-slate-300 px-3 py-2 truncate max-w-[150px]" title="Fisik: {{ $rw->pemeriksaanDokter->pemeriksaan_fisik ?? '-' }} | Alergi: {{ $rw->pemeriksaanDokter->riwayat_alergi ?? '-' }}">
                                    <span class="text-xs text-slate-400 block">PF:</span> {{ $rw->pemeriksaanDokter->pemeriksaan_fisik ?? '-' }}
                                    <span class="text-xs text-slate-400 block mt-1">Al:</span> {{ $rw->pemeriksaanDokter->riwayat_alergi ?? '-' }}
                                </td>
                                <td class="border border-slate-300 px-3 py-2 whitespace-nowrap text-center">
                                    @if($rw->pemeriksaanDokter && $rw->pemeriksaanDokter->status_kasus == 'Baru')
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold">BARU</span>
                                    @elseif($rw->pemeriksaanDokter && $rw->pemeriksaanDokter->status_kasus == 'Lama')
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold">LAMA</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border border-slate-300 px-3 py-2 whitespace-nowrap">{{ $rw->pemeriksaanDokter->kesadaran ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 truncate max-w-[200px]">
                                    @if($rw->pemeriksaanDokter && $rw->pemeriksaanDokter->kode_icd10)
                                        <div class="mb-1">
                                          <span class="font-bold text-amber-700">{{ $rw->pemeriksaanDokter->kode_icd10 }}</span> - {{ $rw->pemeriksaanDokter->nama_diagnosa }}
                                        </div>
                                    @endif
                                    @if($rw->pemeriksaanDokter && $rw->pemeriksaanDokter->kode_icd10_sekunder)
                                        <div>
                                          <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-1 py-0.5 rounded">Sekunder</span>
                                          <span class="font-bold text-slate-700 text-[11px] ml-1">{{ $rw->pemeriksaanDokter->kode_icd10_sekunder }}</span> - <span class="text-[11px] text-slate-600">{{ $rw->pemeriksaanDokter->nama_diagnosa_sekunder }}</span>
                                        </div>
                                    @endif
                                    @if(!$rw->pemeriksaanDokter || (!$rw->pemeriksaanDokter->kode_icd10 && !$rw->pemeriksaanDokter->kode_icd10_sekunder))
                                        -
                                    @endif
                                </td>
                                <td class="border border-slate-300 px-3 py-2 truncate max-w-[150px]" title="{{ $rw->pemeriksaanDokter->keterangan_diagnosa ?? '' }}">{{ $rw->pemeriksaanDokter->keterangan_diagnosa ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="border border-slate-300 px-5 py-6 text-center text-slate-400 italic">Belum ada riwayat anamnesa & diagnosa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FORM ANAMNESA & DIAGNOSA -->
            <form id="formAnamnesa" action="{{ route('rawat_jalan.store_anamnesa', $pendaftaran->id) }}" method="POST">
                @csrf
                
                <!-- KOTAK ANAMNESA -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-6">
                    <div class="px-5 py-4 border-b border-emerald-100 bg-emerald-50 rounded-t-xl flex justify-between items-center">
                        <h2 class="font-bold text-emerald-800 text-sm flex items-center">
                            <i class="fa-solid fa-notes-medical mr-2 text-emerald-600"></i> Form Anamnesa & Pemeriksaan (Dokter)
                        </h2>
                        <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal:</label>
                            <input type="date" name="tanggal" value="{{ $pemeriksaanDokter->tanggal ? \Carbon\Carbon::parse($pemeriksaanDokter->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}" class="border-0 focus:ring-0 text-xs p-0 w-28 font-medium text-slate-700 bg-transparent">
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Keluhan Utama <span class="text-red-500">*</span></label>
                                <textarea name="keluhan_utama" rows="3" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-3 shadow-sm" placeholder="Contoh: Sakit kepala, demam...">{{ $pemeriksaanDokter->keluhan_utama }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Riwayat Penyakit Sekarang (RPS)</label>
                                <textarea name="riwayat_penyakit_sekarang" rows="3" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-3 shadow-sm" placeholder="Contoh: Sudah 3 hari demam naik turun...">{{ $pemeriksaanDokter->riwayat_penyakit_sekarang }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Riwayat Penyakit Dahulu / Keluarga</label>
                                <textarea name="riwayat_penyakit_dahulu" rows="3" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-3 shadow-sm" placeholder="Contoh: DM Tipe 2 (Ayah), Hipertensi...">{{ $pemeriksaanDokter->riwayat_penyakit_dahulu }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Riwayat Alergi <span class="text-[10px] text-red-500 font-normal normal-case ml-1">(Sangat Penting)</span></label>
                                <textarea name="riwayat_alergi" rows="2" class="w-full rounded-lg border-red-200 focus:border-red-500 focus:ring-red-500 text-sm p-3 shadow-sm bg-red-50/30" placeholder="Tidak ada alergi / Alergi paracetamol...">{{ $pemeriksaanDokter->riwayat_alergi }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Kesadaran Umum</label>
                                <select name="kesadaran" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5 shadow-sm">
                                    <option value="Compos Mentis" {{ $pemeriksaanDokter->kesadaran == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis (Sadar Penuh)</option>
                                    <option value="Apatis" {{ $pemeriksaanDokter->kesadaran == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                    <option value="Somnolence" {{ $pemeriksaanDokter->kesadaran == 'Somnolence' ? 'selected' : '' }}>Somnolence</option>
                                    <option value="Sopor" {{ $pemeriksaanDokter->kesadaran == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                    <option value="Coma" {{ $pemeriksaanDokter->kesadaran == 'Coma' ? 'selected' : '' }}>Coma</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pemeriksaan Fisik (Objektif)</label>
                                <textarea name="pemeriksaan_fisik" rows="4" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-3 shadow-sm" placeholder="Contoh: Mata konjungtiva pucat, Thorax dbn...">{{ $pemeriksaanDokter->pemeriksaan_fisik }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOTAK DIAGNOSA -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-4">
                    <div class="px-5 py-4 border-b border-amber-100 bg-amber-50 rounded-t-xl">
                        <h2 class="font-bold text-amber-800 text-sm flex items-center">
                            <i class="fa-solid fa-heart-pulse mr-2 text-amber-600"></i> Form Diagnosa (ICD-10)
                        </h2>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Status Kasus Kunjungan</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_kasus" value="Baru" {{ $pemeriksaanDokter->status_kasus == 'Baru' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                                    <span class="text-sm font-medium text-slate-700">Kasus Baru</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_kasus" value="Lama" {{ $pemeriksaanDokter->status_kasus == 'Lama' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                                    <span class="text-sm font-medium text-slate-700">Kasus Lama / Kontrol</span>
                                </label>
                            </div>
                        </div>

                        <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-200">
                            <h3 class="font-bold text-slate-700 text-sm mb-4"><i class="fa-solid fa-star-of-life text-amber-500 mr-1"></i> Diagnosa Utama <span class="text-red-500">*</span></h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian Diagnosa (ICD-10)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-search text-slate-400"></i>
                                </div>
                                <input type="text" id="icd10_search" autocomplete="off" class="w-full pl-10 rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm" placeholder="Ketik nama penyakit / kode ICD-10">
                                <div id="icd10_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl hidden max-h-60 overflow-y-auto divide-y divide-slate-100">
                                    <!-- Search results will appear here -->
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Kode ICD-10 <span class="text-red-500">*</span></label>
                            <input type="text" id="kode_icd10_input" name="kode_icd10" value="{{ $pemeriksaanDokter->kode_icd10 }}" class="w-full rounded-lg border-slate-300 bg-slate-50 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm font-bold text-slate-700 cursor-not-allowed" readonly required placeholder="Terisi otomatis">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Diagnosa <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_diagnosa_input" name="nama_diagnosa" value="{{ $pemeriksaanDokter->nama_diagnosa }}" class="w-full rounded-lg border-slate-300 bg-slate-50 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm font-bold text-slate-700 cursor-not-allowed" readonly required placeholder="Terisi otomatis">
                        </div>

                        <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-200">
                            <h3 class="font-bold text-slate-700 text-sm mb-4"><i class="fa-solid fa-plus-circle text-amber-500 mr-1"></i> Diagnosa Sekunder (Opsional)</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian Diagnosa Sekunder (ICD-10)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-search text-slate-400"></i>
                                </div>
                                <input type="text" id="icd10_sekunder_search" autocomplete="off" class="w-full pl-10 rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm" placeholder="Ketik minimal 1 huruf (nama penyakit / kode ICD-10)...">
                                <div id="icd10_sekunder_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl hidden max-h-60 overflow-y-auto divide-y divide-slate-100">
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Kode ICD-10 Sekunder</label>
                            <input type="text" id="kode_icd10_sekunder_input" name="kode_icd10_sekunder" value="{{ $pemeriksaanDokter->kode_icd10_sekunder }}" class="w-full rounded-lg border-slate-300 bg-slate-50 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm font-bold text-slate-700 cursor-not-allowed" readonly placeholder="Terisi otomatis">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Diagnosa Sekunder</label>
                            <input type="text" id="nama_diagnosa_sekunder_input" name="nama_diagnosa_sekunder" value="{{ $pemeriksaanDokter->nama_diagnosa_sekunder }}" class="w-full rounded-lg border-slate-300 bg-slate-50 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm font-bold text-slate-700 cursor-not-allowed" readonly placeholder="Terisi otomatis">
                        </div>

                        <div class="md:col-span-2 mt-2 pt-4 border-t border-slate-200">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan / Rencana Tindakan (Plan)</label>
                            <textarea name="keterangan_diagnosa" rows="2" class="w-full rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 text-sm p-3 shadow-sm" placeholder="Istirahat cukup, minum air putih... (Rencana untuk pasien ini)">{{ $pemeriksaanDokter->keterangan_diagnosa }}</textarea>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <!-- FOOTER (TOMBOL SIMPAN) -->
        <div class="px-6 py-4 bg-white border-t border-slate-200 shrink-0 z-10 flex justify-end gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <button type="button" onclick="document.getElementById('formAnamnesa').submit();" class="whitespace-nowrap bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-1.5"></i> Simpan
            </button>
        </div>

    </div>
    
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        function initIcdSearch(searchId, dropdownId, kodeId, namaId, nextFocus, optionClass) {
            let searchTimeout;
            let selectedIndex = -1;
            let pendingEnter = false;
            
            const $search = $('#' + searchId);
            const $dropdown = $('#' + dropdownId);
            const $kode = $('#' + kodeId);
            const $nama = $('#' + namaId);
            
            $search.on('input', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();
                
                if (query.length < 1) {
                    $dropdown.addClass('hidden').empty();
                    return;
                }
                
                $dropdown.removeClass('hidden').html('<div class="p-4 text-center text-sm text-slate-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Mencari...</div>');
                
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: '{{ route("icd10.search") }}',
                        data: { q: query },
                        dataType: 'json',
                        success: function(response) {
                            if (pendingEnter && response.results.length > 0) {
                                $kode.val(response.results[0].id);
                                $nama.val(response.results[0].nama);
                                $search.val('');
                                $dropdown.addClass('hidden').empty();
                                if(nextFocus) $(nextFocus).focus();
                                pendingEnter = false;
                                return;
                            }
                            pendingEnter = false;
                            $dropdown.empty();
                            selectedIndex = -1;
                            
                            if (response.results.length === 0) {
                                $dropdown.html('<div class="p-4 text-center text-sm text-slate-500">Penyakit tidak ditemukan.</div>');
                                return;
                            }
                            
                            response.results.forEach((item, index) => {
                                $dropdown.append(`
                                    <div class="${optionClass} p-3 hover:bg-amber-50 cursor-pointer flex justify-between items-center transition-colors" data-id="${item.id}" data-text="${item.nama}" data-index="${index}">
                                        <div>
                                            <span class="font-bold text-amber-700">${item.id}</span> 
                                            <span class="text-slate-700 ml-2">${item.nama}</span>
                                        </div>
                                        <i class="fa-solid fa-arrow-turn-down fa-rotate-90 text-slate-300 text-xs hidden arrow-icon"></i>
                                    </div>
                                `);
                            });
                            
                            $('.' + optionClass).on('click', function() {
                                selectOption($(this));
                            });
                        }
                    });
                }, 300);
            });
            
            $search.on('keydown', function(e) {
                const options = $('.' + optionClass);
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (selectedIndex < options.length - 1) {
                        selectedIndex++;
                        highlightOption(options);
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (selectedIndex > 0) {
                        selectedIndex--;
                        highlightOption(options);
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (selectedIndex >= 0 && options.length > 0) {
                        selectOption($(options[selectedIndex]));
                    } else if (options.length > 0) {
                        selectOption($(options[0]));
                    } else {
                        pendingEnter = true;
                        $dropdown.removeClass('hidden').html('<div class="p-4 text-center text-sm text-amber-600"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Memproses pilihan...</div>');
                    }
                }
            });
            
            function highlightOption(options) {
                options.removeClass('bg-amber-50').find('.arrow-icon').addClass('hidden');
                if (selectedIndex >= 0) {
                    const selected = $(options[selectedIndex]);
                    selected.addClass('bg-amber-50').find('.arrow-icon').removeClass('hidden');
                    
                    const dropdownEl = $dropdown[0];
                    const optionEl = selected[0];
                    if (optionEl.offsetTop < dropdownEl.scrollTop) {
                        dropdownEl.scrollTop = optionEl.offsetTop;
                    } else if (optionEl.offsetTop + optionEl.offsetHeight > dropdownEl.scrollTop + dropdownEl.offsetHeight) {
                        dropdownEl.scrollTop = optionEl.offsetTop + optionEl.offsetHeight - dropdownEl.offsetHeight;
                    }
                }
            }
            
            function selectOption(element) {
                $kode.val(element.data('id'));
                $nama.val(element.data('text'));
                $search.val('');
                $dropdown.addClass('hidden').empty();
                if(nextFocus) $(nextFocus).focus();
            }
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#' + searchId + ', #' + dropdownId).length) {
                    $dropdown.addClass('hidden');
                }
            });
        }

        // Initialize for Diagnosa Utama
        initIcdSearch('icd10_search', 'icd10_dropdown', 'kode_icd10_input', 'nama_diagnosa_input', '#icd10_sekunder_search', 'icd10-option-utama');
        
        // Initialize for Diagnosa Sekunder
        initIcdSearch('icd10_sekunder_search', 'icd10_sekunder_dropdown', 'kode_icd10_sekunder_input', 'nama_diagnosa_sekunder_input', 'textarea[name="keterangan_diagnosa"]', 'icd10-option-sekunder');
    });
</script>
@endsection









