<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Media</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola konten media dan informasi yang tampil di landing page.
                    </p>
                </div>
                <a href="{{ route('manajemen-media.create') }}"
                    class="bg-red-700 hover:bg-red-800 text-white px-6 py-2.5 rounded-full font-bold shadow-md transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Berita
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm"
                    role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-red-50 text-red-800">
                            <th
                                class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100 w-24">
                                Gambar</th>
                            <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">
                                Judul
                            </th>
                            <th
                                class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100 w-32">
                                Tanggal</th>
                            <th class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100">
                                Deskripsi</th>
                            <th
                                class="py-4 px-6 font-bold uppercase tracking-wider text-xs border-b border-red-100 text-center w-32">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($media as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6">
                                    <div class="h-16 w-24 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}"
                                            class="h-full w-full object-cover">
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-semibold text-gray-800">
                                    {{ $item->judul }}
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 max-w-xs truncate">
                                    {{ Str::limit($item->deskripsi, 50) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('manajemen-media.edit', $item->id) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('manajemen-media.destroy', $item->id) }}'"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <p class="text-lg font-medium">Belum ada data media.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $media->links() }}
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div @click.away="showDeleteModal = false"
                class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                <div
                    class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500 shadow-sm animate-bounce">
                    <i class="fas fa-trash-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Berita?</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">Data berita yang dihapus tidak dapat dikembalikan lagi.
                </p>
                <div class="flex flex-col gap-3">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full py-3.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 shadow-lg transform hover:scale-[1.02] transition">Ya,
                            Hapus Sekarang</button>
                    </form>
                    <button @click="showDeleteModal = false"
                        class="w-full py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 transition">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
</x-layout>