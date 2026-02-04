<x-layout>
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-[#e92027] rounded-t-2xl shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-[#e92027]"></div>
            <div class="p-8 relative z-10">
                <h2 class="text-3xl font-bold text-white">Input Arsip Masuk</h2>
                <p class="text-[#e92027] mt-2">Data awal arsip masuk</p>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-b-2xl shadow-xl border border-red-100">
            <form action="{{ route('arsip-masuk.store') }}" method="POST">
                 @csrf
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                     <!-- Unit Asal -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Unit Asal</label>
                         <select name="unit_asal" required class="w-full bg-[#fff1f2] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e92027]">
                            <option value="" disabled selected>Pilih Unit Asal</option>
                            <option value="Sistem Manajemen">Sistem Manajemen</option>
                            <option value="Internal Audit">Internal Audit</option>
                            <option value="Komunikasi & Kesekretariatan">Komunikasi & Kesekretariatan</option>
                            <option value="CSR">CSR</option>
                            <option value="Hukum">Hukum</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Staf Dept. Komunikasi & Hukum Perusahaan">Staf Dept. Komunikasi & Hukum Perusahaan</option>
                            <option value="Bisnis Inkubasi Non Semen">Bisnis Inkubasi Non Semen</option>
                            <option value="Quality Assurance">Quality Assurance</option>
                            <option value="SHE">SHE</option>
                            <option value="Perencanaan & Evaluasi Produksi">Perencanaan & Evaluasi Produksi</option>
                            <option value="Penunjang Produksi">Penunjang Produksi</option>
                            <option value="Quality Control">Quality Control</option>
                            <option value="Staf AFR">Staf AFR</option>
                            <option value="Operasi Tambang">Operasi Tambang</option>
                            <option value="Produksi Bahan Baku">Produksi Bahan Baku</option>
                            <option value="Perencanaan & Pengawasan Tambang">Perencanaan & Pengawasan Tambang</option>
                            <option value="WHRPG & Utilitas">WHRPG & Utilitas</option>
                            <option value="Produksi Terak">Produksi Terak</option>
                            <option value="Produksi Semen">Produksi Semen</option>
                            <option value="Pabrik Kantong">Pabrik Kantong</option>
                            <option value="Pabrik Dumai">Pabrik Dumai</option>
                            <option value="Pemeliharaan Mesin">Pemeliharaan Mesin</option>
                            <option value="Pemeliharaan Listrik & Instrumen">Pemeliharaan Listrik & Instrumen</option>
                            <option value="Maintenance Reliability">Maintenance Reliability</option>
                            <option value="Capex">Capex</option>
                            <option value="Site Engineering">Site Engineering</option>
                            <option value="Project Management">Project Management</option>
                            <option value="Perencanaan Suku Cadang">Perencanaan Suku Cadang</option>
                            <option value="TPM Officer">TPM Officer</option>
                            <option value="Produksi Mesin & Teknikal Support">Produksi Mesin & Teknikal Support</option>
                            <option value="Produksi BIP & Aplikasi">Produksi BIP & Aplikasi</option>
                            <option value="Operasional SDM">Operasional SDM</option>
                            <option value="Sarana Umum">Sarana Umum</option>
                            <option value="GRC & Internal Control">GRC & Internal Control</option>
                            <option value="Kinerja & Anggaran">Kinerja & Anggaran</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Akuntansi">Akuntansi</option>
                            <option value="Lainnya">Lainnya</option>
                         </select>
                     </div>

                     <!-- Nomor Berita Acara -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Nomor Berita Acara</label>
                         <input type="text" name="nomor_berita_acara" required class="w-full bg-[#fff1f2] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e92027]" placeholder="Masukkan Nomor Berita Acara">
                     </div>

                     <!-- User Penerima -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Penerima</label>
                         <select name="user_penerima" required class="w-full bg-[#fff1f2] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e92027]">
                             @foreach($users as $user)
                                 <option value="{{ $user->id }}">{{ $user->nama }}</option>
                             @endforeach
                         </select>
                     </div>

                     <!-- Tanggal Terima -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tanggal Terima</label>
                         <input type="date" name="tanggal_terima" required class="w-full bg-[#fff1f2] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e92027]">
                     </div>

                     <!-- Jumlah Box Masuk -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Jumlah Box Masuk</label>
                         <input type="number" name="jumlah_box_masuk" required class="w-full bg-[#fff1f2] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e92027]" placeholder="Contoh: 5">
                     </div>
                 </div>
    
                 <div class="flex justify-end mt-10 gap-4">
                     <a href="{{ route('arsip-masuk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105 flex items-center justify-center">
                         Batal
                     </a>
                     <button type="submit" class="bg-[#e92027] hover:bg-[#6e1515] text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105">
                         Simpan
                     </button>
                 </div>
            </form>
        </div>
    </div>
</x-layout>