<x-layout>
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-[#8B1A1A] rounded-t-2xl shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-[#8B1A1A]"></div>
            <div class="p-8 relative z-10">
                <h2 class="text-3xl font-bold text-white">Edit Arsip Masuk</h2>
                <p class="text-red-100 mt-2">Perbarui data arsip masuk</p>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-b-2xl shadow-xl border border-red-50">
            <form action="{{ route('arsip-masuk.update', $arsipMasuk->id) }}" method="POST">
                 @csrf
                 @method('PUT')
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                     <!-- Unit Asal -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Unit Asal</label>
                         <select name="unit_asal" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                            <option value="" disabled>Pilih Unit Asal</option>
                            @php
                                $units = [
                                    "Sistem Manajemen", "Internal Audit", "Komunikasi & Kesekretariatan", "CSR", "Hukum", "Keamanan", 
                                    "Staf Dept. Komunikasi & Hukum Perusahaan", "Bisnis Inkubasi Non Semen", "Quality Assurance", 
                                    "SHE", "Perencanaan & Evaluasi Produksi", "Penunjang Produksi", "Quality Control", 
                                    "Staf AFR", "Operasi Tambang", "Produksi Bahan Baku", "Perencanaan & Pengawasan Tambang", 
                                    "WHRPG & Utilitas", "Produksi Terak", "Produksi Semen", "Pabrik Kantong", "Pabrik Dumai", 
                                    "Pemeliharaan Mesin", "Pemeliharaan Listrik & Instrumen", "Maintenance Reliability", 
                                    "Capex", "Site Engineering", "Project Management", "Perencanaan Suku Cadang", 
                                    "TPM Officer", "Produksi Mesin & Teknikal Support", "Produksi BIP & Aplikasi", 
                                    "Operasional SDM", "Sarana Umum", "GRC & Internal Control", "Kinerja & Anggaran", 
                                    "Keuangan", "Akuntansi", "Lainnya"
                                ];
                            @endphp
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ $arsipMasuk->unit_asal == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                         </select>
                     </div>

                     <!-- Nomor Berita Acara -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Nomor Berita Acara</label>
                         <input type="text" name="nomor_berita_acara" value="{{ old('nomor_berita_acara', $arsipMasuk->nomor_berita_acara) }}" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="Masukkan Nomor Berita Acara">
                     </div>

                     <!-- User Penerima -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Penerima</label>
                         <select name="user_penerima" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                             @foreach($users as $user)
                                 <option value="{{ $user->id }}" {{ $arsipMasuk->user_penerima == $user->id ? 'selected' : '' }}>{{ $user->nama }}</option>
                             @endforeach
                         </select>
                     </div>

                     <!-- Tanggal Terima -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tanggal Terima</label>
                         <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima', $arsipMasuk->tanggal_terima) }}" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                     </div>

                     <!-- Jumlah Box Masuk -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Jumlah Box Masuk</label>
                         <input type="number" name="jumlah_box_masuk" value="{{ old('jumlah_box_masuk', $arsipMasuk->jumlah_box_masuk) }}" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="Contoh: 5">
                     </div>
                 </div>
    
                 <div class="flex justify-end mt-10 gap-4">
                     <a href="{{ route('arsip-masuk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105 flex items-center justify-center">
                         Batal
                     </a>
                     <button type="submit" class="bg-[#8B1A1A] hover:bg-[#6e1515] text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105">
                         Perbarui
                     </button>
                 </div>
            </form>
        </div>
    </div>
</x-layout>=