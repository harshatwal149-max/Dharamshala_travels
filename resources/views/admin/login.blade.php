<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Admin Login | Dharamshala Travels</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: light;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            margin: 0;
        }

        .login-page {
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;
            padding: clamp(1rem, 4vw, 2rem);
        }

        .login-card {
            width: 100%;
            max-width: 28rem;
            padding: clamp(1.25rem, 5vw, 2rem);
            overflow-wrap: anywhere;
        }

        .login-input {
            display: block;
            width: 100%;
            min-width: 0;
            min-height: 2.875rem;
            font: inherit;
        }

        .login-button {
            min-height: 2.875rem;
        }

        .login-message {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        @media (max-width: 380px) {
            .login-page {
                padding: .75rem;
            }

            .login-card {
                padding: 1.125rem;
                border-radius: 1rem;
            }

            .login-subtitle {
                line-height: 1.5;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-100">
    <main class="login-page flex items-center justify-center">
        <section class="login-card bg-white rounded-2xl shadow-2xl border border-slate-800/20 text-slate-800" aria-labelledby="login-title">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center mx-auto mb-3 shadow-md" aria-hidden="true">
                    <i data-lucide="mountain-snow" class="w-6 h-6 text-emerald-400"></i>
                </div>

                <h1 id="login-title" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Admin Portal
                </h1>

                <p class="login-subtitle text-xs sm:text-sm text-slate-500 mt-2">
                    Sign in to manage Dharamshala fleet &amp; bookings
                </p>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="login-message mb-5 p-3 sm:p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-start gap-2" role="status">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0 mt-0.5" aria-hidden="true"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if($errors->any())
                <div class="login-message mb-5 p-3 sm:p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-xs sm:text-sm font-medium space-y-2" role="alert" aria-live="polite">
                    <p class="font-bold">Please check the following:</p>
                    @foreach($errors->all() as $err)
                        <div class="flex items-start gap-2">
                            <span aria-hidden="true">•</span>
                            <span>{{ $err }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- LOGIN FORM --}}
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Email Address
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        inputmode="email"
                        maxlength="255"
                        placeholder="admin@dharamshala.com"
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        class="login-input px-3.5 py-3 bg-slate-50 border @error('email') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-900 focus:bg-white outline-none transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        class="login-input px-3.5 py-3 bg-slate-50 border @error('password') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-900 focus:bg-white outline-none transition-all">
                </div>

                <div class="flex items-center justify-start text-sm pt-1">
                    <label for="remember" class="inline-flex items-center gap-2.5 cursor-pointer text-slate-600 select-none">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                            class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-2 focus:ring-slate-900">
                        <span>Remember session</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="login-button w-full mt-2 px-4 py-3 bg-slate-900 hover:bg-slate-800 active:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 text-white rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <span>Sign In to Console</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-emerald-400 shrink-0" aria-hidden="true"></i>
                </button>
            </form>

            <div class="mt-8 pt-5 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center min-h-10 px-2 text-xs sm:text-sm text-slate-500 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300 rounded-md transition-colors">
                    ← Back to Customer Website
                </a>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</body>
</html>
