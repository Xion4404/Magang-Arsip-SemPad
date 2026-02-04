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

    <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden relative">

        <x-sidebar />



        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 relative">
            
            <!-- Open Sidebar Button (Visible only when sidebar is closed) -->
            <button x-show="!sidebarOpen" 
                    @click="sidebarOpen = true" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="absolute top-7 left-8 z-20 p-2 text-white hover:text-gray-200 transition focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </button>
            


            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>