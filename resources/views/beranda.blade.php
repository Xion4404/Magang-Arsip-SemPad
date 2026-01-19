<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div x-data="{ activeTab: 'peminjaman', mounted: false }" 
         x-init="setTimeout(() => mounted = true, 100)" 
         class="pb-20 bg-gray-50 min-h-screen">

        <div x-show="mounted"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="w-full bg-white shadow-sm"
             style="display: none;" 
        >
            <img src="{{ asset('images/banner-beranda.png') }}" 
                 alt="Banner Semen Padang" 
                 class="w-full h-auto object-cover"
                 style="max-height: 400px;" 
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x300/7f1d1d/FFFFFF?text=Banner+Dashboard';">
        </div>

        <div class="container mx-auto px-4 mt-6 relative z-10">
            <div x-show="mounted"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="translate-y-4 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 class="bg-white p-2 rounded-xl shadow-md border border-gray-100 flex flex-col sm:flex-row justify-between gap-2"
                 style="display: none;"
            >
                <button @click="activeTab = 'arsip'" 
                    :class="activeTab === 'arsip' ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-red-700'"
                    class="flex-1 py-3 px-4 rounded-lg font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2">
                    <span>📂</span> Data Arsip
                </button>

                <button @click="activeTab = 'peminjaman'" 
                    :class="activeTab === 'peminjaman' ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-red-700'"
                    class="flex-1 py-3 px-4 rounded-lg font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2">
                    <span>🔄</span> Peminjaman
                </button>

                <button @click="activeTab = 'karyawan'" 
                    :class="activeTab === 'karyawan' ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-red-700'"
                    class="flex-1 py-3 px-4 rounded-lg font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2">
                    <span>👥</span> Monitoring
                </button>
            </div>
        </div>

        <div x-show="mounted"
             x-transition:enter="transition ease-out duration-700 delay-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mt-8 container mx-auto px-4 md:px-6"
             style="display: none;"
        >

            <div x-show="activeTab === 'peminjaman'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-8 bg-red-800 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">Statistik Peminjaman</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    
                    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 flex flex-col">
                        <h3 class="text-gray-700 font-bold mb-4 text-center text-sm md:text-base">Rasio Peminjaman</h3>
                        
                        <div class="relative h-56 md:h-64 w-full flex justify-center items-center">
                            <canvas id="statusChart"></canvas>
                        </div>

                        <div class="mt-4 flex justify-center gap-4 text-xs md:text-sm font-medium text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-700"></span> Dipinjam: <span class="font-bold">{{ $dipinjam }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-green-600"></span> Kembali: <span class="font-bold">{{ $kembali }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-gray-700 font-bold text-sm md:text-base">Tren Peminjaman</h3>
                            <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded">Tahun {{ date('Y') }}</span>
                        </div>
                        
                        <div class="relative h-56 md:h-64 w-full">
                            <canvas id="trenChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    
                    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300">
                        <h3 class="text-gray-700 font-bold mb-4 text-sm md:text-base border-b border-gray-100 pb-2">
                            Top 5 Unit Peminjam
                        </h3>
                        <div class="relative h-56 md:h-64 w-full">
                            <canvas id="unitChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 flex flex-col">
                        <h3 class="text-gray-700 font-bold mb-4 text-center text-sm md:text-base border-b border-gray-100 pb-2">
                            Proporsi Media Arsip
                        </h3>
                        <div class="relative h-56 md:h-64 w-full flex justify-center items-center">
                            <canvas id="mediaChart"></canvas>
                        </div>
                        <div class="mt-4 text-center text-xs text-gray-400">
                            Perbandingan Hardfile (Fisik) vs Softfile (Digital)
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mb-12">
                    <a href="/peminjaman" class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-red-900 rounded-full shadow-md hover:bg-red-800 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <span>Kelola Data Peminjaman</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

            </div>

            <div x-show="activeTab === 'arsip'" 
                 x-transition:enter="transition ease-out duration-300"
                 class="py-12" style="display: none;">
                <div class="bg-white p-12 rounded-2xl shadow-sm text-center border border-gray-200 max-w-2xl mx-auto">
                    <div class="text-6xl mb-4 opacity-25">📂</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Statistik Arsip</h3>
                    <p class="text-gray-500 mb-6 text-sm">Visualisasi total arsip, klasifikasi, dan ruang penyimpanan.</p>
                    <a href="/arsip" class="text-red-700 font-bold hover:underline text-sm">Lihat Data Arsip →</a>
                </div>
            </div>

            <div x-show="activeTab === 'karyawan'" 
                 x-transition:enter="transition ease-out duration-300"
                 class="py-12" style="display: none;">
                <div class="bg-white p-12 rounded-2xl shadow-sm text-center border border-gray-200 max-w-2xl mx-auto">
                    <div class="text-6xl mb-4 opacity-25">👥</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Monitoring Karyawan</h3>
                    <p class="text-gray-500 mb-6 text-sm">Dashboard aktivitas dan kinerja karyawan.</p>
                    <a href="/monitoring" class="text-red-700 font-bold hover:underline text-sm">Lihat Monitoring →</a>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Konfigurasi Default Font
            Chart.defaults.font.family = "'Inter', 'sans-serif'";
            Chart.defaults.font.size = window.innerWidth < 768 ? 10 : 12; // Responsif font
            
            // --- 1. STATUS (DONUT) ---
            const ctxStatus = document.getElementById('statusChart');
            if (ctxStatus) {
                 new Chart(ctxStatus.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Dipinjam', 'Kembali'],
                        datasets: [{
                            data: [{{ $dipinjam }}, {{ $kembali }}], 
                            backgroundColor: ['#b91c1c', '#16a34a'], 
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%', 
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // --- 2. TREN (STACKED BAR) ---
            const ctxTren = document.getElementById('trenChart');
            if (ctxTren) {
                 new Chart(ctxTren.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [
                            {
                                label: 'Dipinjam',
                                data: @json($dataDipinjam),
                                backgroundColor: '#b91c1c',
                                borderRadius: 2,
                            },
                            {
                                label: 'Kembali',
                                data: @json($dataKembali),
                                backgroundColor: '#16a34a',
                                borderRadius: 2,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, beginAtZero: true, grid: { borderDash: [4, 4] } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // --- 3. TOP UNIT (HORIZONTAL BAR) ---
            const ctxUnit = document.getElementById('unitChart');
            if (ctxUnit) {
                new Chart(ctxUnit.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($unitLabels),
                        datasets: [{
                            data: @json($unitData),
                            backgroundColor: '#7f1d1d',
                            borderRadius: 4,
                            barThickness: window.innerWidth < 768 ? 15 : 20, 
                        }]
                    },
                    options: {
                        indexAxis: 'y', 
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                            y: { grid: { display: false } }
                        }
                    }
                });
            }

            // --- 4. MEDIA (PIE) ---
            const ctxMedia = document.getElementById('mediaChart');
            if (ctxMedia) {
                new Chart(ctxMedia.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Hardfile', 'Softfile'],
                        datasets: [{
                            data: [{{ $mediaHardfile }}, {{ $mediaSoftfile }}],
                            backgroundColor: ['#1f2937', '#3b82f6'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                position: 'right',
                                labels: { boxWidth: 10, padding: 10 }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layout>