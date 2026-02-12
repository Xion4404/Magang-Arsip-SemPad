<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Reset Password
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Masukkan password baru Anda.
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#e92027] focus:border-[#e92027] focus:z-10 sm:text-sm" value="{{ $email ?? old('email') }}" readonly>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#e92027] focus:border-[#e92027] focus:z-10 sm:text-sm" placeholder="Password Baru">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password-confirm" name="password_confirmation" type="password" required class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#e92027] focus:border-[#e92027] focus:z-10 sm:text-sm" placeholder="Konfirmasi Password Baru">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#e92027] hover:bg-[#b91c1c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e92027] transition-colors duration-200">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
