@props(['header' => null])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Report Trainee') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-toast-custom {
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            color: white !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 overflow-hidden transition-colors duration-300">
    <div x-data="{ 
        sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true',
        darkMode: localStorage.getItem('theme') === 'dark',
        toggleSidebar() {
            this.sidebarMinimized = !this.sidebarMinimized;
            localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
        },
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }" class="flex h-screen w-full overflow-hidden">

        {{-- Sidebar --}}
        <aside 
            :class="sidebarMinimized ? 'w-24' : 'w-64'"
            class="bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white flex flex-col flex-shrink-0 transition-all duration-300 ease-in-out relative z-50 border-r border-gray-200 dark:border-gray-800 shadow-xl dark:shadow-2xl dark:shadow-[#00000050]">
            
            {{-- Logo --}}
            <div class="flex items-center h-16 border-b border-gray-200 dark:border-gray-800 shrink-0 overflow-hidden px-4"
                 :class="sidebarMinimized ? 'justify-center' : 'gap-3'">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/20 dark:shadow-indigo-900/40">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
                    </svg>
                </div>
                <div x-show="!sidebarMinimized" x-transition.opacity class="whitespace-nowrap overflow-hidden">
                    <p class="text-sm font-bold text-gray-900 dark:text-white tracking-tight leading-none mb-1">Report Trainee</p>
                    <p class="text-[10px] text-indigo-500 dark:text-indigo-400 font-extrabold uppercase tracking-widest leading-none">Admin Panel</p>
                </div>
            </div>

            {{-- Toggle Button — Expand/Collapse (Internal) --}}
            <button @click="toggleSidebar()"
                class="w-full flex items-center justify-center gap-2 py-3 bg-gray-50 dark:bg-gray-800/60 hover:bg-gray-100 dark:hover:bg-indigo-600/30 border-b border-gray-200 dark:border-gray-700 transition-all duration-200 cursor-pointer group shrink-0"
                :title="sidebarMinimized ? 'Expand Sidebar' : 'Collapse Sidebar'">
                <svg class="w-5 h-5 text-gray-500 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-all duration-300 shrink-0"
                     :class="sidebarMinimized ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7" />
                </svg>
                <span x-show="!sidebarMinimized" x-transition.opacity
                      class="text-xs font-bold text-gray-500 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-300 uppercase tracking-widest transition-colors duration-200 whitespace-nowrap">
                    Minimize
                </span>
            </button>

            {{-- Navigation --}}
            <nav class="flex-1 py-6 space-y-1 overflow-y-auto scrollbar-hide transition-all duration-300"
                :class="sidebarMinimized ? 'px-2' : 'px-4'">
                
                <p x-show="!sidebarMinimized" x-transition.opacity class="px-3 py-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 opacity-50">Main Menu</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 dark:shadow-indigo-900/40' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}"
                    :class="sidebarMinimized ? 'justify-center h-14 w-full' : 'px-3 py-3.5 gap-4'"
                    title="Dashboard">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="!sidebarMinimized" x-transition.opacity class="truncate font-semibold tracking-wide">Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 dark:shadow-indigo-900/40' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}"
                    :class="sidebarMinimized ? 'justify-center h-14 w-full' : 'px-3 py-3.5 gap-4'"
                    title="Manajemen User">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="!sidebarMinimized" x-transition.opacity class="truncate font-semibold tracking-wide">Manajemen User</span>
                </a>

                {{-- Group: Training Management --}}
                <p x-show="!sidebarMinimized" x-transition.opacity class="px-3 pt-8 py-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 opacity-50">Manajemen Training</p>
                
                <a href="{{ route('admin.trainings.index') }}"
                    class="flex items-center rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ request()->routeIs('admin.trainings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 dark:shadow-indigo-900/40' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}"
                    :class="sidebarMinimized ? 'justify-center h-14 w-full' : 'px-3 py-3.5 gap-4'"
                    title="Monitoring Training">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="!sidebarMinimized" x-transition.opacity class="truncate font-semibold tracking-wide">Monitoring (Oversight)</span>
                </a>

                <a href="{{ route('admin.master-trainings.index') }}"
                    class="flex items-center rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ request()->routeIs('admin.master-trainings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 dark:shadow-indigo-900/40' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}"
                    :class="sidebarMinimized ? 'justify-center h-14 w-full' : 'px-3 py-3.5 gap-4'"
                    title="Data Master Training">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span x-show="!sidebarMinimized" x-transition.opacity class="truncate font-semibold tracking-wide">Data Master</span>
                </a>

                {{-- Group: Personnel --}}
                <p x-show="!sidebarMinimized" x-transition.opacity class="px-3 pt-8 py-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 opacity-50">Manajemen Trainee</p>

                <a href="{{ route('admin.employees.index') }}"
                    class="flex items-center rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.import-users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 dark:shadow-indigo-900/40' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}"
                    :class="sidebarMinimized ? 'justify-center h-14 w-full' : 'px-3 py-3.5 gap-4'"
                    title="Master Trainee">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="!sidebarMinimized" x-transition.opacity class="truncate font-semibold tracking-wide">Data Trainee</span>
                </a>
            </nav>

            {{-- User Info --}}
            <div class="border-t border-gray-200 dark:border-gray-800 p-4 transition-all duration-300">
                {{-- Theme Toggle (Relocated) --}}
                <div class="mb-4">
                    <button @click="toggleTheme()" 
                            class="flex items-center w-full rounded-xl transition-all duration-300 group
                                   bg-gray-100 dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-indigo-600/20 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-300"
                            :class="sidebarMinimized ? 'justify-center h-12' : 'px-3 py-3 gap-4'"
                            title="Ganti Tema">
                        <div class="relative w-6 h-6 flex items-center justify-center shrink-0">
                            <!-- Sun Icon -->
                            <svg x-show="!darkMode" class="w-5 h-5 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <!-- Moon Icon -->
                            <svg x-show="darkMode" class="w-5 h-5 transition-transform duration-500 group-hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarMinimized" x-transition.opacity class="text-[10px] font-bold uppercase tracking-[0.2em] whitespace-nowrap">
                            <span x-text="darkMode ? 'Dark Mode' : 'Light Mode'"></span>
                        </span>
                    </button>
                </div>

                <div class="flex items-center transition-all duration-300 overflow-hidden shrink-0"
                     :class="sidebarMinimized ? 'justify-center' : 'gap-4'">
                    <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold shrink-0 border border-indigo-500/20 shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div x-show="!sidebarMinimized" x-transition.opacity class="flex-1 min-w-0 overflow-hidden transition-all duration-300">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate leading-tight mb-0.5">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-gray-500 dark:text-gray-400 font-medium truncate uppercase tracking-tighter leading-tight">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="flex items-center rounded-xl transition-all duration-200 text-gray-500 hover:text-red-400 hover:bg-red-400/5 group/logout w-full"
                        :class="sidebarMinimized ? 'justify-center h-10' : 'px-3 py-2.5 gap-4'"
                        title="Keluar">
                        <svg class="w-5 h-5 shrink-0 transition-transform group-hover/logout:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="!sidebarMinimized" x-transition.opacity class="text-[10px] font-bold uppercase tracking-[0.25em] whitespace-nowrap leading-none">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-white dark:bg-gray-950">
            {{-- Top Bar --}}
            @if (isset($header))
                <header class="bg-white/50 dark:bg-[#0f111a]/50 backdrop-blur-xl border-b border-gray-100 dark:border-gray-800">
                    <div class="py-6 pl-12 md:pl-20 lg:pl-32 pr-12 md:pr-16 lg:pr-24 max-w-[1920px]">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Main Scroll --}}
            <main class="flex-1 overflow-y-auto scroll-smooth">
                <div class="py-8 pl-12 md:pl-20 lg:pl-32 pr-12 md:pr-16 lg:pr-24 max-w-[1920px]">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global SweetAlert Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-toast-custom'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Handle Session Flash Messages
            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            // Global Confirmation Interceptor
            window.confirmAction = function(event, message, type = 'warning', confirmButtonText = 'Ya, Lanjutkan!', onConfirm = null) {
                event.preventDefault();
                const form = event.target.closest('form');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: message || "Aksi ini tidak dapat dibatalkan!",
                    icon: type,
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal',
                    background: '#1e293b',
                    color: '#f8fafc'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof onConfirm === 'function') {
                            onConfirm();
                        } else if (form) {
                            form.submit();
                        } else {
                            console.warn('ConfirmAction: No callback provided and no form found.');
                        }
                    }
                });
            };
        });
    </script>
    @stack('scripts')
</body>

</html>