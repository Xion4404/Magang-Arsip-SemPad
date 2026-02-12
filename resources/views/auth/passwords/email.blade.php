<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Lupa Password?
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Masukkan email Anda untuk menerima link reset password.
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-4 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#e92027] focus:border-[#e92027] focus:z-10 sm:text-sm" placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#e92027] hover:bg-[#b91c1c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e92027] transition-colors duration-200">
                        Kirim Link Reset Password
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="font-medium text-[#e92027] hover:text-[#b91c1c] text-sm">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
