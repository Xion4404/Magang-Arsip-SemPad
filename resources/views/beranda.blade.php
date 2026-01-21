<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div x-data="{ activeTab: '{{ request()->query('active_tab', 'peminjaman') }}', mounted: false }" 
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
                <button @click="activeTab = 'arsip'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
                    :class="activeTab === 'arsip' ? 'bg-red-900 text-white ring-2 ring-red-900 shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Arsip
                </button>

                <button @click="activeTab = 'peminjaman'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
                    :class="activeTab === 'peminjaman' ? 'bg-red-900 text-white ring-2 ring-red-900 shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-50 shadow-sm hover:shadow-md'"
                    class="flex-1 py-3 px-2 md:px-6 rounded-xl font-bold text-xs md:text-base transition-all duration-300 text-center border border-gray-100">
                    Peminjaman
                </button>

                <button @click="activeTab = 'karyawan'; setTimeout(() => window.dispatchEvent(new Event('resize')), 350)" 
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
                <!-- Arsip Charts Container -->
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
                
                <!-- Filter Toolbar -->
                <div class="mb-8">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-4">
                        <input type="hidden" name="active_tab" value="karyawan">
                        
                        <!-- Helper for chevron icon -->
                        @php
                            $chevron = '<svg class="w-4 h-4 text-white pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                        @endphp

                        <!-- PIC Filter -->
                        <div class="relative group">
                            <select name="pic" onchange="this.form.submit()" class="appearance-none bg-[#580000] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-red-900 transition shadow-sm w-full md:w-auto min-w-[180px]">
                                <option value="">Semua PIC</option>
                                @foreach($allPics as $p)
                                    <option value="{{ $p->id }}" {{ request('pic') == $p->id ? 'selected' : '' }} class="bg-white text-gray-800">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            {!! $chevron !!}
                        </div>

                        <!-- Unit Kerja Filter -->
                        <div class="relative group">
                            <select name="unit_kerja" onchange="this.form.submit()" class="appearance-none bg-[#580000] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-red-900 transition shadow-sm w-full md:w-auto min-w-[200px]">
                                <option value="">Semua Unit Kerja</option>
                                @foreach($allUnits as $unit)
                                    <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }} class="bg-white text-gray-800">{{ $unit }}</option>
                                @endforeach
                            </select>
                             {!! $chevron !!}
                        </div>

                        <!-- Bulan Filter -->
                        <div class="relative group">
                            <select name="bulan" onchange="this.form.submit()" class="appearance-none bg-[#580000] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-red-900 transition shadow-sm w-full md:w-auto min-w-[150px]">
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
                            <select name="minggu" onchange="this.form.submit()" class="appearance-none bg-[#580000] text-white pl-6 pr-12 py-3 rounded-xl font-bold border-none focus:ring-0 cursor-pointer hover:bg-red-900 transition shadow-sm w-full md:w-auto min-w-[150px]">
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
                        <a href="{{ route('dashboard') }}?active_tab=karyawan" class="flex items-center justify-center px-4 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition shadow-sm h-full" title="Reset Filter">
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
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-red-900 pl-3">Tahapan Pengarsipan</h3>
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
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-red-900 pl-3">Tren Arsip Masuk (Tahun {{ date('Y') }})</h3>
                        <div class="relative h-72 w-full">
                            <canvas id="arsipBulananChart"></canvas>
                        </div>
                    </div>

                    <!-- Right: Arsip per Unit (Donut) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-red-900 pl-3">Arsip per Unit Kerja (Top 10)</h3>
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
                            <thead class="bg-[#580000] text-white text-xs uppercase">
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
                                                <div class="h-full bg-red-600" style="width: {{ $stat->persentase }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold">{{ $stat->persentase }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- Total Row -->
                                <tr class="bg-[#580000] text-white font-bold">
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
                                <tr class="bg-[#580000] text-white text-xs uppercase">
                                    <th class="px-4 py-3 border-r border-red-800 w-48">Key Activity</th>
                                    <th class="px-4 py-3 border-r border-red-800 w-48"></th>
                                    @foreach($stages as $stage)
                                        <th colspan="3" class="px-4 py-3 text-center border-r border-red-800">{{ $stage }}</th>
                                    @endforeach
                                    <th class="px-4 py-3 text-center border-r border-red-800 bg-emerald-900">Done</th>
                                </tr>
                                <!-- Sub Header: Metrics -->
                                <tr class="bg-red-950 text-white text-[10px] uppercase tracking-wider">
                                    <th class="px-4 py-2 border-r border-red-900">PIC</th>
                                    <th class="px-4 py-2 border-r border-red-900">Unit Kerja</th>
                                    @foreach($stages as $stage)
                                        <th class="px-2 py-2 text-center w-16 bg-red-900 border-r border-red-800 text-red-200"># Krj</th>
                                        <th class="px-2 py-2 text-center w-16 bg-red-900 border-r border-red-800 text-yellow-200"># Tgt</th>
                                        <th class="px-2 py-2 text-center w-16 bg-red-900 border-r border-red-800 text-green-200">%</th>
                                    @endforeach
                                    <th class="px-2 py-2 text-center w-16 bg-red-900 border-r border-red-800 text-white">✓</th>
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
                                        <td class="px-2 py-3 text-center border-r border-gray-50 {{ $data['selesai'] > 0 ? 'text-red-700 font-bold bg-red-50/50' : 'text-gray-300' }}">
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
                                colors: ['#450a0a', '#7f1d1d', '#991b1b', '#b91c1c', '#dc2626'] // Red shades matching Semen Padang
                            };

                            var chart = new ApexCharts(document.querySelector("#activityChart"), options);
                            chart.render();
                        } else {
                            document.querySelector("#activityChart").innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Belum ada data visualisasi</div>';
                        }
                    });
                </script>
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
                                '#580000', // Darkest Red
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
                    }
                });
            }

            // --- 4. CHART ARSIP MASUK PER BULAN (Line Chart) ---
            const ctxBulanan = document.getElementById('arsipBulananChart').getContext('2d');
            if (ctxBulanan) {
                new Chart(ctxBulanan, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Arsip Masuk',
                            data: @json($arsipBulananData),
                            borderColor: '#dc2626', // red-600
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4, // Smooth curve
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#dc2626',
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
                                '#450a0a', '#7f1d1d', '#991b1b', '#b91c1c', '#dc2626', 
                                '#ef4444', '#f87171', '#fca5a5', '#fecaca', '#fee2e2'
                            ], // Red shades
                            borderWidth: 1,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: { 
                                position: 'right',
                                labels: { boxWidth: 12, usePointStyle: true, font: { size: 11 } }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layout>