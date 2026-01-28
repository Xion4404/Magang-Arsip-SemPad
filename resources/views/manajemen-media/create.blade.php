<x-layout>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b border-gray-100 pb-4">Tambah Berita / Media</h2>

        <form action="{{ route('manajemen-media.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Judul -->
                <div>
                    <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Berita</label>
                    <input type="text" name="judul" id="judul" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                        placeholder="Masukkan judul berita...">
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                </div>

                <!-- Gambar -->
                <div>
                    <label for="gambar" class="block text-sm font-bold text-gray-700 mb-2">Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 2MB)</p>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Lengkap</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    placeholder="Tulis deskripsi berita di sini..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-full font-bold shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Simpan Berita
                </button>
                <a href="{{ route('manajemen-media.index') }}"
                    class="text-gray-600 font-semibold hover:text-gray-800 px-4 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layout>