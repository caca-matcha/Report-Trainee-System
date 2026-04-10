<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('admin.master-trainings.index') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline text-xs font-bold uppercase tracking-widest flex items-center gap-1">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        Kembali
                    </a>
                </div>
                <h1
                    class="text-2xl font-black bg-gradient-to-r from-gray-900 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent tracking-tight">
                    Persiapan Eksekusi: {{ $masterTraining->training_course }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">
                    Tinjau dan sesuaikan data pelaksanaan sebelum membuat laporan training baru.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div
                    class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-xl">
                    <div class="text-[10px] text-indigo-500 dark:text-indigo-400 font-black uppercase tracking-widest">
                        No. Training</div>
                    <div class="text-xs font-bold text-indigo-700 dark:text-indigo-300">{{ $masterTraining->event_no }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.master-trainings.store_execution', $masterTraining) }}" method="POST"
            id="execution-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                {{-- Left Column: Configuration Sidebar --}}
                <div class="lg:col-span-4 space-y-8">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <i data-lucide="settings-2" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-wider">
                                Konfigurasi</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Nama
                                    Training</label>
                                <div
                                    class="px-5 py-3.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent rounded-2xl text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $masterTraining->training_course }}
                                    <input type="hidden" name="title" value="{{ $masterTraining->training_course }}">
                                </div>
                            </div>

                            <div>
                                <label for="training_topic"
                                    class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Topic</label>
                                <textarea name="training_topic" id="training_topic" rows="3" required
                                    class="w-full px-5 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white placeholder-gray-400 resize-none min-h-[100px]">{{ old('training_topic', $masterTraining->training_topic) }}</textarea>
                            </div>

                            <div>
                                <label for="organizer"
                                    class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Penyelenggara</label>
                                <input type="text" name="organizer" id="organizer"
                                    value="{{ old('organizer', $masterTraining->provider) }}" required
                                    class="w-full px-5 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white placeholder-gray-400">
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 gap-5">
                                    <div>
                                        <label for="start_date"
                                            class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Tgl
                                            Mulai</label>
                                        <input type="date" name="start_date" id="start_date"
                                            value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                                            class="w-full px-5 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white appearance-none">
                                    </div>
                                    <div>
                                        <label for="end_date"
                                            class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Tgl
                                            Selesai</label>
                                        <input type="date" name="end_date" id="end_date"
                                            value="{{ old('end_date', now()->format('Y-m-d')) }}" required
                                            class="w-full px-5 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white appearance-none">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Estimasi
                                        Durasi</label>
                                    <div class="relative">
                                        <input type="text" id="duration_display" readonly value="1 Hari"
                                            class="w-full px-5 py-3.5 bg-indigo-50/50 dark:bg-indigo-900/20 border-none rounded-2xl text-xs font-black text-indigo-600 dark:text-indigo-400 cursor-not-allowed">
                                        <i data-lucide="calendar-check"
                                            class="absolute right-5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-indigo-500/40"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="passing_grade"
                                    class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Passing
                                    Grade (%)</label>
                                <div class="relative">
                                    <input type="number" name="passing_grade" id="passing_grade"
                                        value="{{ old('passing_grade', $masterTraining->passing_grade ?? 70) }}"
                                        required
                                        class="w-full pl-5 pr-12 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm font-black focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white">
                                    <span
                                        class="absolute right-5 inset-y-0 flex items-center text-xs font-black text-gray-400">%</span>
                                </div>
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Deskripsi
                                    / Catatan</label>
                                <textarea name="description" id="description" rows="2"
                                    placeholder="Tambahkan catatan khusus..."
                                    class="w-full px-5 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white placeholder-gray-400 italic">{{ old('description', $masterTraining->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-indigo-600 rounded-[2.5rem] p-8 shadow-2xl shadow-indigo-500/40 text-white relative overflow-hidden group">
                        <div
                            class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-sm font-black uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                Ready?
                            </h3>
                            <p class="text-[10px] text-indigo-100/70 mb-8 leading-relaxed font-medium">
                                Data peserta, trainer, dan PIC akan disinkronkan ke laporan training baru.
                            </p>
                            <button type="submit"
                                class="w-full py-5 bg-white text-indigo-600 rounded-2xl font-black uppercase tracking-widest text-xs hover:shadow-xl hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i data-lucide="fast-forward" class="w-4 h-4 fill-current"></i>
                                Buat Laporan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Personnel & Management --}}
                <div class="lg:col-span-8 space-y-8">
                    {{-- Personnel Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Trainers Card --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col h-full overflow-hidden">
                            <div class="p-8 border-b border-gray-50 dark:border-gray-700/50">
                                <div class="flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-sm border border-emerald-100 dark:border-emerald-800">
                                            <i data-lucide="award" class="w-5.5 h-5.5"></i>
                                        </div>
                                        <h3
                                            class="text-base font-black text-gray-900 dark:text-white uppercase tracking-wider">
                                            Trainers</h3>
                                    </div>
                                    <button type="button" id="btn-add-manual-trainer"
                                        class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 px-4 py-2 rounded-2xl transition-all border border-emerald-100 dark:border-emerald-800">+
                                        Manual</button>
                                </div>
                                <div class="mt-8 relative group">
                                    <input type="text" id="quick-search-trainer" placeholder="Cari trainer..."
                                        class="w-full pl-12 pr-6 py-4.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-emerald-500/30 focus:ring-8 focus:ring-emerald-500/5 rounded-3xl text-sm transition-all dark:text-white">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    <div id="quick-search-trainer-suggestions"
                                        class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl mt-4 hidden max-h-72 overflow-y-auto">
                                    </div>
                                </div>
                            </div>
                            <div id="trainer_list" class="flex-1 p-8 space-y-4 min-h-[160px]">
                                @php $trainers = old('trainers', $masterTraining->trainers ?? []); @endphp
                                @foreach($trainers as $index => $trainer)
                                    <div
                                        class="trainer-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-emerald-200 dark:hover:border-emerald-500/20 transition-all">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 font-bold shrink-0">
                                            {{ substr(is_array($trainer) ? ($trainer['name'] ?? '?') : $trainer, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-bold text-gray-900 dark:text-white leading-tight mb-0.5">{{ is_array($trainer) ? ($trainer['name'] ?? '') : $trainer }}</span>
                                                <span
                                                    class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter opacity-70">{{ is_array($trainer) ? ($trainer['npk'] ?? '-') : '-' }}</span>
                                            </div>
                                            <input type="hidden" name="trainers[{{ $index }}][name]"
                                                value="{{ is_array($trainer) ? ($trainer['name'] ?? '') : $trainer }}">
                                            <input type="hidden" name="trainers[{{ $index }}][npk]"
                                                value="{{ is_array($trainer) ? ($trainer['npk'] ?? '') : '' }}">
                                            <input type="hidden" name="trainers[{{ $index }}][department]"
                                                value="{{ is_array($trainer) ? ($trainer['department'] ?? '') : '' }}">
                                            <input type="hidden" name="trainers[{{ $index }}][subco]"
                                                value="{{ is_array($trainer) ? ($trainer['subco'] ?? '') : '' }}">
                                        </div>
                                        <button type="button"
                                            class="remove-trainer p-2 text-red-400 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                                @if(empty($trainers))
                                    <div
                                        class="h-full flex flex-col items-center justify-center py-6 text-gray-400 opacity-40">
                                        <i data-lucide="users-2" class="w-8 h-8 mb-2"></i>
                                        <p class="text-[10px] font-bold uppercase tracking-widest italic">Belum ada trainer
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- PIC Section --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col h-full overflow-hidden">
                            <div class="p-8 border-b border-gray-50 dark:border-gray-700/50">
                                <div class="flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-sm border border-blue-100 dark:border-blue-800">
                                            <i data-lucide="user-cog" class="w-5.5 h-5.5"></i>
                                        </div>
                                        <h3
                                            class="text-base font-black text-gray-900 dark:text-white uppercase tracking-wider">
                                            PICs</h3>
                                    </div>
                                    <button type="button" id="btn-add-manual-pic"
                                        class="text-[10px] font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 px-4 py-2 rounded-2xl transition-all border border-blue-100 dark:border-blue-800">+
                                        Manual</button>
                                </div>
                                <div class="mt-8 relative group">
                                    <input type="text" id="quick-search-pic" placeholder="Cari PIC..."
                                        class="w-full pl-12 pr-6 py-4.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500/30 focus:ring-8 focus:ring-blue-500/5 rounded-3xl text-sm transition-all dark:text-white">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    <div id="quick-search-pic-suggestions"
                                        class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl mt-4 hidden max-h-72 overflow-y-auto">
                                    </div>
                                </div>
                            </div>
                            <div id="pic_list" class="flex-1 p-8 space-y-4 min-h-[160px]">
                                @php $pics = old('pics', $masterTraining->pics ?? []); @endphp
                                @foreach($pics as $index => $pic)
                                    <div
                                        class="pic-row flex items-center gap-5 bg-gray-50 dark:bg-gray-900/40 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-blue-200 dark:hover:border-blue-500/10 transition-all shadow-sm">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold shrink-0 shadow-sm">
                                            {{ substr(is_array($pic) ? ($pic['name'] ?? '?') : $pic, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-bold text-gray-900 dark:text-white leading-tight mb-0.5">{{ is_array($pic) ? ($pic['name'] ?? '') : $pic }}</span>
                                                <span
                                                    class="text-[10px] font-black text-blue-500 uppercase tracking-tighter opacity-70">{{ is_array($pic) ? ($pic['npk'] ?? '-') : '-' }}</span>
                                            </div>
                                            <input type="hidden" name="pics[{{ $index }}][name]"
                                                value="{{ is_array($pic) ? ($pic['name'] ?? '') : $pic }}">
                                            <input type="hidden" name="pics[{{ $index }}][npk]"
                                                value="{{ is_array($pic) ? ($pic['npk'] ?? '') : '' }}">
                                            <input type="hidden" name="pics[{{ $index }}][department]"
                                                value="{{ is_array($pic) ? ($pic['department'] ?? '') : '' }}">
                                            <input type="hidden" name="pics[{{ $index }}][subco]"
                                                value="{{ is_array($pic) ? ($pic['subco'] ?? '') : '' }}">
                                        </div>
                                        <button type="button"
                                            class="remove-pic p-2.5 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl transition-colors opacity-0 group-hover:opacity-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                                @if(empty($pics))
                                    <div
                                        class="h-full flex flex-col items-center justify-center py-10 text-gray-400 opacity-40">
                                        <i data-lucide="user-check" class="w-10 h-10 mb-3"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest italic text-center">Belum
                                            ada PIC</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Participants Table Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                        <div
                            class="p-6 md:p-8 border-b border-gray-50 dark:border-gray-700/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-sm border border-indigo-100 dark:border-indigo-800">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3
                                        class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">
                                        Daftar Peserta Pelatihan</h3>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.1em] mt-1"><span
                                            id="participant_count"
                                            class="text-indigo-600 dark:text-indigo-400">{{ count($masterTraining->participants ?? []) }}</span>
                                        Peserta</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <button type="button" id="btn-add-manual-participant"
                                    class="px-5 py-3 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all border border-indigo-100 dark:border-indigo-800 whitespace-nowrap flex items-center gap-2">
                                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                                    Manual
                                </button>
                                <div class="relative flex-1 md:w-80 group">
                                    <input type="text" id="quick-search-participant" placeholder="Tambah peserta..."
                                        class="block w-full pl-12 pr-6 py-4 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500/30 focus:ring-8 focus:ring-indigo-500/5 rounded-3xl text-sm transition-all text-gray-900 dark:text-gray-100 shadow-sm">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                                    <div id="quick-search-suggestions"
                                        class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl mt-4 hidden max-h-96 overflow-y-auto">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-200 dark:scrollbar-thumb-indigo-900/50 scrollbar-track-transparent">
                            <div id="participant_grid" class="grid grid-cols-1 md:grid-cols-2 gap-4 p-8">
                                @php $participants = old('participants', $masterTraining->participants ?? []); @endphp
                                @forelse($participants as $index => $participant)
                                    <div class="participant-card group flex items-center gap-4 bg-gray-50/50 dark:bg-gray-900/40 p-4 rounded-[1.5rem] border border-gray-100 dark:border-gray-700/30 hover:border-indigo-200 dark:hover:border-indigo-500/20 transition-all animate-fade-in relative">
                                        <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-bold shrink-0 shadow-sm">
                                            {{ substr(is_array($participant) ? ($participant['name'] ?? '?') : $participant->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-gray-900 dark:text-white leading-tight mb-0.5 truncate group-hover:text-indigo-600 transition-colors uppercase">{{ is_array($participant) ? ($participant['name'] ?? '') : $participant->name }}</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[9px] font-black text-indigo-500/70 uppercase tracking-tighter">{{ is_array($participant) ? ($participant['npk'] ?? '-') : $participant->npk }}</span>
                                                    <span class="text-gray-300 dark:text-gray-700 text-[10px]">|</span>
                                                    <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase truncate">{{ is_array($participant) ? ($participant['department'] ?? '-') : $participant->department }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="participants[{{ $index }}][npk]" value="{{ is_array($participant) ? ($participant['npk'] ?? '') : $participant->npk }}">
                                            <input type="hidden" name="participants[{{ $index }}][name]" value="{{ is_array($participant) ? ($participant['name'] ?? '') : $participant->name }}">
                                            <input type="hidden" name="participants[{{ $index }}][department]" value="{{ is_array($participant) ? ($participant['department'] ?? '-') : $participant->department }}">
                                            <input type="hidden" name="participants[{{ $index }}][subco]" value="{{ is_array($participant) ? ($participant['subco'] ?? '-') : $participant->subco }}">
                                        </div>
                                        <button type="button" class="remove-participant absolute -right-1 -top-1 w-7 h-7 bg-white dark:bg-gray-800 text-red-500 rounded-full shadow-lg border border-red-50 dark:border-red-900/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:scale-110 active:scale-95">
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                @empty
                                    <div id="empty_grid_msg" class="col-span-full py-20 text-center opacity-30">
                                        <i data-lucide="user-plus" class="w-12 h-12 mx-auto mb-4"></i>
                                        <p class="text-xs font-black uppercase tracking-[0.2em] italic">Belum ada peserta terdaftar</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                lucide.createIcons();

                let trainerIndex = {{ count($trainers ?? []) }};
                let picIndex = {{ count($pics ?? []) }};
                let participantIndex = {{ count($participants ?? []) }};

                const trainerList = document.getElementById('trainer_list');
                const picList = document.getElementById('pic_list');
                const participantGrid = document.getElementById('participant_grid');

                // --- COMMON SEARCH LOGIC ---
                const highlightText = (text, query) => {
                    if (!query) return text;
                    const regex = new RegExp(`(${query})`, 'gi');
                    return text.replace(regex, '<mark class="bg-indigo-500/30 text-indigo-600 dark:text-indigo-200 rounded px-0.5">$1</mark>');
                };

                const performSearch = (query, suggestionsEl, onSelect) => {
                    if (query.length < 3) {
                        suggestionsEl.classList.add('hidden');
                        return;
                    }

                    fetch(`{{ route('admin.search-users') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                suggestionsEl.innerHTML = `
                                    <div class="p-3 border-b border-gray-50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/30">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2">Hasil Pencarian (${data.length})</p>
                                    </div>
                                    ${data.map(user => `
                                        <div class="suggestion-item px-5 py-4 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-5 group transition-all" 
                                             data-user='${JSON.stringify(user).replace(/'/g, "&apos;")}'>
                                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-black shrink-0 shadow-sm overflow-hidden group-hover:scale-105 transition-transform">
                                                ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0)}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-0.5">
                                                    <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">${highlightText(user.npk || '-', query)}</p>
                                                    <span class="text-gray-300 dark:text-gray-700">•</span>
                                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight truncate">${user.department || 'GENERAL'}</p>
                                                </div>
                                                <p class="text-sm font-black text-gray-800 dark:text-white truncate">${highlightText(user.name, query)}</p>
                                            </div>
                                            <div class="opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                                <span class="text-[10px] font-black bg-indigo-600 text-white px-3 py-1.5 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none">PILIH</span>
                                            </div>
                                        </div>
                                    `).join('')}
                                `;
                                suggestionsEl.classList.remove('hidden');

                                // Attach click events
                                suggestionsEl.querySelectorAll('.suggestion-item').forEach(item => {
                                    item.addEventListener('click', () => {
                                        onSelect(JSON.parse(item.dataset.user));
                                        suggestionsEl.classList.add('hidden');
                                    });
                                });
                            } else {
                                suggestionsEl.innerHTML = '<div class="px-8 py-8 text-center"><i data-lucide="search-x" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i><p class="text-xs text-gray-400 italic font-medium">Tidak ada hasil ditemukan.</p></div>';
                                suggestionsEl.classList.remove('hidden');
                                lucide.createIcons();
                            }
                        });
                };

                // --- TRAINER SEARCH ---
                const trainerInput = document.getElementById('quick-search-trainer');
                const trainerSug = document.getElementById('quick-search-trainer-suggestions');
                trainerInput.addEventListener('input', (e) => performSearch(e.target.value, trainerSug, addTrainerRow));

                function addTrainerRow(user) {
                    const emptyMsg = trainerList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="trainer-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-emerald-200 dark:hover:border-emerald-500/20 transition-all animate-fade-in">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 font-bold shrink-0">
                                ${user.name.charAt(0)}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 dark:text-white leading-tight mb-0.5">${user.name}</span>
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter opacity-70">${user.npk || '-'}</span>
                                </div>
                                <input type="hidden" name="trainers[${trainerIndex}][name]" value="${user.name}">
                                <input type="hidden" name="trainers[${trainerIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="trainers[${trainerIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="trainers[${trainerIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <button type="button" class="remove-trainer p-2 text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    `;
                    trainerList.insertAdjacentHTML('beforeend', html);
                    trainerIndex++;
                    trainerInput.value = '';
                    lucide.createIcons();
                }

                // --- PIC SEARCH ---
                const picInput = document.getElementById('quick-search-pic');
                const picSug = document.getElementById('quick-search-pic-suggestions');
                picInput.addEventListener('input', (e) => performSearch(e.target.value, picSug, addPicRow));

                function addPicRow(user) {
                    const emptyMsg = picList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="pic-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-blue-200 dark:hover:border-blue-500/20 transition-all animate-fade-in">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold shrink-0">
                                ${user.name.charAt(0)}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 dark:text-white leading-tight mb-0.5">${user.name}</span>
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-tighter opacity-70">${user.npk || '-'}</span>
                                </div>
                                <input type="hidden" name="pics[${picIndex}][name]" value="${user.name}">
                                <input type="hidden" name="pics[${picIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="pics[${picIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="pics[${picIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <button type="button" class="remove-pic p-2 text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    `;
                    picList.insertAdjacentHTML('beforeend', html);
                    picIndex++;
                    picInput.value = '';
                    lucide.createIcons();
                }

                // --- PARTICIPANT SEARCH ---
                const participantInput = document.getElementById('quick-search-participant');
                const participantSug = document.getElementById('quick-search-suggestions');
                participantInput.addEventListener('input', (e) => performSearch(e.target.value, participantSug, addParticipantRow));

                function addParticipantRow(user) {
                    const emptyMsg = document.getElementById('empty_grid_msg');
                    if (emptyMsg) emptyMsg.remove();

                    const html = `
                        <div class="participant-card group flex items-center gap-4 bg-gray-50/50 dark:bg-gray-900/40 p-4 rounded-[1.5rem] border border-gray-100 dark:border-gray-700/30 hover:border-indigo-200 dark:hover:border-indigo-500/20 transition-all animate-fade-in relative">
                            <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-bold shrink-0 shadow-sm">
                                ${user.name.charAt(0)}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-gray-900 dark:text-white leading-tight mb-0.5 truncate group-hover:text-indigo-600 transition-colors">${user.name}</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-black text-indigo-500/70 uppercase tracking-tighter">${user.npk || '-'}</span>
                                        <span class="text-gray-300 dark:text-gray-700 text-[10px]">|</span>
                                        <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase truncate">${user.department || '-'}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="participants[${participantIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="participants[${participantIndex}][name]" value="${user.name}">
                                <input type="hidden" name="participants[${participantIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="participants[${participantIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <button type="button" class="remove-participant absolute -right-1 -top-1 w-7 h-7 bg-white dark:bg-gray-800 text-red-500 rounded-full shadow-lg border border-red-50 dark:border-red-900/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:scale-110 active:scale-95">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    `;
                    participantGrid.insertAdjacentHTML('beforeend', html);
                    participantIndex++;
                    updateCount();
                    participantInput.value = '';
                    lucide.createIcons();
                }

                // --- MANUAL ADDITION ---
                document.getElementById('btn-add-manual-trainer').addEventListener('click', () => {
                    const emptyMsg = trainerList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="trainer-row border-2 border-emerald-500/30 dark:border-emerald-500/20 flex items-center gap-5 bg-emerald-50/50 dark:bg-emerald-500/10 p-5 rounded-[2rem] animate-fade-in group shadow-sm shadow-emerald-500/5">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-black shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <div class="flex-1 space-y-3">
                                <div class="border-b border-emerald-500/30 dark:border-emerald-500/20 pb-1">
                                    <input type="text" name="trainers[${trainerIndex}][name]" placeholder="Ketik Nama Lengkap Trainer..." class="w-full px-0 bg-transparent border-none text-sm font-black focus:ring-0 placeholder-emerald-800/20 dark:placeholder-emerald-500/30 dark:text-white" required>
                                </div>
                                <div class="border-b border-emerald-500/10 dark:border-emerald-500/5 pb-1 w-1/2">
                                    <input type="text" name="trainers[${trainerIndex}][npk]" placeholder="NPK (Opsional)" class="w-full px-0 bg-transparent border-none text-[10px] font-black uppercase tracking-widest focus:ring-0 placeholder-emerald-800/20 dark:placeholder-emerald-500/30 text-emerald-600 dark:text-emerald-400">
                                </div>
                            </div>
                            <button type="button" class="remove-trainer p-3.5 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl transition-all shadow-sm">
                                <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    `;
                    trainerList.insertAdjacentHTML('beforeend', html);
                    trainerIndex++;
                    lucide.createIcons();
                });

                document.getElementById('btn-add-manual-pic').addEventListener('click', () => {
                    const emptyMsg = picList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="pic-row border-2 border-blue-500/30 dark:border-blue-500/20 flex items-center gap-5 bg-blue-50/50 dark:bg-blue-500/10 p-5 rounded-[2rem] animate-fade-in group shadow-sm shadow-blue-500/5">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <div class="flex-1 space-y-3">
                                <div class="border-b border-blue-500/30 dark:border-blue-500/20 pb-1">
                                    <input type="text" name="pics[${picIndex}][name]" placeholder="Ketik Nama Lengkap PIC..." class="w-full px-0 bg-transparent border-none text-sm font-black focus:ring-0 placeholder-blue-800/20 dark:placeholder-blue-500/30 dark:text-white" required>
                                </div>
                                <div class="border-b border-blue-500/10 dark:border-blue-500/5 pb-1 w-1/2">
                                    <input type="text" name="pics[${picIndex}][npk]" placeholder="NPK (Opsional)" class="w-full px-0 bg-transparent border-none text-[10px] font-black uppercase tracking-widest focus:ring-0 placeholder-blue-800/20 dark:placeholder-blue-500/30 text-blue-600 dark:text-blue-400">
                                </div>
                            </div>
                            <button type="button" class="remove-pic p-3.5 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl transition-all shadow-sm">
                                <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    `;
                    picList.insertAdjacentHTML('beforeend', html);
                    picIndex++;
                    lucide.createIcons();
                });

                document.getElementById('btn-add-manual-participant').addEventListener('click', () => {
                    const emptyMsg = document.getElementById('empty_grid_msg');
                    if (emptyMsg) emptyMsg.remove();

                    const html = `
                        <div class="participant-card border-2 border-dashed border-indigo-100 dark:border-indigo-900/20 bg-white dark:bg-gray-800 p-5 rounded-[2rem] animate-fade-in group relative shadow-sm">
                            <div class="grid grid-cols-1 gap-3">
                                <div class="border-b border-indigo-50 dark:border-indigo-900/10 pb-1">
                                    <input type="text" name="participants[${participantIndex}][name]" placeholder="Nama Lengkap" class="w-full bg-transparent border-none text-xs font-black focus:ring-0 dark:text-white" required>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="participants[${participantIndex}][npk]" placeholder="NPK" class="w-full bg-gray-50 dark:bg-gray-900/30 border-none px-2 py-1.5 rounded-lg text-[9px] font-black font-mono focus:ring-1 focus:ring-indigo-500/30 dark:text-white uppercase">
                                    <input type="text" name="participants[${participantIndex}][department]" placeholder="Dept" class="w-full bg-gray-50 dark:bg-gray-900/30 border-none px-2 py-1.5 rounded-lg text-[9px] font-black focus:ring-1 focus:ring-indigo-500/30 dark:text-white uppercase">
                                </div>
                                <input type="hidden" name="participants[${participantIndex}][subco]" value="-">
                            </div>
                            <button type="button" class="remove-participant absolute -right-1 -top-1 w-7 h-7 bg-red-500 text-white rounded-full shadow-lg flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    `;
                    participantGrid.insertAdjacentHTML('beforeend', html);
                    participantIndex++;
                    updateCount();
                    lucide.createIcons();
                });

                // --- DELEGATION FOR REMOVAL ---
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-trainer')) {
                        const row = e.target.closest('.trainer-row');
                        row.classList.add('animate-fade-out');
                        setTimeout(() => {
                            row.remove();
                            if (trainerList.children.length === 0) {
                                trainerList.innerHTML = '<div class="h-full flex flex-col items-center justify-center py-6 text-gray-400 opacity-40"><i data-lucide="users-2" class="w-8 h-8 mb-2"></i><p class="text-[10px] font-bold uppercase tracking-widest italic">Belum ada trainer</p></div>';
                                lucide.createIcons();
                            }
                        }, 300);
                    }
                    if (e.target.closest('.remove-pic')) {
                        const row = e.target.closest('.pic-row');
                        row.classList.add('animate-fade-out');
                        setTimeout(() => {
                            row.remove();
                            if (picList.children.length === 0) {
                                picList.innerHTML = '<div class="h-full flex flex-col items-center justify-center py-6 text-gray-400 opacity-40"><i data-lucide="user-check" class="w-8 h-8 mb-2"></i><p class="text-[10px] font-bold uppercase tracking-widest italic">Belum ada PIC</p></div>';
                                lucide.createIcons();
                            }
                        }, 300);
                    }
                    if (e.target.closest('.remove-participant')) {
                        const card = e.target.closest('.participant-card');
                        card.classList.add('animate-fade-out');
                        setTimeout(() => {
                            card.remove();
                            updateCount();
                        }, 300);
                    }
                });

                function updateCount() {
                    const cards = participantGrid.querySelectorAll('.participant-card');
                    document.getElementById('participant_count').innerText = cards.length;
                    if (cards.length === 0 && !document.getElementById('empty_grid_msg')) {
                        participantGrid.innerHTML = `
                            <div id="empty_grid_msg" class="col-span-full py-20 text-center opacity-30 animate-fade-in">
                                <i data-lucide="user-plus" class="w-12 h-12 mx-auto mb-4"></i>
                                <p class="text-xs font-black uppercase tracking-[0.2em] italic">Belum ada peserta terdaftar</p>
                            </div>
                        `;
                        lucide.createIcons();
                    }
                }

                // Close suggestions on outside click
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.relative')) {
                        document.querySelectorAll('[id$="-suggestions"]').forEach(el => el.classList.add('hidden'));
                    }
                });

                // --- DURATION CALCULATOR ---
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                const durationDisplay = document.getElementById('duration_display');

                function updateDuration() {
                    if (!startDateInput || !endDateInput || !durationDisplay) return;
                    const start = new Date(startDateInput.value);
                    const end = new Date(endDateInput.value);

                    if (!isNaN(start) && !isNaN(end)) {
                        const diffTime = end - start;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                        if (diffDays > 0) {
                            durationDisplay.value = `${diffDays} Hari`;
                            durationDisplay.classList.remove('text-red-500');
                            durationDisplay.classList.add('text-indigo-600', 'dark:text-indigo-400');
                        } else {
                            durationDisplay.value = `Invalid`;
                            durationDisplay.classList.remove('text-indigo-600', 'dark:text-indigo-400');
                            durationDisplay.classList.add('text-red-500');
                        }
                    }
                }

                if (startDateInput && endDateInput) {
                    startDateInput.addEventListener('change', updateDuration);
                    endDateInput.addEventListener('change', updateDuration);
                    updateDuration();
                }
            });
        </script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }

                to {
                    opacity: 0;
                    transform: translateY(-10px);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            .animate-fade-out {
                animation: fadeOut 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            /* Custom Scrollbar for Participant List */
            .scrollbar-thin::-webkit-scrollbar { width: 6px; }
            .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
            .scrollbar-thin::-webkit-scrollbar-thumb { 
                background: #e2e8f0; 
                border-radius: 10px;
            }
            .dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #334155; }
            .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        </style>
    @endpush
</x-admin-layout>