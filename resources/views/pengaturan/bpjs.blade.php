@extends('layouts.app')

@section('title', 'Konfigurasi Bridging BPJS')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Konfigurasi BPJS Mobile JKN</h1>
                <p class="text-sm text-slate-500 mt-1">Pengaturan kunci API untuk layanan Bridging V2</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-blue-50 border-b border-blue-100 p-6 flex gap-4">
            <div class="mt-1 text-blue-600">
                <i class="fa-solid fa-circle-info text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-blue-900">Penting!</h3>
                <p class="text-blue-800 text-sm mt-1">Data kredensial di bawah ini (Cons ID, Secret Key, dan User Key) didapatkan dari tim IT BPJS Kesehatan melalui portal trustmark/developer mereka. Jangan berikan akses ini ke sembarang orang karena bersifat rahasia.</p>
            </div>
        </div>

        <form action="{{ route('pengaturan.bpjs.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode PPK Faskes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode PPK (Kode Faskes)</label>
                    <input type="text" name="kode_ppk" value="{{ old('kode_ppk', $pengaturan->kode_ppk) }}" 
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" 
                           placeholder="Contoh: 0113R004">
                    <p class="text-xs text-slate-500 mt-1">Kode 8 digit registrasi fasilitas kesehatan Anda di BPJS.</p>
                </div>

                <div class="md:col-span-2 my-2 border-t border-slate-100"></div>

                <!-- Base URL -->
                        <div class="mb-5">
                            <label for="base_url" class="block text-sm font-semibold text-slate-700 mb-2">Base URL API BPJS</label>
                            <input type="url" name="base_url" id="base_url" 
                                value="{{ old('base_url', $pengaturan->base_url ?? '') }}" required
                                placeholder="Contoh: https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 font-mono text-sm bg-white">
                            @error('base_url')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500 mt-1">Masukkan URL dasar sesuai environment (Development / Production).</p>
                        </div>

                        <!-- Cons ID -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Cons ID (Consumer ID)</label>
                    <input type="text" name="cons_id" value="{{ old('cons_id', $pengaturan->cons_id) }}" 
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                </div>

                <!-- Secret Key -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Secret Key (Password)</label>
                    <input type="password" name="secret_key" value="{{ old('secret_key', $pengaturan->secret_key) }}" 
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                </div>

                <!-- User Key -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">User Key (Antrean V2)</label>
                    <input type="password" name="user_key" value="{{ old('user_key', $pengaturan->user_key) }}" 
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors font-mono text-sm" 
                           placeholder="Contoh: a1b2c3d4e5f6g7h8i9j0">
                    <p class="text-xs text-slate-500 mt-1">User Key spesifik untuk layanan Antrean Mobile JKN V2.</p>
                </div>

                <div class="md:col-span-2 my-2 border-t border-slate-100"></div>

                <!-- Environment -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                        <input type="checkbox" name="is_production" value="1" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-slate-300 rounded" {{ old('is_production', $pengaturan->is_production) ? 'checked' : '' }}>
                        <div>
                            <span class="block text-sm font-bold text-slate-800">Mode Production (Live)</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Centang ini hanya jika aplikasi sudah siap online dan melayani pasien nyata. Hapus centang untuk menggunakan mode Development/Sandbox BPJS.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

