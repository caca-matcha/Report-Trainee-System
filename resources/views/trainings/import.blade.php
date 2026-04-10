<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.trainings.show', $training) }}"
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Import Peserta Training</h2>
        </div>
    </x-slot>

    <div class="max-w-[98%] mx-auto py-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-8">
                <div
                    class="flex items-center gap-4 mb-10 p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl">
                    <div
                        class="w-12 h-12 bg-white dark:bg-gray-800 rounded-lg flex items-center justify-center text-indigo-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $training->title }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pilih metode penambahan peserta
                            (Internal/Eksternal).</p>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto">
                    <!-- Area 1: Batch Import -->
                    <div
                        class="p-8 bg-gray-50/50 dark:bg-gray-900/40 rounded-3xl border border-gray-100 dark:border-gray-700/50 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            </svg>
                        </div>

                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">
                                        Grup / Batch Import</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">Upload file Excel atau CSV
                                        sekaligus.</p>
                                </div>
                            </div>

                            <a href="{{ route('trainings.participant_template', $training) }}"
                                class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-black rounded-xl uppercase hover:bg-emerald-100 transition-all flex items-center gap-2 border border-emerald-100 dark:border-emerald-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Template Peserta
                            </a>
                        </div>

                        <form action="{{ route('trainings.import', $training) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Pilih
                                    File</label>
                                <input type="file" name="file" required
                                    class="block w-full text-[10px] text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gray-200 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-indigo-600 hover:file:text-white transition-all cursor-pointer">
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach (['No', 'NPK', 'Nama', 'Dept'] as $col)
                                    <div
                                        class="px-3 py-2 bg-white dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700/50 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                                        <span
                                            class="text-[9px] font-bold text-gray-600 dark:text-gray-400 capitalize">{{ $col }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-[9px] text-gray-400 mt-2 px-1">* Foto akan otomatis diambil dari Master Trainee
                                menggunakan NPK.</p>

                            <button type="submit"
                                class="w-full py-4 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none hover:scale-[1.01] active:scale-[0.99]">
                                Mulai Import Data Peserta
                            </button>
                        </form>
                    </div>
                </div>

                @if(session('error'))
                    <div
                        class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl flex items-center gap-3 text-red-600 dark:text-red-400">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Daftar Peserta Terdaftar -->
                <div class="mt-12 space-y-6">
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xs font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">
                                Peserta Terdaftar ({{ $training->participants->count() }})</h4>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-900/20 rounded-3xl border border-gray-100 dark:border-gray-700/50 overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center w-12">
                                            No</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                            Foto</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            NPK & Nama</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            Unit / Instansi</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                    @forelse($training->participants as $index => $participant)
                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors group">
                                            <td class="px-6 py-4 text-center text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $photo = $participant->photo_path ?: ($participant->user ? $participant->user->photo : null);
                                                    $editLink = $participant->user
                                                        ? route('admin.employees.edit', $participant->user)
                                                        : route('admin.employees.create', [
                                                            'name' => $participant->name,
                                                            'npk' => $participant->npk,
                                                            'department' => $participant->department,
                                                            'subco' => $participant->subco,
                                                        ]);
                                                @endphp
                                                <div class="flex flex-col items-center gap-1.5">
                                                    <a href="{{ $photo ? asset('storage/' . $photo) : (auth()->user()->role === 'admin' ? $editLink : '#') }}"
                                                        {{ $photo ? 'target="_blank"' : '' }}
                                                        class="block w-10 h-10 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-100 dark:border-gray-700 shadow-sm mx-auto hover:opacity-80 transition-opacity">
                                                        @if ($photo)
                                                            <img src="{{ asset('storage/' . $photo) }}"
                                                                class="w-full h-full object-cover" alt="{{ $participant->name }}">
                                                        @else
                                                            <div
                                                                class="w-full h-full flex items-center justify-center bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-black">
                                                                {{ strtoupper(substr($participant->name, 0, 1)) }}
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
                                            <td class="px-6 py-4">
                                                <p class="text-[9px] text-indigo-500 font-bold uppercase tracking-wider">
                                                    {{ $participant->npk }}</p>
                                                <p class="text-[11px] font-black text-gray-900 dark:text-white">
                                                    {{ $participant->name }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-[10px] font-bold text-gray-600 dark:text-gray-300">
                                                    {{ $participant->department }}</p>
                                                <p class="text-[9px] text-gray-400 font-medium">{{ $participant->subco }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <form
                                                    action="{{ route('trainings.remove_participant', [$training, $participant]) }}"
                                                    method="POST" onsubmit="return confirm('Hapus peserta ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <div
                                                        class="w-12 h-12 bg-gray-50 dark:bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-200 dark:text-gray-700">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 1.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-1.414A1 1 0 006.586 13H4" />
                                                        </svg>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                        Belum ada peserta.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div
                    class="flex justify-between items-center pt-10 mt-10 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Pilih Metode Sesuai Jenis Peserta</p>
                    </div>
                    <a href="{{ route('admin.trainings.show', $training) }}"
                        class="px-6 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-500 hover:text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 shadow-sm">
                        Kembali Ke Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-admin-layout>