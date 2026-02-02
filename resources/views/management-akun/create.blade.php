<x-layout>
    {{-- Header Page --}}
    <div
<<<<<<< HEAD
        class="bg-[#9d1b1b] px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl mb-8 flex items-center justify-between relative overflow-hidden">
=======
        class="bg-[#e92027] px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl mb-8 flex items-center justify-between relative overflow-hidden">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white tracking-wide">Tambah Pengguna Baru</h1>
            <p class="text-red-100 text-sm mt-2 opacity-90 font-light">Isi formulir untuk mendaftarkan akun pengguna
                baru.</p>
        </div>
        <div
            class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
        </div>
    </div>

    {{-- Main Form Container --}}
    <div class="max-w-4xl mx-auto px-6 -mt-20 relative z-20 mb-10">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-700 p-4 rounded-r shadow-sm animate-fade-in-down">
                <div class="flex items-start">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg></div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Gagal Menyimpan Data!</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700">@foreach ($errors->all() as $error)<li>
                        {{ $error }}</li>@endforeach</ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('management-akun.store') }}" method="POST"
            class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf
            <div class="p-8 space-y-8">
                <div>
                    <h2
<<<<<<< HEAD
                        class="text-lg font-bold text-[#9d1b1b] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3">
                        <i class="fas fa-user-plus text-[#9d1b1b]"></i> Data Akun
=======
                        class="text-lg font-bold text-[#e92027] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3">
                        <i class="fas fa-user-plus text-[#e92027]"></i> Data Akun
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    </h2>
                    <div class="space-y-5">
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Nama Lengkap <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
<<<<<<< HEAD
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200 placeholder-gray-400"
=======
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200 placeholder-gray-400"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                placeholder="Masukkan nama lengkap">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Email Perusahaan <span
                                    class="text-red-600">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
<<<<<<< HEAD
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200 placeholder-gray-400"
=======
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200 placeholder-gray-400"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                placeholder="nama@semenpadang.co.id">
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Role Pengguna <span
                                    class="text-red-600">*</span></label>
                            <div class="relative">
                                <select name="role" required
<<<<<<< HEAD
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 outline-none appearance-none cursor-pointer focus:bg-white focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
=======
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 outline-none appearance-none cursor-pointer focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-sm"></i></div>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Password <span
                                    class="text-red-600">*</span></label>
                            <input type="password" name="password" required
<<<<<<< HEAD
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200"
=======
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('management-akun.index') }}"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">Batal</a>
                <button type="submit"
<<<<<<< HEAD
                    class="px-8 py-3 bg-[#9d1b1b] text-white rounded-xl font-bold shadow-lg hover:bg-[#7a1515] hover:shadow-xl transition transform hover:-translate-y-0.5">Simpan
=======
                    class="px-8 py-3 bg-[#e92027] text-white rounded-xl font-bold shadow-lg hover:bg-[#7a1515] hover:shadow-xl transition transform hover:-translate-y-0.5">Simpan
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    Pengguna</button>
            </div>
        </form>
    </div>
<<<<<<< HEAD
</x-layout>
=======
</x-layout>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
