<x-layout>
    {{-- Print Header (Visible only in Print) --}}
    <div id="print-header" class="hidden mb-8 border-b-2 border-[#e92027] pb-4">
        <div class="flex items-center justify-between px-8">
            <img src="{{ asset('images/logo-sp.png') }}" alt="Logo" class="h-20 w-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-[#c41820] uppercase">PT Semen Padang</h1>
                <h2 class="text-xl font-bold text-gray-800">Data Arsip Musnah</h2>
                <p class="text-sm text-gray-600">Indarung, Padang 25237, Sumatera Barat</p>
            </div>
            <div class="w-20"></div> {{-- Spacer --}}
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900 text-white pb-32 pt-16 px-8 -mt-6 -mx-6 mb-8 rounded-b-[3rem] shadow-2xl relative overflow-hidden print:hidden">
         <!-- Polygon Pattern Overlay -->
         <div class="absolute inset-0 z-0 opacity-40">
              <svg class="absolute w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                 <defs>
                     <linearGradient id="polyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                         <stop offset="0%" style="stop-color:#000000;stop-opacity:0.3" />
                         <stop offset="100%" style="stop-color:#555555;stop-opacity:0.4" />
                     </linearGradient>
                 </defs>
                 <path fill="url(#polyGrad)" d="M0 0 L1000 0 L1000 500 L0 300 Z" />
                 <path fill="#000000" opacity="0.1" d="M-100 0 L500 0 L200 600 L-100 400 Z" />
                 <path fill="#333333" opacity="0.2" d="M800 0 L1400 0 L1400 400 L600 600 Z" />
                 <path fill="url(#polyGrad)" opacity="0.3" d="M500 600 L1200 600 L800 200 Z" />
             </svg>
         </div>

         <!-- Ornamental Icon -->
         <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4 z-0 pointer-events-none mix-blend-overlay">
             <svg width="400" height="400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" /></svg>
         </div>
            
         <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
            <div class="text-center md:text-left">
                 <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Data Arsip Musnah</h2>
                 <p class="text-gray-300 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Daftar arsip yang telah dimusnahkan dan dihapus dari daftar utama.</p>
            </div>
        </div>
    </div>

        {{-- Content Card --}}
        <div class="w-full max-w-[98%] mx-auto -mt-20 px-2 md:px-0 print:mt-0 print:px-0 relative z-20">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-6 md:p-8 print:shadow-none print:border-0 print:p-0">
                
                {{-- Toolbar (Search) --}}
                <div class="flex flex-col xl:flex-row items-center gap-4 mb-6 print:hidden">
                    <form id="filterForm" action="{{ route('arsip.musnah') }}" method="GET" class="contents">
                        {{-- Search Input --}}
                        <div class="relative w-full xl:w-96 group">
                            <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" placeholder="Cari arsip musnah..." value="{{ request('search') }}" 
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-100 rounded-2xl outline-none focus:border-red-500 focus:ring-4 focus:ring-red-100 transition shadow-sm font-medium text-gray-700">
                        </div>
                    </form>
                </div>

                {{-- Table (Embed directly or use partial if robust) --}}
                {{-- Using a simplified table logic here to avoid complicating the main partial with checks --}}
                <div class="overflow-x-auto rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800 text-white uppercase tracking-wider text-xs shadow-md">
                                <th class="py-5 px-4 font-bold rounded-tl-3xl">No</th>
                                <th class="py-5 px-4 font-bold">Kode</th>
                                <th class="py-5 px-4 font-bold">Nama Berkas</th>
                                <th class="py-5 px-4 font-bold">Uraian</th>
                                <th class="py-5 px-4 font-bold text-center">Tahun</th>
                                <th class="py-5 px-4 font-bold text-center">Tgl Masuk</th>
                                <th class="py-5 px-4 font-bold text-center">Jml</th>
                                <th class="py-5 px-4 font-bold text-center">Box</th>
                                <th class="py-5 px-4 font-bold text-center">Ket</th>
                                <th class="py-5 px-4 font-bold text-center rounded-tr-3xl">Dimusnahkan Pada</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-medium">
                            @forelse($arsips as $index => $arsip)
                                <tr class="hover:bg-red-50 transition duration-200 border-b border-gray-100 last:border-none">
                                    <td class="py-4 px-4">{{ $loop->iteration + ($arsips->currentPage() - 1) * $arsips->perPage() }}</td>
                                    <td class="py-4 px-4">
                                        <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-gray-800">{{ $arsip->nama_berkas }}</td>
                                    <td class="py-4 px-4 text-gray-500 max-w-md truncate" title="{{ $arsip->isi }}">
                                        {{ Str::limit($arsip->isi, 50) }}
                                    </td>
                                    <td class="py-4 px-4 text-center">{{ $arsip->tahun }}</td>
                                    <td class="py-4 px-4 text-center text-xs">
                                        {{ $arsip->tanggal_masuk ? \Carbon\Carbon::parse($arsip->tanggal_masuk)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-center">{{ $arsip->jumlah }}</td>
                                    <td class="py-4 px-4 text-center">{{ $arsip->no_box }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $arsip->tindakan_akhir }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-500 text-xs">
                                        {{ \Carbon\Carbon::parse($arsip->deleted_at)->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            <span class="font-medium">Belum ada arsip yang dimusnahkan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $arsips->links() }}
                </div>
            </div>
        </div>
</x-layout>
