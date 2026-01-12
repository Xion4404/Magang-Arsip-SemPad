<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semen Padang Arsip</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans">

    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">

        <x-sidebar />

        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
            
            <header class="bg-gradient-to-r from-red-800 to-red-600 px-6 py-4 flex justify-between items-center shadow-md z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-red-900 p-2 rounded-lg focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-xl font-bold text-white hidden md:block">Sistem Manajemen dan Monitoring Kearsipan PT Semen Padang</h1>
                </div>

                </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>