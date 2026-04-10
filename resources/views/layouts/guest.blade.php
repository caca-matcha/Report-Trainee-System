<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-indigo-500/30">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc] dark:bg-[#0f172a] relative overflow-hidden">
            {{-- Premium Background Elements --}}
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-[120px] animate-pulse"></div>
                <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl border border-white/20 dark:border-white/5 shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] overflow-hidden sm:rounded-[2.5rem] relative z-10 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(79,70,229,0.15)]">
                {{-- Logo Section --}}
                <div class="flex flex-col items-center mb-10">
                    <a href="/" class="group transition-transform duration-500 hover:scale-110">
                        {{-- Using the custom logo if available, fallback to component --}}
                        @if(file_exists(public_path('assets/img/logo.png')))
                            <img src="{{ asset('assets/img/logo.png') }}" class="w-40 h-auto object-contain" alt="Logo">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-[2rem] flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:rotate-6 transition-all duration-500">
                                <i data-lucide="graduation-cap" class="w-12 h-12 text-white"></i>
                            </div>
                        @endif
                    </a>
                </div>

                {{ $slot }}
            </div>

            {{-- Footer Text --}}
            <div class="mt-8 text-center relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-600">
                    &copy; {{ date('Y') }} Dharma Learning Center
                </p>
            </div>
        </div>
    </body>
</html>
