<x-layout>
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-[#8B1A1A] rounded-t-2xl shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-[#8B1A1A]"></div>
            <div class="absolute top-0 right-0 p-4 opacity-10">
                 <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="p-8 relative z-10">
                <h2 class="text-3xl font-bold text-white">Formulir Monitoring Kerja Karyawan</h2>
                <p class="text-red-100 mt-2">Silakan lengkapi data monitoring di bawah ini</p>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-b-2xl shadow-xl border border-red-50">
            <form action="{{ route('monitoring.store') }}" method="POST">
                 @csrf
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                     <!-- PIC -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">PIC</label>
                         <select name="user_id" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                             @foreach($users as $user)
                                 <option value="{{ $user->id }}">{{ $user->name }}</option>
                             @endforeach
                         </select>
                     </div>
                     
                     <!-- Nomor Berita Acara -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Nomor Berita Acara</label>
                         <input type="text" name="nba" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="Contoh: PB-001">
                     </div>
                     
                     <!-- Tahapan Pengarsipan -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tahapan Pengarsipan</label>
                         <select name="tahapan" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                            <option value="" disabled selected>Pilih Tahapan</option>
                            <option value="Waiting List Pengarsipan">Waiting List Pengarsipan</option>
                            <option value="Pemilahan Arsip">Pemilahan Arsip</option>
                            <option value="Alih Media">Alih Media</option>
                            <option value="Input E-Arsip">Input E-Arsip</option>
                            <option value="Pemusnahan Arsip">Pemusnahan Arsip</option>
                         </select>
                     </div>
    
                     <!-- Jumlah Box -->
                      <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Jumlah Box</label>
                         <input type="number" name="jumlah_box" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="1">
                     </div>
    
                     <!-- Tanggal Berkas Masuk -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tanggal Berkas Masuk</label>
                         <input type="date" name="tanggal_berkas_masuk" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                     </div>
    
                     <!-- Keterangan -->
                     <div class="md:row-span-2">
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Keterangan</label>
                         <textarea name="keterangan" rows="5" class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="Opsional"></textarea>
                     </div>
    
                      <!-- Unit Kerja -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Unit Kerja</label>
                         <select name="unit_kerja" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                            <option value="" disabled selected>Pilih Unit Kerja</option>
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
    
                 </div>
    
                 <div class="flex justify-end mt-10 gap-4">
                     <a href="{{ route('monitoring.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105 flex items-center justify-center">
                         Kembali
                     </a>
                     <button type="submit" class="bg-[#8B1A1A] hover:bg-[#6e1515] text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105">
                         Submit
                     </button>
                 </div>
            </form>
        </div>
    </div>
</x-layout>
