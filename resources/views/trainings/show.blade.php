<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Training Details') }}
            </h2>
            <div class="flex items-center gap-2">
                @if($training->status == 'draft')
                    <a href="{{ route('trainings.scoring', $training) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Input Scoring
                    </a>

                    <a href="{{ route('trainings.attendance_qr', $training) }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded text-sm transition flex items-center gap-2">
                        Attendance QR
                    </a>

                    <a href="{{ route('trainings.attendance_list', $training) }}"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded text-sm transition flex items-center gap-2">
                        Attendance List
                    </a>

                    <a href="{{ route('summaries.show', $training) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Summary Report
                    </a>

                    <a href="{{ route('trainings.edit', $training) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Edit
                    </a>

                    <form action="{{ route('trainings.update', $training) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition"
                            onclick="return confirm('Tandai training selesai (Approved)? Data tidak bisa diubah lagi setelah status menjadi Approved.')">
                            Tandai Selesai
                        </button>
                    </form>
                @else
                    <a href="{{ route('summaries.show', $training) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Summary Report
                    </a>
                    <button disabled class="bg-gray-400 text-white font-bold py-2 px-4 rounded text-sm cursor-not-allowed flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Approved
                    </button>
                @endif
                <a href="{{ route('trainings.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Training Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Training</p>
                            <p class="font-semibold text-lg">{{ $training->title }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $training->status == 'draft' ? 'bg-gray-200 text-gray-700' : '' }}
                                {{ $training->status == 'pending_approval' ? 'bg-yellow-200 text-yellow-700' : '' }}
                                {{ $training->status == 'approved' ? 'bg-green-200 text-green-700' : '' }}
                                {{ $training->status == 'rejected' ? 'bg-red-200 text-red-700' : '' }}
                            ">
                                {{ ucfirst(str_replace('_', ' ', $training->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                @if($training->end_date)
                                    - {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                            <p class="font-medium text-indigo-600 dark:text-indigo-400 font-bold uppercase">{{ $training->training_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Passing Grade</p>
                            <p class="font-bold text-indigo-600 dark:text-indigo-400 text-xl">{{ (float)$training->passing_grade }}<span class="text-xs ml-1">%</span></p>
                        </div>

                        {{-- Collapsible Additional Info --}}
                        <div x-data="{ expanded: false }" class="md:col-span-2 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                            <button @click="expanded = !expanded" class="flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:opacity-70 transition-all outline-none">
                                <svg class="w-3 h-3 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                                <span x-text="expanded ? 'Sembunyikan Detail' : 'Lihat Detail Pelatihan'"></span>
                            </button>
                            
                            <div x-show="expanded" x-collapse x-cloak class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900/30 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kurikulum Master</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white leading-tight">
                                            {{ $training->masterTraining->training_course ?? $training->title }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis / Kategori</p>
                                        <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                            {{ $training->masterTraining->category ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Topik & Deskripsi</p>
                                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="text-indigo-500">Topik:</span> {{ $training->training_topic ?: '-' }}
                                    </p>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-400 italic leading-relaxed">
                                        {{ $training->description ?: 'Tidak ada deskripsi tambahan.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendation Section (Full Width) -->
                        <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <form action="{{ route('summaries.store', $training) }}" method="POST">
                                @csrf
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2 font-medium">Recommendation for next Participant</p>
                                <textarea name="recommendation" rows="3"
                                    class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-indigo-500 text-sm disabled:opacity-50 disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
                                    placeholder="Masukkan rekomendasi untuk peserta/pelatihan selanjutnya..."
                                    {{ $training->status == 'approved' ? 'disabled' : '' }}>{{ old('recommendation', $training->summary->recommendation ?? '') }}</textarea>
                                <div class="mt-2 flex justify-end">
                                    @if($training->status != 'approved')
                                        <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1.5 px-4 rounded text-xs transition shadow-sm">
                                            Save Recommendation
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Participants</h3>
                        <div class="flex items-center gap-2">
                            @if($training->status == 'draft')
                                <a href="{{ route('trainings.observation_template', $training) }}"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1 px-3 rounded text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Template Observasi
                                </a>
                                <button onclick="document.getElementById('importObservationModal').classList.remove('hidden')"
                                    class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-1 px-3 rounded text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import Observasi
                                </button>
                                <div class="relative group mr-2">
                                    <input type="text" id="quick-search-participant" placeholder="Cari & Tambah Peserta..." 
                                        class="w-64 pl-10 pr-4 py-1.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 transition-all dark:text-gray-200">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <div id="quick-search-suggestions" class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-2xl mt-2 hidden max-h-64 overflow-y-auto"></div>
                                </div>
                                <a href="{{ route('trainings.participants.create', $training) }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1.5 px-4 rounded-xl text-xs flex items-center gap-1 transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Manual
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border-none">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase">
                                    <th class="py-2 px-4 text-center w-12">No</th>
                                    <th class="py-2 px-4 text-center w-12">Foto</th>
                                    <th class="py-2 px-4 text-left">NPK</th>
                                    <th class="py-2 px-4 text-left">Name</th>
                                    <th class="py-2 px-4 text-left">Dept</th>
                                    <th class="py-2 px-4 text-center">Pre Test</th>
                                    <th class="py-2 px-4 text-center">Post Test</th>
                                    <th class="py-2 px-4 text-center">Punctuality</th>
                                    <th class="py-2 px-4 text-center">Activeness</th>
                                    <th class="py-2 px-4 text-center">Cooperation</th>
                                    <th class="py-2 px-4 text-center">Attitude</th>
                                    <th class="py-2 px-4 text-center">Present</th>
                                    <th class="py-2 px-4 text-center">Status</th>
                                    @if($training->status == 'draft')
                                        <th class="py-2 px-4 text-center">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 dark:text-gray-200 text-sm">
                                @forelse($training->participants as $index => $participant)
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-4 text-center text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                        <td class="py-2 px-4">
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
                                            <div class="flex flex-col items-center gap-1">
                                                <a href="{{ $photo ? asset('storage/' . $photo) : (auth()->user()->role === 'admin' ? $editLink : '#') }}"
                                                    {{ $photo ? 'target="_blank"' : '' }}
                                                    class="block w-8 h-8 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 mx-auto border border-gray-200 dark:border-gray-600 hover:opacity-80 transition-opacity">
                                                    @if ($photo)
                                                        <img src="{{ asset('storage/' . $photo) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">
                                                            {{ substr($participant->name, 0, 2) }}
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
                                        <td class="py-2 px-4 font-mono text-xs">{{ $participant->npk }}</td>
                                        <td class="py-2 px-4">{{ $participant->name }}</td>
                                        <td class="py-2 px-4 text-xs">{{ $participant->department }}</td>
                                        <td class="py-2 px-4 text-center">
                                            <input type="number" 
                                                value="{{ $participant->pre_test_score !== null ? round($participant->pre_test_score) : '' }}"
                                                onblur="updateScore({{ $participant->id }}, 'pre_test', this.value)"
                                                class="w-16 h-8 text-center text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0"
                                                {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                        </td>
                                        <td class="py-2 px-4 text-center">
                                            <input type="number" 
                                                value="{{ $participant->post_test_score !== null ? round($participant->post_test_score) : '' }}"
                                                onblur="updateScore({{ $participant->id }}, 'post_test', this.value)"
                                                class="w-16 h-8 text-center text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-0 font-semibold {{ $participant->post_test_score !== null && $participant->post_test_score >= $training->passing_grade ? 'text-green-600' : ($participant->post_test_score !== null ? 'text-red-500' : 'text-gray-400') }}"
                                                {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                        </td>
                                        <td class="py-2 px-4 text-center">{{ $participant->punctuality_score ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center">{{ $participant->activeness_score ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center">{{ $participant->cooperation_score ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center">{{ $participant->attitude_score ?? '-' }}</td>
                                        <td class="py-2 px-4 text-center">
                                            <button type="button" id="attendance-btn-{{ $participant->id }}" onclick="toggleAttendance({{ $participant->id }}, this)"
                                                class="focus:outline-none transition-transform hover:scale-105 active:scale-95 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                                {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                                @if($participant->is_present)
                                                    <span class="text-green-500 font-bold">✔ Hadir</span>
                                                @else
                                                    <span class="text-red-500 font-bold">✘ Tidak</span>
                                                @endif
                                            </button>
                                        </td>
                                        <td class="py-2 px-4 text-center" id="pass-fail-status-{{ $participant->id }}">
                                            @if($participant->post_test_score !== null)
                                                @if($participant->post_test_score >= $training->passing_grade)
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Pass</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Not Pass</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        @if($training->status == 'draft')
                                            <td class="py-2 px-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    {{-- Edit Button --}}
                                                    <button type="button" 
                                                        onclick="openEditModal({{ json_encode($participant) }})"
                                                        class="p-1.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>

                                                    {{-- Delete Button --}}
                                                    <form action="{{ route('participants.destroy', $participant) }}" method="POST"
                                                        class="inline" onsubmit="return confirm('Hapus peserta dari training ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="p-1.5 bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 rounded-lg hover:bg-red-100 transition-colors">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="py-4 text-center text-gray-500">No participants added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <!-- ============================================================ -->
            <!-- VISUALISASI SCORING (PREMIUM DESIGN) -->
            <!-- ============================================================ -->
            @php
                $participantsWithScore = $training->participants;
            @endphp

            @if($participantsWithScore->count() > 0)
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
                    @foreach($participantsWithScore as $p)
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
                                        <span class="text-[9px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest">Not Pass</span>
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
                            <div class="flex-1 w-full grid grid-cols-1 lg:grid-cols-12 gap-4 h-auto lg:h-32">
                                {{-- Bar Chart (Exam) --}}
                                <div class="lg:col-span-6 h-32 lg:h-full relative bg-gray-50/30 dark:bg-gray-900/20 rounded-2xl border border-gray-100/50 dark:border-gray-700/30 p-3">
                                    <div class="absolute top-1.5 left-3">
                                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em] opacity-60">Exam Result</span>
                                    </div>
                                    <canvas id="examChart_{{ $p->id }}"></canvas>
                                </div>

                                {{-- Radar Chart (Soft Skills) --}}
                                <div class="lg:col-span-6 h-32 lg:h-full relative bg-gray-50/30 dark:bg-gray-900/20 rounded-2xl border border-gray-100/50 dark:border-gray-700/30 p-1">
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
            <!-- ============================================================ -->

            <!-- Import Observation Modal -->
            <div id="importObservationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Import Nilai Observasi</h3>
                        <form action="{{ route('trainings.import_observation', $training) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mb-4">
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="document.getElementById('importObservationModal').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Edit Participant Modal -->
            <div id="editParticipantModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity">
                <div class="relative top-20 mx-auto p-8 border w-[420px] shadow-2xl rounded-[2.5rem] bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700 animate-fade-in">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-wider">Edit Data Peserta</h3>
                        </div>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    
                    <form id="editParticipantForm" onsubmit="submitEditForm(event)" class="space-y-4">
                        <input type="hidden" id="edit_participant_id">
                        
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                            <input type="text" id="edit_name" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl text-sm font-bold dark:text-white focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">NPK</label>
                            <div class="px-4 py-3 bg-gray-100 dark:bg-gray-900/50 border-none rounded-2xl text-sm font-mono text-gray-500 dark:text-gray-400" id="edit_npk_display"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Departemen</label>
                                <input type="text" id="edit_department" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl text-xs font-bold dark:text-white focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Sub Co</label>
                                <input type="text" id="edit_subco" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl text-xs font-bold dark:text-white focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-indigo-500/30 transition-all active:scale-95">Simpan Perubahan</button>
                            <button type="button" onclick="closeEditModal()" class="px-6 py-3.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-200 transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        function toggleAttendance(participantId, button) {
            const originalContent = button.innerHTML;
            button.innerHTML = '<span class="text-gray-400 font-bold">...</span>';
            button.disabled = true;

            fetch(`/participants/${participantId}/toggle-attendance`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_present) {
                        button.innerHTML = '<span class="text-green-500 font-bold">✔ Hadir</span>';
                    } else {
                        button.innerHTML = '<span class="text-red-500 font-bold">✘ Tidak</span>';
                    }
                } else {
                    button.innerHTML = originalContent;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalContent;
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
                    const btn = document.getElementById(`attendance-btn-${participantId}`);
                    if (data.is_present && btn) {
                        btn.innerHTML = '<span class="text-green-500 font-bold">✔ Hadir</span>';
                    }

                    if (type === 'post_test') {
                        const statusCell = document.getElementById(`pass-fail-status-${participantId}`);
                        const passingGrade = {{ (float) $training->passing_grade }};
                        if (statusCell) {
                            if (value !== '' && value !== null) {
                                const score = parseFloat(value);
                                if (score >= passingGrade) {
                                    statusCell.innerHTML = '<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Pass</span>';
                                } else {
                                    statusCell.innerHTML = '<span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Not Pass</span>';
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
                                <div class="px-4 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-3 group" 
                                    onclick="addSelectedParticipant('${user.name}', '${user.npk}', '${user.department}', '${user.subco}')">
                                    <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 bg-gray-100">
                                        ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold">${user.name.charAt(0)}</div>`}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-gray-800 dark:text-white truncate">${user.name}</p>
                                        <p class="text-[9px] text-indigo-500 font-bold uppercase tracking-widest">${user.npk}</p>
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

            // Close suggestions on outside click
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, npk, department, subco })
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            })
            .catch(() => window.location.reload());
        }

        // --- EDIT MODAL LOGIC ---
        function openEditModal(participant) {
            document.getElementById('edit_participant_id').value = participant.id;
            document.getElementById('edit_name').value = participant.name;
            document.getElementById('edit_npk_display').innerText = participant.npk;
            document.getElementById('edit_department').value = participant.department;
            document.getElementById('edit_subco').value = participant.subco || '-';
            
            document.getElementById('editParticipantModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editParticipantModal').classList.remove('opacity-0');
            }, 10);
        }

        function closeEditModal() {
            document.getElementById('editParticipantModal').classList.add('hidden');
        }

        function submitEditForm(e) {
            e.preventDefault();
            const id = document.getElementById('edit_participant_id').value;
            const name = document.getElementById('edit_name').value;
            const department = document.getElementById('edit_department').value;
            const subco = document.getElementById('edit_subco').value;
            
            const btn = e.target.querySelector('button[type="submit"]');
            btn.innerText = 'Menyimpan...';
            btn.disabled = true;

            // Simple sequentially update fields since we have the toggle-like API
            // Or better, update via combined updateField (I'll add this to the controller)
            
            const fields = [
                { field: 'name', value: name },
                { field: 'department', value: department },
                { field: 'subco', value: subco }
            ];

            // Run updates sequentially
            const updatePromises = fields.map(f => {
                return fetch(`/participants/${id}/update-field`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field: f.field, value: f.value })
                });
            });

            Promise.all(updatePromises)
                .then(() => window.location.reload())
                .catch(() => window.location.reload());
        }

        document.addEventListener('DOMContentLoaded', function () {
            // ---- PER-PARTICIPANT VISUALIZATION CHARTS ----
            const participantsData = {!! json_encode($training->participants->map(function($p) use ($training) {
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
                                    grid: { display: true, color: 'rgba(148, 163, 184, 0.1)', drawBorder: false },
                                    ticks: { font: { size: 8, weight: '600' }, stepSize: 50, color: '#94a3b8' }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 9, weight: '900' }, color: '#64748b', padding: 5 }
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
                                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                                    angleLines: { color: 'rgba(148, 163, 184, 0.1)' },
                                    pointLabels: { 
                                        font: { size: 5.5, weight: '700' }, 
                                        color: '#94a3b8',
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
        });
        });
    </script>
</x-app-layout>