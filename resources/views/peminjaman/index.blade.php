<x-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Peminjaman Arsip</h2>
        <p class="text-gray-500 text-sm">Kelola data peminjaman arsip perusahaan di sini.</p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex gap-2 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:outline-none text-sm">
            </div>
            <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-1 shadow-sm">
                Sort
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </div>

        <button class="bg-red-900 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-red-800 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Peminjaman
        </button>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-bold">Tanggal</th>
                    <th class="px-6 py-4 font-bold">Nama Peminjam</th>
                    <th class="px-6 py-4 font-bold">Unit Peminjam</th>
                    <th class="px-6 py-4 font-bold">Nama Arsip</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($peminjaman as $item)
                <tr class="hover:bg-red-50/30 transition duration-150">
                    <td class="px-6 py-4 text-red-600 font-medium whitespace-nowrap">{{ $item['tanggal'] }}</td>
                    <td class="px-6 py-4 text-gray-900 font-semibold">{{ $item['nama_peminjam'] }}</td>
                    <td class="px-6 py-4">{{ $item['unit'] }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $item['arsip'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($item['status'] == 'Sedang Dipinjam')
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                Sedang Dipinjam
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Sudah Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-3">
                            <button class="text-gray-400 hover:text-green-600 transition tooltip" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button class="text-gray-400 hover:text-blue-600 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="text-gray-400 hover:text-red-600 transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 text-center text-xs text-gray-400">
        &copy; 2026 PT Semen Padang. All rights reserved.
    </div>
</x-layout>