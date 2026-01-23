<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div x-data="{ activeTab: 'peminjaman', mounted: false }" x-init="setTimeout(() => mounted = true, 100)"
        class="pb-20 bg-gray-50 min-h-screen">

        {{-- HERO SECTION --}}
        <div class="bg-[#9d1b1b] px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl relative overflow-hidden">
            <div class="container mx-auto px-4 relative z-10 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-bold text-white tracking-wide mb-2">Dashboard Arsip & Peminjaman</h1>
                <p class="text-red-100 text-sm opacity-90 font-light max-w-2xl">
                    Sistem informasi pengelolaan arsip dan monitoring peminjaman PT Semen Padang.
                </p>
            </div>
            {{-- Decorative Elements --}}
            <div class="hidden md:block absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        </div>

        {{-- NAVIGATION TABS (Floating) --}}
        <div class="container mx-auto px-4 -mt-12 relative z-20 mb-10">
            <div x-show="mounted" x-transition:enter="transition ease-out duration-700 delay-200"
                x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                class="bg-white p-2 rounded-2xl shadow-xl border border-gray-100 flex flex-col md:flex-row justify-between gap-3"
                style="display: none;">
                <button @click="activeTab = 'arsip'"
                    :class="activeTab === 'arsip' ? 'bg-[#9d1b1b] text-white shadow-lg transform scale-[1.02]' : 'text-gray-500 hover:bg-red-50 hover:text-[#9d1b1b]'"
                    class="flex-1 py-4 px-6 rounded-xl font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2.5">
                    <span class="text-lg">📂</span> Data Arsip
                </button>

                <button @click="activeTab = 'peminjaman'"
                    :class="activeTab === 'peminjaman' ? 'bg-[#9d1b1b] text-white shadow-lg transform scale-[1.02]' : 'text-gray-500 hover:bg-red-50 hover:text-[#9d1b1b]'"
                    class="flex-1 py-4 px-6 rounded-xl font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2.5">
                    <span class="text-lg">🔄</span> Peminjaman
                </button>

                <button @click="activeTab = 'karyawan'"
                    :class="activeTab === 'karyawan' ? 'bg-[#9d1b1b] text-white shadow-lg transform scale-[1.02]' : 'text-gray-500 hover:bg-red-50 hover:text-[#9d1b1b]'"
                    class="flex-1 py-4 px-6 rounded-xl font-bold text-sm transition-all duration-300 text-center flex items-center justify-center gap-2.5">
                    <span class="text-lg">👥</span> Monitoring
                </button>
            </div>
        </div>

        <div x-show="mounted" x-transition:enter="transition ease-out duration-700 delay-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-8 container mx-auto px-4 md:px-6" style="display: none;">

            <div x-show="activeTab === 'peminjaman'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                {{-- STATS SUMMARY ROW --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card 1: Total Transaksi -->
                    <div class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-gray-400 hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Total Transaksi</p>
                        <p class="text-4xl font-extrabold text-gray-600">{{ $dipinjam + $kembali }}</p>
                    </div>
                    
                    <!-- Card 2: Sedang Dipinjam -->
                    <div class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-[#9d1b1b] hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sedang Dipinjam</p>
                        <p class="text-4xl font-extrabold text-[#9d1b1b]">{{ $dipinjam }}</p>
                    </div>

                    <!-- Card 3: Sudah Kembali -->
                    <div class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-green-500 hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sudah Kembali</p>
                        <p class="text-4xl font-extrabold text-green-500">{{ $kembali }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-[#9d1b1b] rounded-full"></div>
                    <h2 class="text-2xl font-bold text-gray-800">Analisis Peminjaman</h2>
                </div>

                {{-- CHART ROW 1: Donut & Pie (Balanced) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    
                    <!-- 1. RASIO STATUS (Donut) -->
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-6 z-10 relative">
                            <div>
                                <h3 class="text-gray-800 font-bold text-lg">Rasio Status</h3>
                                <p class="text-xs text-gray-400">Dipinjam vs Kembali</p>
                            </div>
                            <div class="bg-red-50 p-2 rounded-lg text-[#9d1b1b]"><span class="text-lg">📉</span></div>
                        </div>
                        
                        <div class="relative h-52 w-full flex justify-center items-center z-10">
                            <canvas id="statusChart"></canvas>
                        </div>

                        {{-- Decorative Blob --}}
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50 pointer-events-none"></div>
                    </div>

                    <!-- 2. MEDIA ARSIP (Pie) - Moved here for Balance -->
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-3">
                            <h3 class="text-gray-800 font-bold text-lg flex items-center gap-2"><span class="text-blue-500">💿</span> Media Arsip</h3>
                            <div class="bg-blue-50 p-2 rounded-lg text-blue-600"><span class="text-lg">📊</span></div>
                        </div>
                        <div class="relative h-52 w-full flex justify-center items-center">
                            <canvas id="mediaChart"></canvas>
                        </div>
                        <div class="mt-4 text-center">
                            <span class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-200">Fisik (Hardfile) vs Digital (Softfile)</span>
                        </div>
                    </div>
                </div>

                <!-- 3. TREN BULANAN (Bar) - Full Width at Bottom -->
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-center mb-6 z-10 relative">
                        <div>
                            <h3 class="text-gray-800 font-bold text-lg">Tren Bulanan</h3>
                            <p class="text-xs text-gray-400">Aktivitas Tahun {{ date('Y') }}</p>
                        </div>
                        <div class="bg-red-50 p-2 rounded-lg text-[#9d1b1b]"><span class="text-lg">📈</span></div>
                    </div>
                    
                    <div class="relative h-64 w-full z-10">
                        <canvas id="trenChart"></canvas>
                    </div>

                    {{-- Decorative Blob --}}
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50 pointer-events-none"></div>
                </div>
            </div>

            <div class="flex justify-center mb-12 mt-8">
                <a href="/peminjaman" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-[#9d1b1b] rounded-2xl shadow-lg hover:bg-[#801010] hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <span>Kelola Data Peminjaman</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

        </div>

        <div x-show="activeTab === 'arsip'" x-transition:enter="transition ease-out duration-300" class="py-12"
            style="display: none;">
            <div class="bg-white p-12 rounded-2xl shadow-sm text-center border border-gray-200 max-w-2xl mx-auto">
                <div class="text-6xl mb-4 opacity-25">📂</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Statistik Arsip</h3>
                <p class="text-gray-500 mb-6 text-sm">Visualisasi total arsip, klasifikasi, dan ruang penyimpanan.
                </p>
                <a href="/arsip" class="text-red-700 font-bold hover:underline text-sm">Lihat Data Arsip →</a>
            </div>
        </div>

        <div x-show="activeTab === 'karyawan'" x-transition:enter="transition ease-out duration-300" class="py-12"
            style="display: none;">
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
        document.addEventListener('DOMContentLoaded', function () {

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