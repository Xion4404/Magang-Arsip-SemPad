<aside class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out fixed md:relative z-30"
    :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-64 -ml-64 lg:-ml-64 -translate-x-full md:translate-x-0 md:-ml-64'"
    style="height: 100vh;">

    <div class="p-4 border-b border-gray-100 min-w-[16rem] flex justify-between items-center">
        <a href="{{ route('landing') }}" class="flex items-center gap-3 hover:opacity-80 transition"
            title="Kembali ke Landing Page">
            <img src="{{ asset('images/logo-semen-padang.png') }}" alt="Logo PT Semen Padang" class="h-9 w-auto">
            <span class="font-bold text-gray-800 text-sm">PT SEMEN PADANG</span>
        </a>

        <!-- Close Sidebar Button -->
        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-red-700 transition focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <div class="px-6 py-6 text-center min-w-[16rem]">
        <a href="{{ route('profile.edit') }}" class="block group cursor-pointer">
            <div
                class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center text-[#e92027] mb-3 border-2 border-[#e92027] overflow-hidden group-hover:border-[#e92027] transition">

                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                @endif
            </div>
            <h3 class="font-bold text-[#e92027] text-sm group-hover:text-[#b91c1c] transition">
                {{ Auth::user()->nama ?? 'User' }}
            </h3>
            <p class="text-xs text-gray-500 mb-1">{{ Auth::user()->email ?? 'email@example.com' }}</p>
            <span class="text-[10px] text-[#e92027] font-semibold opacity-0 group-hover:opacity-100 transition">Klik untuk
                Edit Profile</span>
        </a>
    </div>

    <nav class="flex-1 px-4 space-y-1 overflow-y-auto min-w-[16rem]">

        <a href="/beranda"
            class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('beranda') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="whitespace-nowrap">Beranda</span>
        </a>

        <a href="{{ route('arsip-masuk.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('arsip-masuk*') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
            </svg>
            <span class="whitespace-nowrap">Arsip Masuk</span>
        </a>

        <a href="/arsip"
            class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('arsip') && !Request::is('arsip/musnah') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="whitespace-nowrap">Arsip</span>
        </a>



        <a href="/peminjaman"
            class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('peminjaman*') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="whitespace-nowrap">Peminjaman</span>
        </a>

        <a href="/monitoring"
            class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('monitoring*') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="whitespace-nowrap">Monitor Karyawan</span>
        </a>
        @if(Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('management-akun.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('management-akun*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="whitespace-nowrap">Manajemen Akun</span>
            </a>

            <a href="{{ route('manajemen-unit.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('manajemen-unit*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="whitespace-nowrap">Manajemen Unit</span>
            </a>

            <a href="{{ route('manajemen-media.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('manajemen-media*') ? 'bg-red-800 text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-red-700' }} rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                <span class="whitespace-nowrap">Manajemen Media</span>
            </a>

            <a href="{{ route('arsip.musnah') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm {{ Request::is('arsip/musnah') ? 'bg-[#e92027] text-white shadow-md' : 'text-gray-600 hover:bg-red-50 hover:text-[#e92027]' }} rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="whitespace-nowrap">Data Musnah</span>
            </a>
        @endif
    </nav>
    
     {{-- LOGOUT BUTTON DI SIDEBAR --}}
    <div class="px-6 py-4 border-t border-gray-100 min-w-[16rem]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition font-bold shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>
