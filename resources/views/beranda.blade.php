<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<<<<<<< HEAD
    <div x-data="{ activeTab: 'peminjaman', mounted: false }" x-init="setTimeout(() => mounted = true, 100)"
        class="pb-20 bg-gray-50 min-h-screen">

        {{-- HERO SECTION --}}
        <div class="bg-[#9d1b1b] px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl relative overflow-hidden">
            <div class="container mx-auto px-4 relative z-10 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-bold text-white tracking-wide mb-2">Dashboard Arsip & Peminjaman
                </h1>
                <p class="text-red-100 text-sm opacity-90 font-light max-w-2xl">
                    Sistem informasi pengelolaan arsip dan monitoring peminjaman PT Semen Padang.
                </p>
            </div>
            {{-- Decorative Elements --}}
            <div
                class="hidden md:block absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent">
            </div>
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
=======
    <div x-data="{ activeTab: '{{ request()->query('active_tab', 'peminjaman') }}', mounted: false }" 
         x-init="setTimeout(() => mounted = true, 100)" 
         x-init="setTimeout(() => mounted = true, 100)" 
         class="pb-20 bg-gray-50 min-h-screen">

        <!-- Background Header -->
        <div class="bg-gradient-to-br from-[#e92027] via-[#b91c1c] to-[#7f090b] text-white pb-32 pt-16 px-8 -mt-6 -mx-6 mb-8 rounded-b-[3rem] shadow-2xl relative overflow-hidden">
            <!-- Polygon Pattern Overlay -->
            <div class="absolute inset-0 z-0 opacity-40">
                 <svg class="absolute w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <defs>
                        <linearGradient id="polyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#580000;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#000000;stop-opacity:0.4" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#polyGrad)" d="M0 0 L1000 0 L1000 500 L0 300 Z" />
                    <path fill="#000000" opacity="0.1" d="M-100 0 L500 0 L200 600 L-100 400 Z" />
                    <path fill="#580000" opacity="0.2" d="M800 0 L1400 0 L1400 400 L600 600 Z" />
                    <path fill="url(#polyGrad)" opacity="0.3" d="M500 600 L1200 600 L800 200 Z" />
                </svg>
            </div>
    
            <!-- Ornamental Icon -->
            <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4 z-0 pointer-events-none mix-blend-overlay">
                <svg width="400" height="400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L24 12L12 24L0 12L12 0Z" /></svg>
            </div>
             
             <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
                <div class="text-center md:text-left">
                     <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Beranda e-Arsip</h2>
                     <p class="text-red-50 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Ringkasan statistik dan aktivitas kearsipan PT Semen Padang.</p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 -mt-10 relative z-20">
            <div x-show="mounted"
                 x-transition:enter="transition ease-out duration-700 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="flex flex-row justify-center gap-2 md:gap-4"
                 style="display: none;"
            >
                <button @click="activeTab = 'arsip'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
                    :class="activeTab === 'arsip' ? 'bg-[#e92027] text-white ring-2 ring-[#e92027] shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Arsip
                </button>

                <button @click="activeTab = 'peminjaman'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
                    :class="activeTab === 'peminjaman' ? 'bg-[#e92027] text-white ring-2 ring-[#e92027] shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Peminjaman
                </button>

                <button @click="activeTab = 'karyawan'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
                    :class="activeTab === 'karyawan' ? 'bg-[#e92027] text-white ring-2 ring-[#e92027] shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Monitoring Karyawan
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
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
                    <div
                        class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-gray-400 hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Total Transaksi
                        </p>
                        <p class="text-4xl font-extrabold text-gray-600">{{ $dipinjam + $kembali }}</p>
                    </div>

                    <!-- Card 2: Sedang Dipinjam -->
                    <div
