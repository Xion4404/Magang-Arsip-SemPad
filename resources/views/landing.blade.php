<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi e-Arsip - PT Semen Padang</title>
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
                <a href="#" class="hover:text-red-600 transition">Beranda</a>
                
                <!-- Dropdown Tentang -->
                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="hover:text-red-600 transition flex items-center gap-1 focus:outline-none">
                        Tentang
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
                        <a href="#visi-misi" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0">Visi Misi</a>
                        <a href="#sejarah" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0">Sejarah</a>
                        <a href="#struktur" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition border-b border-gray-50 last:border-0">Struktur Organisasi</a>
                        <a href="#penghargaan" class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition">Penghargaan</a>
                    </div>
                </div>
                <a href="#fitur" class="hover:text-red-600 transition">Fitur</a>
                <a href="#kontak" class="hover:text-red-600 transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Carousel -->
    <div x-data="{ 
            activeSlide: 0, 
            slides: [
                { img: 'hp 4.jpeg', text: 'Ruang Pameran Arsip' },
                { img: 'hp 5.jpeg', text: 'Ruang Pameran Arsip' },
                { img: 'hp 6.jpeg', text: 'Rak Penyimpanan Arsip' },
                { img: 'hp 7.jpeg', text: 'Penghargaan Kearsipan' }
            ],
            autoplay() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 6000);
            }
        }" 
        x-init="autoplay()"
        class="relative h-screen w-full overflow-hidden">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition transform duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition transform duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0">
                <img :src="'/images/' + slide.img" class="w-full h-full object-cover">
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
            </div>
        </template>

        <!-- Content -->
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6 pt-20">
                <div class="max-w-2xl text-white">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6 drop-shadow-lg">
                        Sistem Informasi <br> e-Arsip <br> PT Semen Padang
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 font-light drop-shadow-md text-gray-100">
                        Solusi Digital untuk Pengelolaan Arsip yang Efisien, Aman, dan Terintegrasi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-[#b91c1c] hover:bg-[#991b1b] text-white font-bold rounded-lg transition transform hover:-translate-y-1 shadow-lg text-center">
                            Login
                        </a>
                        <a href="#tentang" class="px-8 py-4 bg-white hover:bg-gray-100 text-[#b91c1c] font-bold rounded-lg transition transform hover:-translate-y-1 shadow-lg text-center">
                            Pelajari Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Indicators -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex gap-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="activeSlide === index ? 'w-12 bg-red-600' : 'w-3 bg-white/50'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </div>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-20 bg-cover bg-center" style="background-image: url('{{ asset('images/white-bg.jpg') }}');">
        <div class="container mx-auto px-12">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 max-w-6xl mx-auto transform transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl border border-transparent hover:border-red-100">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <!-- Image Section -->
                    <div class="w-full md:w-1/3">
                        <div class="aspect-square rounded-2xl shadow-xl overflow-hidden group">
                            <img src="{{ asset('images/hp 6.jpeg') }}" alt="Tentang Semen Padang" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="w-full md:w-2/3">
                        <h2 class="text-red-700 font-bold text-xl uppercase tracking-wider mb-2">Tentang Kami</h2>
                        <h3 class="text-4xl font-bold text-gray-800 mb-6">Kearsipan PT Semen Padang</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed" style="font-size: 16px;">
                            Kearsipan di PT Semen Padang merupakan bagian penting dalam mendukung tertib administrasi dan kelancaran operasional perusahaan. Setiap arsip dikelola sebagai sumber informasi yang memiliki nilai guna bagi perusahaan, baik sebagai bukti kegiatan, bahan pengambilan keputusan, maupun sebagai bentuk pertanggungjawaban organisasi.
                        </p>
                        <p class="text-gray-600 mb-6 leading-relaxed" style="font-size: 16px;">
                            Pengelolaan kearsipan di PT Semen Padang dilaksanakan secara terkoordinasi oleh Unit Sistem Manajemen dengan mengedepankan keteraturan, keamanan, dan kemudahan akses sesuai kebutuhan kerja. Melalui pengelolaan arsip yang baik, perusahaan berupaya menjaga keberlangsungan informasi serta mendukung penerapan tata kelola perusahaan yang efektif dan berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Arsip Section -->
    <section class="py-20 relative overflow-hidden bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/hp 5.jpeg') }}');">
        <!-- Red Overlay with Blur -->
         <div class="absolute inset-0 bg-red-900/35 backdrop-blur-sm z-0"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-white text-4xl font-bold mb-4">Statistik Arsip</h2>
                <div class="w-24 h-1 bg-white mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Card 1: Total Arsip Masuk -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-2xl text-center text-white hover:transform hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl font-bold mb-2">{{ $totalArsip }}</div>
                    <div class="text-red-100 font-medium">Total Arsip Masuk</div>
                </div>
                <!-- Card 2: Arsip Masuk Bulan Ini -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-2xl text-center text-white hover:transform hover:-translate-y-2 transition duration-300">
                     <div class="text-5xl font-bold mb-2">{{ $bulanIniArsip }}</div>
                    <div class="text-red-100 font-medium">Arsip Masuk Bulan Ini</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxLanding = document.getElementById('landingArsipChart').getContext('2d');
            if (ctxLanding) {
                new Chart(ctxLanding, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Arsip Masuk',
                            data: @json($arsipBulananData),
                            borderColor: '#dc2626', // red-600
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#dc2626',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#1f2937',
                                bodyColor: '#dc2626',
                                borderColor: '#e5e7eb',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [4, 4], color: '#f3f4f6' },
                                ticks: { stepSize: 1, color: '#6b7280' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#6b7280' }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                    }
                });
            }
        });
    </script>

    <!-- Dokumentasi Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-red-700 uppercase tracking-wider mb-4">Dokumentasi</h2>
                <div class="w-24 h-1 bg-red-700 mx-auto rounded"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Image 1 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-xl h-72 cursor-pointer">
                    <img src="{{ asset('images/hp 4.jpeg') }}" alt="Dokumentasi 1" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Kegiatan Arsip</span>
                    </div>
                </div>
                <!-- Image 2 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-xl h-72 cursor-pointer">
                    <img src="{{ asset('images/hp 7.jpeg') }}" alt="Dokumentasi 2" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Pengelolaan Dokumen</span>
                    </div>
                </div>
                <!-- Image 3 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-xl h-72 cursor-pointer">
                    <img src="{{ asset('images/hp 5.jpeg') }}" alt="Dokumentasi 3" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Monitoring Aktivitas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="relative bg-white">
        <!-- Red Background Top with CSS Spotlight (Fixed) -->
        <div class="absolute top-0 left-0 w-full h-[300px] bg-[#7f1d1d] overflow-hidden">
             <!-- CSS Spotlight Effect -->
             <div class="absolute inset-0" style="background: radial-gradient(circle at 50% 0%, #ef4444 0%, #991b1b 60%, #7f1d1d 100%);"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 pt-15 pb-20">
            <div class="text-center mb-16">
                 <h2 class="text-4xl font-bold text-white mb-4">Fitur e-Arsip</h2>
                 <p class="text-red-100 max-w-2xl mx-auto">
                    Sistem E-Arsip PT Semen Padang adalah solusi digital terintegrasi yang dikembangkan khusus untuk mengelola dokumen dan arsip secara efisien dan aman.
                 </p>
                 <p class="text-red-100 max-w-2xl mx-auto">
                    Kelola arsip dengan mudah dan cepat menggunakan fitur-fitur unggulan kami yang terintegrasi.
                 </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Feature 1: Dashboard -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#b91c1c] transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#b91c1c] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-[#b91c1c] transition-colors">Dashboard</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Pantau keseluruhan statistik arsip dan ativitas terkini dalam satu tampilan ringkas.
                    </p>
                </div>

                <!-- Feature 2: Arsip Masuk -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#b91c1c] transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#b91c1c] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-[#b91c1c] transition-colors">Arsip Masuk</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Kelola arsip masuk dengan pencatatan yang rapi dan terstruktur.
                    </p>
                </div>

                <!-- Feature 3: Arsip -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#b91c1c] transition-colors duration-300">
                         <svg class="w-8 h-8 text-[#b91c1c] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-[#b91c1c] transition-colors">Arsip</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Penyimpanan digital yang aman untuk arsip perusahaan.
                    </p>
                </div>

                <!-- Feature 4: Monitor Karyawan -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#b91c1c] transition-colors duration-300">
                         <svg class="w-8 h-8 text-[#b91c1c] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                     <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-[#b91c1c] transition-colors">Monitor Karyawan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Sistem monitoring kinerja karyawan dalam pengelolaan arsip secara real-time.
                    </p>
                </div>

                <!-- Feature 5: Peminjaman -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#b91c1c] transition-colors duration-300">
                         <svg class="w-8 h-8 text-[#b91c1c] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-[#b91c1c] transition-colors">Peminjaman</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Layanan peminjaman arsip dengan pencatatan yang akurat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="pt-20 pb-10 border-t border-gray-200 bg-gray-100 bg-cover bg-center" style="background-image: url('{{ asset('images/SuperGrafis.png') }}');">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Kantor Utama -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Kantor Utama</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Jl. Raya Indarung, Kec. Lubuk Kilangan Kota Padang 25237, Sumatera Barat
                    </p>
                </div>
                <!-- Kantor Perwakilan -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Kantor Perwakilan Jakarta</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Graha Irama, Lt. 11, Jl. H. R. Rasuna Said No. 1 & 2, RT.6/RW.4, Kuningan Timur, Kecamatan Setiabudi, Kota Jakarta Selatan 12950, DKI Jakarta
                    </p>
                </div>
                <!-- Media Sosial -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Media Sosial</h4>
                    <div class="flex gap-4 mb-6">
                        <a href="https://twitter.com/semenpadang1910" target="_blank" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg></a>
                        <a href="https://www.instagram.com/semenpadang/" target="_blank" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="https://www.youtube.com/channel/UCIi9Yy9jRMlB8k9_8djAJcA/feed" target="_blank" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                        <a href="https://www.tiktok.com/@semenpadang1910?_t=8hadknUhwFF&_r=1" target="_blank" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.65-1.62-1.1-.04 1.86.04 3.66.17 5.51.18 2.58-.62 5.13-2.4 7.29-1.42 1.75-3.64 2.7-5.99 2.7-3.36.03-6.54-1.74-8.19-4.57-1.74-3.08-1.55-7.06.63-9.92.51-.7 1.12-1.32 1.83-1.83 1.96-1.43 4.54-1.85 6.93-1.25.1.58.21 1.17.32 1.76-1.09-.37-2.29-.44-3.41-.09-1.13.34-2.11 1.05-2.73 2.05-.66 1.06-.82 2.37-.58 3.6.43 2.21 2.4 4.02 4.63 4.1 1.23.07 2.45-.31 3.42-1.1 1.08-.85 1.66-2.26 1.58-3.62-.06-2.58-.02-5.16-.01-7.74-.01-.98-.02-1.95-.03-2.93-.01-.65-.01-1.31-.02-1.96H12.525z"/></svg></a>
                        <a href="https://web.facebook.com/PTsemenpadang1910/" target="_blank" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">SIG Group</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <a href="https://sig.id/" target="_blank" class="hover:text-red-700 transition">www.sig.id</a>
                    </p>
                </div>
                <!-- Logo Footer -->
                <div class="flex flex-col items-start gap-4">
                    <img src="{{ asset('images/sp-black.png') }}" class="h-20 p-2 rounded">
                    <div class="text-right w-full">
                        <p class="text-xs text-gray-500 font-bold tracking-widest uppercase">Hotline Coverage</p>
                        <p class="text-2xl font-black text-red-700">0800 1088888</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-[#dc2626] -mx-6 -mb-10 py-4 text-center">
                 <p class="text-white text-sm">© {{ date('Y') }} PT Semen Padang. All Rights Reserved. e-Arsip System.</p>
            </div>
        </div>
    </footer>

</body>
</html>