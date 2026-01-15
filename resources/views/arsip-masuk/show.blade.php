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

        <!-- Info Grid -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-red-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-4 bg-red-50 rounded-xl">
                    <span class="text-xs font-bold text-red-800 uppercase tracking-wide block mb-1">Tanggal Terima</span>
                    <span class="text-lg text-gray-800 font-medium">{{ \Carbon\Carbon::parse($arsipMasuk->tanggal_terima)->format('d F Y') }}</span>
                </div>
                <div class="p-4 bg-red-50 rounded-xl">
                    <span class="text-xs font-bold text-red-800 uppercase tracking-wide block mb-1">Jumlah Box Masuk</span>
                    <span class="text-lg text-gray-800 font-medium">{{ $arsipMasuk->jumlah_box_masuk }} Box</span>
                </div>
                <div class="p-4 bg-red-50 rounded-xl">
                    <span class="text-xs font-bold text-red-800 uppercase tracking-wide block mb-1">Total Berkas Terdata</span>
                    <span class="text-lg text-gray-800 font-medium">{{ $arsipMasuk->berkas->count() }} Berkas</span>
                </div>
                <div class="p-4 bg-red-50 rounded-xl">
                    <span class="text-xs font-bold text-red-800 uppercase tracking-wide block mb-1">Penerima</span>
                    <span class="text-lg text-gray-800 font-medium">{{ $arsipMasuk->penerima->nama ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Daftar Berkas Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-red-100">
            <div class="p-6 bg-white border-b border-red-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Daftar Berkas</h3>
                <a href="{{ route('arsip-masuk.berkas.create', $arsipMasuk->id) }}" class="text-sm text-red-600 hover:text-red-800 font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Kelola Berkas
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-red-50 text-red-900 border-b border-red-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">No</th>
                            <th class="py-4 px-6 font-semibold">No Box</th>
                            <th class="py-4 px-6 font-semibold">Kode Klasifikasi</th>
                            <th class="py-4 px-6 font-semibold">Uraian / Nama Berkas</th>
                            <th class="py-4 px-6 font-semibold">Tahun</th>
                            <th class="py-4 px-6 font-semibold text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-50">
                        @forelse($arsipMasuk->berkas as $index => $berkas)
                        <tr class="hover:bg-red-50 transition">
                            <td class="py-4 px-6 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 text-gray-700 font-medium">Box {{ $berkas->no_box }}</td>
                            <td class="py-4 px-6 text-gray-700">
                                <span class="bg-white border border-red-200 px-2 py-1 rounded text-xs font-mono text-red-700">
                                    {{ $berkas->klasifikasi->kode_klasifikasi ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-700">{{ $berkas->nama_berkas }}</td>
                            <td class="py-4 px-6 text-gray-700">
                                {{ $berkas->tanggal_berkas ? \Carbon\Carbon::parse($berkas->tanggal_berkas)->format('Y') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-gray-700 text-center">{{ $berkas->jumlah }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500 italic">Belum ada berkas yang diinput untuk arsip ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