<<<<<<< HEAD
                        class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-[#9d1b1b] hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sedang Dipinjam
                        </p>
                        <p class="text-4xl font-extrabold text-[#9d1b1b]">{{ $dipinjam }}</p>
=======
                        class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-[#e92027] hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sedang Dipinjam
                        </p>
                        <p class="text-4xl font-extrabold text-[#e92027]">{{ $dipinjam }}</p>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    </div>

                    <!-- Card 3: Sudah Kembali -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-red-300 hover:-translate-y-1 transition duration-300">
                        <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sudah Kembali</p>
                        <p class="text-4xl font-extrabold text-red-300">{{ $kembali }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 mb-6">
<<<<<<< HEAD
                    <div class="w-1.5 h-8 bg-[#9d1b1b] rounded-full"></div>
=======
                    <div class="w-1.5 h-8 bg-[#e92027] rounded-full"></div>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    <h2 class="text-2xl font-bold text-gray-800">Analisis Peminjaman</h2>
                </div>

                {{-- CHART ROW 1: Donut & Pie (Balanced) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                    <!-- 1. RASIO STATUS (Donut) -->
                    <div
                        class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-6 z-10 relative">
                            <div>
                                <h3 class="text-gray-800 font-bold text-lg">Rasio Status</h3>
                                <p class="text-xs text-gray-400">Dipinjam vs Kembali</p>
                            </div>
<<<<<<< HEAD
                            <div class="bg-red-50 p-2 rounded-lg text-[#9d1b1b]"><span class="text-lg">📉</span></div>
=======
                            <div class="bg-red-50 p-2 rounded-lg text-[#e92027]"><span class="text-lg">📉</span></div>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                        </div>

                        <div class="relative h-52 w-full flex justify-center items-center z-10">
                            <canvas id="statusChart"></canvas>
                        </div>

                        {{-- Decorative Blob --}}
                        <div
                            class="absolute -bottom-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50 pointer-events-none">
                        </div>
                    </div>

                    <!-- 2. MEDIA ARSIP (Pie) - Moved here for Balance -->
                    <div
                        class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-3">
                            <h3 class="text-gray-800 font-bold text-lg flex items-center gap-2"><span
                                    class="text-blue-500">💿</span> Media Arsip</h3>
                            <div class="bg-blue-50 p-2 rounded-lg text-blue-600"><span class="text-lg">📊</span></div>
                        </div>
                        <div class="relative h-52 w-full flex justify-center items-center">
                            <canvas id="mediaChart"></canvas>
                        </div>
                        <div class="mt-4 text-center">
                            <span
                                class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-200">Fisik
                                (Hardfile) vs Digital (Softfile)</span>
                        </div>
                    </div>
                </div>

                <!-- 3. TREN BULANAN (Bar) - Full Width at Bottom -->
                <div
                    class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100/50 hover:shadow-2xl transition-all duration-300 flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-center mb-6 z-10 relative">
                        <div>
                            <h3 class="text-gray-800 font-bold text-lg">Tren Bulanan</h3>
                            <p class="text-xs text-gray-400">Aktivitas Tahun {{ date('Y') }}</p>
                        </div>
<<<<<<< HEAD
                        <div class="bg-red-50 p-2 rounded-lg text-[#9d1b1b]"><span class="text-lg">📈</span></div>
=======
                        <div class="bg-red-50 p-2 rounded-lg text-[#e92027]"><span class="text-lg">📈</span></div>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    </div>

                    <div class="relative h-64 w-full z-10">
                        <canvas id="trenChart"></canvas>
                    </div>
<<<<<<< HEAD
=======

                    {{-- Decorative Blob --}}
                    <div
                        class="absolute -top-10 -left-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50 pointer-events-none">
                    </div>
                </div>

                <div class="flex justify-center mb-12 mt-8">
                    <a href="/peminjaman"
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-[#e92027] rounded-2xl shadow-lg hover:bg-[#c41820] hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <span>Kelola Data Peminjaman</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9

                    {{-- Decorative Blob --}}
                    <div
                        class="absolute -top-10 -left-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50 pointer-events-none">
                    </div>
                </div>
            </div>

<<<<<<< HEAD
            <div class="flex justify-center mb-12 mt-8">
                <a href="/peminjaman"
                    class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-[#9d1b1b] rounded-2xl shadow-lg hover:bg-[#801010] hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <span>Kelola Data Peminjaman</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
=======
            <div x-show="activeTab === 'karyawan'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 style="display: none;">
                
                <!-- Filter Toolbar -->
                <div class="mb-8">
                    <form action="{{ route('beranda') }}" method="GET" class="flex flex-wrap gap-4">
                        <input type="hidden" name="active_tab" value="karyawan">
                        
                        <!-- Helper for chevron icon -->
                        @php
                            $chevron = '<svg class="w-4 h-4 text-white pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                        @endphp

                        <!-- PIC Filter -->
                        <div class="relative group">
                            <select name="pic" onchange="this.form.submit()" class="appearance-none bg-[#e92027] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-[#c41820] transition shadow-sm w-full md:w-auto min-w-[180px]">
                                <option value="">Semua PIC</option>
                                @foreach($allPics as $p)
                                    <option value="{{ $p->id }}" {{ request('pic') == $p->id ? 'selected' : '' }} class="bg-white text-gray-800">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            {!! $chevron !!}
                        </div>

                        <!-- Unit Kerja Filter -->
                        <div class="relative group">
                            <select name="unit_kerja" onchange="this.form.submit()" class="appearance-none bg-[#e92027] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-[#c41820] transition shadow-sm w-full md:w-auto min-w-[200px]">
                                <option value="">Semua Unit Kerja</option>
                                @foreach($allUnits as $unit)
                                    <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }} class="bg-white text-gray-800">{{ $unit }}</option>
                                @endforeach
                            </select>
                             {!! $chevron !!}
                        </div>

                        <!-- Bulan Filter -->
                        <div class="relative group">
                            <select name="bulan" onchange="this.form.submit()" class="appearance-none bg-[#e92027] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-[#c41820] transition shadow-sm w-full md:w-auto min-w-[150px]">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1,12) as $m)
                                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }} class="bg-white text-gray-800">
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                             {!! $chevron !!}
                        </div>

                        <!-- Minggu Filter -->
                        <div class="relative group">
                            <select name="minggu" onchange="this.form.submit()" class="appearance-none bg-[#e92027] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-[#c41820] transition shadow-sm w-full md:w-auto min-w-[150px]">
                                <option value="">Semua Minggu</option>
                                <option value="" class="bg-gray-100 font-bold text-gray-500" disabled>-- Minggu Ke --</option>
                                @foreach(range(1, 5) as $w)
                                    <option value="{{ $w }}" {{ request('minggu') == $w ? 'selected' : '' }} class="bg-white text-gray-800">Minggu Ke-{{ $w }}</option>
                                @endforeach
                            </select>
                             {!! $chevron !!}
                        </div>

                         <!-- Reset (Only show if filtering) -->
                        @if(request()->hasAny(['pic', 'unit_kerja', 'bulan', 'minggu']))
                        <a href="{{ route('beranda') }}?active_tab=karyawan" class="flex items-center justify-center px-4 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition shadow-sm h-full" title="Reset Filter">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                    </form>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-black text-gray-800">{{ $totalBox }}</p>
                        <p class="text-xs text-gray-500 font-medium">Total Box Arsip Masuk</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Arsip Masuk Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bulanIniArsip }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Pemilahan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pemilahan }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Pendataan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pendataan }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Pelabelan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pelabelan }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Input E-Arsip</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $inputEArsip }}</p>
                    </div>
                </div>

                <!-- Row 1: Tahapan & Rata-rata Aktivitas -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                    <!-- Left: Tahapan Pengarsipan (Horizontal Bar) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 h-full">
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-[#e92027] pl-3">Tahapan Pengarsipan</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="tahapanChart"></canvas>
                        </div>
                    </div>

                    <!-- Right: Rata-rata Aktivitas PIC (Bar Chart) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                        <div class="mb-2">
                            <h3 class="font-bold text-gray-800">Rata-rata Aktivitas PIC</h3>
                            <p class="text-xs text-gray-500">Persentase penyelesaian seluruh tahapan</p>
                        </div>
                        <div id="activityChart" class="flex-1 w-full min-h-[300px]"></div>
                    </div>
                </div>

                <!-- Row 2: Tren & Unit Kerja -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Left: Trend Arsip Masuk (Line) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-[#e92027] pl-3">Tren Arsip Masuk (Tahun {{ date('Y') }})</h3>
                        <div class="relative h-72 w-full">
                            <canvas id="arsipBulananChart"></canvas>
                        </div>
                    </div>

                    <!-- Right: Arsip per Unit (Donut) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-[#e92027] pl-3">Arsip per Unit Kerja (Top 10)</h3>
                        <div class="relative h-72 w-full flex justify-center">
                            <canvas id="arsipUnitChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Pemilahan Arsip Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col mb-8">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Pemilahan Arsip</h3>
                        <span class="text-xs font-semibold bg-gray-200 text-gray-600 px-2 py-1 rounded">Target vs Realisasi</span>
                    </div>
                    <div class="overflow-x-auto p-0">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[#e92027] text-white text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3">PIC</th>
                                    <th class="px-4 py-3 text-center"># Target</th>
                                    <th class="px-4 py-3 text-center"># Selesai</th>
                                    <th class="px-4 py-3 text-center">% Progress</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($pemilahanStats as $stat)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $stat->user->nama ?? 'Unknown' }}</td>
                                    <td class="px-4 py-2 text-center text-gray-600 font-mono">{{ $stat->total_target }}</td>
                                    <td class="px-4 py-2 text-center text-gray-800 font-bold font-mono">{{ $stat->total_selesai }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-[#e92027]" style="width: {{ $stat->persentase }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold">{{ $stat->persentase }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- Total Row -->
                                <tr class="bg-[#e92027] text-white font-bold">
                                    <td class="px-4 py-2">Total</td>
                                    <td class="px-4 py-2 text-center">{{ $pemilahanStats->sum('total_target') }}</td>
                                    <td class="px-4 py-2 text-center">{{ $pemilahanStats->sum('total_selesai') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        @php
                                            $grandTotalTarget = $pemilahanStats->sum('total_target');
                                            $grandTotalSelesai = $pemilahanStats->sum('total_selesai');
                                            $grandPercent = $grandTotalTarget > 0 ? round(($grandTotalSelesai / $grandTotalTarget) * 100) : 0;
                                        @endphp
                                        {{ $grandPercent }}%
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BOTTOM ROW: Detailed Matrix -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">Detail Aktivitas Pengarsipan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <!-- Top Header: Activities -->
                                <tr class="bg-[#e92027] text-white text-xs uppercase">
                                    <th class="px-4 py-3 border-r border-[#c41820] w-48">Key Activity</th>
                                    <th class="px-4 py-3 border-r border-[#c41820] w-48"></th>
                                    @foreach($stages as $stage)
                                        <th colspan="3" class="px-4 py-3 text-center border-r border-[#c41820]">{{ $stage }}</th>
                                    @endforeach
                                    <th class="px-4 py-3 text-center border-r border-[#c41820] bg-emerald-900">Done</th>
                                </tr>
                                <!-- Sub Header: Metrics -->
                                <tr class="bg-[#c41820] text-white text-[10px] uppercase tracking-wider">
                                    <th class="px-4 py-2 border-r border-[#a0131a]">PIC</th>
                                    <th class="px-4 py-2 border-r border-[#a0131a]">Unit Kerja</th>
                                    @foreach($stages as $stage)
                                        <th class="px-2 py-2 text-center w-16 bg-[#b91c1c] border-r border-[#a0131a] text-red-100"># Krj</th>
                                        <th class="px-2 py-2 text-center w-16 bg-[#b91c1c] border-r border-[#a0131a] text-yellow-200"># Tgt</th>
                                        <th class="px-2 py-2 text-center w-16 bg-[#b91c1c] border-r border-[#a0131a] text-green-200">%</th>
                                    @endforeach
                                    <th class="px-2 py-2 text-center w-16 bg-[#b91c1c] border-r border-[#a0131a] text-white">✓</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($matrixData as $row)
                                <tr class="hover:bg-red-50 transition-colors group">
                                    <td class="px-4 py-3 font-semibold text-gray-800 border-r border-gray-100 group-hover:bg-red-100 transition-colors">
                                        {{ $row['user']->nama }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-600 border-r border-gray-100 group-hover:bg-red-50 transition-colors">
                                        {{ $row['unit_kerja'] }}
                                    </td>
                                    @foreach($stages as $stage)
                                        @php $data = $row[$stage]; @endphp
                                        <td class="px-2 py-3 text-center border-r border-gray-50 {{ $data['selesai'] > 0 ? 'text-[#e92027] font-bold bg-red-50/50' : 'text-gray-300' }}">
                                            {{ $data['selesai'] > 0 ? $data['selesai'] : '-' }}
                                        </td>
                                        <td class="px-2 py-3 text-center border-r border-gray-50 {{ $data['target'] > 0 ? 'text-gray-700 font-mono' : 'text-gray-300' }}">
                                            {{ $data['target'] > 0 ? $data['target'] : '-' }}
                                        </td>
                                        <td class="px-2 py-3 text-center border-r border-gray-100">
                                            @if($data['target'] > 0)
                                                <span class="{{ $data['progress'] == 100 ? 'text-green-600 font-bold' : ($data['progress'] > 50 ? 'text-blue-600' : 'text-orange-500') }}">
                                                    {{ $data['progress'] }}%
                                                </span>
                                            @else
                                                <span class="text-gray-200">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="px-4 py-3 text-center border-r border-gray-100">
                                        @if(isset($row['Input E-Arsip']) && $row['Input E-Arsip']['progress'] == 100)
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full font-bold shadow-sm">
                                                ✓
                                            </span>
                                        @else
                                            <span class="text-gray-200">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ 3 + count($stages) * 3 }}" class="px-6 py-8 text-center text-gray-400">
                                        Belum ada data aktivitas monitoring.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ApexCharts Script -->
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const chartStats = @json($chartStats);
                        
                        if(chartStats && chartStats.length > 0) {
                            const categories = chartStats.map(s => s.user ? s.user.nama : 'Unknown');
                            const seriesData = chartStats.map(s => s.persentase);

                            var options = {
                                series: [{
                                    name: 'Penyelesaian',
                                    data: seriesData
                                }],
                                chart: {
                                    type: 'bar',
                                    height: 350,
                                    toolbar: { show: false },
                                    fontFamily: 'inherit'
                                },
                                plotOptions: {
                                    bar: {
                                        borderRadius: 4,
                                        horizontal: false,
                                        columnWidth: '55%',
                                        distributed: true,
                                    }
                                },
                                dataLabels: {
                                    enabled: true,
                                    formatter: function (val) { return val + "%"; },
                                    offsetY: -20,
                                    style: { fontSize: '12px', colors: ["#334155"] }
                                },
                                legend: { show: false },
                                xaxis: {
                                    categories: categories,
                                    labels: { 
                                        style: { fontSize: '11px' },
                                        rotate: -45,
                                        trim: true
                                    }
                                },
                                yaxis: {
                                    max: 100,
                                    title: { text: 'Persentase (%)' }
                                },
                                grid: { strokeDashArray: 4 },
                                theme: { mode: 'light' },
                                colors: ['#e92027', '#c41820', '#ef4444', '#f87171', '#fca5a5'] // Red shades matching Semen Padang
                            };

                            var chart = new ApexCharts(document.querySelector("#activityChart"), options);
                            chart.render();
                        } else {
                            document.querySelector("#activityChart").innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Belum ada data visualisasi</div>';
                        }
                    });
                </script>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
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

<<<<<<< HEAD
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Konfigurasi Default Font
            Chart.defaults.font.family = "'Montserrat', 'sans-serif'";
            Chart.defaults.font.size = window.innerWidth < 768 ? 10 : 12; // Responsif font

=======
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
            // --- 1. STATUS (DONUT) ---
            const ctxStatus = document.getElementById('statusChart');
            if (ctxStatus) {
                new Chart(ctxStatus.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Dipinjam', 'Kembali'],
                        datasets: [{
                            data: [{{ $dipinjam }}, {{ $kembali }}],
<<<<<<< HEAD
                            backgroundColor: ['#9d1b1b', '#fca5a5'], // Red Primary & Faded Red
=======
                            backgroundColor: ['#e92027', '#fca5a5'], // Red Primary & Faded Red
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
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
<<<<<<< HEAD
                                backgroundColor: '#9d1b1b', // Red Primary
=======
                                backgroundColor: ['#e92027'], // Red Primary
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                borderRadius: 2,
                            },
                            {
                                label: 'Kembali',
                                data: @json($dataKembali),
<<<<<<< HEAD
                                backgroundColor: '#fca5a5', // Faded Red
=======
                                backgroundColor: ['#fca5a5'], // Faded Red
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
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
<<<<<<< HEAD
=======
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
                            backgroundColor: ['#e92027', '#fc8181'], // Use E9 for Hardfile
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
                                labels: { boxWidth: 10, padding: 10, font: { family: 'Montserrat' } }
                            }
                        }
                    }
                });
            }
            // --- 3. CHART TAHAPAN PENGARSIPAN (Horizontal Bar) ---
            const ctxTahapan = document.getElementById('tahapanChart').getContext('2d');
            if (ctxTahapan) {
                new Chart(ctxTahapan, {
                    type: 'bar', // Forcing horizontal
                    data: {
                        labels: @json($tahapanChartData['labels']),
                        datasets: [{
                            label: 'Jumlah Box',
                            data: @json($tahapanChartData['data']),
                            backgroundColor: [
                                '#e92027', // Main
                                '#b91c1c', // red-700
                                '#ef4444', // red-500
                                '#fca5a5'  // red-300
                            ],
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Convert to Horizontal Bar
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.x + ' Box';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { borderDash: [4, 4], color: '#f3f4f6' }
                            },
                            y: {
                                grid: { display: false }
                            }
                        }
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
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
<<<<<<< HEAD
                            data: [{{ $mediaHardfile }}, {{ $mediaSoftfile }}],
                            backgroundColor: ['#7f1d1d', '#fc8181'], // Dark Maroon & Soft Red
                            borderWidth: 2,
=======
                            label: 'Jumlah Arsip Masuk',
                            data: @json($arsipBulananData),
                            borderColor: '#e92027', // red-600
                            backgroundColor: 'rgba(233, 32, 39, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4, // Smooth curve
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#e92027',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [4, 4], color: '#f3f4f6' },
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // --- 5. CHART ARSIP PER UNIT KERJA (Donut Chart) ---
            const ctxUnit = document.getElementById('arsipUnitChart').getContext('2d');
            if (ctxUnit) {
                new Chart(ctxUnit, {
                    type: 'doughnut',
                    data: {
                        labels: @json($arsipUnitChart['labels']),
                        datasets: [{
                            data: @json($arsipUnitChart['data']),
                            backgroundColor: [
                                '#b91c1c', '#c41820', '#e92027', '#ef4444', '#f87171', 
                                '#fca5a5', '#fecaca', '#fee2e2'
                            ], // Red shades
                            borderWidth: 1,
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { boxWidth: 10, padding: 10, font: { family: 'Montserrat' } }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layout>
