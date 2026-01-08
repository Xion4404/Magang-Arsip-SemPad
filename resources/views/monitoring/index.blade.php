<x-layout>
    <div class="bg-[#8B1A1A] text-white p-6 rounded-xl shadow-lg mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
             <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
        </div>
        <h2 class="text-2xl font-bold relative z-10">Monitoring Kerja Karyawan</h2>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-40">
            <h3 class="text-[#8B1A1A] font-bold text-xl mb-2">Total</h3>
            <p class="text-5xl font-extrabold text-gray-800">{{ $total }}</p>
        </div>
        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-40">
            <h3 class="text-[#8B1A1A] font-bold text-xl mb-2">Bulan ini</h3>
            <p class="text-5xl font-extrabold text-gray-800">{{ $bulanIni }}</p>
        </div>
        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-40">
            <h3 class="text-[#8B1A1A] font-bold text-xl mb-2">Selesai</h3>
            <p class="text-5xl font-extrabold text-gray-800">{{ $selesai }}</p>
        </div>
        <!-- Card 4 (Large) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-40">
             <h3 class="text-[#8B1A1A] font-bold text-xl">Ringkasan Monitoring</h3>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex items-center gap-3 w-full md:w-auto flex-wrap">
             <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" placeholder="Search..." class="w-full py-2.5 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#8B1A1A] text-sm bg-white">
             </div>
             
             <!-- Dropdowns (mockup) -->
             <button class="bg-[#5c1313] hover:bg-[#4a0f0f] text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 transition">
                 PIC <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
             </button>
             <button class="bg-[#5c1313] hover:bg-[#4a0f0f] text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 transition">
                 Tahapan <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
             </button>
        </div>

        <a href="{{ route('monitoring.create') }}" class="bg-[#8B1A1A] hover:bg-[#7a1616] text-white px-6 py-2.5 rounded-lg font-bold shadow-md flex items-center gap-2 transition transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Isi Formulir
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-red-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">
                <thead class="bg-white border-b border-red-100">
                    <tr>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide">PIC</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Tahapan Pengarsipan</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Tanggal Berkas Masuk</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Unit Kerja</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">NBA</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Jumlah Box</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-50 bg-[#FFF5F5]">
                    @forelse($monitoring as $index => $item)
                    <tr class="hover:bg-red-50 transition duration-150 ease-in-out">
                        <td class="py-4 px-4 text-[#8B1A1A] font-medium">{{ $item->user->name ?? '-' }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->tahapan }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ \Carbon\Carbon::parse($item->tanggal_berkas_masuk)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->unit_kerja }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->nba }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->jumlah_box }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-gray-500 italic">Belum ada data monitoring.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center items-center gap-2">
        <span class="text-xs text-gray-400 font-medium">Previous</span>
        <button class="w-8 h-8 flex items-center justify-center bg-[#8B1A1A] text-white rounded shadow text-xs font-bold">1</button>
        <button class="w-8 h-8 flex items-center justify-center bg-red-100 text-[#8B1A1A] rounded shadow text-xs font-bold hover:bg-red-200">2</button>
        <button class="w-8 h-8 flex items-center justify-center bg-red-100 text-[#8B1A1A] rounded shadow text-xs font-bold hover:bg-red-200">3</button>
        <span class="text-xs text-gray-400 font-medium">Next</span>
    </div>
</x-layout>
