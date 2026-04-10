<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- Session Flash Messages --}}
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-gray-800 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30 font-bold uppercase tracking-widest animate-pulse" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 dark:bg-gray-800 dark:text-rose-400 border border-rose-100 dark:border-rose-900/30 font-bold uppercase tracking-widest" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="p-4 mb-4 text-sm text-indigo-800 rounded-2xl bg-indigo-50 dark:bg-gray-800 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30 font-bold uppercase tracking-widest" role="alert">
                {{ session('info') }}
            </div>
        @endif

        {{-- Welcome Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative group">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-50 dark:bg-indigo-900/20 rounded-full blur-3xl opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative space-y-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">Halo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed">Selamat datang kembali di sistem pelaporan & manajemen training. <br> Pantau jadwal dan berikan feedback untuk setiap pelatihan Anda.</p>
            </div>
            <div class="relative">
                <div class="flex items-center -space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Training List --}}
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h4 class="text-xs font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">Jadwal Pelatihan Anda</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    // Ambil training dimana user terdaftar sebagai peserta
                    $userParticipations = \App\Models\TrainingParticipant::where('npk', Auth::user()->email)
                        ->with('training')
                        ->latest()
                        ->get();
                @endphp

                @forelse($userParticipations as $participation)
                    @php $training = $participation->training; @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 hover:shadow-xl hover:scale-[1.01] transition-all duration-300 group">
                        <div class="flex flex-col h-full space-y-6">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/40 text-[8px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter rounded-md">
                                            {{ $training->training_type }}
                                        </span>
                                        @if($participation->is_present)
                                            <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/40 text-[8px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter rounded-md flex items-center gap-1">
                                                <div class="w-1 h-1 bg-emerald-500 rounded-full"></div> Hadir
                                            </span>
                                        @endif
                                    </div>
                                    <h5 class="text-sm font-black text-gray-900 dark:text-white uppercase leading-tight group-hover:text-indigo-600 transition-colors">{{ $training->title }}</h5>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $training->organizer }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-400 group-hover:text-indigo-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-tighter">Tanggal</p>
                                        <p class="text-[10px] font-bold text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 mt-auto">
                                @if(!$participation->is_present)
                                    <a href="{{ route('trainings.scan', $training) }}" class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-200 dark:shadow-none hover:scale-[1.03] active:scale-[0.98]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 11v1m2-12h-1m-1 5h-5M3 8h1m15 10h1M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        Scan Kehadiran
                                    </a>
                                @else
                                    <div class="w-full p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl flex items-center justify-center gap-2 text-gray-400">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Absensi Sukses</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-white dark:bg-gray-800 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-gray-700/50 flex flex-col items-center justify-center space-y-4">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-3xl flex items-center justify-center text-gray-200 dark:text-gray-700">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 1.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-1.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest text-center">Anda belum terdaftar <br> di pelatihan manapun.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
