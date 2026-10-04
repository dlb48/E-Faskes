<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Faskes - @yield('title', 'Aplikasi')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite / Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal !important;
            color: #475569 !important;
        }
        .select2-search__field {
            outline: none !important;
        }
    </style>
</head>
<body class="text-slate-800 bg-slate-50 font-sans">

    <!-- TOP BAR NAVIGATION -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Menu Kiri -->
                <div class="flex">
                    <!-- Menu Utama -->
                    <div class="hidden sm:flex sm:space-x-1">
                        <!-- Menu Aktif -->
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-brand-500 text-brand-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-house mr-2"></i> Beranda
                        </a>
                        <a href="{{ route('pendaftaran.index') }}" class="{{ request()->routeIs('pendaftaran.*') ? 'border-brand-500 text-brand-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-clipboard-user mr-2"></i> Pendaftaran
                        </a>
                        <a href="{{ route('rawat_jalan.index') }}" class="{{ request()->routeIs('rawat_jalan.*') ? 'border-brand-500 text-brand-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-stethoscope mr-2"></i> Rawat Jalan
                        </a>
                        <a href="#" class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-bed-pulse mr-2"></i> Rawat Inap
                        </a>
                        <a href="#" class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-pills mr-2"></i> Apotek
                        </a>
                        <a href="#" class="border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 inline-flex items-center px-3 pt-1 border-b-2 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-cash-register mr-2"></i> Kasir
                        </a>
                    </div>
                </div>
                </div>

                <!-- Menu Kanan (User / Setting) -->
                <div class="flex items-center">
                    <button class="p-2 text-slate-400 hover:text-slate-500 relative">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>
                    
                    <div class="ml-4 relative flex items-center gap-3 cursor-pointer">
                        <div class="text-right hidden md:block">
                            <div class="text-sm font-semibold text-slate-700">Dr. Sarah Jenkins</div>
                            <div class="text-xs text-slate-500">Poli Umum</div>
                        </div>
                        <img class="h-9 w-9 rounded-full object-cover border border-slate-200" src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=0D8ABC&color=fff" alt="">
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT AREA -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Global SweetAlert Handler -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: "Silakan periksa kembali isian formulir Anda."
            });
        @endif
    </script>
    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    @yield('scripts')
</body>
</html>






