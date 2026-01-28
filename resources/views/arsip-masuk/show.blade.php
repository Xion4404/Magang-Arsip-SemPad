<x-layout>
    <div class="max-w-7xl mx-auto my-10">
        <!-- Header Card -->
        <div class="bg-[#8B1A1A] rounded-t-2xl shadow-lg relative overflow-hidden mb-6">
            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-[#8B1A1A]"></div>
            <div class="absolute top-0 right-0 p-4 opacity-10">
                 <svg class="w-32 h-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="p-8 relative z-10 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold">Detail Arsip Masuk</h2>
                        <p class="text-red-100 mt-2 text-lg">{{ $arsipMasuk->unit_asal }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-red-700 bg-opacity-50 border border-red-500 rounded-lg px-4 py-2 backdrop-blur-sm">
                            <span class="text-xs text-red-200 block uppercase tracking-wider">Nomor Berita Acara</span>
                            <span class="font-mono text-xl font-bold">{{ $arsipMasuk->nomor_berita_acara }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Tanggal Terima -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-red-50 hover:shadow-lg transition duration-300 flex items-center gap-5 group">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Tanggal Terima</span>
                    <span class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($arsipMasuk->tanggal_terima)->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Jumlah Box -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-red-50 hover:shadow-lg transition duration-300 flex items-center gap-5 group">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Jumlah Box Masuk</span>
                    <span class="text-xl font-bold text-gray-900">{{ $arsipMasuk->jumlah_box_masuk }} Box</span>
                </div>
            </div>

            <!-- Penerima -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-red-50 hover:shadow-lg transition duration-300 flex items-center gap-5 group">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Penerima</span>
                    <span class="text-xl font-bold text-gray-900">{{ $arsipMasuk->penerima->nama ?? '-' }}</span>
                </div>
            </div>
        </div>



        <div class="mt-8">
            <a href="{{ route('arsip-masuk.index') }}" class="inline-flex items-center text-gray-600 hover:text-red-800 font-medium transition">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-layout>