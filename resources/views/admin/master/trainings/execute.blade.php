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
                            class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col h-full">
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
                                <div class="mt-8 relative" id="quick-search-trainer-wrapper">
                                    <input type="text" id="quick-search-trainer" placeholder="Cari trainer..."
                                        class="w-full pl-12 pr-6 py-4.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-emerald-500/30 focus:ring-8 focus:ring-emerald-500/5 rounded-3xl text-sm transition-all dark:text-white">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <div id="quick-search-trainer-suggestions"
                                    class="fixed z-[99999] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl hidden overflow-y-auto" style="min-width:340px;">
                                </div>
                            </div>
                            <div id="trainer_list" class="flex-1 p-8 space-y-4 min-h-[160px]">
                                @php $trainers = old('trainers', $masterTraining->trainers ?? []); @endphp
                                @foreach($trainers as $index => $trainer)
                                    <div class="trainer-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-emerald-200 dark:hover:border-emerald-500/20 transition-all relative z-10 hover:z-50 overflow-visible">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 font-bold shrink-0 overflow-hidden">
                                            @if(!empty($trainer['photo']))
                                                <img src="{{ $trainer['photo'] }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr(is_array($trainer) ? ($trainer['name'] ?? '?') : $trainer, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pr-8">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white leading-tight mb-0.5">{{ is_array($trainer) ? ($trainer['name'] ?? '') : $trainer }}</span>
                                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter opacity-70">{{ is_array($trainer) ? ($trainer['npk'] ?? '-') : '-' }}</span>
                                            </div>
                                            <input type="hidden" name="trainers[{{ $index }}][name]" value="{{ is_array($trainer) ? ($trainer['name'] ?? '') : $trainer }}">
                                            <input type="hidden" name="trainers[{{ $index }}][npk]" value="{{ is_array($trainer) ? ($trainer['npk'] ?? '') : '' }}">
                                            <input type="hidden" name="trainers[{{ $index }}][id]" value="{{ is_array($trainer) ? ($trainer['id'] ?? '') : ($trainer->id ?? '') }}">
                                            <input type="hidden" name="trainers[{{ $index }}][department]" value="{{ is_array($trainer) ? ($trainer['department'] ?? '') : '' }}">
                                            <input type="hidden" name="trainers[{{ $index }}][subco]" value="{{ is_array($trainer) ? ($trainer['subco'] ?? '') : '' }}">
                                        </div>
                                        {{-- Floating Profile Popover --}}
                                        <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                            <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                            <div class="text-center relative z-10">
                                                <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                                    @if(!empty($trainer['photo']))
                                                        <img src="{{ $trainer['photo'] }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr(is_array($trainer) ? ($trainer['name'] ?? '?') : $trainer, 0, 1)) }}
                                                    @endif
                                                </div>
                                                <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">{{ is_array($trainer) ? ($trainer['name'] ?? '') : $trainer }}</h4>
                                                <p class="text-[10px] font-bold text-emerald-500/80 uppercase tracking-widest mb-4">{{ is_array($trainer) ? ($trainer['npk'] ?? '-') : '-' }}</p>
                                                
                                                <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($trainer) ? ($trainer['department'] ?? '-') : '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($trainer) ? ($trainer['subco'] ?? '-') : '-' }}</p>
                                                    </div>
                                                </div>
                                                @php 
                                                    $e_id = is_array($trainer) ? ($trainer['id'] ?? null) : ($trainer->id ?? null);
                                                    $npk_t = is_array($trainer) ? ($trainer['npk'] ?? '') : ''; 
                                                @endphp
                                                @if($e_id)
                                                    <a href="{{ route('admin.employees.edit', $e_id) }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-600 dark:hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-emerald-100 dark:border-emerald-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Trainee
                                                    </a>
                                                @elseif($npk_t)
                                                    <a href="{{ route('admin.employees.index') }}?search={{ $npk_t }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-600 dark:hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-emerald-100 dark:border-emerald-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Profile
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button" class="remove-trainer absolute right-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-red-50 dark:bg-red-500/10 text-red-500 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                            class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col h-full">
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
                                <div class="mt-8 relative" id="quick-search-pic-wrapper">
                                    <input type="text" id="quick-search-pic" placeholder="Cari PIC..."
                                        class="w-full pl-12 pr-6 py-4.5 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500/30 focus:ring-8 focus:ring-blue-500/5 rounded-3xl text-sm transition-all dark:text-white">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                </div>
                                <div id="quick-search-pic-suggestions"
                                    class="fixed z-[99999] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl hidden overflow-y-auto" style="min-width:340px;">
                                </div>
                            </div>
                            <div id="pic_list" class="flex-1 p-8 space-y-4 min-h-[160px]">
                                @php $pics = old('pics', $masterTraining->pics ?? []); @endphp
                                @foreach($pics as $index => $pic)
                                    <div class="pic-row flex items-center gap-5 bg-gray-50 dark:bg-gray-900/40 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-blue-200 dark:hover:border-blue-500/10 transition-all shadow-sm relative z-10 hover:z-50 overflow-visible">
                                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold shrink-0 shadow-sm overflow-hidden">
                                            @if(!empty($pic['photo']))
                                                <img src="{{ $pic['photo'] }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr(is_array($pic) ? ($pic['name'] ?? '?') : $pic, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pr-8">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white leading-tight mb-0.5">{{ is_array($pic) ? ($pic['name'] ?? '') : $pic }}</span>
                                                <span class="text-[10px] font-black text-blue-500 uppercase tracking-tighter opacity-70">{{ is_array($pic) ? ($pic['npk'] ?? '-') : '-' }}</span>
                                            </div>
                                            <input type="hidden" name="pics[{{ $index }}][name]" value="{{ is_array($pic) ? ($pic['name'] ?? '') : $pic }}">
                                            <input type="hidden" name="pics[{{ $index }}][npk]" value="{{ is_array($pic) ? ($pic['npk'] ?? '') : '' }}">
                                            <input type="hidden" name="pics[{{ $index }}][id]" value="{{ is_array($pic) ? ($pic['id'] ?? '') : ($pic->id ?? '') }}">
                                            <input type="hidden" name="pics[{{ $index }}][department]" value="{{ is_array($pic) ? ($pic['department'] ?? '') : '' }}">
                                            <input type="hidden" name="pics[{{ $index }}][subco]" value="{{ is_array($pic) ? ($pic['subco'] ?? '') : '' }}">
                                        </div>
                                        {{-- Floating Profile Popover --}}
                                        <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                            <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                            <div class="text-center relative z-10">
                                                <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-blue-50 dark:bg-blue-900/50 text-blue-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                                    @if(!empty($pic['photo']))
                                                        <img src="{{ $pic['photo'] }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr(is_array($pic) ? ($pic['name'] ?? '?') : $pic, 0, 1)) }}
                                                    @endif
                                                </div>
                                                <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">{{ is_array($pic) ? ($pic['name'] ?? '') : $pic }}</h4>
                                                <p class="text-[10px] font-bold text-blue-500/80 uppercase tracking-widest mb-4">{{ is_array($pic) ? ($pic['npk'] ?? '-') : '-' }}</p>
                                                
                                                <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($pic) ? ($pic['department'] ?? '-') : '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($pic) ? ($pic['subco'] ?? '-') : '-' }}</p>
                                                    </div>
                                                </div>
                                                @php $npk_p = is_array($pic) ? ($pic['npk'] ?? '') : ''; @endphp
                                                @php 
                                                    $pic_id = is_array($pic) ? ($pic['id'] ?? null) : ($pic->id ?? null);
                                                    $npk_p = is_array($pic) ? ($pic['npk'] ?? '') : ''; 
                                                @endphp
                                                @if($pic_id)
                                                    <a href="{{ route('admin.employees.edit', $pic_id) }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-600 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-blue-100 dark:border-blue-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Trainee
                                                    </a>
                                                @elseif($npk_p)
                                                    <a href="{{ route('admin.employees.index') }}?search={{ $npk_p }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-600 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-blue-100 dark:border-blue-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Profile
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button" class="remove-pic absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-red-50 dark:bg-red-500/10 text-red-500 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                            <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
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
                                <div class="relative flex-1 md:w-80" id="quick-search-participant-wrapper">
                                    <input type="text" id="quick-search-participant" placeholder="Tambah peserta..."
                                        class="block w-full pl-12 pr-6 py-4 bg-gray-50 dark:bg-gray-900/50 border border-transparent focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500/30 focus:ring-8 focus:ring-indigo-500/5 rounded-3xl text-sm transition-all text-gray-900 dark:text-gray-100 shadow-sm">
                                    <i data-lucide="search"
                                        class="absolute left-4.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <div id="quick-search-suggestions"
                                    class="fixed z-[99999] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2rem] shadow-2xl hidden overflow-y-auto" style="min-width:340px;">
                                </div>
                            </div>
                        </div>

                        <div class="max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-200 dark:scrollbar-thumb-indigo-900/50 scrollbar-track-transparent">
                            <div id="participant_grid" class="grid grid-cols-1 md:grid-cols-2 gap-4 p-8">
                                @php $participants = old('participants', $masterTraining->participants ?? []); @endphp
                                @forelse($participants as $index => $participant)
                                    <div class="participant-card group flex items-center gap-4 bg-gray-50/50 dark:bg-gray-900/40 p-4 rounded-[1.5rem] border border-gray-100 dark:border-gray-700/30 hover:border-indigo-200 dark:hover:border-indigo-500/20 transition-all animate-fade-in relative z-10 hover:z-50 overflow-visible">
                                        <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-bold shrink-0 shadow-sm overflow-hidden">
                                            @if(!empty($participant['photo']))
                                                <img src="{{ $participant['photo'] }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr(is_array($participant) ? ($participant['name'] ?? '?') : $participant->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pr-8">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-gray-900 dark:text-white leading-tight mb-0.5 truncate uppercase">{{ is_array($participant) ? ($participant['name'] ?? '') : $participant->name }}</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[9px] font-black text-indigo-500/70 uppercase tracking-tighter">{{ is_array($participant) ? ($participant['npk'] ?? '-') : $participant->npk }}</span>
                                                    <span class="text-gray-300 dark:text-gray-700 text-[10px]">|</span>
                                                    <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase truncate">{{ is_array($participant) ? ($participant['department'] ?? '-') : $participant->department }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="participants[{{ $index }}][name]" value="{{ is_array($participant) ? ($participant['name'] ?? '') : $participant->name }}">
                                            <input type="hidden" name="participants[{{ $index }}][npk]" value="{{ is_array($participant) ? ($participant['npk'] ?? '') : $participant->npk }}">
                                            <input type="hidden" name="participants[{{ $index }}][id]" value="{{ is_array($participant) ? ($participant['id'] ?? '') : ($participant->id ?? '') }}">
                                            <input type="hidden" name="participants[{{ $index }}][department]" value="{{ is_array($participant) ? ($participant['department'] ?? '-') : $participant->department }}">
                                            <input type="hidden" name="participants[{{ $index }}][subco]" value="{{ is_array($participant) ? ($participant['subco'] ?? '-') : $participant->subco }}">
                                        </div>
                                        {{-- Floating Profile Popover --}}
                                        <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                            <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                            <div class="text-center relative z-10">
                                                <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                                    @if(!empty($participant['photo']))
                                                        <img src="{{ $participant['photo'] }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr(is_array($participant) ? ($participant['name'] ?? '?') : $participant->name, 0, 1)) }}
                                                    @endif
                                                </div>
                                                <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">{{ is_array($participant) ? ($participant['name'] ?? '') : $participant->name }}</h4>
                                                <p class="text-[10px] font-bold text-indigo-500/80 uppercase tracking-widest mb-4">{{ is_array($participant) ? ($participant['npk'] ?? '-') : $participant->npk }}</p>
                                                
                                                <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($participant) ? ($participant['department'] ?? '-') : $participant->department }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">{{ is_array($participant) ? ($participant['subco'] ?? '-') : $participant->subco }}</p>
                                                    </div>
                                                </div>

                                                @php 
                                                    $p_id = is_array($participant) ? ($participant['id'] ?? null) : ($participant->id ?? null);
                                                    $npk = is_array($participant) ? ($participant['npk'] ?? '') : $participant->npk; 
                                                @endphp
                                                @if($p_id)
                                                    <a href="{{ route('admin.employees.edit', $p_id) }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-indigo-100 dark:border-indigo-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Trainee
                                                    </a>
                                                @elseif($npk)
                                                    <a href="{{ route('admin.employees.index') }}?search={{ $npk }}" target="_blank"
                                                       class="w-full flex items-center justify-center gap-2 py-3 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-indigo-100 dark:border-indigo-800">
                                                        <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                                        Edit Profile
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button" class="remove-participant absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-400 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                            <i data-lucide="x" class="w-4 h-4"></i>
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

                // --- ADAPTIVE POSITIONING LOGIC ---
                function positionSuggestions(wrapperId, suggestionsEl) {
                    const wrapper = document.getElementById(wrapperId);
                    if (!wrapper || !suggestionsEl) return;
                    
                    const rect = wrapper.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom - 12;
                    const spaceAbove = rect.top - 12;
                    const maxH = Math.min(380, Math.max(spaceBelow, 120));
                    
                    const w = Math.max(rect.width, 340);
                    suggestionsEl.style.width = w + 'px';
                    suggestionsEl.style.left = Math.min(rect.left + window.scrollX, window.innerWidth - w - 8) + 'px';
                    suggestionsEl.style.maxHeight = maxH + 'px';

                    if (spaceBelow >= 120 || spaceBelow >= spaceAbove) {
                        suggestionsEl.style.top = (rect.bottom + window.scrollY + 8) + 'px';
                        suggestionsEl.style.bottom = 'auto';
                    } else {
                        suggestionsEl.style.top = 'auto';
                        suggestionsEl.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
                    }
                }

                // Move portals to body
                ['quick-search-trainer-suggestions', 'quick-search-pic-suggestions', 'quick-search-suggestions'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) document.body.appendChild(el);
                });

                const performSearch = (query, suggestionsEl, wrapperId, onSelect) => {
                    if (query.length < 3) {
                        suggestionsEl.classList.add('hidden');
                        return;
                    }

                    fetch(`{{ route('admin.search-users') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                suggestionsEl.innerHTML = `
                                    <div style="padding:12px 20px 8px; border-bottom:1px solid rgba(148,163,184,0.15); background: rgba(148,163,184,0.03);">
                                        <p style="font-size:9px; font-weight:900; color:#94a3b8; text-transform:uppercase; letter-spacing:0.12em; margin:0;">Hasil Pencarian (${data.length})</p>
                                    </div>
                                    ${data.map(user => {
                                        const initial = (user.name || '?').charAt(0).toUpperCase();
                                        return `
                                            <div class="suggestion-item" 
                                                 style="padding:12px 20px; cursor:pointer; border-bottom:1px solid rgba(148,163,184,0.08); display:flex; align-items:center; gap:16px; transition:all 0.2s;"
                                                 onmouseenter="this.style.background='rgba(99,102,241,0.08)'"
                                                 onmouseleave="this.style.background=''"
                                                 data-user='${JSON.stringify(user).replace(/'/g, "&apos;")}'>
                                                <div style="width:40px; height:40px; border-radius:12px; background:#4f46e5; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:900; font-size:16px; flex-shrink:0; overflow:hidden; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">
                                                    ${user.photo ? `<img src="${user.photo}" style="width:100%; height:100%; object-fit:cover;">` : initial}
                                                </div>
                                                <div style="flex:1; min-width:0; overflow:hidden;">
                                                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px; overflow:hidden;">
                                                        <span style="font-size:10px; font-weight:900; color:#6366f1; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">${user.npk || '-'}</span>
                                                        <span style="color:#cbd5e1; font-size:10px;">&bull;</span>
                                                        <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${user.department || '-'}</span>
                                                    </div>
                                                    <div class="suggestion-name" style="font-size:14px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${user.name}</div>
                                                </div>
                                                <div style="flex-shrink:0; font-size:9px; font-weight:900; background:#4f46e5; color:#white; padding:5px 10px; border-radius:8px; color:#fff;">PILIH</div>
                                            </div>
                                        `;
                                    }).join('')}
                                `;
                                suggestionsEl.classList.remove('hidden');
                                positionSuggestions(wrapperId, suggestionsEl);

                                // Attach click events
                                suggestionsEl.querySelectorAll('.suggestion-item').forEach(item => {
                                    item.addEventListener('click', () => {
                                        onSelect(JSON.parse(item.dataset.user));
                                        suggestionsEl.classList.add('hidden');
                                    });
                                });
                            } else {
                                suggestionsEl.innerHTML = '<div style="padding:40px 20px; text-align:center; color:#94a3b8; font-style:italic; font-size:13px;">Tidak ada hasil ditemukan.</div>';
                                suggestionsEl.classList.remove('hidden');
                                positionSuggestions(wrapperId, suggestionsEl);
                            }
                        });
                };

                // --- TRAINER SEARCH ---
                const trainerInput = document.getElementById('quick-search-trainer');
                const trainerSug = document.getElementById('quick-search-trainer-suggestions');
                trainerInput.addEventListener('input', (e) => performSearch(e.target.value, trainerSug, 'quick-search-trainer-wrapper', addTrainerRow));
                trainerInput.addEventListener('focus', () => performSearch(trainerInput.value, trainerSug, 'quick-search-trainer-wrapper', addTrainerRow));

                function addTrainerRow(user) {
                    const emptyMsg = trainerList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="trainer-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-emerald-200 dark:hover:border-emerald-500/20 transition-all animate-fade-in relative overflow-visible">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 font-bold shrink-0 overflow-hidden">
                                ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0 pr-8">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 dark:text-white leading-tight mb-0.5">${user.name}</span>
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter opacity-70">${user.npk || '-'}</span>
                                </div>
                                <input type="hidden" name="trainers[${trainerIndex}][name]" value="${user.name}">
                                <input type="hidden" name="trainers[${trainerIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="trainers[${trainerIndex}][id]" value="${user.id || ''}">
                                <input type="hidden" name="trainers[${trainerIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="trainers[${trainerIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <!-- Floating Profile Popover -->
                            <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                <div class="text-center relative z-10">
                                    <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                        ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">${user.name}</h4>
                                    <p class="text-[10px] font-bold text-emerald-500/80 uppercase tracking-widest mb-4">${user.npk || '-'}</p>
                                    <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.department || '-'}</p>
                                        </div>
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.subco || '-'}</p>
                                        </div>
                                    </div>
                                    ${user.id ? `
                                        <a href="/admin/employees/${user.id}/edit" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-600 dark:hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-emerald-100 dark:border-emerald-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Trainee
                                        </a>
                                    ` : user.npk ? `
                                        <a href="{{ route('admin.employees.index') }}?search=${user.npk}" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-600 dark:hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-emerald-100 dark:border-emerald-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Profile
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                            <button type="button" class="remove-trainer absolute right-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-red-50 dark:bg-red-500/10 text-red-500 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                picInput.addEventListener('input', (e) => performSearch(e.target.value, picSug, 'quick-search-pic-wrapper', addPicRow));
                picInput.addEventListener('focus', () => performSearch(picInput.value, picSug, 'quick-search-pic-wrapper', addPicRow));

                function addPicRow(user) {
                    const emptyMsg = picList.querySelector('.italic');
                    if (emptyMsg) emptyMsg.parentElement.remove();

                    const html = `
                        <div class="pic-row flex items-center gap-4 bg-gray-50 dark:bg-gray-900/40 p-3.5 rounded-2xl border border-gray-100 dark:border-gray-700/30 group hover:border-blue-200 dark:hover:border-blue-500/20 transition-all animate-fade-in relative overflow-visible">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold shrink-0 overflow-hidden">
                                ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0 pr-8">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 dark:text-white leading-tight mb-0.5">${user.name}</span>
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-tighter opacity-70">${user.npk || '-'}</span>
                                </div>
                                <input type="hidden" name="pics[${picIndex}][name]" value="${user.name}">
                                <input type="hidden" name="pics[${picIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="pics[${picIndex}][id]" value="${user.id || ''}">
                                <input type="hidden" name="pics[${picIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="pics[${picIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <!-- Floating Profile Popover -->
                            <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                <div class="text-center relative z-10">
                                    <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-blue-50 dark:bg-blue-900/50 text-blue-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                        ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">${user.name}</h4>
                                    <p class="text-[10px] font-bold text-blue-500/80 uppercase tracking-widest mb-4">${user.npk || '-'}</p>
                                    <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.department || '-'}</p>
                                        </div>
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.subco || '-'}</p>
                                        </div>
                                    </div>
                                    ${user.id ? `
                                        <a href="/admin/employees/${user.id}/edit" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-600 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-blue-100 dark:border-blue-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Trainee
                                        </a>
                                    ` : user.npk ? `
                                        <a href="{{ route('admin.employees.index') }}?search=${user.npk}" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-600 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-blue-100 dark:border-blue-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Profile
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                            <button type="button" class="remove-pic absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-red-50 dark:bg-red-500/10 text-red-500 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
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
                participantInput.addEventListener('input', (e) => performSearch(e.target.value, participantSug, 'quick-search-participant-wrapper', addParticipantRow));
                participantInput.addEventListener('focus', () => performSearch(participantInput.value, participantSug, 'quick-search-participant-wrapper', addParticipantRow));

                function addParticipantRow(user) {
                    const emptyMsg = document.getElementById('empty_grid_msg');
                    if (emptyMsg) emptyMsg.remove();

                    const html = `
                        <div class="participant-card group flex items-center gap-4 bg-gray-50/50 dark:bg-gray-900/40 p-4 rounded-[1.5rem] border border-gray-100 dark:border-gray-700/30 hover:border-indigo-200 dark:hover:border-indigo-500/20 transition-all animate-fade-in relative overflow-visible">
                            <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 font-bold shrink-0 shadow-sm overflow-hidden">
                                ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0 pr-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-gray-900 dark:text-white leading-tight mb-0.5 truncate uppercase">${user.name}</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-black text-indigo-500/70 uppercase tracking-tighter">${user.npk || '-'}</span>
                                        <span class="text-gray-300 dark:text-gray-700 text-[10px]">|</span>
                                        <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase truncate">${user.department || '-'}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="participants[${participantIndex}][npk]" value="${user.npk || ''}">
                                <input type="hidden" name="participants[${participantIndex}][name]" value="${user.name}">
                                <input type="hidden" name="participants[${participantIndex}][id]" value="${user.id || ''}">
                                <input type="hidden" name="participants[${participantIndex}][department]" value="${user.department || ''}">
                                <input type="hidden" name="participants[${participantIndex}][subco]" value="${user.subco || ''}">
                            </div>
                            <!-- Floating Profile Popover -->
                            <div class="absolute right-0 bottom-full mb-3 w-64 bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-100 dark:border-gray-700/50 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[90] translate-y-4 group-hover:translate-y-0 scale-95 group-hover:scale-100 origin-bottom-right pointer-events-none group-hover:pointer-events-auto">
                                <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white dark:bg-gray-800 border-b border-r border-gray-100 dark:border-gray-700/50 rotate-45"></div>
                                <div class="text-center relative z-10">
                                    <div class="w-16 h-16 mx-auto rounded-[1.25rem] bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 font-extrabold flex items-center justify-center text-3xl shadow-sm overflow-hidden mb-3 ring-4 ring-white dark:ring-gray-800">
                                        ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <h4 class="text-sm font-black text-gray-900 dark:text-white mb-0.5 truncate px-2">${user.name}</h4>
                                    <p class="text-[10px] font-bold text-indigo-500/80 uppercase tracking-widest mb-4">${user.npk || '-'}</p>
                                    <div class="grid grid-cols-2 gap-2 mb-4 text-left bg-gray-50/50 dark:bg-gray-900/50 p-2.5 rounded-2xl border border-gray-100/50 dark:border-gray-700/30">
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Departemen</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.department || '-'}</p>
                                        </div>
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Sub Divisi</p>
                                            <p class="text-[10px] font-black text-gray-700 dark:text-gray-300 truncate">${user.subco || '-'}</p>
                                        </div>
                                    </div>
                                    ${user.id ? `
                                        <a href="/admin/employees/${user.id}/edit" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-indigo-100 dark:border-indigo-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Trainee
                                        </a>
                                    ` : user.npk ? `
                                        <a href="{{ route('admin.employees.index') }}?search=${user.npk}" target="_blank"
                                           class="w-full flex items-center justify-center gap-2 py-3 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-widest group/btn mt-1 border border-indigo-100 dark:border-indigo-800">
                                            <i data-lucide="user-cog" class="w-3.5 h-3.5 transition-transform group-hover/btn:scale-110"></i>
                                            Edit Profile
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                            <button type="button" class="remove-participant absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-400 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:hover:bg-red-500 z-20">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                        <div class="trainer-row border-2 border-emerald-500/30 dark:border-emerald-500/20 flex items-center gap-5 bg-emerald-50/50 dark:bg-emerald-500/10 p-5 rounded-[2rem] animate-fade-in group shadow-sm shadow-emerald-500/5 relative z-10 hover:z-50">
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
                    if (!e.target.closest('[id$="-wrapper"]') && !e.target.closest('[id$="-suggestions"]')) {
                        document.querySelectorAll('[id$="-suggestions"]').forEach(el => el.classList.add('hidden'));
                    }
                });

                // Update positions on scroll/resize
                window.addEventListener('resize', () => {
                    positionSuggestions('quick-search-trainer-wrapper', trainerSug);
                    positionSuggestions('quick-search-pic-wrapper', picSug);
                    positionSuggestions('quick-search-participant-wrapper', participantSug);
                });
                window.addEventListener('scroll', () => {
                    positionSuggestions('quick-search-trainer-wrapper', trainerSug);
                    positionSuggestions('quick-search-pic-wrapper', picSug);
                    positionSuggestions('quick-search-participant-wrapper', participantSug);
                }, true);

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
                // --- ADAPTIVE PROFILE POPOVERS ---
                const popoversMap = new Map();
                let hoverTimeout = null;
                let activePopover = null;
                let activeRow = null;

                function showGlobalPopover(row) {
                    if (activePopover && activeRow !== row) {
                        hideGlobalPopover(activePopover);
                    }
                    
                    let popover = popoversMap.get(row) || row.querySelector('.absolute.w-64.origin-bottom-right, .absolute.w-64.origin-top-right');
                    if (!popover) return;
                    
                    if (!popoversMap.has(row)) {
                        popoversMap.set(row, popover);
                        document.body.appendChild(popover);
                        // Convert from CSS-hover-based to JS-controlled
                        popover.classList.remove('group-hover:opacity-100', 'group-hover:visible', 'group-hover:translate-y-0', 'group-hover:scale-100');
                        popover.classList.add('transition-all', 'duration-300');
                    }
                    
                    activeRow = row;
                    activePopover = popover;
                    
                    const rect = row.getBoundingClientRect();
                    popover.style.position = 'fixed';
                    popover.style.zIndex = '999999';
                    
                    // Force solid background to bypass tailwind class removal or bleed-through issues
                    const isDark = document.documentElement.classList.contains('dark');
                    const bgColor = isDark ? '#111827' : '#ffffff';
                    
                    // Force the color on the main container with !important
                    popover.style.setProperty('background-color', bgColor, 'important');
                    popover.style.opacity = '1';
                    popover.style.visibility = 'visible';
                    popover.style.pointerEvents = 'auto';
                    popover.style.display = 'block';
                    popover.style.height = 'auto';
                    popover.style.minHeight = 'max-content';
                    popover.style.overflow = 'visible';
                    popover.style.boxShadow = isDark ? '0 25px 50px -12px rgba(0, 0, 0, 0.8)' : '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                    
                    // Show it to measure it
                    popover.classList.remove('invisible', 'opacity-0', 'scale-95', 'translate-y-4');
                    popover.classList.add('visible', 'opacity-100', 'scale-100', 'translate-y-0');
                    
                    const pHeight = popover.offsetHeight || 260; 
                    const pWidth = popover.offsetWidth || 256;
                    
                    let top = rect.top - pHeight - 12;
                    let position = 'top';
                    
                    if (top < 70) {
                        // Not enough space above, flip to bottom
                        top = rect.bottom + 12;
                        position = 'bottom';
                    }
                    
                    // Adaptive horizontal positioning (try to center over the card)
                    let left = rect.left + (rect.width / 2) - (pWidth / 2);
                    
                    // Prevent rendering off-screen (keep it at least 16px from edges)
                    if (left < 16) left = 16;
                    if (left + pWidth > window.innerWidth - 16) left = window.innerWidth - pWidth - 16;
                    
                    let arrow = popover.querySelector('.rotate-45');
                    if (arrow) {
                        arrow.style.backgroundColor = isDark ? '#111827' : '#ffffff';
                        // Remove manual right constraints
                        arrow.classList.remove('right-8');
                        
                        // Dynamically center the arrow pointing exactly at the center of the card
                        let arrowLeftOffset = rect.left + (rect.width / 2) - left - 8; // -8 for half arrow width
                        // Keep arrow within popover bounds
                        if (arrowLeftOffset < 16) arrowLeftOffset = 16;
                        if (arrowLeftOffset > pWidth - 24) arrowLeftOffset = pWidth - 24;
                        
                        arrow.style.left = arrowLeftOffset + 'px';
                        
                        if (position === 'bottom') {
                            arrow.className = arrow.className.replace('-bottom-2', '-top-2').replace('border-b', 'border-t').replace('border-r', 'border-l');
                        } else {
                            arrow.className = arrow.className.replace('-top-2', '-bottom-2').replace('border-t', 'border-b').replace('border-l', 'border-r');
                        }
                    }
                    
                    popover.style.top = top + 'px';
                    popover.style.left = left + 'px';
                }

                function hideGlobalPopover(popover) {
                    if (!popover) return;
                    popover.classList.remove('visible', 'opacity-100', 'scale-100', 'translate-y-0');
                    popover.classList.add('invisible', 'opacity-0', 'scale-95', 'translate-y-4');
                    // Reset inline styles that override classes
                    popover.style.opacity = '0';
                    popover.style.visibility = 'hidden';
                    popover.style.pointerEvents = 'none';
                }

                document.addEventListener('mouseover', (e) => {
                    // Try to find if user is hovering over a trigger row or the popover itself
                    const row = e.target.closest('.trainer-row, .pic-row, .participant-card');
                    const isHoveringPopover = e.target.closest('.absolute.w-64.origin-bottom-right, .absolute.w-64.origin-top-right');
                    
                    if (row) {
                        clearTimeout(hoverTimeout);
                        showGlobalPopover(row);
                    } else if (isHoveringPopover) {
                        clearTimeout(hoverTimeout);
                    } else if (activePopover) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = setTimeout(() => {
                            hideGlobalPopover(activePopover);
                            activePopover = null;
                            activeRow = null;
                        }, 150);
                    }
                });

                window.addEventListener('scroll', () => {
                    if (activePopover) {
                        hideGlobalPopover(activePopover);
                        activePopover = null;
                        activeRow = null;
                    }
                }, true);
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

            .suggestion-name { color: #1e293b; }
            .dark .suggestion-name { color: #f8fafc; }

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