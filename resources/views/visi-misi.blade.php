<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi Misi - Sistem Informasi e-Arsip PT Semen Padang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif !important; }
    </style>
</head>
<body class="bg-white">

    <!-- Navigation -->
    <nav x-data="{ isScrolled: false }" 
         @scroll.window="isScrolled = (window.pageYOffset > 50)"
         :class="isScrolled ? 'bg-white shadow-md py-6' : 'bg-transparent py-4'"
         class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                 <img :src="isScrolled ? '{{ asset('images/sp-black.png') }}' : '{{ asset('images/sp-white.png') }}'" alt="Logo Semen Padang" class="h-20 drop-shadow-lg filter brightness-100 rounded px-2 py-1 transition-all duration-300">
            </div>
            <div class="hidden md:flex items-center gap-6 font-medium drop-shadow-md transition-colors duration-300"
                 :class="isScrolled ? 'text-gray-800' : 'text-white'">
                 <a href="{{ route('landing') }}" class="hover:text-red-600 transition">Beranda</a>
                
                <!-- Dropdown Tentang Kami -->
                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="hover:text-red-600 transition flex items-center gap-1 focus:outline-none text-red-600">
                        Tentang Kami
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-0 mt-0 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100"
                         style="display: none;">
                        <a href="{{ route('visi-misi') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0 font-bold bg-red-50 text-red-700">Visi Misi</a>
                        <a href="{{ route('sejarah') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0">Sejarah</a>
                        <a href="{{ route('landing') }}#struktur" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0">Struktur Organisasi</a>
                        <a href="{{ route('penghargaan') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition">Penghargaan</a>
                    </div>
                </div>
                <a href="{{ route('landing') }}#fitur" class="hover:text-red-600 transition">Fitur</a>
                <a href="{{ route('landing') }}#kontak" class="hover:text-red-600 transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <style>
        @keyframes zoomIn {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        .animate-zoom {
            animation: zoomIn 10s infinite alternate;
        }
    </style>
    <div class="relative h-[40vh] w-full overflow-hidden">
        <div class="absolute inset-0">
             <img src="{{ asset('images/hp 1.jpg') }}" class="w-full h-full object-cover animate-zoom">
             <!-- Overlay Gradient -->
             <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6 pt-20">
                <div class="max-w-2xl text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-2 drop-shadow-lg">
                        Tentang Kami
                    </h1>
                     <p class="text-xl font-light">Visi Misi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-20 relative bg-white bg-cover bg-center" style="background-image: url('{{ asset('images/BG_supergrafis.png') }}');"> 
        <div class="container mx-auto px-6 relative z-10">
            
            <!-- Meaning Semen Padang -->
            <div class="text-center mb-16">
                 <h2 class="text-2xl text-gray-800 font-medium mb-2">Kearsipan PT Semen Padang</h2>
                 <h3 class="text-3xl md:text-4xl font-bold text-[#e92027]">“Tepat Kelola, Tepat Saji”</h3>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-20">
                <div class="flex flex-col md:flex-row gap-16 items-start">
                     <!-- Images Grid -->
                     <div class="w-full md:w-1/2 grid grid-cols-2 gap-4">
                          <!-- Main Image (hp 6) -->
                          <div class="col-span-2 rounded-2xl shadow-xl overflow-hidden aspect-video relative group">
                               <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-500 z-10"></div>
                               <img src="{{ asset('images/hp 6.jpeg') }}" alt="Visi Misi Semen Padang" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                          </div>
                          <!-- Secondary Image 1 (hp 4) -->
                          <div class="rounded-2xl shadow-xl overflow-hidden aspect-video relative group">
                               <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-500 z-10"></div>
                               <img src="{{ asset('images/hp 4.jpeg') }}" alt="Kegiatan Arsip" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                          </div>
                          <!-- Secondary Image 2 (hp 5) -->
                          <div class="rounded-2xl shadow-xl overflow-hidden aspect-video relative group">
                               <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-500 z-10"></div>
                               <img src="{{ asset('images/hp 5.jpeg') }}" alt="Fasilitas Arsip" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                          </div>
                     </div>

                     <!-- Text -->
                     <div class="w-full md:w-1/2">
                          <!-- Visi -->
                          <div class="mb-8">
                               <div class="flex items-center gap-3 mb-2">
                                   <div class="w-1.5 h-8 bg-[#e92027]"></div>
                                   <h2 class="text-3xl font-bold text-gray-900 tracking-wide">VISI</h2>
                               </div>
                               <p class="text-gray-700 leading-relaxed text-lg pl-4 border-l-2 border-gray-100 text-justify">
                                    "Menuju manajemen kearsipan yang <span class="font-bold text-gray-900">TEPAT KELOLA DAN TEPAT SAJI DENGAN MEMPERHATIKAN ASPEK K3</span>"
                               </p>
                          </div>

                          <!-- Misi -->
                          <div>
                               <div class="flex items-center gap-3 mb-4">
                                   <div class="w-1.5 h-8 bg-[#e92027]"></div>
                                   <h2 class="text-3xl font-bold text-gray-900 tracking-wide">MISI</h2>
                               </div>
                               <ol class="list-none space-y-3 text-gray-700 leading-relaxed text-lg text-justify">
                                   <li class="flex gap-4">
                                       <span class="font-bold text-[#e92027] text-xl">1.</span>
                                       <span>Membangun manajemen kearsipan yang <span class="font-bold text-gray-900">EFEKTIF DAN EFISIEN</span></span>
                                   </li>
                                   <li class="flex gap-3">
                                       <span class="font-bold text-[#e92027] text-xl">2.</span>
                                       <span>Peningkatan kemampuan dan <span class="font-bold text-gray-900">KOMPETENSI SDM</span> diunit kearsipan serta koordinator anggota tu- ukp unit kerja</span>
                                   </li>
                                   <li class="flex gap-3">
                                       <span class="font-bold text-[#e92027] text-xl">3.</span>
                                       <span>Meningkatkan efesiensi dan efektifitas <span class="font-bold text-gray-900">PELAYANAN</span></span>
                                   </li>
                                   <li class="flex gap-3">
                                       <span class="font-bold text-[#e92027] text-xl">4.</span>
                                       <span>Menjadikan arsip sebagai memori kolektif dan jati diri perusahaan</span>
                                   </li>
                               </ol>
                          </div>
                     </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Navigation -->
    <section class="py-16 relative overflow-hidden">
        <!-- Background with subtle pattern -->
        <div class="absolute inset-0 bg-gray-50"></div>
        <div class="absolute inset-0 opacity-5" style="background-image: url('{{ asset('images/BG_supergrafis.png') }}'); background-size: cover; background-position: center;"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Jelajahi Tentang Kami</h2>
                    <div class="h-1 w-20 bg-[#e92027] rounded-full"></div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- 1. Visi Misi -->
                <a href="{{ route('visi-misi') }}" class="group bg-white p-8 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-l-4 border-transparent hover:border-[#e92027] flex flex-col justify-between h-48">
                    <div>
                         <span class="text-sm font-semibold text-gray-400 group-hover:text-[#e92027] transition mb-2 block">01</span>
                         <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#e92027] transition">Visi Misi</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-500 font-medium group-hover:text-red-500 transition">Lihat Detail</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#e92027] group-hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- 2. Sejarah -->
                <a href="{{ route('sejarah') }}" class="group bg-white p-8 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-l-4 border-transparent hover:border-[#e92027] flex flex-col justify-between h-48">
                    <div>
                         <span class="text-sm font-semibold text-gray-400 group-hover:text-[#e92027] transition mb-2 block">02</span>
                         <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#e92027] transition">Sejarah</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-500 font-medium group-hover:text-red-500 transition">Lihat Detail</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#e92027] group-hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- 3. Struktur Organisasi -->
                <a href="{{ route('landing') }}#struktur" class="group bg-white p-8 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-l-4 border-transparent hover:border-[#e92027] flex flex-col justify-between h-48">
                    <div>
                         <span class="text-sm font-semibold text-gray-400 group-hover:text-[#e92027] transition mb-2 block">03</span>
                         <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#e92027] transition">Struktur Organisasi</h3>
                    </div>
                     <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-500 font-medium group-hover:text-red-500 transition">Lihat Detail</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#e92027] group-hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- 4. Penghargaan -->
                <a href="{{ route('penghargaan') }}" class="group bg-white p-8 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-l-4 border-transparent hover:border-[#e92027] flex flex-col justify-between h-48">
                    <div>
                         <span class="text-sm font-semibold text-gray-400 group-hover:text-[#e92027] transition mb-2 block">04</span>
                         <h3 class="text-xl font-bold text-gray-800 group-hover:text-[#e92027] transition">Penghargaan</h3>
                    </div>
                     <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-500 font-medium group-hover:text-red-500 transition">Lihat Detail</span>
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#e92027] group-hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="relative bg-cover bg-center border-t border-gray-200" style="background-image: url('{{ asset('images/SuperGrafis.png') }}');">
        <!-- Main Footer Content with Pattern -->
        <div class="pt-12 pb-8">
            <div class="container mx-auto px-6">
                <!-- Top Section: 3 Columns -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- Column 1: Kantor Utama -->
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg mb-3">Kantor Utama</h4>
                        <p class="text-gray-600 text-sm leading-relaxed max-w-xs">
                            Jl. Raya Indarung, Kec. Lubuk Kilangan<br>
                            Kota Padang 25237, Sumatera Barat
                        </p>
                    </div>
                    
                    <!-- Column 2: Kantor Perwakilan -->
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg mb-3">Kantor Perwakilan Jakarta</h4>
                        <p class="text-gray-600 text-sm leading-relaxed max-w-sm">
                            Graha Irama, Lt. 11, Jl. H. R. Rasuna Said No. 1 & 2, RT.6/RW.4, Kuningan Timur, Kecamatan Setiabudi, Kota Jakarta Selatan 12950, DKI Jakarta
                        </p>
                    </div>

                    <!-- Column 3: Media Sosial & SIG Group -->
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg mb-3">Media Sosial</h4>
                        <div class="flex gap-4 mb-6">
                            <a href="https://twitter.com/semenpadang1910" target="_blank" class="w-8 h-8 link-hover"><svg class="w-5 h-5 text-gray-600 hover:text-black transition" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg></a>
                            <a href="https://www.instagram.com/semenpadang/" target="_blank" class="w-8 h-8 link-hover"><svg class="w-5 h-5 text-gray-600 hover:text-[#e92027] transition" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                            <a href="https://www.youtube.com/channel/UCIi9Yy9jRMlB8k9_8djAJcA/feed" target="_blank" class="w-8 h-8 link-hover"><svg class="w-5 h-5 text-gray-600 hover:text-[#e92027] transition" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                            <a href="https://www.tiktok.com/@semenpadang1910?_t=8hadknUhwFF&_r=1" target="_blank" class="w-8 h-8 link-hover"><svg class="w-5 h-5 text-gray-600 hover:text-[#e92027] transition" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.65-1.62-1.1-.04 1.86.04 3.66.17 5.51.18 2.58-.62 5.13-2.4 7.29-1.42 1.75-3.64 2.7-5.99 2.7-3.36.03-6.54-1.74-8.19-4.57-1.74-3.08-1.55-7.06.63-9.92.51-.7 1.12-1.32 1.83-1.83 1.96-1.43 4.54-1.85 6.93-1.25.1.58.21 1.17.32 1.76-1.09-.37-2.29-.44-3.41-.09-1.13.34-2.11 1.05-2.73 2.05-.66 1.06-.82 2.37-.58 3.6.43 2.21 2.4 4.02 4.63 4.1 1.23.07 2.45-.31 3.42-1.1 1.08-.85 1.66-2.26 1.58-3.62-.06-2.58-.02-5.16-.01-7.74-.01-.98-.02-1.95-.03-2.93-.01-.65-.01-1.31-.02-1.96H12.525z"/></svg></a>
                            <a href="https://web.facebook.com/PTsemenpadang1910/" target="_blank" class="w-8 h-8 link-hover"><svg class="w-5 h-5 text-gray-600 hover:text-[#e92027] transition" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        </div>
                        
                        <h4 class="font-bold text-gray-900 text-lg mb-2">SIG Group</h4>
                        <a href="https://sig.id/" target="_blank" class="text-gray-600 hover:text-[#e92027] transition font-medium">www.sig.id</a>
                    </div>
                </div>

                <!-- Bottom Section: Logo and Hotline -->
                <div class="flex flex-col md:flex-row justify-between items-center border-t border-gray-200/50 pt-6">
                    <!-- Logo -->
                    <div class="mb-4 md:mb-0">
                        <img src="{{ asset('images/sp-black.png') }}" class="h-16 object-contain">
                    </div>

                    <!-- Hotline -->
                    <div class="text-center md:text-right">
                        <h4 class="font-bold text-gray-900 text-xl tracking-widest uppercase mb-0">HOTLINE</h4>
                        <p class="text-2xl font-bold text-gray-900">0800 1088888</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Red Bar -->
        <div class="bg-[#e92027] h-14 w-full relative">
            <div class="container mx-auto px-6 h-full flex justify-end items-center">
                 <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="w-6 h-6 flex items-center justify-center bg-red-800/50 hover:bg-red-900 text-white rounded transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                 </button>
            </div>
        </div>
            
        <!-- Copyright -->
        <div class="py-4">
            <div class="container mx-auto px-6 text-center">
                  <p class="text-gray-800 text-sm font-medium">PT Sinergi Informatika Semen Indonesia &copy; Copyright {{ date('Y') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
