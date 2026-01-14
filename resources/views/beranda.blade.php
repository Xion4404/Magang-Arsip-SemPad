<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div x-data="{ activeTab: 'peminjaman', mounted: false }" 
         x-init="setTimeout(() => mounted = true, 100)" 
         class="pb-20 bg-gray-50 min-h-screen">

        <div x-show="mounted"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 transform scale-[0.98] translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             class="relative w-full overflow-hidden shadow-md z-0 bg-white"
             style="display: none;" 
        >
            <img src="{{ asset('images/banner-beranda.png') }}" 
                 alt="Banner Selamat Datang PT Semen Padang" 
                 class="w-full h-auto max-h-[400px] object-cover object-bottom"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x400/7f1d1d/FFFFFF?text=Gambar+Banner+Tidak+Ditemukan';">
        </div>

        <div class="container mx-auto px-4 mt-6 relative z-10">
            <div x-show="mounted"
                 x-transition:enter="transition ease-out duration-700 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="flex flex-row justify-center gap-2 md:gap-4"
                 style="display: none;"
            >
                <button @click="activeTab = 'arsip'" 
                    :class="activeTab === 'arsip' ? 'bg-red-900 text-white ring-2 ring-red-900 shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Arsip
                </button>

                <button @click="activeTab = 'peminjaman'" 
                    :class="activeTab === 'peminjaman' ? 'bg-red-900 text-white ring-2 ring-red-900 shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Peminjaman
                </button>

                <button @click="activeTab = 'karyawan'" 
                    :class="activeTab === 'karyawan' ? 'bg-red-900 text-white ring-2 ring-red-900 shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Monitoring Karyawan
                </button>
            </div>
        </div>

        <div x-show="mounted"
             x-transition:enter="transition ease-out duration-700 delay-500"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mt-8 container mx-auto px-4"
             style="display: none;"
        >

            <div x-show="activeTab === 'peminjaman'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 border-l-4 border-red-900 pl-4 flex items-center gap-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
                    Statistik Peminjaman
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <h3 class="text-gray-700 font-bold mb-4 text-center text-base md:text-lg">
                            Status Saat Ini
                        </h3>
                        <div class="relative h-72 w-full flex justify-center">
                            <canvas id="statusChart"></canvas>
                        </div>
                         <div class="mt-6 flex justify-center gap-4 text-xs md:text-sm font-medium text-gray-600">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-600 ring-2 ring-red-100"></span> Dipinjam</div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-600 ring-2 ring-green-100"></span> Kembali</div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-gray-700 font-bold text-base md:text-lg">
                                Tren Tahunan
                            </h3>
                            <span class="text-xs font-bold bg-red-100 text-red-900 px-3 py-1 rounded-full">Tahun {{ date('Y') }}</span>
                        </div>
                        <div class="relative h-72 w-full">
                            <canvas id="trenChart"></canvas>
                        </div>
                        <div class="mt-4 flex justify-center gap-4 text-xs md:text-sm font-medium text-gray-600">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-red-600"></span> Sedang Dipinjam</div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-green-600"></span> Telah Dikembalikan</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mb-12">
                    <a href="/peminjaman" class="group relative inline-flex items-center justify-center px-8 py-3 text-base md:text-lg text-red-900 font-bold bg-white border border-red-200 rounded-full shadow-sm hover:bg-red-50 hover:border-red-300 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <span>Lihat Data Selengkapnya</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

            </div>

            <div x-show="activeTab === 'arsip'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 style="display: none;">
                <div class="bg-white p-12 rounded-2xl shadow-md text-center border border-gray-100">
                    <div class="text-6xl mb-6 animate-bounce">📂</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Modul Arsip</h3>
                    <p class="text-gray-500">Visualisasi data arsip keseluruhan akan ditampilkan di sini.</p>
                </div>
            </div>

            <div x-show="activeTab === 'karyawan'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 style="display: none;">
                <div class="bg-white p-12 rounded-2xl shadow-md text-center border border-gray-100">
                    <div class="text-6xl mb-6 animate-pulse">👥</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Modul Karyawan</h3>
                    <p class="text-gray-500">Monitoring kinerja dan aktivitas karyawan akan ditampilkan di sini.</p>
                </div>
            </div>

        </div>
    </div>

     <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- 1. CONFIG CHART STATUS (DONUT) ---
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            if (ctxStatus) {
                 new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sedang Dipinjam', 'Telah Dikembalikan'],
                        datasets: [{
                            data: [{{ $dipinjam }}, {{ $kembali }}], 
                            backgroundColor: ['#dc2626', '#16a34a'], // Merah & Hijau
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%', 
                        plugins: {
                            legend: { display: false } // Legend kita buat manual HTML
                        },
                        layout: {
                            padding: 10
                        }
                    }
                });
            }

            // --- 2. CONFIG CHART TREN (STACKED BAR) ---
            // Update: Menggunakan dataDipinjam dan dataKembali dari Controller
            const ctxTren = document.getElementById('trenChart').getContext('2d');
            if (ctxTren) {
                 new Chart(ctxTren, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [
                            {
                                label: 'Sedang Dipinjam',
                                data: @json($dataDipinjam), // Data Array dari Controller
                                backgroundColor: '#dc2626', // Merah
                                borderRadius: 4,
                            },
                            {
                                label: 'Telah Dikembalikan',
                                data: @json($dataKembali),  // Data Array dari Controller
                                backgroundColor: '#16a34a', // Hijau
                                borderRadius: 4,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true, // INI KUNCINYA AGAR BERTUMPUK
                                grid: { display: false },
                                ticks: { font: { size: 12 } }
                            },
                            y: {
                                stacked: true, // INI KUNCINYA AGAR BERTUMPUK
                                beginAtZero: true,
                                grid: { borderDash: [4, 4], color: '#e5e7eb' },
                                ticks: { stepSize: 1, font: { size: 12 } }
                            }
                        },
                        plugins: { 
                            legend: { display: false }, // Legend manual di HTML biar rapi
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        layout: {
                            padding: { top: 10, bottom: 5 }
                        }
                    }
                });
            }
        });
    </script>
</x-layout>