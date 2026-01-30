<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Arsip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Upload File Excel Arsip</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('arsip.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">Pilih File Excel (.xlsx, .xls)</label>
                            <input type="file" name="file" id="file" accept=".xlsx, .xls, .csv" required
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Pastikan format file sesuai dengan template.</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Import Data
                            </button>
                            <a href="{{ route('arsip.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                                Kembali
                            </a>
                        </div>
                    </form>

                    <div class="mt-8 border-t pt-4">
                        <h4 class="font-medium mb-2">Petunjuk Import:</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                            <li>File Excel harus memiliki header di baris ke-4.</li>
                            <li>Data dimulai dari baris ke-6 (Baris 5 dianggap sub-header/kosong).</li>
                            <li>Kolom Wajib: No Berkas, Kode Klasifikasi, Nama Berkas.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
