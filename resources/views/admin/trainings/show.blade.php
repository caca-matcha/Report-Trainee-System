<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.trainings.index') }}"
                    class="group p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 dark:hover:border-indigo-900 transition-all duration-200 shadow-sm">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent tracking-tight">Detail Training</h1>
                        <span class="hidden md:inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50 uppercase tracking-wider">
                            ID: {{ $training->masterTraining->event_no ?? '#' . $training->id }}
                        </span>
                    </div>
                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mt-0.5">
                        Dibuat Oleh: <span class="text-gray-700 dark:text-gray-300 font-bold">{{ $training->user->name }}</span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3">
                @if(!$training->is_approved)
                    <form id="approve-form-{{ $training->id }}" action="{{ route('admin.trainings.approve', $training) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <button type="button" 
                        onclick="confirmAction(event, 'Apakah Anda yakin ingin mengunci laporan ini? Semua data dan kolom tanda tangan akan dinonaktifkan permanen.', 'warning', 'Lock Sekarang', () => document.getElementById('approve-form-{{ $training->id }}').submit())"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all duration-200 shadow-lg shadow-emerald-100 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Lock Report</span>
                    </button>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-xl text-xs font-black uppercase tracking-widest border border-gray-200 dark:border-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Laporan Terkunci</span>
                    </div>
                @endif

                <a href="{{ route('summaries.show', $training) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all duration-200 shadow-lg shadow-indigo-100 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Summary Report</span>
                </a>
                <a href="{{ route('trainings.attendance_list', $training) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>Presensi</span>
                </a>
                <a href="{{ route('trainings.attendance_qr', $training) }}"
                    class="inline-flex items-center justify-center p-2.5 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-all duration-200 group" title="Tampilkan QR">
                    <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 11v1m2-12h-1m-1 5h-5M3 8h1m15 10h1M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Info Utama --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Judul</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $training->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">PIC / Penanggung Jawab</p>
                    <div class="mt-1 flex flex-wrap gap-1">
                        @if($training->pics && is_array($training->pics) && count($training->pics) > 0)
                            @foreach($training->pics as $pic)
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-md">
                                    {{ $pic['name'] }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-semibold">{{ $training->user->name ?? '-' }}</p>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Tanggal</p>
                    <p class="mt-1 text-sm font-bold text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">Durasi</p>
                    <p class="mt-1 text-sm font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter">
                        @php
                            $start = \Carbon\Carbon::parse($training->start_date);
                            $end = \Carbon\Carbon::parse($training->end_date ?? $training->start_date);
                            echo $start->diffInDays($end) + 1;
                        @endphp Hari
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Tipe Training</p>
                    <span class="mt-1 inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                        {{ $training->training_type }}
                    </span>
                </div>
            </div>

            {{-- Collapsible Additional Info --}}
            <div x-data="{ expanded: false }" class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                <button @click="expanded = !expanded" class="flex items-center gap-2 text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:opacity-70 transition-all outline-none">
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                    <span x-text="expanded ? 'Sembunyikan Detail' : 'Lihat Detail Pelatihan'"></span>
                </button>
                
                <div x-show="expanded" x-collapse x-cloak class="mt-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Left Column: Master Identification --}}
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-indigo-50/30 dark:bg-indigo-900/10 rounded-3xl p-6 border border-indigo-100/50 dark:border-indigo-800/20 group hover:border-indigo-300 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-200 dark:shadow-none flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[9px] font-black text-indigo-500 dark:text-indigo-400 uppercase tracking-[0.3em] mb-1">Master Training</p>
                                            <p class="text-xs font-black text-gray-900 dark:text-white leading-tight break-words">
                                                {{ $training->masterTraining->training_course ?? $training->title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-purple-50/30 dark:bg-purple-900/10 rounded-3xl p-6 border border-purple-100/50 dark:border-purple-800/20 group hover:border-purple-300 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-purple-600 shadow-lg shadow-purple-200 dark:shadow-none flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[9px] font-black text-purple-500 dark:text-purple-400 uppercase tracking-[0.3em] mb-1">Kategori</p>
                                            <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                                {{ $training->masterTraining->category ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-emerald-50/30 dark:bg-emerald-900/10 rounded-3xl p-6 border border-emerald-100/50 dark:border-emerald-800/20 group hover:border-emerald-300 transition-colors">
                                <div class="flex items-center justify-between gap-5">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-emerald-600 shadow-lg shadow-emerald-200 dark:shadow-none flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[9px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-[0.3em] mb-1">Durasi Pelatihan</p>
                                            @php
                                                $start = \Carbon\Carbon::parse($training->start_date);
                                                $end = \Carbon\Carbon::parse($training->end_date ?? $training->start_date);
                                                $days = $start->diffInDays($end) + 1;
                                            @endphp
                                            <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                                {{ $days }} Hari
                                            </p>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block text-right">
                                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $start->format('d M') }} - {{ $end->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Detailed Execution Info --}}
                        <div class="bg-gray-50 dark:bg-gray-900/40 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-800 shadow-xl dark:shadow-none relative overflow-hidden">
                            {{-- Decorative Background Glow --}}
                            <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <div class="relative space-y-8">
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                        <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em]">Topik Sesi</h4>
                                    </div>
                                    <div class="pl-4">
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-relaxed italic">
                                            "{{ $training->training_topic ?: 'Topik sesi belum ditentukan.' }}"
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="relative">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                                        <h4 class="text-[10px] font-black text-amber-500 uppercase tracking-[0.4em]">Deskripsi Pelaksanaan</h4>
                                    </div>
                                    <div class="pl-4">
                                        <div class="text-[13px] text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
                                            {!! nl2br(e($training->description ?: 'Tidak ada deskripsi tambahan untuk sesi ini.')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- PIC List --}}
        @php
            $displayPics = $training->pics && is_array($training->pics) ? $training->pics : [];
            if (empty($displayPics)) {
                $masterForPic = \App\Models\MasterTraining::where($training->master_training_id ? ['id' => $training->master_training_id] : ['training_id' => $training->id])->first();
                if ($masterForPic && !empty($masterForPic->pics)) {
                    $displayPics = $masterForPic->pics;
                }
            }
        @endphp

        @if(count($displayPics) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Daftar PIC
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($displayPics as $pic)
                        <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600">
                            <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-indigo-50 dark:bg-indigo-900/40 border border-gray-200 dark:border-gray-600">
                                @php $photoPath = $pic['photo'] ?? ($pic['photo_path'] ?? null); @endphp
                                @if($photoPath)
                                    <img src="{{ asset('storage/' . $photoPath) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-indigo-500 font-bold uppercase text-lg">
                                        {{ substr($pic['name'] ?? '?', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $pic['name'] ?? '-' }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">{{ $pic['npk'] ?? '-' }}</p>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium uppercase truncate">{{ $pic['subco'] ?? '-' }}</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $pic['department'] ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Peserta / Management Section --}}
        <div class="bg-white dark:bg-[#111827] rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800 p-8">
            <div class="space-y-6 mb-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.3em]">Daftar Peserta Trainee</h3>
                        <span class="bg-indigo-600 text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow-lg shadow-indigo-500/20">{{ $training->participants->count() }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if(!$training->is_approved)
                            <button type="button" onclick="toggleManualAddRow()"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black rounded-xl uppercase transition-all shadow-xl shadow-indigo-500/20 flex items-center gap-2 group active:scale-95">
                                <svg class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                + Tambah Manual
                            </button>
                            <button type="button" onclick="saveAllScores()" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black rounded-xl uppercase transition-all shadow-xl shadow-blue-500/20 flex items-center gap-2 active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Simpan Data
                            </button>
                        @endif
                    </div>
                </div>
                
                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium italic">Cari nama/NPK di kotak bawah untuk menambah peserta otomatis, atau klik Tambah Manual untuk data baru.</p>
                
                <div class="relative group max-w-3xl">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="quick-search-participant" placeholder="Ketik nama atau NPK peserta..." autocomplete="off"
                        class="block w-full pl-14 pr-6 py-4.5 bg-gray-50 dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-800 rounded-2xl text-sm focus:ring-0 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm transition-all focus:shadow-2xl focus:shadow-indigo-500/10 placeholder:text-gray-400">
                    <div id="quick-search-suggestions" class="absolute z-50 w-full bg-white dark:bg-gray-800 border-2 border-gray-50 dark:border-gray-700 rounded-2xl shadow-2xl mt-3 hidden max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700/50"></div>
                </div>

                @if(!$training->is_approved)
                    <div class="flex flex-wrap gap-2 pt-2">
                        <a href="{{ route('trainings.participant_template', $training) }}"
                            class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[9px] font-black rounded-lg uppercase hover:bg-emerald-100 transition-all flex items-center gap-1.5 border border-emerald-100 dark:border-emerald-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Template Excel
                        </a>
                        <a href="{{ route('trainings.importForm', $training) }}"
                            class="px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[9px] font-black rounded-lg uppercase hover:bg-amber-100 transition-all flex items-center gap-1.5 border border-amber-100 dark:border-amber-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Import CSV/Excel
                        </a>
                        <form action="{{ route('admin.trainings.bulk_attendance', $training) }}" method="POST" onsubmit="confirmAction(event, 'Hadirkan seluruh peserta sekaligus?', 'question')">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[9px] font-black rounded-lg uppercase hover:bg-slate-100 transition-all flex items-center gap-1.5 border border-slate-200 dark:border-slate-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Hadirkan Semua
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/50 text-[10px] uppercase font-black text-gray-400 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-4 py-4 w-12 text-center">No</th>
                            <th class="px-4 py-4 w-16 text-center">Foto</th>
                            <th class="px-4 py-4">NPK</th>
                            <th class="px-4 py-4">Nama Lengkap</th>
                            <th class="px-4 py-4">Departemen</th>
                            <th class="px-4 py-4 text-center">Pre</th>
                            <th class="px-4 py-4 text-center">Post</th>
                            <th class="px-4 py-4 text-center">Punc</th>
                            <th class="px-4 py-4 text-center">Actv</th>
                            <th class="px-4 py-4 text-center">Coop</th>
                            <th class="px-4 py-4 text-center">Attd</th>
                            <th class="px-4 py-4 text-center">Hadir</th>
                            <th class="px-4 py-4 text-center">Subco</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($training->participants as $index => $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-3 text-center text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $photo = $p->photo_path ?: ($p->user ? $p->user->photo : null);
                                        $editLink = $p->user
                                            ? route('admin.employees.edit', $p->user)
                                            : route('admin.employees.create', [
                                                'name' => $p->name,
                                                'npk' => $p->npk,
                                                'department' => $p->department,
                                                'subco' => $p->subco,
                                            ]);
                                    @endphp
                                    <div class="flex flex-col items-center gap-1">
                                        <a href="{{ $photo ? asset('storage/' . $photo) : (auth()->user()->role === 'admin' ? $editLink : '#') }}"
                                            {{ $photo ? 'target="_blank"' : '' }}
                                            class="block w-8 h-8 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 mx-auto border border-gray-200 dark:border-gray-600 hover:opacity-80 transition-opacity">
                                            @if ($photo)
                                                <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">
                                                    {{ substr($p->name, 0, 2) }}
                                                </div>
                                            @endif
                                        </a>
                                        @if (!$photo && auth()->user()->role === 'admin')
                                            <a href="{{ $editLink }}"
                                                class="text-[7px] text-indigo-500 hover:underline leading-none text-center font-bold uppercase tracking-tighter">
                                                Tambah Foto
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 font-mono text-xs">
                                    {{ $p->npk ?? '-' }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $p->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-xs">{{ $p->department ?? '-' }}
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" 
                                        value="{{ $p->pre_test_score !== null ? round($p->pre_test_score) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'pre_test', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-16 h-8 text-center text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" 
                                        value="{{ $p->post_test_score !== null ? round($p->post_test_score) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'post_test', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-16 h-8 text-center text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 font-semibold disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed {{ $p->post_test_score !== null && $p->post_test_score >= $training->passing_grade ? 'text-green-600' : ($p->post_test_score !== null ? 'text-red-500' : 'text-gray-400') }}">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" min="0" max="5" 
                                        value="{{ $p->punctuality_score !== null ? number_format($p->punctuality_score, 1) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'punctuality', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-12 h-8 text-center text-xs border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" min="0" max="5" 
                                        value="{{ $p->activeness_score !== null ? number_format($p->activeness_score, 1) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'activeness', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-12 h-8 text-center text-xs border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" min="0" max="5" 
                                        value="{{ $p->cooperation_score !== null ? number_format($p->cooperation_score, 1) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'cooperation', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-12 h-8 text-center text-xs border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" min="0" max="5" 
                                        value="{{ $p->attitude_score !== null ? number_format($p->attitude_score, 1) : '' }}"
                                        onblur="updateScore({{ $p->id }}, 'attitude', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-12 h-8 text-center text-xs border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 disabled:bg-gray-100 dark:disabled:bg-gray-900 disabled:cursor-not-allowed">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" id="attendance-btn-{{ $p->id }}" onclick="{{ $training->is_approved ? 'return false;' : 'toggleAttendance(' . $p->id . ', this)' }}"
                                        class="focus:outline-none transition-transform {{ $training->is_approved ? 'opacity-75 cursor-not-allowed' : 'hover:scale-105 active:scale-95 cursor-pointer' }}">
                                        @if($p->is_present)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">✓
                                                Hadir</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">✗
                                                Tidak</span>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="text" value="{{ $p->subco ?? '-' }}" 
                                        onchange="updateField({{ $p->id }}, 'subco', this.value)"
                                        onkeydown="handleTableKey(event)"
                                        data-table-input
                                        {{ $training->is_approved ? 'disabled' : '' }}
                                        class="w-full bg-transparent border-none focus:ring-0 text-center text-gray-600 dark:text-gray-400 text-xs font-medium uppercase tracking-wider p-0 cursor-pointer disabled:cursor-not-allowed hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded transition-colors"
                                        placeholder="...">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(!$training->is_approved)
                                            <button type="button" 
                                                onclick="openEditParticipantModal({{ json_encode($p) }})"
                                                class="p-1.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('trainings.remove_participant', [$training, $p]) }}" method="POST" 
                                                onsubmit="confirmAction(event, 'Keluarkan peserta ini dari training?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 rounded-lg hover:bg-red-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic">Locked</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="px-6 py-6 text-center text-gray-400 italic">Belum ada peserta terdaftar.</td>
                            </tr>
                        @endforelse

                        {{-- INLINE MANUAL ADD ROW (MASTER STYLE) --}}
                        <tr id="manual-add-row" class="hidden bg-indigo-50/30 dark:bg-indigo-900/10 border-t border-indigo-100 dark:border-indigo-900/50 animate-fade-in">
                            <td class="px-4 py-5 text-center text-indigo-600 dark:text-indigo-400 font-black text-xs">+</td>
                            <td class="px-4 py-5 flex justify-center">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 font-black border border-indigo-200 dark:border-indigo-800 text-[10px]">M</div>
                            </td>
                            <td class="px-4 py-5">
                                <input type="text" id="manual_npk_input" placeholder="NPK" class="w-full text-[10px] font-mono px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 text-indigo-600 dark:text-indigo-400 font-black tracking-tighter shadow-sm transition-all focus:shadow-indigo-500/20">
                            </td>
                            <td class="px-4 py-5">
                                <input type="text" id="manual_name_input" placeholder="NAMA LENGKAP" class="w-full text-[11px] font-bold px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white uppercase placeholder:normal-case shadow-sm transition-all focus:shadow-indigo-500/20">
                            </td>
                            <td class="px-4 py-5 font-bold uppercase tracking-widest text-[9px] text-gray-400">
                                <input type="text" id="manual_dept_input" placeholder="DEPARTEMEN" class="w-full text-xs px-3 py-2 bg-transparent border-none rounded-lg focus:ring-1 focus:ring-indigo-500/30 text-gray-500 dark:text-gray-400 uppercase placeholder:normal-case font-medium">
                            </td>
                            <td colspan="6" class="px-4 py-5 text-center italic text-gray-400 dark:text-gray-600 text-[10px] tracking-tight">
                                (Entry manual &mdash; score diisi setelah peserta ditambahkan)
                            </td>
                            <td class="px-4 py-5 text-center text-gray-200">&bull;</td>
                            <td class="px-4 py-5">
                                <input type="text" id="manual_subco_input" placeholder="SUBCO" class="w-full text-[9px] text-center px-1 py-2 bg-transparent border-dashed border-gray-300 dark:border-gray-700 rounded-lg focus:ring-1 focus:ring-indigo-500/30 font-black tracking-[0.2em] text-gray-400 uppercase">
                            </td>
                            <td class="px-4 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="submitInlineManualAdd()" class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 hover:scale-110 active:scale-95 transition-all shadow-lg shadow-indigo-500/20" title="Simpan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button onclick="toggleManualAddRow()" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all active:scale-95" title="Batal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $displayParticipants = $training->participants;
        @endphp

        @if($displayParticipants->count() > 0)
            <div x-data="{ expanded: true }" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tighter flex items-center gap-3">
                            <span class="w-2.5 h-10 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.4)]"></span>
                            Visualisasi Scoring Peserta
                        </h2>
                        {{-- Minimize Toggle Button --}}
                        <button @click="expanded = !expanded" 
                                class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 hover:bg-indigo-100 dark:bg-gray-800 dark:hover:bg-indigo-900/40 rounded-xl transition-all duration-300 group/btn border border-gray-200 dark:border-gray-700">
                            <svg class="w-4 h-4 text-gray-500 group-hover/btn:text-indigo-500 transition-transform duration-500" 
                                 :class="expanded ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                            <span class="text-[9px] font-black text-gray-400 group-hover/btn:text-indigo-400 uppercase tracking-widest" x-text="expanded ? 'Minimize' : 'Expand'">Minimize</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-3 bg-gray-50/50 dark:bg-gray-800/50 p-2 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <span class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-white dark:bg-gray-900 px-3 py-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.5)]"></span> Score
                        </span>
                        <span class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-white dark:bg-gray-900 px-3 py-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                            <span class="w-5 h-0.5 bg-orange-400 rounded-full"></span> Target
                        </span>
                    </div>
                </div>

                <div x-show="expanded" 
                     x-collapse
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 gap-4">
                    @foreach($displayParticipants as $p)
                        @php
                            $isPassed = $p->post_test_score !== null && $p->post_test_score >= $training->passing_grade;
                            $photo = $p->photo_path ?: ($p->user ? $p->user->photo : null);
                        @endphp
                        <div class="bg-white dark:bg-gray-800/40 dark:backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none border border-gray-100 dark:border-gray-700/50 p-6 flex flex-col md:flex-row items-center gap-8 relative hover:border-indigo-500/50 dark:hover:border-indigo-500/50 transition-all duration-300 group overflow-hidden">
                            {{-- Decorative Background Glow --}}
                            <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-500/10 transition-colors"></div>

                            {{-- Status Badge (Floating) --}}
                            <div class="absolute top-6 right-8 md:static shrink-0">
                                @if($p->post_test_score === null)
                                    <div class="flex items-center gap-1 px-2.5 py-0.5 bg-gray-100 dark:bg-gray-700/50 rounded-full border border-gray-200 dark:border-gray-600 animate-pulse">
                                        <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                        <span class="text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Pending</span>
                                    </div>
                                @elseif($isPassed)
                                    <div class="flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-full border border-emerald-100 dark:border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                        <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Passed</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1 px-2.5 py-0.5 bg-rose-50 dark:bg-rose-500/10 rounded-full border border-rose-100 dark:border-rose-500/20 shadow-[0_0_15px_rgba(244,63,94,0.1)]">
                                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]"></div>
                                        <span class="text-[9px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest">Failed</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Trainee Profile Section --}}
                            <div class="flex items-center gap-6 w-full md:w-auto md:min-w-[280px]">
                                {{-- Enhanced Photo --}}
                                <div class="w-20 h-24 shrink-0 rounded-2xl overflow-hidden bg-gray-50 dark:bg-gray-900 border-2 border-white dark:border-gray-700 shadow-xl group-hover:border-indigo-400 transition-colors relative">
                                    @if($photo)
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tighter leading-none group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $p->name }}</h3>
                                    <p class="text-[11px] font-bold text-indigo-500 mt-1.5 flex items-center gap-1.5 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-500/10 w-fit px-2 py-0.5 rounded-md">
                                        {{ $p->npk ?? '-' }}
                                    </p>
                                    
                                    <div class="mt-4 flex flex-col gap-0.5">
                                        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest font-mono">{{ $p->subco ?? 'SDI' }}</p>
                                        <p class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-tight truncate">{{ $p->department ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Charts Visual Section --}}
                            <div class="flex-1 w-full grid grid-cols-1 lg:grid-cols-12 gap-4 h-auto lg:h-34">
                                {{-- Bar Chart (Exam) --}}
                                <div class="lg:col-span-6 h-34 lg:h-full relative bg-gray-50/30 dark:bg-gray-900/20 rounded-2xl border border-gray-100/50 dark:border-gray-700/30 p-3">
                                    <div class="absolute top-1.5 left-3">
                                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Exam Result</span>
                                    </div>
                                    <canvas id="examChart_{{ $p->id }}"></canvas>
                                </div>

                                {{-- Radar Chart (Soft Skills) --}}
                                <div class="lg:col-span-6 h-34 lg:h-full relative bg-gray-50/30 dark:bg-gray-900/20 rounded-2xl border border-gray-100/50 dark:border-gray-700/30 p-1">
                                    <div class="absolute top-1.5 left-0 right-0 text-center">
                                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Soft Skills</span>
                                    </div>
                                    <canvas id="evalRadar_{{ $p->id }}"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CSI EVALUATION (DUMMY DATA) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    CSI Evaluation (Trainer & Class)
                </h2>
                <div class="flex items-center gap-2">
                    @if(!$training->is_approved)
                        <a href="{{ route('admin.trainings.csi_template', $training) }}"
                            class="px-3 py-1 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-black rounded-lg uppercase hover:bg-emerald-100 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Template CSI
                        </a>
                        <button onclick="document.getElementById('importCsiModal').classList.remove('hidden')"
                            class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black rounded-lg uppercase hover:bg-indigo-100 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Import CSI CSV
                        </button>
                        <button onclick="document.getElementById('manualCsiModal').classList.remove('hidden')"
                            class="px-3 py-1 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] font-black rounded-lg uppercase hover:bg-amber-100 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Manual Input CSI
                        </button>
                    @endif
                </div>
            </div>

            @php
                $evalData = optional($training->evaluation)->data ?? null;
                $trainersDataArr = data_get($evalData, 'trainers', []);
                $assignedTrainers = $training->trainers ?? [];
                
                // Auto-sync with Master Training if the current list is empty or minimal
                if (count($assignedTrainers) <= 1) {
                    $master = \App\Models\MasterTraining::where($training->master_training_id ? ['id' => $training->master_training_id] : ['training_id' => $training->id])->first();
                    if ($master && !empty($master->trainers) && count($master->trainers) > count($assignedTrainers)) {
                        $assignedTrainers = $master->trainers;
                    }
                }

                $trainersForJs = [];
                if (count($assignedTrainers) > 0) {
                    foreach ($assignedTrainers as $tr) {
                        $matchedData = null;
                        $trName = trim($tr['name'] ?? '');
                        
                        foreach ($trainersDataArr as $td) {
                            if (mb_strtolower(trim($td['name'] ?? '')) === mb_strtolower($trName)) {
                                $matchedData = $td;
                                break;
                            }
                        }
                        
                        if ($matchedData) {
                            $trainersForJs[] = $matchedData;
                        } else {
                            $trainersForJs[] = [
                                'name' => $trName,
                                'photo' => $tr['photo'] ?? null,
                                'scores' => [],
                                'feedback' => [],
                                'impressions' => []
                            ];
                        }
                    }
                } else {
                    if (!empty($trainersDataArr)) {
                        $trainersForJs = $trainersDataArr;
                    } else {
                        $trainersForJs[] = [
                            'name' => $training->user->name ?? 'Unknown Trainer',
                            'photo' => $training->user->photo ?? null,
                            'scores' => [],
                            'feedback' => [],
                            'impressions' => []
                        ];
                    }
                }
            @endphp

            <div class="space-y-8">
                {{-- Top: Trainer Evaluation (Dark Navy Theme) --}}
                <div class="space-y-6">
                    @foreach($trainersForJs as $index => $trainerData)
                        @php
                            $tScores = $trainerData['scores'] ?? [];
                            $tAvg = count($tScores) > 0 ? round(array_sum($tScores) / count($tScores), 2) : 4.67;
                        @endphp
                        <div class="bg-white dark:bg-[#1c2235] rounded-xl overflow-hidden shadow-sm dark:shadow-lg border border-gray-100 dark:border-gray-700/50">
                            <div class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-gray-100 dark:divide-white/5">
                                {{-- Profile & Radar (8 cols) --}}
                                <div class="lg:col-span-8 p-6 md:p-8">
                                    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                                        {{-- Profile Photo Left --}}
                                        <div
                                            class="w-32 h-44 shrink-0 rounded-2xl overflow-hidden bg-indigo-600 dark:bg-[#4270f2] shadow-xl border border-white/20 relative">
                                            @if($trainerData['photo'])
                                                <img src="{{ asset('storage/' . $trainerData['photo']) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Right Side of Left Panel (Header + Radar) --}}
                                        <div class="flex-1 w-full">
                                            <div class="flex justify-between items-start mb-6">
                                                <div>
                                                    <h3
                                                        class="text-xl md:text-2xl font-bold text-indigo-950 dark:text-white uppercase tracking-tight">
                                                        {{ $trainerData['name'] }}</h3>
                                                    <p
                                                        class="text-[10px] md:text-xs font-bold text-indigo-500 uppercase tracking-widest mt-1">
                                                        Instructor</p>
                                                </div>
                                                <div class="text-right">
                                                    <p
                                                        class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1">
                                                        Avg Score</p>
                                                    <p
                                                        class="text-3xl md:text-4xl font-semibold text-indigo-500 leading-none">
                                                        {{ $tAvg }}</p>
                                                </div>
                                            </div>

                                            <div
                                                class="relative w-full aspect-square md:aspect-auto md:h-64 flex items-center justify-center">
                                                <canvas id="csiRadarChart_{{ $index }}" width="100%" height="100%"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Feedback & Impressions Right (4 cols) --}}
                                <div class="lg:col-span-4 p-6 md:p-8 space-y-8 bg-indigo-50/30 dark:bg-[#161a2b]" x-data="{ showAllFeedback: false, showAllImpressions: false }">
                                    <div>
                                        <h4
                                            class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Trainer Feedback
                                        </h4>
                                        <div class="space-y-3">
                                            @php
                                                $rawFeedbacks = (array) ($trainerData['feedback'] ?? []);
                                                $aggregatedFeedbacks = [];
                                                foreach ($rawFeedbacks as $f) {
                                                    $f = trim($f);
                                                    if (!isset($aggregatedFeedbacks[$f])) $aggregatedFeedbacks[$f] = 0;
                                                    $aggregatedFeedbacks[$f]++;
                                                }
                                                // Sort by count descending
                                                arsort($aggregatedFeedbacks);
                                                $feedbackItems = [];
                                                foreach ($aggregatedFeedbacks as $text => $count) {
                                                    $feedbackItems[] = $count > 1 ? "$text ($count peserta)" : $text;
                                                }
                                            @endphp

                                            @forelse($feedbackItems as $index => $feedback)
                                                <p
                                                    class="text-xs text-gray-600 dark:text-[#a0aabf] italic border-l border-indigo-500/30 pl-3 leading-relaxed {{ $index >= 5 ? 'print:block' : '' }}"
                                                    x-show="{{ $index >= 5 ? 'showAllFeedback' : 'true' }}"
                                                    {{ $index >= 5 ? 'x-cloak' : '' }}>
                                                    '{{ $feedback }}'
                                                </p>
                                            @empty
                                                <p class="text-xs text-gray-600 italic">No feedback provided.</p>
                                            @endforelse

                                            @if(count($feedbackItems) > 5)
                                                <button @click="showAllFeedback = !showAllFeedback" 
                                                    class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
                                                    <span x-text="showAllFeedback ? 'Tampilkan Lebih Sedikit' : 'Lihat ' + ({{ count($feedbackItems) }} - 5) + ' feedback lainnya'"></span>
                                                    <svg class="w-3 h-3 transition-transform" :class="showAllFeedback ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <h4
                                            class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Trainer Impression
                                        </h4>
                                        <div class="space-y-3">
                                            @php
                                                $rawImpressions = (array) ($trainerData['impressions'] ?? []);
                                                $aggregatedImpressions = [];
                                                foreach ($rawImpressions as $i) {
                                                    $i = trim($i);
                                                    if (!isset($aggregatedImpressions[$i])) $aggregatedImpressions[$i] = 0;
                                                    $aggregatedImpressions[$i]++;
                                                }
                                                arsort($aggregatedImpressions);
                                                $impressionItems = [];
                                                foreach ($aggregatedImpressions as $text => $count) {
                                                    $impressionItems[] = $count > 1 ? "$text ($count peserta)" : $text;
                                                }
                                            @endphp

                                            @forelse($impressionItems as $index => $impression)
                                                <p
                                                    class="text-xs font-semibold text-gray-600 dark:text-[#a0aabf] border-l border-indigo-500/30 pl-3 leading-relaxed {{ $index >= 5 ? 'print:block' : '' }}"
                                                    x-show="{{ $index >= 5 ? 'showAllImpressions' : 'true' }}"
                                                    {{ $index >= 5 ? 'x-cloak' : '' }}>
                                                    "{{ $impression }}"
                                                </p>
                                            @empty
                                                <p class="text-xs text-gray-600 italic">No impression provided.</p>
                                            @endforelse

                                            @if(count($impressionItems) > 5)
                                                <button @click="showAllImpressions = !showAllImpressions" 
                                                    class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
                                                    <span x-text="showAllImpressions ? 'Tampilkan Lebih Sedikit' : 'Lihat ' + ({{ count($impressionItems) }} - 5) + ' kesan lainnya'"></span>
                                                    <svg class="w-3 h-3 transition-transform" :class="showAllImpressions ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Bottom: Class Evaluation (3 Columns: D1, D2, D3) --}}
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- D1. TRAINER --}}
                        <div class="p-5 bg-white dark:bg-[#1c2235] rounded-xl shadow-sm dark:shadow-lg border border-gray-100 dark:border-gray-700/50">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-3 h-px bg-gray-500"></span> D1. TRAINER
                            </h4>
                            <div class="h-80">
                                <canvas id="csiClassTrainerBar"></canvas>
                            </div>
                        </div>

                        {{-- D2. SUBJECT --}}
                        <div class="p-5 bg-white dark:bg-[#1c2235] rounded-xl shadow-sm dark:shadow-lg border border-gray-100 dark:border-gray-700/50">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-3 h-px bg-gray-500"></span> D2. SUBJECT
                            </h4>
                            <div class="h-80">
                                <canvas id="csiSubjectChart"></canvas>
                            </div>
                        </div>

                        {{-- D3. OPERATIONAL --}}
                        <div class="p-5 bg-white dark:bg-[#1c2235] rounded-xl shadow-sm dark:shadow-lg border border-gray-100 dark:border-gray-700/50">
                            <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-3 h-px bg-gray-500"></span> D3. OPERATIONAL
                            </h4>
                            <div class="h-80">
                                <canvas id="csiOperationalChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ showAllVoiceOps: false, showAllVoiceSub: false }">
                        {{-- Voice of Trainee (Operational) - Green Accent --}}
                        <div class="p-6 bg-emerald-50/50 dark:bg-[#1c2235] rounded-xl shadow-sm dark:shadow-lg border border-emerald-100 dark:border-emerald-500/20 relative group overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500/50"></div>
                            <div class="flex justify-between items-center mb-6">
                                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">VOICE OF TRAINEE (OPERATIONAL)</p>
                                <a href="{{ route('summaries.show', $training) }}" class="text-[9px] font-bold text-gray-600 dark:text-[#a0aabf]/50 hover:text-emerald-500 uppercase tracking-tighter transition-colors">BUAT RINGKASAN</a>
                            </div>
                            @php 
                                $voiceOpsRaw = (array) data_get($evalData, 'qualitative.voice_operational', []);
                                $aggVoiceOps = [];
                                foreach ($voiceOpsRaw as $vo) {
                                    $vo = trim($vo);
                                    if (!isset($aggVoiceOps[$vo])) $aggVoiceOps[$vo] = 0;
                                    $aggVoiceOps[$vo]++;
                                }
                                arsort($aggVoiceOps);
                                $voiceOpsItems = [];
                                foreach ($aggVoiceOps as $text => $count) {
                                    $voiceOpsItems[] = $count > 1 ? "$text ($count peserta)" : $text;
                                }
                            @endphp
                            <div class="space-y-3">
                                @forelse($voiceOpsItems as $index => $vop)
                                    <p class="text-xs text-gray-600 dark:text-[#a0aabf] italic leading-relaxed pl-3 border-l border-emerald-500/30 {{ $index >= 5 ? 'print:block' : '' }}"
                                       x-show="{{ $index >= 5 ? 'showAllVoiceOps' : 'true' }}"
                                       {{ $index >= 5 ? 'x-cloak' : '' }}>
                                        "{{ $vop }}"
                                    </p>
                                @empty
                                    <p class="text-xs text-gray-600 italic">No feedback provided.</p>
                                @endforelse

                                @if(count($voiceOpsItems) > 5)
                                    <button @click="showAllVoiceOps = !showAllVoiceOps" 
                                        class="text-[10px] font-bold text-emerald-400 hover:text-emerald-300 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
                                        <span x-text="showAllVoiceOps ? 'Tampilkan Lebih Sedikit' : 'Lihat ' + ({{ count($voiceOpsItems) }} - 5) + ' masukan lainnya'"></span>
                                        <svg class="w-3 h-3 transition-transform" :class="showAllVoiceOps ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Voice of Trainee (Subject) - Orange Accent --}}
                        <div class="p-6 bg-orange-50/50 dark:bg-[#1c2235] rounded-xl shadow-sm dark:shadow-lg border border-orange-100 dark:border-orange-500/20 relative group overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-orange-500/50"></div>
                            <div class="flex justify-between items-center mb-6">
                                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">VOICE OF TRAINEE (SUBJECT)</p>
                                <a href="{{ route('summaries.show', $training) }}" class="text-[9px] font-bold text-gray-600 dark:text-[#a0aabf]/50 hover:text-orange-500 uppercase tracking-tighter transition-colors">BUAT RINGKASAN</a>
                            </div>
                            @php 
                                $voiceSubRaw = (array) data_get($evalData, 'qualitative.voice_subject', []);
                                $aggVoiceSub = [];
                                foreach ($voiceSubRaw as $vs) {
                                    $vs = trim($vs);
                                    if (!isset($aggVoiceSub[$vs])) $aggVoiceSub[$vs] = 0;
                                    $aggVoiceSub[$vs]++;
                                }
                                arsort($aggVoiceSub);
                                $voiceSubItems = [];
                                foreach ($aggVoiceSub as $text => $count) {
                                    $voiceSubItems[] = $count > 1 ? "$text ($count peserta)" : $text;
                                }
                            @endphp
                            <div class="space-y-3">
                                @forelse($voiceSubItems as $index => $vsb)
                                    <p class="text-xs text-gray-600 dark:text-[#a0aabf] italic leading-relaxed pl-3 border-l border-orange-500/30 {{ $index >= 5 ? 'print:block' : '' }}"
                                       x-show="{{ $index >= 5 ? 'showAllVoiceSub' : 'true' }}"
                                       {{ $index >= 5 ? 'x-cloak' : '' }}>
                                        "{{ $vsb }}"
                                    </p>
                                @empty
                                    <p class="text-xs text-gray-600 italic">No feedback provided.</p>
                                @endforelse

                                @if(count($voiceSubItems) > 5)
                                    <button @click="showAllVoiceSub = !showAllVoiceSub" 
                                        class="text-[10px] font-bold text-orange-400 hover:text-orange-300 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
                                        <span x-text="showAllVoiceSub ? 'Tampilkan Lebih Sedikit' : 'Lihat ' + ({{ count($voiceSubItems) }} - 5) + ' masukan lainnya'"></span>
                                        <svg class="w-3 h-3 transition-transform" :class="showAllVoiceSub ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECOMMENDATION FOR NEXT PARTICIPANT --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                Recommendation for next Participant
            </h2>

            <form action="{{ route('summaries.store', $training) }}" method="POST">
                @csrf
                <div class="relative group">
                    <textarea name="recommendation" rows="4"
                        class="w-full bg-gray-50 dark:bg-[#111111] border-gray-200 dark:border-white/5 rounded-2xl p-6 text-gray-900 dark:text-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder:text-gray-400 dark:placeholder:text-gray-600 italic"
                        placeholder="Berikan rekomendasi untuk peserta atau pelatihan selanjutnya (misal: penambahan materi visual, durasi lebih lama, dsb)...">{{ old('recommendation', $training->summary->recommendation ?? '') }}</textarea>

                    <div
                        class="absolute top-4 right-4 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H13.017C12.4647 8 12.017 8.44772 12.017 9V15C12.017 15.5523 11.5693 16 11.017 16H8.01705C7.46477 16 7.01705 16.4477 7.01705 17V21M7.01705 21H3.01705C2.46477 21 2.01705 20.5523 2.01705 20V14C2.01705 13.4477 2.46477 13 3.01705 13H9.01705C9.56933 13 10.017 13.4477 10.017 14V20C10.017 20.5523 9.56933 21 9.01705 21" />
                        </svg>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-white/5">
                    <div>
                        <x-input-label for="checked_by"
                            class="text-[10px] font-black text-gray-500 dark:text-white/40 uppercase mb-2">Checked By (Section
                            Head)</x-input-label>
                        <input type="text" name="checked_by" id="checked_by" list="users-list"
                            value="{{ old('checked_by', $training->summary->checked_by ?? '') }}"
                            class="w-full bg-gray-50 dark:bg-[#111111] border-gray-200 dark:border-white/5 rounded-xl px-4 py-2.5 text-gray-900 dark:text-gray-200 text-sm focus:ring-1 focus:ring-indigo-500"
                            placeholder="Nama Section Head">
                    </div>
                    <div>
                        <x-input-label for="confirmed_by"
                            class="text-[10px] font-black text-gray-500 dark:text-white/40 uppercase mb-2">Confirmed By (Dept
                            Head)</x-input-label>
                        <input type="text" name="confirmed_by" id="confirmed_by" list="users-list"
                            value="{{ old('confirmed_by', $training->summary->confirmed_by ?? '') }}"
                            class="w-full bg-gray-50 dark:bg-[#111111] border-gray-200 dark:border-white/5 rounded-xl px-4 py-2.5 text-gray-900 dark:text-gray-200 text-sm focus:ring-1 focus:ring-indigo-500"
                            placeholder="Nama Dept Head">
                    </div>
                </div>

                {{-- Datalist for Autocomplete --}}
                <datalist id="users-list">
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->npk }}</option>
                    @endforeach
                </datalist>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-8 rounded-xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Data Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- TRAINING ATMOSPHERE (REAL GALLERY) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="w-8 h-[1px] bg-gray-200 dark:bg-gray-700"></span>
                    TRAINING ATMOSPHERE
                </h2>
                <button onclick="document.getElementById('addAtmosphereModal').classList.remove('hidden')"
                    class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black rounded-lg uppercase hover:bg-indigo-100 transition-colors flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Dokumentasi
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($training->atmospheres as $atmosphere)
                    <div
                        class="group relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                        <div class="aspect-video overflow-hidden relative">
                            <img src="{{ asset('storage/' . $atmosphere->image_path) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $atmosphere->title }}">

                            {{-- Delete Button --}}
                            <form action="{{ route('admin.trainings.atmospheres.destroy', $atmosphere) }}" method="POST"
                                class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="confirmAction(event, 'Hapus dokumentasi ini?')"
                                    class="p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="bg-[#1a1a1a] p-4 text-center">
                            <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-1">
                                {{ $atmosphere->title }}
                            </p>
                            <p class="text-xs font-bold text-white mb-0.5">{{ $atmosphere->subtitle }}</p>
                            @if(Storage::disk('public')->exists($atmosphere->image_path))
                                <p class="text-[9px] text-white/50 mb-1 font-bold">
                                    {{ number_format(Storage::disk('public')->size($atmosphere->image_path) / 1048576, 2) }} MB
                                </p>
                            @else
                                <p class="text-[9px] text-red-400 mb-1 font-bold">
                                    File Missing
                                </p>
                            @endif
                            @if($atmosphere->description)
                                <p class="text-[10px] text-white/40 font-medium">{{ $atmosphere->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($training->atmospheres->count() === 0)
                    <div
                        class="lg:col-span-3 py-12 flex flex-col items-center justify-center border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-3xl">
                        <div
                            class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada dokumentasi</p>
                        <button onclick="document.getElementById('addAtmosphereModal').classList.remove('hidden')"
                            class="mt-4 text-indigo-600 font-bold text-xs uppercase hover:underline">Tambah
                            Sekarang</button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Add Atmosphere Modal --}}
        <div id="addAtmosphereModal"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[60]">
            <div
                class="relative top-20 mx-auto p-8 border-0 w-full max-w-md shadow-2xl rounded-3xl bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 tracking-tighter uppercase">Tambah
                        Dokumentasi</h3>
                    <button onclick="document.getElementById('addAtmosphereModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.trainings.atmospheres.store', $training) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pilih
                            Gambar</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 dark:border-gray-700 border-dashed rounded-2xl hover:border-indigo-400 transition-colors group">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-indigo-400 transition-colors"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input name="image" type="file" class="sr-only" required accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 italic">PNG, JPG (Max 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Title
                            (Header Hitam)</label>
                        <input type="text" name="title" required placeholder="p.g. OPENING CEREMONY:"
                            class="w-full bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-bold uppercase tracking-widest placeholder:text-gray-400">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Subtitle
                            (Teks Tengah)</label>
                        <input type="text" name="subtitle" required placeholder="p.g. Manager Class, Trainee & Trainer"
                            class="w-full bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-bold">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Description
                            (Teks Kecil Bawah)</label>
                        <input type="text" name="description" placeholder="p.g. (Trainee)"
                            class="w-full bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-medium italic">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest shadow-xl shadow-indigo-200 dark:shadow-none transition-all">Simpan
                            Dokumentasi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Riwayat Approval --}}
        @if($training->approvals->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Riwayat Approval</h2>
                <div class="space-y-3">
                    @foreach($training->approvals as $approval)
                        <div class="flex items-start gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div
                                class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                                                                                                                                                                                                                                                                                                                                {{ $approval->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $approval->level }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $approval->approver->name ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $approval->note ?? 'Tidak ada catatan' }}
                                </p>
                            </div>
                            <span
                                class="text-xs font-medium {{ $approval->status === 'approved' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $approval->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Import CSI Modal --}}
        <div id="importCsiModal"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[60]">
            <div
                class="relative top-20 mx-auto p-8 border-0 w-full max-w-md shadow-2xl rounded-3xl bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 tracking-tighter uppercase">Import
                        CSI Data</h3>
                    <button onclick="document.getElementById('importCsiModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.trainings.import_csi', $training) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pilih
                            File Excel / CSV (CSI)</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 dark:border-gray-700 border-dashed rounded-2xl hover:border-indigo-400 transition-colors group">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-indigo-400 transition-colors"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload CSV file</span>
                                        <input name="file" type="file" class="sr-only" required accept=".csv">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">Supports .csv only</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest shadow-xl shadow-indigo-200 dark:shadow-none transition-all">Import
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="importObservationModal"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[60]">
            <div
                class="relative top-20 mx-auto p-8 border-0 w-full max-w-md shadow-2xl rounded-3xl bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 tracking-tighter uppercase">Import
                        Observasi</h3>
                    <button onclick="document.getElementById('importObservationModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('trainings.import_observation', $training) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pilih
                            File Excel (Observasi)</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 dark:border-gray-700 border-dashed rounded-2xl hover:border-orange-400 transition-colors group">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-orange-400 transition-colors"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                        <span>Upload Excel file</span>
                                        <input name="file" type="file" class="sr-only" required accept=".xlsx,.xls,.csv"
                                            onchange="updateFileName(this, 'obs-file-name')">
                                    </label>
                                </div>
                                <p id="obs-file-name" class="text-xs text-gray-500 mt-2 font-medium">Supports .xlsx,
                                    .xls</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest shadow-xl shadow-orange-200 dark:shadow-none transition-all">Import
                            Data</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Google Sheets Observation Sync Modal --}}
        <div id="syncObservationModal"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[60]">
            <div class="relative top-20 mx-auto p-8 border-0 w-full max-w-md shadow-2xl rounded-3xl bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 tracking-tighter uppercase">Sync Google Sheets Obs</h3>
                    <button onclick="document.getElementById('syncObservationModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <p class="text-xs text-gray-500 font-medium">Masukkan link Google Sheets yang sudah di-"Publish to Web" sebagai CSV.</p>
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">URL Google Sheets</label>
                        <input type="url" id="obs-google-sheets-url" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                            placeholder="https://docs.google.com/spreadsheets/d/.../edit?usp=sharing">
                    </div>

                    <div id="obs-sync-loading" class="hidden">
                        <div class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Sinkronisasi sedang berjalan...</span>
                        </div>
                    </div>

                    <button onclick="syncGoogleSheetsObservation()" id="obs-sync-button"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest shadow-xl shadow-emerald-200 dark:shadow-none transition-all">
                        Mulai Sinkronisasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input, targetId) {
            const fileName = input.files[0]?.name;
            if (fileName) {
                document.getElementById(targetId).textContent = fileName;
                document.getElementById(targetId).classList.add('text-indigo-600', 'dark:text-indigo-400', 'font-bold');
                  }
    }
    </script>

    @php
        $displayParticipants = $training->participants;
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const labelColor = isDark ? '#9CA3AF' : '#475569';
            const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

            // ---- PER-PARTICIPANT VISUALIZATION CHARTS ----
            const participantsData = {!! json_encode($displayParticipants->map(function($p) use ($training) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'pre' => (float)$p->pre_test_score,
                    'post' => (float)$p->post_test_score,
                    'is_passed' => $p->post_test_score >= $training->passing_grade,
                    'soft' => [
                        (float)($p->punctuality_score ?? 0),
                        (float)($p->activeness_score ?? 0),
                        (float)($p->cooperation_score ?? 0),
                        (float)($p->attitude_score ?? 0)
                    ]
                ];
            })) !!};

            const passingGrade = {{ (float) $training->passing_grade }};

            participantsData.forEach(p => {
                // 1. Exam Result Chart (Bar with Target Line)
                const examCtx = document.getElementById('examChart_' + p.id);
                if (examCtx) {
                    new Chart(examCtx, {
                        type: 'bar',
                        data: {
                            labels: ['PRE', 'POST'],
                            datasets: [{
                                data: [p.pre || 0, p.post || 0],
                                backgroundColor: function(context) {
                                    const chart = context.chart;
                                    const {ctx, chartArea} = chart;
                                    if (!chartArea) return null;
                                    
                                    const gradientBlue = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                                    gradientBlue.addColorStop(0, 'rgba(79, 70, 229, 0.7)');
                                    gradientBlue.addColorStop(1, 'rgba(129, 140, 248, 1)');

                                    const gradientEmerald = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                                    gradientEmerald.addColorStop(0, 'rgba(16, 185, 129, 0.7)');
                                    gradientEmerald.addColorStop(1, 'rgba(52, 211, 153, 1)');

                                    const gradientRose = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                                    gradientRose.addColorStop(0, 'rgba(225, 29, 72, 0.7)');
                                    gradientRose.addColorStop(1, 'rgba(251, 113, 133, 1)');

                                    if (context.dataIndex === 0) return gradientBlue;
                                    return p.is_passed ? gradientEmerald : gradientRose;
                                },
                                borderRadius: 8,
                                barThickness: 28,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: { padding: { top: 25, bottom: 5 } },
                            plugins: {
                                legend: { display: false },
                                tooltip: { 
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: { size: 10, weight: 'bold' },
                                    bodyFont: { size: 10 },
                                    padding: 10,
                                    cornerRadius: 8,
                                    displayColors: false
                                }
                            },
                            scales: {
                                y: {
                                    display: true,
                                    min: 0, max: 100,
                                    grid: { display: true, color: gridColor, drawBorder: false },
                                    ticks: { font: { size: 8, weight: '600' }, stepSize: 50, color: labelColor }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 9, weight: '900' }, color: labelColor, padding: 5 }
                                }
                            }
                        },
                        plugins: [{
                            id: 'chartPlugins',
                            afterDraw: (chart) => {
                                const { ctx, chartArea: { left, right }, scales: { x, y } } = chart;
                                
                                // Draw Target Line (Dashed)
                                const yPos = y.getPixelForValue(passingGrade);
                                if (yPos >= 0) {
                                    ctx.save();
                                    ctx.setLineDash([5, 5]); // SET DASHED LINE
                                    ctx.beginPath();
                                    ctx.moveTo(left, yPos);
                                    ctx.lineTo(right, yPos);
                                    ctx.lineWidth = 1.5;
                                    ctx.strokeStyle = 'rgba(251, 146, 60, 0.8)';
                                    ctx.stroke();
                                    
                                    // Target Label
                                    ctx.fillStyle = 'rgba(251, 146, 60, 0.8)';
                                    ctx.font = 'bold 8px Inter, sans-serif';
                                    ctx.fillText('TARGET: ' + passingGrade, right - 45, yPos - 5);
                                    ctx.restore();
                                }

                                // Draw Value Labels
                                chart.data.datasets.forEach((dataset, i) => {
                                    chart.getDatasetMeta(i).data.forEach((bar, index) => {
                                        const value = dataset.data[index];
                                        if (value > 0) {
                                            ctx.fillStyle = '#64748b';
                                            ctx.font = 'black 11px Inter, sans-serif';
                                            ctx.textAlign = 'center';
                                            ctx.fillText(Math.round(value), bar.x, bar.y - 12);
                                        }
                                    });
                                });
                            }
                        }]
                    });
                }

                // 2. Trainee Evaluation Radar
                const radarCtx = document.getElementById('evalRadar_' + p.id);
                if (radarCtx) {
                    new Chart(radarCtx, {
                        type: 'radar',
                        data: {
                            labels: ['Punctuality', 'Activeness', 'Cooperation', 'Attitude'],
                            datasets: [{
                                data: p.soft,
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                borderColor: 'rgba(99, 102, 241, 0.6)',
                                borderWidth: 1.5,
                                pointRadius: 3,
                                pointBackgroundColor: '#6366f1'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: { 
                                padding: {
                                    top: 20,
                                    right: 35,
                                    bottom: 20,
                                    left: 35
                                } 
                            }, 
                            plugins: { legend: { display: false } },
                            scales: {
                                r: {
                                    min: 0, max: 5,
                                    ticks: { display: false, stepSize: 1 },
                                    grid: { color: gridColor },
                                    angleLines: { color: gridColor },
                                    pointLabels: { 
                                        font: { size: 5.5, weight: '700' }, 
                                        color: labelColor,
                                        padding: 0
                                    }
                                }
                            }
                        },
                        plugins: [{
                            id: 'radarValues',
                            afterDraw: (chart) => {
                                const { ctx, scales: { r } } = chart;
                                chart.data.datasets[0].data.forEach((value, i) => {
                                    const point = r.getPointPositionForValue(i, value);
                                    ctx.fillStyle = '#6366f1';
                                    ctx.font = 'bold 9px Inter, sans-serif';
                                    ctx.textAlign = 'center';
                                    // Offset the text based on position
                                    let yOffset = value > 4 ? (point.y < r.y ? -10 : 15) : (point.y < r.y ? -5 : 10);
                                    ctx.fillText(value.toFixed(1).replace('.', ','), point.x, point.y + yOffset);
                                });
                            }
                        }]
                    });
                }
            });

            // ---- CSI DATA ----
            @php
                $evalData = optional($training->evaluation)->data ?? null;
                $trainersForJsJson = json_encode($trainersForJs ?? []);
                $subjectScores = $evalData['subject'] ?? [];
                $operationalScores = $evalData['operational'] ?? [];
            @endphp

            const trainersDataJs = {!! $trainersForJsJson !!};

            trainersDataJs.forEach((trainer, index) => {
                const csiRadarCtx = document.getElementById('csiRadarChart_' + index);
                if (csiRadarCtx) {
                    const scores = trainer.scores || {};
                    new Chart(csiRadarCtx, {
                        type: 'radar',
                        data: {
                            labels: ['Sikap', 'Penguasaan Materi', 'Penyajian Materi', 'Antusiasme', 'Pengendalian Waktu', 'Penguasaan Kelas', 'Penampilan', 'Penyimpulan'],
                            datasets: [{
                                label: trainer.name || 'Trainer',
                                data: [
                                    scores[25] ?? 0,
                                    scores[26] ?? 0,
                                    scores[27] ?? 0,
                                    scores[28] ?? 0,
                                    scores[29] ?? 0,
                                    scores[30] ?? 0,
                                    scores[31] ?? 0,
                                    scores[32] ?? 0
                                ],
                                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                                borderColor: '#6366f1',
                                borderWidth: 2,
                                pointBackgroundColor: '#818cf8',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    min: 0, max: 5,
                                    ticks: { stepSize: 1, display: false },
                                    grid: { color: gridColor },
                                    angleLines: { color: gridColor },
                                    pointLabels: { font: { size: 10, weight: 'bold' }, color: labelColor }
                                }
                            },
                            plugins: { legend: { display: false } }
                        }
                    });
                }
            });

            const csiSubjectCtx = document.getElementById('csiSubjectChart');
            if (csiSubjectCtx) {
                new Chart(csiSubjectCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Sistematika Penyampaian', 'Kesiapan Penyampaian', 'Manfaat Materi', 'Relevansi Materi'],
                        datasets: [{
                            data: [
                                {{ $subjectScores[14] ?? 0 }},
                                {{ $subjectScores[13] ?? 0 }},
                                {{ $subjectScores[12] ?? 0 }},
                                {{ $subjectScores[11] ?? 0 }}
                            ],
                            backgroundColor: '#f59e0b',
                            borderRadius: 6,
                            barThickness: 24,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { 
                                min: 0, max: 5, 
                                grid: { color: gridColor },
                                border: { display: false },
                                ticks: { color: labelColor, font: { size: 10 } }
                            },
                            y: { 
                                grid: { display: false }, 
                                ticks: { color: labelColor, font: { size: 9, weight: '500' } } 
                            }
                        }
                    }
                });
            }

            const csiOperationalCtx = document.getElementById('csiOperationalChart');
            if (csiOperationalCtx) {
                new Chart(csiOperationalCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Waktu', 'Suasana', 'Konsumsi', 'Fasilitas Mengajar', 'Tempat Pelaksanaan'],
                        datasets: [{
                            data: [
                                {{ $operationalScores[20] ?? 0 }},
                                {{ $operationalScores[19] ?? 0 }},
                                {{ $operationalScores[18] ?? 0 }},
                                {{ $operationalScores[17] ?? 0 }},
                                {{ $operationalScores[16] ?? 0 }}
                            ],
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            barThickness: 20,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { 
                                min: 0, max: 5, 
                                grid: { color: gridColor },
                                border: { display: false },
                                ticks: { color: labelColor, font: { size: 10 } }
                            },
                            y: { 
                                grid: { display: false }, 
                                ticks: { color: labelColor, font: { size: 9, weight: '500' } } 
                            }
                        }
                    }
                });
            }

            // New D1 Trainer Bar Chart
            const csiClassTrainerCtx = document.getElementById('csiClassTrainerBar');
            if (csiClassTrainerCtx) {
                @php
                    $allTrainerScores = [];
                    foreach ($trainersForJs as $ct) {
                        foreach (($ct['scores'] ?? []) as $sc_id => $s) {
                            if ($sc_id >= 25 && $sc_id <= 32) {
                                $allTrainerScores[$sc_id][] = $s;
                            }
                        }
                    }
                    $avgTrainerScores = [];
                    for ($i = 25; $i <= 32; $i++) {
                        $vals = $allTrainerScores[$i] ?? [];
                        $avgTrainerScores[] = count($vals) > 0 ? round(array_sum($vals) / count($vals), 2) : 0;
                    }
                @endphp
                new Chart(csiClassTrainerCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Sikap', 'Penguasaan Materi', 'Penyajian Materi', 'Antusiasme', 'Pengendalian Waktu', 'Penguasaan Kelas', 'Penampilan', 'Penyimpulan'],
                        datasets: [{
                            data: {!! json_encode($avgTrainerScores) !!},
                            backgroundColor: '#6366f1',
                            borderRadius: 6,
                            barThickness: 16,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { 
                                min: 0, max: 5, 
                                grid: { color: gridColor },
                                border: { display: false },
                                ticks: { color: labelColor, font: { size: 10 } }
                            },
                            y: { 
                                grid: { display: false }, 
                                ticks: { color: labelColor, font: { size: 9, weight: '500' } } 
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script>
        function toggleAttendance(participantId, button) {
            const originalContent = button.innerHTML;
            button.innerHTML = '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200"><svg class="animate-spin h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>...</span>';
            button.disabled = true;

            fetch(`/participants/${participantId}/toggle-attendance`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (data.is_present) {
                            button.innerHTML = '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">✓ Hadir</span>';
                        } else {
                            button.innerHTML = '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">✗ Tidak</span>';
                        }
                    } else {
                        button.innerHTML = originalContent;
                        alert('Gagal mengubah status kehadiran.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.innerHTML = originalContent;
                    alert('Terjadi kesalahan koneksi.');
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        function updateScore(participantId, type, value) {
            fetch(`/participants/${participantId}/update-score`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type, value: value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update Attendance UI if it was changed (Auto-Hadir)
                    const btn = document.getElementById(`attendance-btn-${participantId}`);
                    if (data.is_present && btn) {
                        btn.innerHTML = '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">✓ Hadir</span>';
                    }

                    // Update Pass/Fail status dynamically if type is post_test
                    if (type === 'post_test') {
                        const statusCell = document.getElementById(`pass-fail-status-${participantId}`);
                        const passingGrade = {{ (float) $training->passing_grade }};
                        if (statusCell) {
                            if (value !== '' && value !== null) {
                                const score = parseFloat(value);
                                if (score >= passingGrade) {
                                    statusCell.innerHTML = '<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Pass</span>';
                                } else {
                                    statusCell.innerHTML = '<span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Fail</span>';
                                }
                            } else {
                                statusCell.innerHTML = '<span class="text-gray-400 text-xs">-</span>';
                            }
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error updating score:', error);
            });
        }

        function saveAllScores() {
            const btn = document.getElementById('btn-save-all');
            const inputs = document.querySelectorAll('input[data-table-input]');

            // Disable button while saving
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Menyimpan...`;

            // Trigger blur on all inputs to fire existing updateScore() calls
            inputs.forEach(input => {
                input.blur();
            });

            // After a short delay, restore button and show success toast
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Data`;

                // Show toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-green-600 text-white px-5 py-3 rounded-2xl shadow-2xl text-sm font-bold transition-all duration-500 opacity-0 translate-y-4';
                toast.innerHTML = `
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Data berhasil disimpan!`;
                document.body.appendChild(toast);

                // Animate in
                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                });

                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-4');
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
            }, 800);
        }

        function handleTableKey(e) {
            const keys = ['ArrowRight', 'ArrowLeft', 'ArrowUp', 'ArrowDown', 'Enter'];
            if (!keys.includes(e.key)) return;

            const inputs = Array.from(document.querySelectorAll('input[data-table-input]'));
            const index = inputs.indexOf(e.target);
            if (index === -1) return;

            const cols = 7; // Fixed columns: Pre, Post, Punc, Act, Coop, Att, Subco
            let nextIndex = -1;

            if (e.key === 'ArrowRight' || e.key === 'Enter') {
                nextIndex = index + 1;
            } else if (e.key === 'ArrowLeft') {
                nextIndex = index - 1;
            } else if (e.key === 'ArrowDown') {
                nextIndex = index + cols;
            } else if (e.key === 'ArrowUp') {
                nextIndex = index - cols;
            }

            if (nextIndex >= 0 && nextIndex < inputs.length) {
                e.preventDefault();
                inputs[nextIndex].focus();
                inputs[nextIndex].select();
            }
        }
    </script>

    {{-- CSI SCANNER MODAL --}}
    <div id="csiScannerModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeCsiScanner()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Scan Barcode/QR CSI</h3>
                        <button onclick="closeCsiScanner()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div id="csi-reader" class="w-full aspect-square bg-gray-100 dark:bg-gray-800 rounded-3xl overflow-hidden relative">
                        <div id="csi-scanner-loading" class="absolute inset-0 flex items-center justify-center bg-gray-900/50 z-10 hidden">
                             <div class="animate-spin rounded-full h-12 w-12 border-4 border-indigo-500 border-t-transparent"></div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3">
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold text-center italic">Scan QR, Upload Gambar QR, atau tempelkan JSON</p>
                        
                        <div class="flex flex-col gap-2">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Upload File QR (Gambar)</label>
                            <input type="file" id="csi-qr-file" accept="image/*" class="w-full text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all">
                        </div>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center text-[10px] uppercase font-bold">
                                <span class="bg-white dark:bg-gray-900 px-2 text-gray-400">Atau Manual</span>
                            </div>
                        </div>

                        <textarea id="csi-manual-json" rows="2" class="w-full px-3 py-2 text-xs bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Paste JSON data di sini..."></textarea>
                        <button onclick="processManualJson()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all">Proses Manual</button>
                    </div>
                </div>
            </div>
                    </div>
                </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrScannerForCsi = null;

        function openCsiScanner() {
            document.getElementById('csiScannerModal').classList.remove('hidden');
            if (!html5QrScannerForCsi) {
                html5QrScannerForCsi = new Html5Qrcode("csi-reader");
            }
            
            // Add listener for file upload once
            const fileInput = document.getElementById('csi-qr-file');
            if (fileInput && !fileInput.dataset.listenerAdded) {
                fileInput.addEventListener('change', e => {
                    if (e.target.files.length === 0) return;
                    
                    document.getElementById('csi-scanner-loading').classList.remove('hidden');
                    const imageFile = e.target.files[0];
                    
                    html5QrScannerForCsi.scanFile(imageFile, true)
                        .then(decodedText => {
                            submitCsiJson(decodedText);
                        })
                        .catch(err => {
                            console.error("Error scanning file", err);
                            alert("Gagal membaca QR dari gambar. Pastikan gambar jelas dan berisi QR valid.");
                            document.getElementById('csi-scanner-loading').classList.add('hidden');
                        });
                });
                fileInput.dataset.listenerAdded = "true";
            }

            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            html5QrScannerForCsi.start(
                { facingMode: "environment" },
                config,
                onCsiScanSuccess
            ).catch(err => {
                console.error("Scanning failed", err);
            });
        }

        function closeCsiScanner() {
            if (html5QrScannerForCsi && html5QrScannerForCsi.isScanning) {
                html5QrScannerForCsi.stop().then(() => {
                    document.getElementById('csiScannerModal').classList.add('hidden');
                });
            } else {
                document.getElementById('csiScannerModal').classList.add('hidden');
            }
        }

        function onCsiScanSuccess(decodedText) {
            submitCsiJson(decodedText);
        }

        function processManualJson() {
            const jsonData = document.getElementById('csi-manual-json').value;
            if (jsonData) submitCsiJson(jsonData);
        }

        function submitCsiJson(jsonData) {
            document.getElementById('csi-scanner-loading').classList.remove('hidden');
            
            fetch("{{ route('admin.trainings.import_csi_json', $training) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ json_data: jsonData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses data.');
            })
            .finally(() => {
                document.getElementById('csi-scanner-loading').classList.add('hidden');
            });
        }
    </script>

    {{-- GOOGLE SHEETS SYNC MODAL --}}


    {{-- CSI MANUAL INPUT MODAL --}}
    <div id="manualCsiModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('manualCsiModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-flex align-middle bg-white dark:bg-gray-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100 dark:border-gray-800 flex-col max-h-[90vh] relative z-[61]">
                {{-- Fixed Header --}}
                <div class="px-10 py-7 border-b border-gray-100 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md z-[70] flex justify-between items-center shrink-0">
                    <div class="flex flex-col gap-1.5">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight flex items-center gap-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-amber-500 shadow-[0_0_12px_rgba(245,158,11,0.6)]"></span>
                            Manual CSI Input (Trainer)
                        </h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-6 opacity-80">Penilaian performa instruktur oleh peserta ke dalam sistem</p>
                    </div>
                    <button onclick="document.getElementById('manualCsiModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition-all bg-gray-100 hover:bg-red-50 dark:bg-gray-800 dark:hover:bg-red-900/30 rounded-2xl p-2.5 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Scrollable Body --}}
                <div class="flex-1 overflow-y-auto p-10 scrollbar-hide bg-white dark:bg-gray-900 relative">
                    {{-- Thick Left Border Decorative --}}
                    <div class="absolute left-0 top-0 w-1.5 h-full bg-gradient-to-b from-amber-500 via-amber-400 to-amber-600 opacity-20"></div>

                    <form action="{{ route('admin.trainings.manual_csi', $training) }}" method="POST" x-data="manualCsiForm()" id="manualCsiFormElement">
                        @csrf
                        
                        {{-- Trainer Tabs Navigation --}}
                        <div class="flex items-center gap-2 mb-8 bg-gray-100/50 dark:bg-gray-800/30 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 w-fit">
                            <template x-for="(trainer, tIndex) in trainers" :key="'tab-'+tIndex">
                                <button type="button" 
                                    @click="activeTab = tIndex"
                                    class="px-5 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all flex items-center gap-2"
                                    :class="activeTab === tIndex 
                                        ? 'bg-white dark:bg-gray-700 text-amber-600 dark:text-amber-400 shadow-sm border border-gray-200/50 dark:border-gray-600' 
                                        : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-700/50'">
                                    <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[9px]" 
                                        :class="activeTab === tIndex ? 'bg-amber-100 dark:bg-amber-900/50' : 'bg-gray-200 dark:bg-gray-800'">
                                        <span x-text="tIndex + 1"></span>
                                    </span>
                                    <span x-text="trainer.name || 'Trainer ' + (tIndex + 1)"></span>
                                </button>
                            </template>
                        </div>

                        <template x-for="(trainer, tIndex) in trainers" :key="tIndex">
                            <div x-show="activeTab === tIndex" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="space-y-8">
                                
                                <div class="p-6 bg-gray-50/50 dark:bg-gray-800/20 rounded-3xl border border-gray-200 dark:border-gray-700/50 shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500 rounded-l-3xl"></div>
                                    <div class="flex items-center gap-5 mb-8 pb-6 border-b border-gray-200/60 dark:border-gray-700/50">
                                        <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-amber-600 dark:text-amber-400 font-black shadow-inner border border-amber-200/50 dark:border-amber-800/50 text-xl overflow-hidden relative group">
                                            <template x-if="trainer.photo">
                                                <img :src="'/storage/' + trainer.photo" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!trainer.photo">
                                                <span x-text="(trainer.name || '?').substring(0, 1).toUpperCase()"></span>
                                            </template>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 opacity-70">Identitas Instruktur</label>
                                            <input type="text" x-model="trainer.name" :name="'trainers['+tIndex+'][name]'" class="w-full bg-transparent border-none text-2xl font-black p-0 focus:ring-0 text-gray-900 dark:text-white placeholder-gray-300 dark:placeholder-gray-700 leading-none" placeholder="Masukkan nama..." required>
                                            <input type="hidden" x-model="trainer.photo" :name="'trainers['+tIndex+'][photo]'">
                                        </div>
                                    </div>

                                {{-- 8 Radar Scores --}}
                                <div class="mb-8">
                                    <h4 class="text-[11px] font-black text-amber-600 uppercase tracking-widest mb-5 flex items-center gap-2 bg-amber-50 dark:bg-amber-900/20 inline-flex px-3 py-1 rounded-lg border border-amber-100 dark:border-amber-800/30">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg> 
                                        Radar Scores (0.00 - 5.00)
                                    </h4>
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                        <template x-for="(label, key) in radarLabels" :key="key">
                                            <div class="bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:border-amber-300 dark:hover:border-amber-700 transition-colors">
                                                <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 truncate" x-text="label.name"></label>
                                                <div class="relative">
                                                    <input type="number" step="0.01" min="0" max="5" 
                                                        x-model="trainer.scores[label.id]" 
                                                        :name="'trainers['+tIndex+'][scores]['+label.id+']'" 
                                                        @keydown="handleKey($event)"
                                                        data-csi-input
                                                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent font-black text-gray-900 dark:text-white" required>
                                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 font-bold text-xs opacity-50">/ 5</div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    {{-- Feedback --}}
                                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Trainer Feedback
                                            </h4>
                                            <button type="button" @click="addFeedback(tIndex)" class="text-[9px] font-black text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-all uppercase flex items-center gap-1 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah
                                            </button>
                                        </div>
                                        <div class="space-y-3 max-h-56 overflow-y-auto pr-2 scrollbar-hide">
                                            <template x-for="(fb, fIndex) in trainer.feedback" :key="'fb-'+fIndex">
                                                <div class="flex items-start gap-2 group">
                                                    <div class="mt-2.5 w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0"></div>
                                                    <div class="flex-1">
                                                        <textarea rows="2" x-model="trainer.feedback[fIndex]" :name="'trainers['+tIndex+'][feedback][]'" class="w-full px-3 py-2 text-xs text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent italic placeholder-gray-400 resize-none transition-all" placeholder="Tulis masukan di sini..." maxlength="100"></textarea>
                                                        <div class="text-[9px] font-bold text-gray-400 text-right mt-1 px-1">
                                                            <span x-text="(trainer.feedback[fIndex] || '').length"></span> / 100
                                                        </div>
                                                    </div>
                                                    <button type="button" @click="removeFeedback(tIndex, fIndex)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100 mt-0.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </template>
                                            <div x-show="trainer.feedback.length === 0" class="flex flex-col items-center justify-center py-6 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50/50 dark:bg-gray-800/50">
                                                <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Belum ada feedback.</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Impressions --}}
                                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-[10px] font-black text-purple-500 uppercase tracking-widest flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Trainer Impression
                                            </h4>
                                            <button type="button" @click="addImpression(tIndex)" class="text-[9px] font-black text-purple-600 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-all uppercase flex items-center gap-1 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah
                                            </button>
                                        </div>
                                        <div class="space-y-3 max-h-56 overflow-y-auto pr-2 scrollbar-hide">
                                            <template x-for="(imp, iIndex) in trainer.impressions" :key="'imp-'+iIndex">
                                                <div class="flex items-start gap-2 group">
                                                    <div class="mt-2.5 w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600 shrink-0"></div>
                                                    <div class="flex-1">
                                                        <textarea rows="2" x-model="trainer.impressions[iIndex]" :name="'trainers['+tIndex+'][impressions][]'" class="w-full px-3 py-2 text-xs text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-medium placeholder-gray-400 resize-none transition-all" placeholder="Tulis kesan di sini..." maxlength="100"></textarea>
                                                        <div class="text-[9px] font-bold text-gray-400 text-right mt-1 px-1">
                                                            <span x-text="(trainer.impressions[iIndex] || '').length"></span> / 100
                                                        </div>
                                                    </div>
                                                    <button type="button" @click="removeImpression(tIndex, iIndex)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100 mt-0.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </template>
                                            <div x-show="trainer.impressions.length === 0" class="flex flex-col items-center justify-center py-6 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50/50 dark:bg-gray-800/50">
                                                <svg class="w-6 h-6 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Belum ada impression.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- D2 & D3: Class Evaluation --}}
                        <div class="mb-4 mt-12 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-emerald-500 rounded-full"></span>
                            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider">Evaluasi Kelas (Subject & Operational)</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            {{-- D2. Subject --}}
                            <div class="p-6 bg-gray-50/50 dark:bg-gray-800/20 rounded-2xl border border-gray-200 dark:border-gray-700/50 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500 rounded-l-2xl"></div>
                                <h4 class="text-[11px] font-black text-emerald-600 uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    D2. Subject Scores
                                </h4>
                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    <template x-for="(label, key) in subjectLabels" :key="key">
                                        <div class="bg-white dark:bg-gray-800/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                                            <label class="block text-[9px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 truncate" x-text="label.name"></label>
                                            <div class="relative">
                                                <input type="number" step="0.01" min="0" max="5" 
                                                    x-model="subjectScores[label.id]" 
                                                    :name="'subject['+label.id+']'" 
                                                    @keydown="handleKey($event)"
                                                    data-csi-input
                                                    class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-black text-gray-900 dark:text-white" required>
                                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 font-bold text-xs opacity-50">/ 5</div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h5 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Voice of Subject</h5>
                                        <button type="button" @click="voiceSubject.push('')" class="text-[9px] font-black text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-all uppercase flex items-center gap-1 shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah
                                        </button>
                                    </div>
                                    <div class="space-y-2 max-h-40 overflow-y-auto pr-2 scrollbar-hide">
                                        <template x-for="(vs, vIndex) in voiceSubject" :key="'vs-'+vIndex">
                                            <div class="flex gap-2 group">
                                                <div class="flex-1">
                                                    <textarea rows="2" x-model="voiceSubject[vIndex]" name="voice_subject[]" class="w-full px-3 py-2 text-xs text-gray-900 dark:text-white bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent italic placeholder-gray-400 resize-none transition-all" placeholder="Tulis Voice of Subject..." maxlength="100"></textarea>
                                                    <div class="text-[9px] font-bold text-gray-400 text-right mt-1 px-1">
                                                        <span x-text="(voiceSubject[vIndex] || '').length"></span> / 100
                                                    </div>
                                                </div>
                                                <button type="button" @click="voiceSubject.splice(vIndex, 1)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100 mt-0.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </template>
                                        <p x-show="voiceSubject.length === 0" class="text-xs text-gray-400 italic text-center py-4">Belum ada feedback Subject.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- D3. Operational --}}
                            <div class="p-6 bg-gray-50/50 dark:bg-gray-800/20 rounded-2xl border border-gray-200 dark:border-gray-700/50 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500 rounded-l-2xl"></div>
                                <h4 class="text-[11px] font-black text-blue-600 uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    D3. Operational Scores
                                </h4>
                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    <template x-for="(label, key) in operationalLabels" :key="key">
                                        <div class="bg-white dark:bg-gray-800/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover:border-blue-300 dark:hover:border-blue-700 transition-colors">
                                            <label class="block text-[9px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2 truncate" x-text="label.name"></label>
                                            <div class="relative">
                                                <input type="number" step="0.01" min="0" max="5" 
                                                    x-model="operationalScores[label.id]" 
                                                    :name="'operational['+label.id+']'" 
                                                    @keydown="handleKey($event)"
                                                    data-csi-input
                                                    class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-black text-gray-900 dark:text-white" required>
                                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 font-bold text-xs opacity-50">/ 5</div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h5 class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Voice of Operational</h5>
                                        <button type="button" @click="voiceOperational.push('')" class="text-[9px] font-black text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-all uppercase flex items-center gap-1 shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah
                                        </button>
                                    </div>
                                    <div class="space-y-2 max-h-40 overflow-y-auto pr-2 scrollbar-hide">
                                        <template x-for="(vo, vIndex) in voiceOperational" :key="'vo-'+vIndex">
                                            <div class="flex gap-2 group">
                                                <div class="flex-1">
                                                    <textarea rows="2" x-model="voiceOperational[vIndex]" name="voice_operational[]" class="w-full px-3 py-2 text-xs text-gray-900 dark:text-white bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent italic placeholder-gray-400 resize-none transition-all" placeholder="Tulis Voice of Operational..." maxlength="100"></textarea>
                                                    <div class="text-[9px] font-bold text-gray-400 text-right mt-1 px-1">
                                                        <span x-text="(voiceOperational[vIndex] || '').length"></span> / 100
                                                    </div>
                                                </div>
                                                <button type="button" @click="voiceOperational.splice(vIndex, 1)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100 mt-0.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </template>
                                        <p x-show="voiceOperational.length === 0" class="text-xs text-gray-400 italic text-center py-4">Belum ada feedback Operational.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                {{-- Fixed Footer --}}
                <div class="px-8 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50 backdrop-blur-md shrink-0 flex flex-col-reverse sm:flex-row gap-3 justify-end">
                    <button type="button" onclick="document.getElementById('manualCsiModal').classList.add('hidden')" class="px-5 py-2 font-bold text-gray-500 hover:text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-xl transition-all uppercase tracking-widest text-[9px] hover:shadow-sm active:scale-95">
                        Batal
                    </button>
                    <button type="submit" form="manualCsiFormElement" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-indigo-100 dark:shadow-none flex items-center justify-center gap-2 text-[9px] group active:scale-95">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data CSI
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Participant Modal -->
    <div id="editParticipantModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[100] transition-all duration-300">
        <div class="relative top-20 mx-auto p-0 border-none w-[440px] shadow-2xl rounded-[2.5rem] bg-white dark:bg-[#1a1f2e] overflow-hidden animate-fade-in-up">
            <div class="px-8 pt-8 pb-6 bg-gradient-to-br from-indigo-50/50 to-transparent dark:from-indigo-500/5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-100 dark:shadow-none flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-wider">Edit Data Peserta</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Form Perubahan Informasi</p>
                        </div>
                    </div>
                    <button onclick="closeEditParticipantModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            
            <form id="editParticipantForm" onsubmit="submitEditParticipantForm(event)" class="px-8 pb-8 space-y-5">
                <input type="hidden" id="edit_participant_id">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" id="edit_p_name" required 
                        class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-2xl text-sm font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Identitas NPK</label>
                    <div class="px-5 py-4 bg-gray-100 dark:bg-gray-900/30 border border-gray-200 dark:border-gray-800 rounded-2xl text-sm font-mono font-bold text-gray-500 dark:text-gray-400 flex items-center justify-between">
                        <span id="edit_p_npk_display"></span>
                        <svg class="w-4 h-4 opacity-30" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Departemen</label>
                        <input type="text" id="edit_p_department" required 
                            class="w-full px-5 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-2xl text-[11px] font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Sub Co</label>
                        <input type="text" id="edit_p_subco" 
                            class="w-full px-5 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-2xl text-[11px] font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                            placeholder="...">
                    </div>
                </div>
                <div class="pt-6 flex gap-3">
                    <button type="submit" 
                        class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-indigo-500/30 transition-all active:scale-[0.97] flex items-center justify-center gap-2 group">
                        <span>Simpan Perubahan</span>
                    </button>
                    <button type="button" onclick="closeEditParticipantModal()" 
                        class="px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-200 dark:hover:bg-gray-700 transition-all active:scale-[0.97]">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const trainersDataJs = {!! json_encode($trainersForJs) !!};

        // --- QUICK SEARCH TO ADD PARTICIPANT ---
        const quickSearchInput = document.getElementById('quick-search-participant');
        const searchSuggestions = document.getElementById('quick-search-suggestions');

        if (quickSearchInput) {
            quickSearchInput.addEventListener('input', function() {
                const query = this.value;
                if (query.length < 3) {
                    searchSuggestions.classList.add('hidden');
                    return;
                }

                fetch(`/trainings/search-users?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            searchSuggestions.innerHTML = data.map(user => `
                                <div class="px-4 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-3 group text-left" 
                                    onclick="addSelectedParticipant('${user.name}', '${user.npk}', '${user.department}', '${user.subco}')">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-gray-800 dark:text-white truncate uppercase">${user.name}</p>
                                        <p class="text-[9px] text-indigo-500 font-bold uppercase tracking-widest">${user.npk} • ${user.department}</p>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100">
                                        <span class="text-[9px] font-black bg-indigo-600 text-white px-2 py-1 rounded">ADD</span>
                                    </div>
                                </div>
                            `).join('');
                            searchSuggestions.classList.remove('hidden');
                        } else {
                            searchSuggestions.innerHTML = '<div class="px-4 py-3 text-xs text-gray-400 italic">Tidak ditemukan...</div>';
                            searchSuggestions.classList.remove('hidden');
                        }
                    });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('#quick-search-participant') && !e.target.closest('#quick-search-suggestions')) {
                    searchSuggestions.classList.add('hidden');
                }
            });
        }

        function addSelectedParticipant(name, npk, department, subco) {
            fetch(`{{ route('trainings.participants.store', $training) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, npk, department, subco })
            })
            .then(res => res.json())
            .then(() => window.location.reload())
            .catch(() => window.location.reload());
        }

        function toggleManualAddRow() {
            const row = document.getElementById('manual-add-row');
            row.classList.toggle('hidden');
            if (!row.classList.contains('hidden')) {
                document.getElementById('manual_npk_input').focus();
            }
        }

        function submitInlineManualAdd() {
            const name = document.getElementById('manual_name_input').value;
            const npk = document.getElementById('manual_npk_input').value;
            const department = document.getElementById('manual_dept_input').value;
            const subco = document.getElementById('manual_subco_input').value;

            if (!name) {
                alert('Nama harus diisi.');
                return;
            }

            const btn = document.querySelector('#manual-add-row button');
            btn.innerText = 'WAIT...';
            btn.disabled = true;

            fetch(`{{ route('trainings.participants.store', $training) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, npk, department, subco })
            })
            .then(res => res.json())
            .then(() => window.location.reload())
            .catch(() => window.location.reload());
        }

        function openEditParticipantModal(participant) {
            document.getElementById('edit_participant_id').value = participant.id;
            document.getElementById('edit_p_name').value = participant.name;
            document.getElementById('edit_p_npk_display').innerText = participant.npk || '-';
            document.getElementById('edit_p_department').value = participant.department || '';
            document.getElementById('edit_p_subco').value = participant.subco || '';
            document.getElementById('editParticipantModal').classList.remove('hidden');
        }

        function closeEditParticipantModal() {
            document.getElementById('editParticipantModal').classList.add('hidden');
        }

        function submitEditParticipantForm(e) {
            e.preventDefault();
            const id = document.getElementById('edit_participant_id').value;
            const name = document.getElementById('edit_p_name').value;
            const department = document.getElementById('edit_p_department').value;
            const subco = document.getElementById('edit_p_subco').value;
            
            const btn = e.target.querySelector('button[type="submit"]');
            btn.innerText = 'Menyimpan...';
            btn.disabled = true;

            const updateField = (field, value) => {
                return fetch(`/participants/${id}/update-field`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field, value })
                });
            };

            Promise.all([
                updateField('name', name),
                updateField('department', department),
                updateField('subco', subco)
            ]).then(() => window.location.reload())
              .catch(() => window.location.reload());
        }

        document.addEventListener('alpine:init', () => {
            if (typeof Alpine !== 'undefined') {
                registerManualCsiData();
            }
        });

        // Fallback for safety
        if (typeof Alpine !== 'undefined') {
            registerManualCsiData();
        }

        function registerManualCsiData() {
            if (window.manualCsiDataRegistered) return;
            window.manualCsiDataRegistered = true;
            
            Alpine.data('manualCsiForm', () => ({
                activeTab: 0,
                trainers: [],
                subjectScores: {},
                operationalScores: {},
                voiceSubject: [],
                voiceOperational: [],
                radarLabels: [
                    { id: 25, name: 'Sikap' },
                    { id: 26, name: 'Penguasaan Materi' },
                    { id: 27, name: 'Penyajian Materi' },
                    { id: 28, name: 'Antusiasme' },
                    { id: 29, name: 'Pengendalian Waktu' },
                    { id: 30, name: 'Penguasaan Kelas' },
                    { id: 31, name: 'Penampilan' },
                    { id: 32, name: 'Penyimpulan' },
                ],
                subjectLabels: [
                    { id: 11, name: 'Relevansi Materi' },
                    { id: 12, name: 'Manfaat Materi' },
                    { id: 13, name: 'Kesiapan Penyampaian' },
                    { id: 14, name: 'Sistematika Penyampaian' }
                ],
                operationalLabels: [
                    { id: 16, name: 'Tempat Pelaksanaan' },
                    { id: 17, name: 'Fasilitas Mengajar' },
                    { id: 18, name: 'Konsumsi' },
                    { id: 19, name: 'Suasana' },
                    { id: 20, name: 'Waktu' }
                ],
                init() {
                    let existingData = typeof trainersDataJs !== 'undefined' ? trainersDataJs : [];
                    if (existingData.length > 0) {
                        this.trainers = JSON.parse(JSON.stringify(existingData));
                        
                        this.trainers.forEach(t => {
                            if (!t.scores) t.scores = {};
                            this.radarLabels.forEach(l => {
                                if (t.scores[l.id] === undefined) t.scores[l.id] = null;
                            });
                            if (!t.feedback) t.feedback = [];
                            if (!t.impressions) t.impressions = [];
                        });
                    } else {
                        // fallback to 1 empty trainer
                        this.trainers = [{
                            name: "{{ $training->user->name ?? 'Trainer 1' }}",
                            photo: "{{ $training->user->photo ?? '' }}",
                            scores: { 25:null, 26:null, 27:null, 28:null, 29:null, 30:null, 31:null, 32:null },
                            feedback: [],
                            impressions: []
                        }];
                    }

                    // Init Subject & Operational Data
                    const sScores = {!! json_encode(data_get($evalData, 'subject', [])) !!};
                    this.subjectLabels.forEach(l => {
                        this.subjectScores[l.id] = sScores[l.id] !== undefined ? sScores[l.id] : null;
                    });

                    const oScores = {!! json_encode(data_get($evalData, 'operational', [])) !!};
                    this.operationalLabels.forEach(l => {
                        this.operationalScores[l.id] = oScores[l.id] !== undefined ? oScores[l.id] : null;
                    });

                    const qualitative = {!! json_encode(data_get($evalData, 'qualitative', [])) !!};
                    this.voiceSubject = qualitative['voice_subject'] || [];
                    this.voiceOperational = qualitative['voice_operational'] || [];
                },
                addFeedback(tIndex) {
                    this.trainers[tIndex].feedback.push('');
                },
                removeFeedback(tIndex, fIndex) {
                    this.trainers[tIndex].feedback.splice(fIndex, 1);
                },
                addImpression(tIndex) {
                    this.trainers[tIndex].impressions.push('');
                },
                removeImpression(tIndex, iIndex) {
                    this.trainers[tIndex].impressions.splice(iIndex, 1);
                },
                handleKey(e) {
                    const keys = ['ArrowRight', 'ArrowLeft', 'ArrowUp', 'ArrowDown', 'Enter'];
                    if (!keys.includes(e.key)) return;

                    // Only find inputs that are visible (not in hidden trainer tabs)
                    const inputs = Array.from(document.querySelectorAll('#manualCsiModal input[data-csi-input]'))
                        .filter(input => input.closest('[x-show]') ? (input.offsetParent !== null) : true);
                    
                    const index = inputs.indexOf(e.target);
                    if (index === -1) return;

                    let nextIndex = -1;
                    // Detect current grid columns
                    const grid = e.target.closest('.grid');
                    let cols = 2; // default
                    if (grid) {
                        if (grid.classList.contains('lg:grid-cols-4')) {
                            cols = window.innerWidth >= 1024 ? 4 : 2;
                        } else if (grid.classList.contains('md:grid-cols-2')) {
                            cols = 2;
                        }
                    }

                    if (e.key === 'ArrowRight' || e.key === 'Enter') {
                        nextIndex = index + 1;
                    } else if (e.key === 'ArrowLeft') {
                        nextIndex = index - 1;
                    } else if (e.key === 'ArrowDown') {
                        nextIndex = index + cols;
                    } else if (e.key === 'ArrowUp') {
                        nextIndex = index - cols;
                    }

                    if (nextIndex >= 0 && nextIndex < inputs.length) {
                        e.preventDefault();
                        inputs[nextIndex].focus();
                        inputs[nextIndex].select();
                    }
                }
            }));
        }

        // Initialize Radar Charts for all trainers
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof trainersDataJs !== 'undefined') {
                trainersDataJs.forEach((trainer, index) => {
                    const canvasId = 'csiRadarChart_' + index;
                    const canvas = document.getElementById(canvasId);
                    if (canvas) {
                        // Destroy existing chart if it exists to avoid "Canvas is already in use" error
                        const existingChart = Chart.getChart(canvasId) || Chart.getChart(canvas);
                        if (existingChart) {
                            existingChart.destroy();
                        }

                        const ctx = canvas.getContext('2d');
                        const rawScores = Object.values(trainer.scores || {}).map(v => parseFloat(v) || 0);
                        const data8 = rawScores.slice(0, 8);

                        new Chart(ctx, {
                            type: 'radar',
                            data: {
                                labels: ['Sikap', 'Penguasaan Materi', 'Penyajian Materi', 'Antusiasme', 'Pengendalian Waktu', 'Penguasaan Kelas', 'Penampilan', 'Penyimpulan'],
                                datasets: [{
                                    label: 'Score',
                                    data: data8,
                                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                                    borderColor: 'rgba(99, 102, 241, 0.8)',
                                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    r: {
                                        min: 0, max: 5,
                                        ticks: { display: false, stepSize: 1 },
                                        grid: { color: 'rgba(255,255,255,0.05)' },
                                        angleLines: { color: 'rgba(255,255,255,0.1)' },
                                        pointLabels: { color: '#94a3b8', font: { size: 9 } }
                                    }
                                },
                                plugins: { legend: { display: false } }
                            }
                        });
                    }
                });
            }
        });


        function syncGoogleSheetsObservation() {
            const url = document.getElementById('obs-google-sheets-url').value;
            if (!url) {
                alert('Silakan masukkan URL Google Sheets.');
                return;
            }

            const button = document.getElementById('obs-sync-button');
            const loading = document.getElementById('obs-sync-loading');

            button.disabled = true;
            button.classList.add('opacity-50');
            loading.classList.remove('hidden');

            fetch("{{ route('trainings.sync_observation', $training) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    google_sheets_url: url
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat sinkronisasi.');
            })
            .finally(() => {
                button.disabled = false;
                button.classList.remove('opacity-50');
                loading.classList.add('hidden');
            });
        }
    </script>
</x-admin-layout>
