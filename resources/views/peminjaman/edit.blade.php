<x-layout>
    <div class="bg-gradient-to-r from-red-900 to-red-700 px-8 py-4 shadow-md rounded-t-lg -mx-4 -mt-4 md:-mx-6 md:-mt-6 mb-6">
        <h1 class="text-xl font-bold text-white">Form Edit Peminjaman</h1>
    </div>

    <div class="flex justify-center items-start min-h-[80vh]">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-4xl border border-gray-100 relative">
            
            <form action="/peminjaman/{{ $id }}" method="POST">
                @csrf
                @method('PUT') <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Tanggal Peminjaman :</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal" value="{{ $editData['tanggal'] }}" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Nama Peminjam :</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama_peminjam" value="{{ $editData['nama_peminjam'] }}" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Unit Peminjam :</label>
                        <div class="md:col-span-2">
                            <select name="unit" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-bold text-gray-700 bg-white">
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ $unit == $editData['unit'] ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="font-medium text-gray-700 text-lg">Arsip Saat Ini :</label>
                        <div class="md:col-span-2">
                             <div class="bg-gray-100 p-3 rounded mb-2 text-gray-600 font-mono text-sm">
                                {{ $editData['arsip'] }}
                            </div>
                            <p class="text-xs text-red-500 mb-2">*Pilih arsip di bawah jika ingin mengubah data arsip.</p>

                            <select name="arsip[]" class="w-full border-2 border-gray-300 rounded-lg p-3 outline-none font-bold text-gray-700 bg-white shadow-sm">
                                <option value="" selected>-- Tidak Mengubah Arsip --</option>
                                @foreach($daftarArsip as $arsip)
                                    <option value="{{ $arsip }}">{{ $arsip }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-red-900 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-red-800 transition transform hover:scale-105">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>