<x-layout>
    <div class="bg-gradient-to-r from-red-900 to-red-700 px-8 py-4 shadow-md rounded-t-lg -mx-4 -mt-4 md:-mx-6 md:-mt-6 mb-6">
        <h1 class="text-xl font-bold text-white">Form Tambahkan Peminjam</h1>
    </div>

    <div class="flex justify-center items-start min-h-[80vh]">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-4xl border border-gray-100 relative">
            
            <form action="/peminjaman" method="POST">
                @csrf
                <div class="space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Tanggal Peminjaman :</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Nama Peminjam :</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama_peminjam" placeholder="Masukkan nama lengkap..." required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Unit Peminjam :</label>
                        <div class="md:col-span-2">
                            <select name="unit" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-bold text-gray-700 bg-white">
                                <option value="" disabled selected>-- Pilih Unit --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}">{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div x-data="{ inputs: [1] }" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <div class="flex justify-between items-center md:block">
                            <label class="font-medium text-gray-700 text-lg">Nama Arsip :</label>
                        </div>
                        
                        <div class="md:col-span-2 space-y-3">
                            <div class="flex justify-end mb-2">
                                <button type="button" @click="inputs.push(inputs.length + 1)" class="bg-red-800 text-white text-xs px-3 py-1.5 rounded-md hover:bg-red-900 flex items-center gap-1 shadow-sm transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Arsip
                                </button>
                            </div>

                            <template x-for="(input, index) in inputs" :key="index">
                                <div class="flex gap-2">
                                    <select name="arsip[]" required class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-bold text-gray-700 bg-white shadow-sm">
                                        <option value="" disabled selected>-- Pilih Arsip --</option>
                                        @foreach($daftarArsip as $arsip)
                                            <option value="{{ $arsip }}">{{ $arsip }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <button type="button" x-show="inputs.length > 1" @click="inputs.splice(index, 1)" class="text-red-500 hover:text-red-700 p-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-red-900 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-red-800 transition transform hover:scale-105">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layout>