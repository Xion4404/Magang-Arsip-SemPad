<x-layout>
    <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800">Arsip Masuk</h2>
                <p class="text-gray-500 text-sm mt-1">Daftar arsip yang telah diterima dan dicatat.</p>
            </div>
            <a href="{{ route('arsip-masuk.create') }}"
                class="bg-red-700 hover:bg-red-800 text-white px-6 py-2.5 rounded-full font-bold shadow-md transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Arsip Masuk
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-center border-collapse">
                <thead>
                    <tr class="bg-red-50 text-red-800">
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">No.
                            Berita Acara</th>
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">Tanggal
                            Terima</th>
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">Unit
                            Asal</th>
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">Jml Box
                        </th>
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">
                            Penerima</th>
                        <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($arsipMasuk as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td
                                class="py-4 px-6 font-medium text-gray-900 border-l-4 border-transparent hover:border-red-500 transition-all">
                                {{ $item->nomor_berita_acara }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ $item->unit_asal }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold">
                                    {{ $item->jumlah_box_masuk }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ $item->penerima->nama ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('arsip-masuk.show', $item->id) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    {{-- <a href="{{ route('arsip-masuk.edit', $item->id) }}"
                                        class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a> --}}
                                    {{-- Tambahkan Form Archive/Delete jika perlu --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada data arsip masuk.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $arsipMasuk->links() }}
        </div>
    </div>
</x-layout>