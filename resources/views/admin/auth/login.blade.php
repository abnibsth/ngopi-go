<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - NgopiGo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Premium Colors - Same as Landing Page */
        :root {
            --black: #121212;
            --dark-brown: #2E1F1A;
            --gold: #C69C6D;
            --gold-light: #D4AF7A;
            --cream: #F5F0E6;
        }

        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Premium Card */
        .premium-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(198, 156, 109, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#2E1F1A] via-[#1a120f] to-[#0f0a08] min-h-screen flex items-center justify-center p-4">
    <!-- Login Card -->
    <div class="bg-[#1a120f] rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-[#C69C6D]/30 premium-card">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-8 py-6 text-center border-b border-[#C69C6D]/30">
            <div class="text-5xl mb-3">☕</div>
            <h1 class="text-2xl font-bold gradient-gold">Login Pegawai NgopiGo</h1>
            <p class="text-[#C69C6D] mt-1">Silahkan login untuk melanjutkan</p>
        </div>

        <!-- Body -->
        <div class="px-8 py-8">
            @if(session('success'))
            <div class="bg-[#1a2f1a] border border-[#4ade80]/50 text-[#4ade80] px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-[#2f1a1a] border border-[#f87171]/50 text-[#f87171] px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf

                <!-- Username -->
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-[#F5F0E6] mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#C69C6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               required
                               autofocus
                               class="w-full pl-10 pr-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] placeholder-[#C69C6D]/50 focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('username') border-[#f87171] @enderror"
                               placeholder="Masukkan username">
                    </div>
                    @error('username')
                    <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-[#F5F0E6] mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#C69C6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               class="w-full pl-10 pr-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] placeholder-[#C69C6D]/50 focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('password') border-[#f87171] @enderror"
                               placeholder="Masukkan password">
                    </div>
                    @error('password')
                    <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="remember"
                               class="w-4 h-4 text-[#C69C6D] border-[#C69C6D]/30 rounded focus:ring-[#C69C6D] bg-[#2E1F1A]">
                        <span class="ml-2 text-sm text-[#C69C6D]">Ingat saya (Remember me)</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    🚀 Login
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-[#2E1F1A]/50 px-8 py-4 text-center border-t border-[#C69C6D]/20">
            <p class="text-sm text-[#C69C6D]">
                © {{ date('Y') }} NgopiGo Admin Panel
            </p>
        </div>
    </div>
</body>
</html>
