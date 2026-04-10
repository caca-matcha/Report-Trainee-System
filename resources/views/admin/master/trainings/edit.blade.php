<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.master-trainings.index') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">Edit Master Training</h2>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('admin.master-trainings.update', $masterTraining) }}" method="POST"
            class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Pelatihan</label>
                    <select name="category" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Mandatory" {{ old('category', $masterTraining->category) == 'Mandatory' ? 'selected' : '' }}>Mandatory (MDT)</option>
                        <option value="Managerial" {{ old('category', $masterTraining->category) == 'Managerial' ? 'selected' : '' }}>Managerial (MNG)</option>
                        <option value="Technical" {{ old('category', $masterTraining->category) == 'Technical' ? 'selected' : '' }}>Technical (TKT)</option>
                        <option value="Awareness" {{ old('category', $masterTraining->category) == 'Awareness' ? 'selected' : '' }}>Awareness (ARS)</option>
                        <option value="Certification" {{ old('category', $masterTraining->category) == 'Certification' ? 'selected' : '' }}>Certification (CER)</option>
                        <option value="Others" {{ old('category', $masterTraining->category) == 'Others' ? 'selected' : '' }}>Others (OT)</option>
                    </select>
                    @error('category') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Training</label>
                    <input type="text" name="event_no" value="{{ old('event_no', $masterTraining->event_no) }}" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 font-mono text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                    @error('event_no') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    <p class="mt-1 text-[10px] text-gray-400 font-bold uppercase tracking-widest text-orange-500">Nomor training bersifat permanen dan tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Training</label>
                    <input type="text" name="training_course"
                        value="{{ old('training_course', $masterTraining->training_course) }}" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('training_course') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Training
                        Topic</label>
                    <input type="text" name="training_topic"
                        value="{{ old('training_topic', $masterTraining->training_topic) }}" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('training_topic') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provider Type</label>
                    <select name="provider_type" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Internal" {{ old('provider_type', $masterTraining->provider_type) == 'Internal' ? 'selected' : '' }}>Internal</option>
                        <option value="External" {{ old('provider_type', $masterTraining->provider_type) == 'External' ? 'selected' : '' }}>External</option>
                    </select>
                    @error('provider_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provider Name</label>
                    <input type="text" name="provider" value="{{ old('provider', $masterTraining->provider) }}" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('provider') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-full pt-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-1">
                                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Daftar Trainer / Instruktur</h3>
                                <p class="text-xs text-gray-500">Tambahkan satu atau lebih trainer yang mengajar pelatihan ini.</p>
                            </div>
                            <button type="button" id="btn-add-manual-trainer" class="text-xs px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg font-bold transition-colors">
                                + Tambah Manual
                            </button>
                        </div>

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="quick-search-trainer" placeholder="Ketik nama atau NPK trainer..." autocomplete="off"
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm">
                        <div id="quick-search-trainer-suggestions" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg mt-2 hidden max-h-72 overflow-y-auto"></div>
                    </div>

                    <div id="trainers-wrapper" class="space-y-2 mt-4">
                        @php $trainers = old('trainers', $masterTraining->trainers ?? []); @endphp
                        @forelse($trainers as $index => $trainer)
                            <div class="trainer-row flex flex-col md:flex-row gap-4 items-center bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl relative group border border-gray-100 dark:border-gray-800">
                                @if(isset($trainer['photo']) && $trainer['photo'])
                                    <img src="{{ $trainer['photo'] }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">{{ substr($trainer['name'] ?? '?', 0, 1) }}</div>
                                @endif
                                <input type="hidden" name="trainers[{{ $index }}][photo]" value="{{ $trainer['photo'] ?? '' }}">
                                <input type="hidden" name="trainers[{{ $index }}][npk]" value="{{ $trainer['npk'] ?? '' }}">
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama Trainer</label>
                                        <input type="text" name="trainers[{{ $index }}][name]" value="{{ $trainer['name'] ?? '' }}" readonly class="bg-transparent border-none p-0 text-gray-900 dark:text-white text-sm font-bold focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen/Instansi</label>
                                        <input type="text" name="trainers[{{ $index }}][department]" value="{{ $trainer['department'] ?? '' }}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Company</label>
                                        <input type="text" name="trainers[{{ $index }}][subco]" value="{{ $trainer['subco'] ?? '-' }}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-1 flex justify-end">
                                        <button type="button" class="remove-trainer p-2 text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="no-trainers" class="text-center py-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border-2 border-dashed border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 italic">Belum ada trainer.</p>
                            </div>
                        @endforelse
                    </div>

<div class="col-span-full pt-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-1">
                                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Daftar PIC</h3>
                                <p class="text-xs text-gray-500">Tambahkan satu atau lebih pic yang bertanggung jawab pada pelatihan ini.</p>
                            </div>
                            <button type="button" id="btn-add-manual-pic" class="text-xs px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg font-bold transition-colors">
                                + Tambah Manual
                            </button>
                        </div>

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="quick-search-pic" placeholder="Ketik nama atau NPK pic..." autocomplete="off"
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm">
                        <div id="quick-search-pic-suggestions" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg mt-2 hidden max-h-72 overflow-y-auto"></div>
                    </div>

                    <div id="pics-wrapper" class="space-y-2 mt-4">
                        @php $pics = old('pics', $masterTraining->pics ?? []); @endphp
                        @forelse($pics as $index => $pic)
                            <div class="pic-row flex flex-col md:flex-row gap-4 items-center bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl relative group border border-gray-100 dark:border-gray-800">
                                @if(isset($pic['photo']) && $pic['photo'])
                                    <img src="{{ $pic['photo'] }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">{{ substr($pic['name'] ?? '?', 0, 1) }}</div>
                                @endif
                                <input type="hidden" name="pics[{{ $index }}][photo]" value="{{ $pic['photo'] ?? '' }}">
                                <input type="hidden" name="pics[{{ $index }}][npk]" value="{{ $pic['npk'] ?? '' }}">
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama PIC</label>
                                        <input type="text" name="pics[{{ $index }}][name]" value="{{ $pic['name'] ?? '' }}" readonly class="bg-transparent border-none p-0 text-gray-900 dark:text-white text-sm font-bold focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen/Instansi</label>
                                        <input type="text" name="pics[{{ $index }}][department]" value="{{ $pic['department'] ?? '' }}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Company</label>
                                        <input type="text" name="pics[{{ $index }}][subco]" value="{{ $pic['subco'] ?? '-' }}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                                    </div>
                                    <div class="md:col-span-1 flex justify-end">
                                        <button type="button" class="remove-pic p-2 text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="no-pics" class="text-center py-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border-2 border-dashed border-gray-100 dark:border-gray-800">
                                <p class="text-xs text-gray-400 italic">Belum ada pic.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Passing Grade
                        (%)</label>
                    <input type="number" name="passing_grade"
                        value="{{ old('passing_grade', $masterTraining->passing_grade) }}" min="0" max="100" step="1"
                        required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('passing_grade') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>



                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start
                            Date</label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $masterTraining->start_date->format('Y-m-d')) }}" required
                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date', $masterTraining->end_date->format('Y-m-d')) }}" required
                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" required
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Open Registration"
                            {{ old('status', $masterTraining->status) == 'Open Registration' ? 'selected' : '' }}>Open
                            Registration</option>
                        <option value="Sedang Berlangsung"
                            {{ old('status', $masterTraining->status) == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang
                            Berlangsung</option>
                        <option value="Selesai" {{ old('status', $masterTraining->status) == 'Selesai' ? 'selected' : '' }}>
                            Selesai</option>
                        <option value="Dibatalkan"
                            {{ old('status', $masterTraining->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>

            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description
                    (Optional)</label>
                <textarea name="description" rows="3"
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $masterTraining->description) }}</textarea>
            </div>

            <div class="col-span-full space-y-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Daftar Peserta Trainee</h3>
                            <span id="participant-count" class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 text-[10px] font-bold px-2 py-0.5 rounded-full">0</span>
                        </div>
                        <button type="button" id="btn-add-manual-participant" class="text-xs px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg font-bold transition-colors">
                            + Tambah Manual
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Cari nama/NPK di kotak bawah untuk menambah peserta otomatis, atau klik Tambah Manual.</p>
                </div>

                <div class="relative max-w-2xl">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="quick-search-participant" placeholder="Ketik nama atau NPK peserta..." autocomplete="off"
                        class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm">
                    <div id="quick-search-suggestions" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg mt-2 hidden max-h-72 overflow-y-auto"></div>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm mt-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-900/50 text-[10px] uppercase font-black text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                                    <th scope="col" class="px-4 py-3 w-16 text-center">Foto</th>
                                    <th scope="col" class="px-4 py-3">NPK</th>
                                    <th scope="col" class="px-4 py-3">Nama Lengkap</th>
                                    <th scope="col" class="px-4 py-3">Departemen</th>
                                    <th scope="col" class="px-4 py-3">Sub Company</th>
                                    <th scope="col" class="px-4 py-3 w-16 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="participants-wrapper" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $participants = old('participants', $masterTraining->participants ?? []);
                                    // Build a lookup map of NPK -> subco from users table
                                    $npkList = collect($participants)->pluck('npk')->filter()->values();
                                    $userSubcoMap = \App\Models\User::whereIn('npk', $npkList)->pluck('subco', 'npk');
                                @endphp
                                @forelse($participants as $index => $participant)
                                    @php
                                        // Resolve subco: use stored value or fall back to DB lookup
                                        $resolvedSubco = (!empty($participant['subco'])) 
                                            ? $participant['subco'] 
                                            : ($userSubcoMap[$participant['npk'] ?? ''] ?? '');
                                    @endphp
                                    <tr class="participant-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                        <td class="px-4 py-3 text-center text-gray-900 dark:text-white font-medium participant-number">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 flex justify-center">
                                            @if(isset($participant['photo']) && $participant['photo'])
                                                <img src="{{ $participant['photo'] }}" class="w-8 h-8 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold border border-gray-200 dark:border-gray-700">{{ substr($participant['name'] ?? '?', 0, 1) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="hidden" name="participants[{{ $index }}][photo]" value="{{ $participant['photo'] ?? '' }}">
                                            @if(isset($participant['is_manual']) && $participant['is_manual'])
                                                <input type="hidden" name="participants[{{ $index }}][is_manual]" value="1">
                                            @endif
                                            <input type="text" name="participants[{{ $index }}][npk]" value="{{ $participant['npk'] ?? '' }}" readonly class="w-full text-[10px] font-mono px-2 py-1 rounded bg-transparent border-none focus:ring-0 text-indigo-600 dark:text-indigo-400 font-black tracking-tighter" required>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text" name="participants[{{ $index }}][name]" value="{{ $participant['name'] ?? '' }}" class="w-full text-xs font-bold px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-900 dark:text-white" required>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text" name="participants[{{ $index }}][department]" value="{{ $participant['department'] ?? '-' }}" class="w-full text-[10px] px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-500 dark:text-gray-400 uppercase font-medium">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text" name="participants[{{ $index }}][subco]" value="{{ $resolvedSubco }}" placeholder="Isi Sub Co..." class="w-full text-[10px] px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-400 dark:text-gray-500 uppercase font-black tracking-widest">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <button type="button" class="remove-participant p-1.5 text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="no-participants">
                                        <td colspan="6" class="px-4 py-8 text-center text-xs text-gray-500 bg-gray-50 dark:bg-gray-900/30 italic">Belum ada peserta yang dipilih.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="flex items-center justify-center gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 -mx-6">
                <a href="{{ route('admin.master-trainings.index') }}"
                    class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 shadow-sm">
                    Batal
                </a>
                <button type="submit"
                    class="px-12 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-indigo-200 dark:shadow-none ring-offset-2 focus:ring-2 focus:ring-indigo-500">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('participants-wrapper');
            const searchInput = document.getElementById('quick-search-participant');
            const suggestions = document.getElementById('quick-search-suggestions');
            let participantIndex = {{ count($participants ?? []) }};
            
            const trainersWrapper = document.getElementById('trainers-wrapper');
            const trainerSearchInput = document.getElementById('quick-search-trainer');
            const trainerSuggestions = document.getElementById('quick-search-trainer-suggestions');
            let trainerIndex = {{ count($trainers ?? []) }};

            // Common helper for highlighting search terms
            const highlightText = (text, query) => {
                if (!query) return text;
                const regex = new RegExp(`(${query})`, 'gi');
                return text.replace(regex, '<mark class="bg-indigo-500/30 text-indigo-200 rounded px-0.5">$1</mark>');
            };

            const addTrainerRow = (user) => {
                const noTrainers = document.getElementById('no-trainers');
                if (noTrainers) noTrainers.remove();

                const existingNpks = Array.from(trainersWrapper.querySelectorAll('input[name*="[npk]"]')).map(i => i.value);
                if (existingNpks.includes(user.npk) && user.npk !== '') {
                    alert('Trainer ini sudah ada dalam daftar.');
                    return;
                }

                const photoHtml = user.photo 
                    ? `<img src="${user.photo}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700">` 
                    : `<div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">${user.name.charAt(0)}</div>`;

                const html = `
                    <div class="trainer-row flex flex-col md:flex-row gap-4 items-center bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl relative group animate-fade-in border border-gray-100 dark:border-gray-800">
                        ${photoHtml}
                        <input type="hidden" name="trainers[${trainerIndex}][photo]" value="${user.photo || ''}">
                        <input type="hidden" name="trainers[${trainerIndex}][npk]" value="${user.npk}">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama Trainer</label>
                                <input type="text" name="trainers[${trainerIndex}][name]" value="${user.name}" readonly class="bg-transparent border-none p-0 text-gray-900 dark:text-white text-sm font-bold focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen/Instansi</label>
                                <input type="text" name="trainers[${trainerIndex}][department]" value="${user.department || '-'}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Company</label>
                                <input type="text" name="trainers[${trainerIndex}][subco]" value="${user.subco || '-'}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-1 flex justify-end">
                                <button type="button" class="remove-trainer p-2 text-red-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                trainersWrapper.insertAdjacentHTML('beforeend', html);
                trainerIndex++;
                trainerSearchInput.value = '';
                trainerSuggestions.classList.add('hidden');
                trainerSearchInput.focus();
            };

            const performTrainerSearch = (query) => {
                if (query.length < 3) {
                    trainerSuggestions.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('admin.search-users') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            trainerSuggestions.innerHTML = data.map(user => `
                                <div class="quick-suggestion-item-trainer px-4 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-center gap-4 group" 
                                     data-user='${JSON.stringify(user)}'>
                                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-gray-200 dark:border-gray-700">
                                        ${user.photo 
                                            ? `<img src="${user.photo}" class="w-full h-full object-cover">` 
                                            : `<div class="w-full h-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold">${user.name.charAt(0)}</div>`}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">${highlightText(user.npk || '-', query)}</p>
                                            <span class="text-gray-300 dark:text-gray-600">•</span>
                                            <p class="text-[10px] text-gray-500">${user.department || '-'}</p>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white mt-0.5">${highlightText(user.name, query)}</p>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center">
                                        <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded">TAMBAH</span>
                                    </div>
                                </div>
                            `).join('');
                            trainerSuggestions.classList.remove('hidden');
                        } else {
                            trainerSuggestions.innerHTML = '<div class="px-4 py-3 text-xs text-gray-500 italic">Tidak ada hasil ditemukan.</div>';
                            trainerSuggestions.classList.remove('hidden');
                        }
                    });
            };

            let trainerTimeout = null;
            trainerSearchInput.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(trainerTimeout);
                trainerTimeout = setTimeout(() => performTrainerSearch(query), 300);
            });

            trainerSearchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(trainerTimeout);
                    performTrainerSearch(this.value);
                }
            });

            trainerSuggestions.addEventListener('click', function(e) {
                const item = e.target.closest('.quick-suggestion-item-trainer');
                if (item) {
                    const user = JSON.parse(item.dataset.user);
                    addTrainerRow(user);
                }
            });

// Script for PICs
            const picsWrapper = document.getElementById('pics-wrapper');
            const picSearchInput = document.getElementById('quick-search-pic');
            const picSuggestions = document.getElementById('quick-search-pic-suggestions');
            let picIndex = {{ count($pics ?? []) }};

            const addPICRow = (user) => {
                const noPICs = document.getElementById('no-pics');
                if (noPICs) noPICs.remove();

                const existingNpks = Array.from(picsWrapper.querySelectorAll('input[name*="[npk]"]')).map(i => i.value);
                if (existingNpks.includes(user.npk) && user.npk !== '') {
                    alert('PIC ini sudah ada dalam daftar.');
                    return;
                }

                const photoHtml = user.photo 
                    ? `<img src="${user.photo}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700">` 
                    : `<div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">${user.name.charAt(0)}</div>`;

                const html = `
                    <div class="pic-row flex flex-col md:flex-row gap-4 items-center bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl relative group animate-fade-in border border-gray-100 dark:border-gray-800">
                        ${photoHtml}
                        <input type="hidden" name="pics[${picIndex}][photo]" value="${user.photo || ''}">
                        <input type="hidden" name="pics[${picIndex}][npk]" value="${user.npk}">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama PIC</label>
                                <input type="text" name="pics[${picIndex}][name]" value="${user.name}" readonly class="bg-transparent border-none p-0 text-gray-900 dark:text-white text-sm font-bold focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen/Instansi</label>
                                <input type="text" name="pics[${picIndex}][department]" value="${user.department || '-'}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Company</label>
                                <input type="text" name="pics[${picIndex}][subco]" value="${user.subco || '-'}" readonly class="bg-transparent border-none p-0 text-gray-500 dark:text-gray-400 text-xs focus:ring-0 w-full">
                            </div>
                            <div class="md:col-span-1 flex justify-end">
                                <button type="button" class="remove-pic p-2 text-red-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                picsWrapper.insertAdjacentHTML('beforeend', html);
                picIndex++;
                picSearchInput.value = '';
                picSuggestions.classList.add('hidden');
                picSearchInput.focus();
            };

            const performPICSearch = (query) => {
                if (query.length < 3) {
                    picSuggestions.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('admin.search-users') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            picSuggestions.innerHTML = data.map(user => `
                                <div class="quick-suggestion-item-pic px-4 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-center gap-4 group" 
                                     data-user='${JSON.stringify(user)}'>
                                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-gray-200 dark:border-gray-700">
                                        ${user.photo 
                                            ? `<img src="${user.photo}" class="w-full h-full object-cover">` 
                                            : `<div class="w-full h-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold">${user.name.charAt(0)}</div>`}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">${highlightText(user.npk || '-', query)}</p>
                                            <span class="text-gray-300 dark:text-gray-600">•</span>
                                            <p class="text-[10px] text-gray-500">${user.department || '-'}</p>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white mt-0.5">${highlightText(user.name, query)}</p>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center">
                                        <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded">TAMBAH</span>
                                    </div>
                                </div>
                            `).join('');
                            picSuggestions.classList.remove('hidden');
                        } else {
                            picSuggestions.innerHTML = '<div class="px-4 py-3 text-xs text-gray-500 italic">Tidak ada hasil ditemukan.</div>';
                            picSuggestions.classList.remove('hidden');
                        }
                    });
            };

            let picTimeout = null;
            picSearchInput.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(picTimeout);
                picTimeout = setTimeout(() => performPICSearch(query), 300);
            });

            picSearchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(picTimeout);
                    performPICSearch(this.value);
                }
            });

            picSuggestions.addEventListener('click', function(e) {
                const item = e.target.closest('.quick-suggestion-item-pic');
                if (item) {
                    const user = JSON.parse(item.dataset.user);
                    addPICRow(user);
                }
            });

            document.getElementById('btn-add-manual-pic').addEventListener('click', function() {
                const noPICs = document.getElementById('no-pics');
                if (noPICs) noPICs.remove();

                const html = `
                    <div class="pic-row bg-indigo-50/30 dark:bg-indigo-900/10 flex flex-col md:flex-row gap-4 items-center p-4 rounded-xl relative group animate-fade-in border border-indigo-100 dark:border-indigo-900/30">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">M</div>
                        <input type="hidden" name="pics[${picIndex}][photo]" value="">
                        <input type="hidden" name="pics[${picIndex}][is_manual]" value="1">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">NPK</label>
                                <input type="text" name="pics[${picIndex}][npk]" placeholder="NPK" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white" required>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama PIC</label>
                                <input type="text" name="pics[${picIndex}][name]" placeholder="Nama Lengkap" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white" required>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen</label>
                                <input type="text" name="pics[${picIndex}][department]" placeholder="Instansi/Dept" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Co</label>
                                <input type="text" name="pics[${picIndex}][subco]" placeholder="Sub Company" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-1 flex justify-end items-end pb-1">
                                <button type="button" class="remove-pic p-1.5 text-red-500 hover:text-red-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                picsWrapper.insertAdjacentHTML('beforeend', html);
                picIndex++;
            });

            picsWrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-pic')) {
                    e.target.closest('.pic-row').remove();
                    if (picsWrapper.querySelectorAll('.pic-row').length === 0) {
                        picsWrapper.innerHTML = `<div id="no-pics" class="text-center py-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border-2 border-dashed border-gray-100 dark:border-gray-800"><p class="text-xs text-gray-400 italic">Belum ada pic.</p></div>`;
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#quick-search-pic') && !e.target.closest('#quick-search-pic-suggestions')) {
                    picSuggestions.classList.add('hidden');
                }
            });

            document.getElementById('btn-add-manual-trainer').addEventListener('click', function() {
                const noTrainers = document.getElementById('no-trainers');
                if (noTrainers) noTrainers.remove();

                const html = `
                    <div class="trainer-row bg-indigo-50/30 dark:bg-indigo-900/10 flex flex-col md:flex-row gap-4 items-center p-4 rounded-xl relative group animate-fade-in border border-indigo-100 dark:border-indigo-900/30">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-gray-200 dark:border-gray-700">M</div>
                        <input type="hidden" name="trainers[${trainerIndex}][photo]" value="">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-3 w-full">
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">NPK</label>
                                <input type="text" name="trainers[${trainerIndex}][npk]" placeholder="NPK" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white" required>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Nama Trainer</label>
                                <input type="text" name="trainers[${trainerIndex}][name]" placeholder="Nama Lengkap" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white" required>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Departemen</label>
                                <input type="text" name="trainers[${trainerIndex}][department]" placeholder="Instansi/Dept" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-0.5">Sub Co</label>
                                <input type="text" name="trainers[${trainerIndex}][subco]" placeholder="Sub Company" class="w-full text-xs px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            </div>
                            <div class="md:col-span-1 flex justify-end items-end pb-1">
                                <button type="button" class="remove-trainer p-1.5 text-red-500 hover:text-red-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                trainersWrapper.insertAdjacentHTML('beforeend', html);
                trainerIndex++;
            });

            trainersWrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-trainer')) {
                    e.target.closest('.trainer-row').remove();
                    if (trainersWrapper.querySelectorAll('.trainer-row').length === 0) {
                        trainersWrapper.innerHTML = `<div id="no-trainers" class="text-center py-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border-2 border-dashed border-gray-100 dark:border-gray-800"><p class="text-xs text-gray-400 italic">Belum ada trainer.</p></div>`;
                    }
                }
            });

            // Function to update participant row numbers and count
            const updateParticipantDisplay = () => {
                const rows = wrapper.querySelectorAll('.participant-row');
                const countBadge = document.getElementById('participant-count');
                if (countBadge) countBadge.textContent = rows.length;
                
                rows.forEach((row, idx) => {
                    const numCell = row.querySelector('.participant-number');
                    if (numCell) numCell.textContent = idx + 1;
                });

                if (rows.length === 0) {
                    wrapper.innerHTML = `<tr id="no-participants"><td colspan="7" class="px-4 py-8 text-center text-xs text-gray-500 bg-gray-50 dark:bg-gray-900/30 italic">Belum ada peserta yang dipilih.</td></tr>`;
                }
            };
            
            // Initialize count on load
            updateParticipantDisplay();

            const addParticipantRow = (user) => {
                const noParticipants = document.getElementById('no-participants');
                if (noParticipants) noParticipants.remove();

                // Check if already in list
                const existingNpks = Array.from(wrapper.querySelectorAll('input[name*="[npk]"]')).map(i => i.value);
                if (existingNpks.includes(user.npk) && user.npk !== '') {
                    alert('Peserta ini sudah ada dalam daftar.');
                    return;
                }

                const photoHtml = user.photo 
                    ? `<img src="${user.photo}" class="w-8 h-8 rounded-full object-cover border border-gray-200 dark:border-gray-700">` 
                    : `<div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold border border-gray-200 dark:border-gray-700">${user.name.charAt(0)}</div>`;

                const html = `
                    <tr class="participant-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group animate-fade-in">
                        <td class="px-4 py-3 text-center text-gray-900 dark:text-white font-medium participant-number"></td>
                        <td class="px-4 py-3 flex justify-center">${photoHtml}</td>
                        <td class="px-4 py-3">
                            <input type="hidden" name="participants[${participantIndex}][photo]" value="${user.photo || ''}">
                            <input type="text" name="participants[${participantIndex}][npk]" value="${user.npk}" readonly class="w-full text-[10px] font-mono px-2 py-1 rounded bg-transparent border-none focus:ring-0 text-indigo-600 dark:text-indigo-400 font-black tracking-tighter" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][name]" value="${user.name}" class="w-full text-xs font-bold px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-900 dark:text-white" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][department]" value="${user.department || '-'}" class="w-full text-[10px] px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-500 dark:text-gray-400 uppercase font-medium">
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][subco]" value="${user.subco || ''}" placeholder="Isi Sub Co..." class="w-full text-[10px] px-2 py-1 rounded bg-transparent border-none focus:ring-1 focus:ring-indigo-500/30 text-gray-400 dark:text-gray-500 uppercase font-black tracking-widest">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" class="remove-participant p-1.5 text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                wrapper.insertAdjacentHTML('beforeend', html);
                participantIndex++;
                updateParticipantDisplay();
                searchInput.value = '';
                suggestions.classList.add('hidden');
                searchInput.focus();
            };

            document.getElementById('btn-add-manual-participant').addEventListener('click', function() {
                const noParticipants = document.getElementById('no-participants');
                if (noParticipants) noParticipants.remove();

                const html = `
                    <tr class="participant-row bg-indigo-50/30 dark:bg-indigo-900/10 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group animate-fade-in">
                        <td class="px-4 py-3 text-center text-gray-900 dark:text-white font-medium participant-number"></td>
                        <td class="px-4 py-3 flex justify-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold border border-gray-200 dark:border-gray-700">M</div>
                            <input type="hidden" name="participants[${participantIndex}][photo]" value="">
                        </td>
                        <td class="px-4 py-3">
                            <input type="hidden" name="participants[${participantIndex}][is_manual]" value="1">
                            <input type="text" name="participants[${participantIndex}][npk]" placeholder="NPK" class="w-full text-[10px] font-mono px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-indigo-600 dark:text-indigo-400 font-black tracking-tighter" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][name]" placeholder="Nama Lengkap" class="w-full text-xs font-bold px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-900 dark:text-white" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][department]" placeholder="Departemen" class="w-full text-[10px] px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-500 dark:text-gray-400 uppercase font-medium">
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="participants[${participantIndex}][subco]" placeholder="Sub Company" class="w-full text-[10px] px-2 py-1 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 text-gray-400 dark:text-gray-500 uppercase font-black tracking-widest">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" class="remove-participant p-1.5 text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                wrapper.insertAdjacentHTML('beforeend', html);
                participantIndex++;
                updateParticipantDisplay();
            });


            const performSearch = (query) => {
                if (query.length < 3) {
                    suggestions.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('admin.search-users') }}?q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            suggestions.innerHTML = data.map(user => `
                                <div class="quick-suggestion-item px-4 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-center gap-4 group" 
                                     data-user='${JSON.stringify(user)}'>
                                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-gray-200 dark:border-gray-700">
                                        ${user.photo 
                                            ? `<img src="${user.photo}" class="w-full h-full object-cover">` 
                                            : `<div class="w-full h-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold">${user.name.charAt(0)}</div>`}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">${highlightText(user.npk || '-', query)}</p>
                                            <span class="text-gray-300 dark:text-gray-600">•</span>
                                            <p class="text-[10px] text-gray-500">${user.department || '-'}</p>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white mt-0.5">${highlightText(user.name, query)}</p>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center">
                                        <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded">PILIH</span>
                                    </div>
                                </div>
                            `).join('');
                            suggestions.classList.remove('hidden');
                        } else {
                            suggestions.innerHTML = '<div class="px-4 py-3 text-xs text-gray-500 italic">Tidak ada hasil ditemukan.</div>';
                            suggestions.classList.remove('hidden');
                        }
                    });
            };

            let timeout = null;
            searchInput.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(timeout);
                timeout = setTimeout(() => performSearch(query), 300);
            });

            // Cegah Enter melakukan submit form, dialihkan untuk mencari
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Stop form submit
                    clearTimeout(timeout);
                    performSearch(this.value);
                }
            });

            suggestions.addEventListener('click', function(e) {
                const item = e.target.closest('.quick-suggestion-item');
                if (item) {
                    const user = JSON.parse(item.dataset.user);
                    addParticipantRow(user);
                }
            });


            wrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-participant')) {
                    e.target.closest('.participant-row').remove();
                    updateParticipantDisplay();
                }
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#quick-search-participant') && !e.target.closest('#quick-search-suggestions')) {
                    suggestions.classList.add('hidden');
                }
            });
        });
    </script>
</x-admin-layout>