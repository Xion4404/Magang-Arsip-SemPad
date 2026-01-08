<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Arsip PT Semen Padang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white antialiased">

    <div class="min-h-screen flex flex-col md:flex-row relative">
        
        <div class="absolute top-6 left-6 flex items-center space-x-3 z-20">
            <img src="{{ asset('images/logo-sp.png') }}" alt="Logo" class="h-10 md:h-12 w-auto">
            <span class="text-[#4A1D1D] font-bold text-lg md:text-xl tracking-tight">PT SEMEN PADANG</span>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center px-12 lg:px-28 py-20 bg-white">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-[#4A1D1D] leading-tight mb-2">
                    Manajemen Arsip <br>
                    Terintegrasi & Monitoring
                </h1>
                <h2 class="text-2xl md:text-3xl font-bold text-[#8B1A1A]">Login</h2>
            </div>

            <form method="POST" action="#" class="space-y-6 max-w-md mx-auto w-full">
                @csrf
                <div>
                    <label class="block text-[#8B1A1A] font-bold mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-user text-gray-400 text-sm"></i>
                        </span>
                        <input type="email" name="email" placeholder="Type your username" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none text-sm shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[#8B1A1A] font-bold mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </span>
                        <input type="password" name="password" placeholder="Enter Current Password" required
                            class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none text-sm shadow-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <i class="far fa-eye-slash text-gray-400 text-sm"></i>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-xs font-semibold text-gray-600 cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="ml-2">Remember Me</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-[#8B1A1A] hover:underline">Forgot password?</a>
                </div>

                <button type="submit" 
                    class="w-full bg-[#8B1A1A] text-white font-bold py-3 rounded-lg hover:bg-[#6B1414] transition-colors shadow-lg text-lg">
                    Sign in
                </button>
            </form>

            <p class="mt-16 text-center text-[10px] text-gray-300 tracking-widest uppercase">
                © 2026 PT Semen Padang - Information Technology Division
            </p>
        </div>

        <div class="hidden md:flex md:w-1/2 p-10 bg-[#FDF2F2] justify-center items-center">
            <div class="h-full w-full rounded-[3rem] overflow-hidden shadow-2xl">
                <img src="{{ asset('images/pabrik-sp.png') }}" alt="Pabrik Semen Padang" class="h-full w-full object-cover shadow-inner">
            </div>
        </div>
    </div>

</body>
</html>