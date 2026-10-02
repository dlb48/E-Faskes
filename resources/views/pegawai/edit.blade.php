@extends('layouts.app')

@section('title', 'Ubah Data Pegawai')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Ubah Data Pegawai</h1>
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

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-user-tie text-amber-500 mr-2"></i>Data Profil Pegawai</h2>
        </div>
        
        <form novalidate action="{{ route('pegawai.update', $pegawai->nip) }}" method="POST" class="p-6" id="formEdit">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Induk Pegawai (NIP) <span class="text-red-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap (beserta gelar) <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        @php $jk = old('jenis_kelamin', $pegawai->jenis_kelamin); @endphp
                        <option value="Laki-laki" {{ $jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">{{ old('alamat', $pegawai->alamat) }}</textarea>
                </div>
            </div>
            
            <div class="border-t border-slate-200 pt-6 mt-2 mb-6">
                <h3 class="font-bold text-slate-800 mb-4"><i class="fa-solid fa-briefcase text-amber-500 mr-2"></i>Data Pekerjaan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Departemen / Divisi <span class="text-red-500">*</span></label>
                        <select name="departemen" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                            <option value="">-- Pilih Departemen --</option>
                            @php $dept = old('departemen', $pegawai->departemen); @endphp
                            <option value="Pelayanan Medis" {{ $dept == 'Pelayanan Medis' ? 'selected' : '' }}>Pelayanan Medis</option>
                            <option value="Keperawatan" {{ $dept == 'Keperawatan' ? 'selected' : '' }}>Keperawatan</option>
                            <option value="Farmasi & Laboratorium" {{ $dept == 'Farmasi & Laboratorium' ? 'selected' : '' }}>Farmasi & Laboratorium</option>
                            <option value="Administrasi & Keuangan" {{ $dept == 'Administrasi & Keuangan' ? 'selected' : '' }}>Administrasi & Keuangan</option>
                            <option value="SDM & Umum" {{ $dept == 'SDM & Umum' ? 'selected' : '' }}>SDM & Umum</option>
                            <option value="IT & Sistem Informasi" {{ $dept == 'IT & Sistem Informasi' ? 'selected' : '' }}>IT & Sistem Informasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status Karyawan <span class="text-red-500">*</span></label>
                        <select name="status_karyawan" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                            <option value="">-- Pilih Status --</option>
                            @php $status_kar = old('status_karyawan', $pegawai->status_karyawan); @endphp
                            <option value="Tetap" {{ $status_kar == 'Tetap' ? 'selected' : '' }}>Karyawan Tetap</option>
                            <option value="Kontrak" {{ $status_kar == 'Kontrak' ? 'selected' : '' }}>Karyawan Kontrak</option>
                            <option value="Harian" {{ $status_kar == 'Harian' ? 'selected' : '' }}>Harian Lepas / Freelance</option>
                            <option value="Magang" {{ $status_kar == 'Magang' ? 'selected' : '' }}>Magang / Internship</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', $pegawai->tanggal_bergabung) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 mt-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Akun Pegawai <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    @php $status = old('status_aktif', $pegawai->status_aktif); @endphp
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ $status ? 'border-brand-300 bg-brand-50' : '' }}">
                        <input type="radio" name="status_aktif" value="1" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500" {{ $status ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-slate-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto {{ !$status ? 'border-red-300 bg-red-50' : '' }}">
                        <input type="radio" name="status_aktif" value="0" class="w-4 h-4 text-red-600 border-slate-300 focus:ring-red-500" {{ !$status ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-slate-700">Nonaktif / Keluar</span>
                    </label>
                </div>
            </div>

        </form>
    </div>

    <!-- Fixed action buttons -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-end gap-3">
            <a href="{{ route('pegawai.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" form="formEdit" class="px-5 py-2.5 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection

