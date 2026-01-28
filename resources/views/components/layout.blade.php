<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semen Padang Arsip</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- [PENTING] FontAwesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts: Montserrat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">

        {{-- Sidebar Component --}}
        <x-sidebar />

        {{-- Main Content Wrapper --}}
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 relative">

            {{-- Header --}}
            <header
                class="bg-gradient-to-r from-red-900 to-red-700 px-6 py-4 flex justify-between items-center shadow-md z-10">
                <div class="flex items-center gap-4">
                    {{-- Toggle Sidebar Button --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-white hover:bg-white/10 p-2 rounded-lg focus:outline-none transition">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    {{-- Title --}}
                    <h1 class="text-lg md:text-xl font-bold text-white hidden md:block tracking-wide">
                        Sistem Manajemen & Monitoring Kearsipan
                    </h1>
                </div>

                {{-- User Profile / Logout --}}
                <div class="flex items-center gap-3">
                    {{-- User Info --}}
                </div>
            </header>

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 scroll-smooth">
                {{ $slot }}
            </main>
        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- INI BARIS PANCINGANNYA (JANGAN DIHAPUS) --}}
    {{-- Fungsinya agar Tailwind memproses class warna Pink --}}
    {{-- ======================================================== --}}
    <div class="hidden bg-pink-700 border-pink-700 text-white ring-pink-200"></div>

</body>

</html>