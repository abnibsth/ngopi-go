<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai — NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --black:      #0e0c0a;
            --dark-brown: #1e1410;
            --mid-brown:  #2a1c16;
            --gold:       #b8924a;
            --gold-light: #d4af7a;
            --gold-pale:  #e8d5b0;
            --cream:      #f4ede3;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            background-image: url('{{ asset('images/coffee_bg.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow: hidden;
        }

        h1, h2, .font-serif { font-family: 'Playfair Display', serif; }

        /* Background animated particles and overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(184,146,74,0.15) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 80% 30%, rgba(184,146,74,0.1) 0%, transparent 70%),
                rgba(14, 12, 10, 0.65); /* Dark overlay to keep card readable */
            pointer-events: none;
            z-index: 0;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }

        .gradient-gold {
            background: linear-gradient(120deg, #b8924a 0%, #e8d5b0 45%, #c4a265 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Page enter animation */
        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .login-card {
            animation: pageEnter 0.65s cubic-bezier(0.23, 1, 0.32, 1) both;
        }

        /* Floating coffee steam */
        @keyframes steam {
            0%   { opacity: 0; transform: translateY(0) scaleX(1); }
            30%  { opacity: 0.6; }
            80%  { opacity: 0.2; transform: translateY(-28px) scaleX(1.4); }
            100% { opacity: 0; transform: translateY(-36px) scaleX(1.6); }
        }
        .steam-line {
            animation: steam 2.2s ease-in-out infinite;
        }
        .steam-line:nth-child(2) { animation-delay: 0.6s; }
        .steam-line:nth-child(3) { animation-delay: 1.2s; }

        /* Gold line */
        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(184,146,74,0.6), transparent);
        }

        /* Input group */
        .input-group { position: relative; }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            background: rgba(0,0,0,0.25);
            border: 1px solid rgba(184,146,74,0.22);
            border-radius: 0.75rem;
            color: #f4ede3;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            outline: none;
        }
        .input-field::placeholder { color: rgba(184,146,74,0.35); }
        .input-field:focus {
            border-color: rgba(184,146,74,0.7);
            background: rgba(0,0,0,0.35);
            box-shadow: 0 0 0 3px rgba(184,146,74,0.1);
        }

        /* Autofill fix for dark mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(0,0,0,0.4) inset !important;
            -webkit-text-fill-color: #f4ede3 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(184,146,74,0.5);
            width: 18px; height: 18px;
            transition: color 0.25s ease;
            pointer-events: none;
        }
        .input-group:focus-within .input-icon {
            color: rgba(184,146,74,0.85);
        }

        /* Label float */
        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(184,146,74,0.6);
            margin-bottom: 0.45rem;
            transition: color 0.2s ease;
        }
        .input-group:focus-within .field-label {
            color: rgba(184,146,74,0.9);
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #b8924a, #d4af7a);
            color: #0e0c0a;
            font-weight: 600;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.03em;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(184,146,74,0.35);
            filter: brightness(1.06);
        }
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(184,146,74,0.25);
        }

        /* Alert */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert {
            animation: slideDown 0.3s ease both;
            display: flex; align-items: flex-start; gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .alert-success {
            background: rgba(74,222,128,0.1);
            border: 1px solid rgba(74,222,128,0.3);
            color: #86efac;
        }
        .alert-error {
            background: rgba(248,113,113,0.1);
            border: 1px solid rgba(248,113,113,0.3);
            color: #fca5a5;
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }

        /* Decorative dots pattern */
        .dot-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(184,146,74,0.12) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body>
    <div class="login-card relative z-10 w-full max-w-md">
        <!-- Card -->
        <div style="background: rgba(30,20,16,0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(184,146,74,0.25); border-radius: 1.25rem; overflow: hidden; box-shadow: 0 32px 64px rgba(0,0,0,0.5), 0 0 0 1px rgba(184,146,74,0.08);">

            <!-- Header / Branding -->
            <div style="padding: 2.25rem 2rem 1.75rem; text-align: center; position: relative; overflow: hidden;">
                <!-- Subtle dot bg -->
                <div class="dot-pattern" style="opacity: 0.4;"></div>

                <!-- Coffee cup SVG with steam -->
                <div style="position: relative; display: inline-block; margin-bottom: 1rem;">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block; margin: 0 auto;">
                        <path d="M17 8h1a4 4 0 0 1 0 8h-1" stroke="#b8924a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8z" stroke="#b8924a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 2v2M10 2v2M14 2v2" stroke="#b8924a" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <!-- Steam lines -->
                    <svg style="position: absolute; top: -18px; left: 50%; transform: translateX(-50%);" width="32" height="20" viewBox="0 0 32 20" fill="none">
                        <path class="steam-line" d="M8 18 Q6 12 8 8 Q10 4 8 0" stroke="rgba(184,146,74,0.5)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                        <path class="steam-line" d="M16 18 Q14 11 16 7 Q18 3 16 0" stroke="rgba(184,146,74,0.4)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                        <path class="steam-line" d="M24 18 Q22 12 24 8 Q26 4 24 0" stroke="rgba(184,146,74,0.5)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>

                <h1 style="font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 600; margin: 0 0 0.3rem; position: relative;">
                    <span class="gradient-gold">NgopiGo</span>
                </h1>
                <p style="color: rgba(184,146,74,0.55); font-size: 0.78rem; letter-spacing: 0.12em; text-transform: uppercase; position: relative;">
                    Staff Portal
                </p>
            </div>

            <!-- Gold separator -->
            <div style="padding: 0 1.5rem;">
                <div class="gold-line"></div>
            </div>

            <!-- Form body -->
            <div style="padding: 1.75rem 2rem 2rem;">

                @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="username" class="field-label">Username</label>
                        <div class="input-group">
                            <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   value="{{ old('username') }}"
                                   required
                                   autofocus
                                   class="input-field @error('username') error @enderror"
                                   placeholder="Masukkan username">
                        </div>
                        @error('username')
                        <p style="color: #fca5a5; font-size: 0.78rem; margin-top: 0.4rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="password" class="field-label">Password</label>
                        <div class="input-group">
                            <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   required
                                   class="input-field @error('password') error @enderror"
                                   placeholder="Masukkan password"
                                   style="padding-right: 2.75rem;">
                            
                            <!-- Toggle Password Button -->
                            <button type="button" class="password-toggle" onclick="togglePassword()" style="position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; color: rgba(184,146,74,0.5); cursor: pointer; transition: color 0.25s ease;" onmouseover="this.style.color='rgba(184,146,74,0.9)'" onmouseout="this.style.color='rgba(184,146,74,0.5)'">
                                <svg id="eye-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p style="color: #fca5a5; font-size: 0.78rem; margin-top: 0.4rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox"
                               name="remember"
                               id="remember"
                               style="width: 15px; height: 15px; accent-color: #b8924a; cursor: pointer;">
                        <label for="remember" style="font-size: 0.82rem; color: rgba(184,146,74,0.6); cursor: pointer;">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-login">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                        Masuk ke Panel
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div style="padding: 0.9rem 2rem; border-top: 1px solid rgba(184,146,74,0.12); text-align: center;">
                <p style="font-size: 0.75rem; color: rgba(184,146,74,0.35);">
                    &copy; {{ date('Y') }} NgopiGo &mdash; Staff Access Only
                </p>
            </div>
        </div>
    </div>
</body>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // Change to eye-slash icon
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;
        } else {
            passwordInput.type = 'password';
            // Change back to regular eye icon
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
        }
    }
</script>
</html>
