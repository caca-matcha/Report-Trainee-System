<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.trainings.show', $training) }}"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">Input Penilaian: {{ $training->title }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Passing Grade: <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-full font-bold ml-1">{{ (float) $training->passing_grade }}</span>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <form action="{{ route('trainings.scoring.update', $training) }}" method="POST">
            @csrf

            {{-- Scoring Card --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-4 font-bold text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-700 w-12 text-center uppercase tracking-tighter">
                                    No</th>
                                <th
                                    class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-700 w-64 uppercase tracking-tighter">
                                    Peserta</th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-36">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Target:
                                        {{ (float) $training->passing_grade }}</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Exam
                                        Result (Post)</span>
                                </th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-28">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Target:
                                        {{ (float) $training->passing_grade }}</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Pre
                                        Test</span>
                                </th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-28">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Min:
                                        2.0 / Maks: 4.0</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Punctuality</span>
                                </th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-28">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Min:
                                        2.0 / Maks: 4.0</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Activeness</span>
                                </th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-28">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Min:
                                        2.0 / Maks: 4.0</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Cooperation</span>
                                </th>
                                <th class="px-2 py-4 border-r border-gray-200 dark:border-gray-700 text-center w-28">
                                    <span
                                        class="block text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1">Min:
                                        2.0 / Maks: 4.0</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Attitude</span>
                                </th>
                                <th
                                    class="px-4 py-4 text-center w-20 uppercase font-bold text-gray-700 dark:text-gray-300 tracking-tighter">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @php $no = 1; @endphp
                            @foreach($training->participants as $participant)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td
                                        class="px-4 py-4 text-center border-r border-gray-100 dark:border-gray-700 font-mono text-gray-400 text-xs">
                                        {{ $no++ }}</td>
                                    <td class="px-6 py-4 border-r border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="relative group">
                                                @php
                                                    $photo = $participant->photo_path ?: ($participant->user ? $participant->user->photo : null);
                                                @endphp
                                                @if($photo)
                                                    <img src="{{ asset('storage/' . $photo) }}"
                                                        class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-indigo-500 transition-all shadow-sm"
                                                        alt="">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500 text-[10px] font-bold ring-2 ring-gray-50 dark:ring-gray-800">
                                                        {{ strtoupper(substr($participant->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-[10px] font-mono text-gray-400 tracking-tighter">
                                                    {{ $participant->npk ?? '-' }}</div>
                                                <div
                                                    class="font-bold text-gray-900 dark:text-white truncate text-sm leading-tight">
                                                    {{ $participant->name }}</div>
                                                <div
                                                    class="text-[9px] text-indigo-500 dark:text-indigo-400 font-bold uppercase tracking-widest">
                                                    {{ $participant->department ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- POST TEST --}}
                                    <td
                                        class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center bg-gray-50/30 dark:bg-gray-900/10">
                                        <input type="number" name="scores[{{ $participant->id }}][post_test_score]"
                                            value="{{ $participant->post_test_score !== null ? round($participant->post_test_score) : '' }}" min="0" max="100" step="0.01"
                                            class="score-post w-20 h-10 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg text-lg font-black transition-all focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                            data-passing="{{ $training->passing_grade }}" oninput="colorPostTest(this)">
                                    </td>

                                    {{-- PRE TEST --}}
                                    <td class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center">
                                        <input type="number" name="scores[{{ $participant->id }}][pre_test_score]"
                                            value="{{ $participant->pre_test_score !== null ? round($participant->pre_test_score) : '' }}" min="0" max="100" step="0.01"
                                            class="w-16 h-8 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-xs font-medium focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 border-dashed transition-all">
                                    </td>

                                    {{-- PUNCTUALITY --}}
                                    <td class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center">
                                        <input type="number" name="scores[{{ $participant->id }}][punctuality_score]"
                                            value="{{ $participant->punctuality_score !== null ? number_format($participant->punctuality_score, 1) : '' }}"
                                            min="1" max="4" step="0.1"
                                            class="score-soft w-16 h-8 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm font-bold transition-all focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                            oninput="colorSoftSkill(this)">
                                    </td>

                                    {{-- ACTIVENESS --}}
                                    <td class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center">
                                        <input type="number" name="scores[{{ $participant->id }}][activeness_score]"
                                            value="{{ $participant->activeness_score !== null ? number_format($participant->activeness_score, 1) : '' }}"
                                            min="1" max="4" step="0.1"
                                            class="score-soft w-16 h-8 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm font-bold transition-all focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                            oninput="colorSoftSkill(this)">
                                    </td>

                                    {{-- COOPERATION --}}
                                    <td class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center">
                                        <input type="number" name="scores[{{ $participant->id }}][cooperation_score]"
                                            value="{{ $participant->cooperation_score !== null ? number_format($participant->cooperation_score, 1) : '' }}"
                                            min="1" max="4" step="0.1"
                                            class="score-soft w-16 h-8 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm font-bold transition-all focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                            oninput="colorSoftSkill(this)">
                                    </td>

                                    {{-- ATTITUDE --}}
                                    <td class="px-3 py-4 border-r border-gray-100 dark:border-gray-700 text-center">
                                        <input type="number" name="scores[{{ $participant->id }}][attitude_score]"
                                            value="{{ $participant->attitude_score !== null ? number_format($participant->attitude_score, 1) : '' }}"
                                            min="1" max="4" step="0.1"
                                            class="score-soft w-16 h-8 text-center border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-sm font-bold transition-all focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                            oninput="colorSoftSkill(this)">
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($participant->post_test_score !== null)
                                            @if($participant->post_test_score >= $training->passing_grade)
                                                <span
                                                    class="px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-[9px] font-black uppercase tracking-widest ring-1 ring-green-200 dark:ring-green-800 shadow-sm">PASS</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg text-[9px] font-black uppercase tracking-widest ring-1 ring-red-200 dark:ring-red-800 shadow-sm">FAIL</span>
                                            @endif
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600 text-[10px]">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Card with Guide & Submit -->
                <div class="p-6 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex-1 space-y-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span
                                    class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Guide
                                    & Keterangan:</span>
                            </div>
                            <div class="flex flex-wrap gap-4 text-[10px] font-medium uppercase tracking-wider">
                                <span class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <span class="w-2 h-2 rounded-full bg-green-400 dark:bg-green-500 shadow-sm"></span>
                                    Post Test &ge; Passing Grade
                                </span>
                                <span class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <span class="w-2 h-2 rounded-full bg-red-400 dark:bg-red-500 shadow-sm"></span>
                                    Post Test &lt; Passing Grade
                                </span>
                                <span class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 dark:bg-amber-500 shadow-sm"></span>
                                    Soft Skill &lt; 2.0 (Dibawah Minimum)
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-10 py-3.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black dark:hover:bg-gray-100 transition-all shadow-xl active:scale-95 group">
                                <svg class="w-4 h-4 mr-2 group-hover:scale-125 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Semua Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Highlight post test berdasarkan passing grade
        function colorPostTest(input) {
            const val = parseFloat(input.value);
            const pg = parseFloat(input.dataset.passing);
            input.classList.remove('text-emerald-600', 'text-rose-600', 'bg-emerald-50/50', 'bg-rose-50/50', 'dark:bg-emerald-900/20', 'dark:bg-rose-900/20');
            if (!isNaN(val) && !isNaN(pg)) {
                if (val >= pg) {
                    input.classList.add('text-emerald-600', 'bg-emerald-50/50', 'dark:bg-emerald-900/20');
                } else {
                    input.classList.add('text-rose-600', 'bg-rose-50/50', 'dark:bg-rose-900/20');
                }
            }
        }

        // Highlight soft skill: hijau ≥ 2.0, merah < 2.0, kuning jika > 4.0
        function colorSoftSkill(input) {
            const val = parseFloat(input.value);
            input.classList.remove('text-emerald-600', 'text-rose-600', 'text-amber-600', 'bg-emerald-50/50', 'bg-rose-50/50', 'bg-amber-50/50', 'dark:bg-emerald-900/20', 'dark:bg-rose-900/20', 'dark:bg-amber-900/20');
            if (!isNaN(val)) {
                if (val > 4.0) {
                    input.value = 4.0;
                    input.classList.add('text-amber-600', 'bg-amber-50/50', 'dark:bg-amber-900/20');
                } else if (val >= 2.0) {
                    input.classList.add('text-emerald-600', 'bg-emerald-50/50', 'dark:bg-emerald-900/20');
                } else {
                    input.classList.add('text-rose-600', 'bg-rose-50/50', 'dark:bg-rose-900/20');
                }
            }
        }

        // Inisialisasi warna saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.score-post').forEach(colorPostTest);
            document.querySelectorAll('.score-soft').forEach(colorSoftSkill);
        });
    </script>
</x-admin-layout>