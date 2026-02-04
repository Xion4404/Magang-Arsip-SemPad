<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Arsip PT Semen Padang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

<body class="bg-white antialiased">

    <div class="h-screen w-screen flex flex-col md:flex-row relative overflow-hidden">

        <div class="absolute top-6 left-6 flex items-center space-x-3 z-20">
            <img src="{{ asset('images/sp-black.png') }}" alt="Logo" class="h-14 md:h-12 w-auto">
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center px-12 lg:px-28 py-10 bg-white h-full">

            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-black leading-tight mb-5">
                    e-Arsip <br>
                    PT Semen Padang
                </h1>
                <h2 class="text-xl md:text-2xl font-bold text-[#e92027]">Login</h2>
            </div>

            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-5 max-w-md mx-auto w-full">
                @csrf
                @if($errors->any())
                    <div class="bg-red-50 text-red-700 p-2 rounded-lg text-xs mb-3">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-[#e92027] font-bold mb-1 text-sm">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-user text-gray-400 text-sm"></i>
                        </span>
                        <input type="email" name="email" placeholder="Type your username" required
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#e92027] outline-none text-sm shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[#e92027] font-bold mb-1 text-sm">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </span>
                        <input type="password" name="password" placeholder="Enter Current Password" required
                            class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#e92027] outline-none text-sm shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <i class="far fa-eye-slash text-gray-400 text-sm"></i>
                        </span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#e92027] text-white font-bold py-2.5 rounded-lg hover:bg-[#c41820] transition-colors shadow-lg text-base mt-2">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-center text-[10px] text-gray-300 tracking-widest uppercase">
                © 2026 PT Semen Padang - Kearsipan Unit Sistem Manajemen
            </p>
        </div>

        <div class="hidden md:flex md:w-1/2 bg-[#e92027] justify-center items-center h-full">
            <img src="{{ asset('images/pabrik-sp.png') }}" alt="Arsip Semen Padang"
                class="max-h-[85%] max-w-[85%] object-contain">
        </div>
    </div>

</body>

</html>
