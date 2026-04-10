<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master-trainings.index') }}"
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Detail Master Training</h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Header/Banner --}}
            <div class="bg-indigo-600 px-8 py-10 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[10px] font-black text-indigo-200 uppercase tracking-widest">No. Training</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-widest">
                                {{ $masterTraining->event_no }}
                            </span>
                        </div>
                        <h1 class="mt-4 text-3xl font-black tracking-tight leading-tight">
                            {{ $masterTraining->training_course }}
                        </h1>
                        <p class="mt-2 text-indigo-100 font-medium opacity-90">
                            {{ $masterTraining->training_topic }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-white text-indigo-600 shadow-lg">
                            {{ $masterTraining->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Left Column: Details --}}
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Penyelenggara &
                                Jenis</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Provider
                                        </p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $masterTraining->provider }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Tipe
                                            Provider</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $masterTraining->provider_type }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Waktu
                                Pelaksanaan</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Tanggal
                                        </p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $masterTraining->start_date->format('d M Y') }} -
                                            {{ $masterTraining->end_date->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Jam &
                                            Kompetensi</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ substr($masterTraining->start_time, 0, 5) }} -
                                            {{ substr($masterTraining->end_time, 0, 5) }} WIB
                                            <span
                                                class="ml-2 text-indigo-600 dark:text-indigo-400 font-black tracking-tighter">/
                                                Min. Score:
                                                {{ number_format($masterTraining->passing_grade, 0) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Description --}}
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Deskripsi Training
                        </h3>
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 min-h-[200px]">
                            @if($masterTraining->description)
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $masterTraining->description }}
                                </p>
                            @else
                                <div class="h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8 mb-2 opacity-20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    <p class="text-xs italic">Tidak ada deskripsi tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    @if($masterTraining->training_id && \App\Models\Training::find($masterTraining->training_id))
                        {{-- Sudah pernah dieksen — tampilkan tombol ke laporan --}}
                        <a href="{{ route('admin.trainings.show', $masterTraining->training_id) }}"
                            class="px-8 py-3 bg-emerald-600 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Lihat Laporan Training
                        </a>
                    @else
                        {{-- Belum dieksen --}}
                        <form action="{{ route('admin.master-trainings.execute', $masterTraining) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2"
                                onclick="confirmAction(event, 'Eksekusi training ini? Data peserta akan disalin ke laporan training.', 'question')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Eksekusi Training
                            </button>
                        </form>
                    @endif

                    <div class="flex gap-3">
                        <a href="{{ route('admin.master-trainings.edit', $masterTraining) }}"
                            class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-white rounded-xl text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('admin.master-trainings.destroy', $masterTraining) }}" method="POST"
                            onsubmit="confirmAction(event, 'Hapus data master training ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2.5 bg-red-50 text-red-600 rounded-xl text-sm font-bold hover:bg-red-100 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trainers & Participants --}}
        <div class="mt-8 space-y-8">
            {{-- Trainers --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-8">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Trainers / Instruktur
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($masterTraining->trainers ?? [] as $trainer)
                        <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600">
                             <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 font-bold shrink-0 border border-indigo-200 dark:border-indigo-800/30">
                                {{ substr($trainer['name'] ?? '?', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $trainer['name'] ?? '-' }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">{{ $trainer['npk'] ?? '-' }}</p>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium uppercase truncate">{{ $trainer['subco'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                             <p class="text-xs italic uppercase tracking-widest font-bold">Belum ada trainer terdaftar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- PICs --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-8">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    PIC / Penanggung Jawab
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($masterTraining->pics ?? [] as $pic)
                        <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600">
                             <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-500 font-bold shrink-0 border border-blue-200 dark:border-blue-800/30">
                                {{ substr($pic['name'] ?? '?', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $pic['name'] ?? '-' }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-tighter">{{ $pic['npk'] ?? '-' }}</p>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium uppercase truncate">{{ $pic['subco'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                             <p class="text-xs italic uppercase tracking-widest font-bold">Belum ada PIC terdaftar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Participants --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-8">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Peserta Training ({{ count($masterTraining->participants ?? []) }})
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs font-black text-gray-500 uppercase tracking-widest border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3">Nama Peserta</th>
                                <th class="px-4 py-3">NPK</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3 text-right">Sub Company</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($masterTraining->participants ?? [] as $participant)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-gray-900 dark:text-white">{{ $participant['name'] }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-black tracking-tighter">{{ $participant['npk'] }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ $participant['department'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md">{{ $participant['subco'] ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 italic">Belum ada peserta.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>