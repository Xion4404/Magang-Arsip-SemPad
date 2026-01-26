<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi e-Arsip - PT Semen Padang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">

    <!-- Navigation -->
    <nav class="absolute top-0 left-0 w-full z-50 bg-transparent py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                 <img src="{{ asset('images/logo-semen-padang.png') }}" alt="Logo Semen Padang" class="h-12 drop-shadow-lg filter brightness-100 bg-white/80 rounded px-2 py-1">
            </div>
            <div class="hidden md:flex gap-6 text-white font-medium drop-shadow-md">
                <a href="#" class="hover:text-red-200 transition">Beranda</a>
                <a href="#tentang" class="hover:text-red-200 transition">Tentang</a>
                <a href="#fitur" class="hover:text-red-200 transition">Fitur</a>
                <a href="#kontak" class="hover:text-red-200 transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Carousel -->
    <div x-data="{ 
            activeSlide: 0, 
            slides: [
                { img: 'hp 1.jpg', text: 'Sistem Informasi e-Arsip' },
                { img: 'hp 2.jpeg', text: 'Pengelolaan Arsip Digital' },
                { img: 'hp 3.jpeg', text: 'Efisien dan Terintegrasi' }
            ],
            autoplay() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 5000);
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
    <section id="tentang" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                <!-- Red Box Image Placeholder -->
                <div class="w-full md:w-1/3">
                    <div class="aspect-square bg-[#b91c1c] rounded-2xl shadow-xl flex items-center justify-center relative overflow-hidden group">
                        <!-- Decorative Pattern -->
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                         <div class="text-white text-center p-8">
                            <span class="text-6xl font-bold block mb-2">SP</span>
                            <span class="text-xl uppercase tracking-widest">Semen Padang</span>
                        </div>
                    </div>
                </div>
                
                <!-- Text Content -->
                <div class="w-full md:w-2/3">
                    <h2 class="text-red-700 font-bold text-xl uppercase tracking-wider mb-2">Tentang Kami</h2>
                    <h3 class="text-4xl font-bold text-gray-800 mb-6">Kearsipan PT Semen Padang</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                        Kearsipan di PT Semen Padang merupakan bagian penting dalam mendukung tertib administrasi dan kelancaran operasional perusahaan. Setiap arsip dikelola sebagai sumber informasi yang memiliki nilai guna bagi perusahaan, baik sebagai bukti kegiatan, bahan pengambilan keputusan, maupun sebagai bentuk pertanggungjawaban organisasi.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                        Pengelolaan kearsipan di PT Semen Padang dilaksanakan secara terkoordinasi oleh Unit Sistem Manajemen dengan mengedepankan keteraturan, keamanan, dan kemudahan akses sesuai kebutuhan kerja. Melalui pengelolaan arsip yang baik, perusahaan berupaya menjaga keberlangsungan informasi serta mendukung penerapan tata kelola perusahaan yang efektif dan berkelanjutan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Arsip Section -->
    <section class="py-20 bg-[#b91c1c] relative overflow-hidden">
        <!-- Background Pattern -->
         <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        
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
                    <img src="{{ asset('images/hp 1.jpg') }}" alt="Dokumentasi 1" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Kegiatan Arsip</span>
                    </div>
                </div>
                <!-- Image 2 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-xl h-72 cursor-pointer">
                    <img src="{{ asset('images/hp 2.jpeg') }}" alt="Dokumentasi 2" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Pengelolaan Dokumen</span>
                    </div>
                </div>
                <!-- Image 3 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-xl h-72 cursor-pointer">
                    <img src="{{ asset('images/hp 3.jpeg') }}" alt="Dokumentasi 3" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                        <span class="text-white font-medium tracking-wide">Monitoring Aktivitas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="relative bg-white">
        <!-- Red Background Top -->
        <div class="absolute top-0 left-0 w-full h-[300px] bg-[#b91c1c]"></div>

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
    <footer id="kontak" class="bg-gray-100 pt-20 pb-10 border-t border-gray-200">
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
                        <a href="#" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">SIG Group</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <www class="sig id">www.sig.id</www>
                    </p>
                </div>
                <!-- Logo Footer -->
                <div class="flex flex-col items-start gap-4">
                    <img src="{{ asset('images/logo-semen-padang.png') }}" class="h-16 bg-white p-2 rounded">
                    <div class="text-right w-full">
                        <p class="text-xs text-gray-500 font-bold tracking-widest uppercase">Hotline Coverage</p>
                        <p class="text-2xl font-black text-red-700">0800 1000 800</p>
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
