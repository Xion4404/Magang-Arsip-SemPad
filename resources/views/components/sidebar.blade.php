<aside 
    class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out"
    :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-0 -translate-x-full opacity-0 overflow-hidden'"
>
    <div class="p-6 flex items-center justify-center gap-2 border-b border-gray-100 min-w-[16rem]">
        <img src="{{ asset('images/logo-semen-padang.png') }}" alt="Logo PT Semen Padang" class="h-12 w-auto">
        <span class="font-bold text-gray-800 text-sm">PT SEMEN PADANG</span>
    </div>

    <div class="px-6 py-6 text-center min-w-[16rem]">
        <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center text-red-600 mb-3 border-2 border-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <h3 class="font-bold text-red-700 text-sm">Annisa Revalina H.</h3>
        <p class="text-xs text-gray-500">annisa1234@gmail.com</p>
    </div>

    <nav class="flex-1 px-4 space-y-1 overflow-y-auto min-w-[16rem]">
        
        <a href="/beranda" 
           class="flex items-center gap-3 px-4 py-3 {{ Request::is('beranda') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="whitespace-nowrap">Dashboard</span>
        </a>

        <a href="{{ route('arsip-masuk.index') }}" class="flex items-center gap-3 px-4 py-3 {{ Request::is('arsip-masuk*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
            <span class="whitespace-nowrap">Arsip Masuk</span>
        </a>

        <a href="/arsip" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span class="whitespace-nowrap">Arsip</span>
        </a>
        
        <a href="/peminjaman" 
           class="flex items-center gap-3 px-4 py-3 {{ Request::is('peminjaman*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span class="whitespace-nowrap">Peminjaman</span>
        </a>

        <a href="/pengunjung" 
           class="flex items-center gap-3 px-4 py-3 {{ Request::is('pengunjung*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            <span class="whitespace-nowrap">Buku Tamu</span>
        </a>

        <a href="{{ route('monitoring.index') }}" class="flex items-center gap-3 px-4 py-3 {{ Request::is('monitoring*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span class="whitespace-nowrap">Monitor Karyawan</span>
        </a>

    </nav>
</aside>