<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.trainings.show', $training) }}" 
                    class="group p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all duration-200 text-gray-500 dark:text-gray-400 flex items-center justify-center"
                    title="Back to Training Details">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Training Summary Report') }}
                </h2>
            </div>
            <div class="flex gap-2">
                {{-- Download PDF Button --}}
                <button id="downloadPdfBtn" onclick="downloadPdf()"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center gap-2 print:hidden">
                    <svg id="pdfIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <svg id="pdfSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span id="pdfBtnText">Download PDF</span>
                </button>

                @if($training->status == 'approved')
                    <div class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-sm font-black uppercase tracking-widest border border-green-200 dark:border-green-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        Laporan Terkunci
                    </div>
                @endif


            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[98%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-8 text-black min-w-[1400px]">
                    {{-- HEADER & SECTION A: Excel Layout Mimic --}}
                    <div class="mb-12 text-black">
                        {{-- Row 1: Header Logos, Title, Signatures --}}
                        <div class="pdf-section flex bg-white items-stretch min-h-[100px] w-full">
                            {{-- Col 1: Logos --}}
                            <div class="w-[220px] shrink-0 p-4 flex flex-col justify-center gap-4">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/dg-logo.png') }}" class="w-14 h-auto object-contain" alt="Dharma Group">
                                    <div>
                                        <div class="text-[12px] font-bold text-blue-900 leading-tight">DHARMA GROUP</div>
                                        <div class="text-[9px] text-green-600 font-semibold leading-tight">Exist To Contribute</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                     {{-- Placeholder for DLC Logo --}}
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        <span class="text-3xl font-black text-green-700 tracking-tighter">D<span class="text-blue-900">L</span>C</span>
                                    </div>
                                    <div class="text-[12px] font-bold text-blue-900 leading-tight">
                                        DHARMA<br>LEARNING<br>CENTER
                                    </div>
                                </div>
                            </div>

                            {{-- Col 2: Title --}}
                            <div class="flex-1 p-4 flex flex-col items-center justify-center text-center">
                                <div class="font-bold text-sm tracking-widest mb-1">TRAINING REPORT</div>
                                <div class="text-xl font-black uppercase mb-1 leading-tight px-2">{{ $training->title }}</div>
                                <div class="text-sm font-semibold text-gray-700 uppercase">
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('F, jS') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('Y') }}
                                </div>
                            </div>

                            {{-- Col 3: Signatures --}}
                            <div class="w-[330px] shrink-0 flex text-center text-[10px] font-semibold divide-x-2 divide-black border-2 border-black">
                                {{-- Prepared By --}}
                                <div class="flex-1 flex flex-col">
                                    <div class="border-b-2 border-black bg-white flex items-center justify-center pt-[2px] pb-[4px] leading-tight">Prepared By,</div>
                                    <div class="flex-1 flex items-center justify-center relative min-h-[70px] bg-white">
                                        @if($preparedSignature)
                                            <img src="{{ asset('storage/' . $preparedSignature) }}" class="max-h-14 z-0" alt="Signature">
                                        @endif
                                    </div>
                                    <div class="border-y-2 border-black bg-white flex justify-center w-full">
                                        <input type="text"
                                            class="signature-input w-full bg-transparent border-none text-center p-0 py-0.5 text-[9px] focus:ring-0 z-10 signer-trigger font-bold px-1"
                                            style="text-decoration: underline;"
                                            data-field="prepared_by" list="users-datalist"
                                            value="{{ $summary->prepared_by ?? '' }}" placeholder=""
                                            {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                    </div>
                                    <div class="bg-white px-1 text-center font-bold text-[8.5px] leading-tight flex items-center justify-center h-8 break-words pt-[1px] pb-[4px]">Staff Learning & Dev.</div>
                                </div>
                                
                                {{-- Checked By --}}
                                <div class="flex-1 flex flex-col">
                                    <div class="border-b-2 border-black bg-white flex items-center justify-center pt-[2px] pb-[4px] leading-tight flex-col">Checked By,</div>
                                    <div class="flex-1 flex items-center justify-center relative min-h-[70px] bg-white">
                                        @if($checkedSignature)
                                            <img src="{{ asset('storage/' . $checkedSignature) }}" class="max-h-14 z-0" alt="Signature">
                                        @endif
                                        @if($training->is_approved)
                                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
                                                <div class="border-4 border-emerald-500 text-emerald-500 font-black text-[14px] px-3 py-1 rounded-lg uppercase tracking-[0.2em] transform -rotate-12 opacity-80 flex flex-col items-center leading-none bg-white/50 backdrop-blur-[1px]">
                                                    <span>APPROVED</span>
                                                    @if($training->approved_at)
                                                        <span class="text-[8px] mt-1 tracking-normal font-bold">{{ $training->approved_at->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="border-y-2 border-black bg-white flex justify-center w-full">
                                        <input type="text"
                                            class="signature-input w-full bg-transparent border-none text-center p-0 py-0.5 text-[9px] focus:ring-0 z-10 signer-trigger font-bold px-1"
                                            style="text-decoration: underline;"
                                            data-field="checked_by" list="users-datalist"
                                            value="{{ $summary->checked_by ?? '' }}" placeholder=""
                                            {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                    </div>
                                    <div class="bg-white px-1 text-center font-bold text-[8.5px] leading-tight flex items-center justify-center h-8 break-words pt-[1px] pb-[4px]">Dept. Head Learning & Dev</div>
                                </div>

                                {{-- Confirmed By --}}
                                <div class="flex-1 flex flex-col">
                                    <div class="border-b-2 border-black bg-white flex items-center justify-center pt-[2px] pb-[4px] leading-tight flex-col">Confirm,</div>
                                    <div class="flex-1 flex items-center justify-center relative min-h-[70px] bg-white">
                                        @if($confirmedSignature)
                                            <img src="{{ asset('storage/' . $confirmedSignature) }}" class="max-h-14 z-0" alt="Signature">
                                        @endif
                                        @if($training->is_approved)
                                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
                                                <div class="border-4 border-emerald-500 text-emerald-500 font-black text-[14px] px-3 py-1 rounded-lg uppercase tracking-[0.2em] transform -rotate-12 opacity-80 flex flex-col items-center leading-none bg-white/50 backdrop-blur-[1px]">
                                                    <span>APPROVED</span>
                                                    @if($training->approved_at)
                                                        <span class="text-[8px] mt-1 tracking-normal font-bold">{{ $training->approved_at->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="border-y-2 border-black bg-white flex justify-center w-full">
                                        <input type="text"
                                            class="signature-input w-full bg-transparent border-none text-center p-0 py-0.5 text-[9px] focus:ring-0 z-10 signer-trigger font-bold px-1"
                                            style="text-decoration: underline;"
                                            data-field="confirmed_by" list="users-datalist"
                                            value="{{ $summary->confirmed_by ?? '' }}" placeholder=""
                                            {{ $training->status == 'approved' ? 'disabled' : '' }}>
                                    </div>
                                    <div class="bg-white px-1 text-center font-bold text-[8.5px] leading-tight flex items-center justify-center h-8 break-words pt-[1px] pb-[4px]">Deputy Div. Head HRGA</div>
                                </div>
                            </div>
                        </div>

                        {{-- Section A: TRAINING SUMMARY (Combined Title & Content) --}}
                        <div class="pdf-section bg-white border border-gray-300 mb-6">
                            <div class="bg-gray-100 border-b border-gray-300 py-1 px-2">
                                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-widest">A. TRAINING SUMMARY</h3>
                            </div>

                            <div class="flex w-full bg-white text-[10px] divide-x divide-gray-300">
                            
                            {{-- Col 1: Stats List --}}
                            <div class="flex-1 p-2 space-y-1">
                                <div class="flex gap-1">
                                    <span class="w-3">1.</span>
                                    <span>Training invitation only {{ $totalInvitation }} Person, {{ $totalAbsent }} Trainee did not Attend the Class without Confirmation</span>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-3">2.</span>
                                    <span>{{ $passCount == $totalAttend ? 'All trainee did Passed the test' : 'Total ' . $passCount . ' trainees passed the test' }}</span>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-3">3.</span>
                                    <div class="flex items-center gap-2">
                                        <span>Average exam result before : {{ number_format($avgPreTest, 1) }}</span>
                                        <div class="flex-1 flex items-center mx-1 min-w-[20px]">
                                            <div class="flex-1 h-[1px] bg-black"></div>
                                            <svg width="5" height="7" viewBox="0 0 5 7" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0 -ml-[1px]">
                                                <path d="M0 0L5 3.5L0 7V0Z" fill="black"/>
                                            </svg>
                                        </div>
                                        <span>After : {{ number_format($avgPostTest, 1) }}</span>
                                        <span class="ml-4">Passing Grade: {{ $training->passing_grade }}</span>
                                    </div>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-3">4.</span>
                                    <span>Attendance Ratio {{ $attendanceRatio }}% ({{ $totalAttend }}/{{ $totalInvitation }})</span>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-3">5.</span>
                                    <span></span>
                                </div>
                            </div>

                            {{-- Col 2: Behaviour Eval --}}
                            <div class="w-[300px] shrink-0 p-2 flex flex-col justify-center">
                                <div class="text-center mb-1">4. Average Behaviour Evaluation</div>
                                <div class="space-y-0.5 max-w-[200px] mx-auto w-full">
                                    <div class="flex justify-between">
                                        <span>> Punctuality</span>
                                        <span class="font-bold">{{ number_format($avgPunctuality, 1) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>> Activeness</span>
                                        <span class="font-bold">{{ number_format($avgActiveness, 1) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>> Cooperation</span>
                                        <span class="font-bold">{{ number_format($avgCooperation, 1) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>> Attitude</span>
                                        <span class="font-bold">{{ number_format($avgAttitude, 1) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Col 3: Recommendation --}}
                            <div class="flex-1 p-2">
                                <div class="mb-1">Recommendation for next Participant :</div>
                                <div>
                                    @if($summary->recommendation)
                                        <p>- {{ $summary->recommendation }}</p>
                                    @else
                                        <p class="text-transparent">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section B: Trainee Evaluation — Excel-style table --}}
                    <div class="mb-12">
                        <div class="pdf-section mb-2">
                            <div class="w-12 h-1 bg-indigo-600 mb-2"></div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-700">
                                B. TRAINEE EVALUATION
                            </h3>
                            
                            {{-- Column Headers nested in same section to ensure they render together --}}
                            <div class="flex w-full gap-[2px] mt-4">
                                @for ($hi = 0; $hi < 3; $hi++)
                                <div class="flex-1 flex text-[9px] font-black uppercase bg-gray-300 border border-gray-400 items-stretch min-h-[20px]">
                                    <div class="w-1/3 border-r border-gray-400 px-1 flex items-center justify-center text-center pt-[1px] pb-[3px] leading-tight">Trainee</div>
                                    <div class="w-1/3 border-r border-gray-400 px-1 flex items-center justify-center text-center pt-[1px] pb-[3px] leading-tight">Exam Result</div>
                                    <div class="w-1/3 px-1 flex items-center justify-center text-center pt-[1px] pb-[3px] leading-tight">Trainee Evaluation</div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                        @php
                            $participantsColl = $participants ?? collect();
                            $chunkedParticipants = $participantsColl->chunk(3);
                        @endphp

                        {{-- Rows of 3 participants --}}
                        @foreach($chunkedParticipants as $chunkIdx => $chunk)
                        <div class="pdf-section flex gap-[2px] mb-1 break-inside-avoid w-full">

                            @php $chunkArr = $chunk->values(); @endphp

                            @for ($ci = 0; $ci < 3; $ci++)
                            @php $participant = $chunkArr[$ci] ?? null; @endphp

                            @if($participant)
                                @php $passed = ($participant->post_test_score ?? 0) >= $training->passing_grade; @endphp
                                <div class="flex-1 flex border border-gray-300 bg-white min-w-0" style="min-height: 100px; max-width: calc(33.333% - 1.33px);">

                                    {{-- Col 1: Trainee Info --}}
                                    <div class="w-1/3 shrink-0 border-r border-gray-300 p-2 pl-3 flex items-start justify-between relative">
                                        {{-- Info details (Left) --}}
                                        <div class="flex-1 min-w-0 flex flex-col h-full z-10 pr-1">
                                            {{-- Status Badge --}}
                                            <div class="flex items-center gap-1.5 mb-1.5 shrink-0">
                                                <div class="w-3.5 h-3.5 rounded-full {{ $passed ? 'bg-[#568a35]' : 'bg-red-600' }} border-[1px] border-black shrink-0"></div>
                                                <span class="text-[11px] font-bold text-black leading-none">{{ $passed ? 'Pass' : 'Fail' }}</span>
                                            </div>
                                            
                                            {{-- Name & ID --}}
                                            <p class="font-normal text-[10px] text-black leading-tight mb-0.5" style="word-break:break-word;">{{ $participant->name }}</p>
                                            <p class="text-[9px] text-black mb-2 leading-tight">{{ $participant->npk }}</p>
                                            
                                            {{-- Department & Subco --}}
                                            <div class="mt-auto shrink-0 mb-1">
                                                <p class="text-[10px] text-black leading-tight" title="{{ $participant->department }}">{{ $participant->department }}</p>
                                                <p class="text-[9px] text-gray-500 font-bold mt-0.5 uppercase">{{ $participant->subco }}</p>
                                            </div>
                                        </div>
                                        
                                        {{-- Photo (Right) --}}
                                        <div class="w-[45px] shrink-0 border-[0.5px] border-black bg-gray-200 mt-0.5" style="height:60px;">
                                            @if($participant->photo_path)
                                                <img src="{{ asset('storage/' . $participant->photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Col 2: Exam Result Bar Chart --}}
                                    <div class="w-1/3 shrink-0 border-r border-gray-300 flex flex-col pt-2" style="min-height:100px;">
                                        <div class="relative flex-1 min-h-0 px-1 pb-1">
                                            <canvas id="score-bar-{{ $participant->id }}"
                                                class="participant-score-bar w-full h-full"
                                                data-pre="{{ (float) ($participant->pre_test_score ?? 0) }}"
                                                data-post="{{ (float) ($participant->post_test_score ?? 0) }}"
                                                data-passing="{{ (float) $training->passing_grade }}">
                                            </canvas>
                                        </div>
                                    </div>

                                    {{-- Col 3: Radar --}}
                                    <div class="w-1/3 shrink-0 relative min-h-0" style="min-height:100px; padding:2px;">
                                        <canvas id="radar-{{ $participant->id }}" class="participant-radar w-full h-full"
                                            data-pun="{{ round((float) ($participant->punctuality_score ?? 0), 1) }}"
                                            data-act="{{ round((float) ($participant->activeness_score ?? 0), 1) }}"
                                            data-coo="{{ round((float) ($participant->cooperation_score ?? 0), 1) }}"
                                            data-att="{{ round((float) ($participant->attitude_score ?? 0), 1) }}">
                                        </canvas>
                                    </div>

                                </div>
                            @else
                                {{-- Empty slot: just placeholder to preserve grid columns without borders --}}
                                <div></div>
                            @endif
                            @endfor

                        </div>
                        @endforeach
                    </div>

                    <div class="mb-12">
                        @php
                        $evalData = $training->evaluation->data ?? null;
                        $trainersDataArr = $evalData['trainers'] ?? [];
                        $assignedTrainers = $training->trainers ?? [];
                        
                        // Auto-sync with Master Training if the current list is empty or minimal
                        // but the user expects more based on their recent edits to Master.
                        if (count($assignedTrainers) <= 1) {
                            $master = \App\Models\MasterTraining::where('training_id', $training->id)->first();
                            if ($master && !empty($master->trainers) && count($master->trainers) > count($assignedTrainers)) {
                                $assignedTrainers = $master->trainers;
                            }
                        }

                        $csiTrainersArr = [];
                        
                        if (count($assignedTrainers) > 0) {
                            // Focus on assigned trainers as the source of truth
                            foreach ($assignedTrainers as $tr) {
                                $matchedData = null;
                                $trName = trim($tr['name'] ?? '');
                                
                                // Try to find matching data in imported CSI by name (case-insensitive)
                                foreach ($trainersDataArr as $td) {
                                    if (mb_strtolower(trim($td['name'] ?? '')) === mb_strtolower($trName)) {
                                        $matchedData = $td;
                                        break;
                                    }
                                }
                                
                                if ($matchedData) {
                                    // Use data from import
                                    $csiTrainersArr[] = $matchedData;
                                } else {
                                    // Fallback for assigned trainer with no CSI data (placeholder)
                                    $csiTrainersArr[] = [
                                        'name' => $trName,
                                        'photo' => $tr['photo'] ?? null,
                                        'scores' => [],
                                        'feedback' => [],
                                        'impressions' => []
                                    ];
                                }
                            }
                        } else {
                            // If no trainers assigned specifically, fallback to import results or PIC
                            if (!empty($trainersDataArr)) {
                                $csiTrainersArr = $trainersDataArr;
                            } else {
                                $csiTrainersArr[] = [
                                    'name' => $training->user->name ?? 'Unknown Trainer',
                                    'photo' => $training->user->photo ?? null,
                                    'scores' => [],
                                    'feedback' => [],
                                    'impressions' => []
                                ];
                            }
                        }
                    @endphp

                    @if(count($csiTrainersArr) > 0)
                        <div class="pdf-section mb-12">
                            <div class="mb-4">
                                <div class="w-12 h-1 bg-indigo-600 mb-2"></div>
                                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-700">
                                    C. TRAINER EVALUATION
                                </h3>
                            </div>
                            
                            <div class="grid grid-cols-1 {{ count($csiTrainersArr) > 1 ? 'md:grid-cols-2' : '' }} gap-6">
                                @foreach($csiTrainersArr as $ti => $csiTrainer)
                                    @php
                                        $csiScores = $csiTrainer['scores'] ?? [];
                                        $csiAvg = count($csiScores) > 0 ? round(array_sum($csiScores) / count($csiScores), 2) : 0;
                                    @endphp
                                    
                                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-2">
                                        <div
                                            class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-gray-200">
                                            {{-- Profile & Radar (7 cols) --}}
                                            <div class="lg:col-span-7 p-6">
                                                <div class="flex flex-col md:flex-row items-center gap-8">
                                                    <div
                                                        class="w-32 h-40 shrink-0 rounded-xl overflow-hidden border-2 border-indigo-100 dark:border-indigo-900/50 shadow-sm relative group">
                                                        @if($csiTrainer['photo'])
                                                            <img src="{{ asset('storage/' . $csiTrainer['photo']) }}"
                                                                class="w-full h-full object-cover">
                                                        @else
                                                            <div
                                                                class="w-full h-full bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                                                                <svg class="w-12 h-12 text-indigo-200" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 w-full">
                                                        <div class="flex justify-between items-start mb-4">
                                                            <div>
                                                                <h4
                                                                    class="text-xl font-black text-gray-900 uppercase tracking-tight">
                                                                    {{ $csiTrainer['name'] }}
                                                                </h4>
                                                                <p
                                                                    class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest mt-1">
                                                                    Instructor</p>
                                                            </div>
                                                            <div class="text-right">
                                                                <p
                                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                                                    AVG Score</p>
                                                                <p class="text-3xl font-black text-indigo-600 leading-none">
                                                                    {{ $csiAvg }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div style="height: 200px;">
                                                            <canvas id="csiTrainerRadar_{{ $ti }}" class="csi-trainer-radar"
                                                                data-scores="{{ json_encode(array_values($csiScores)) }}">
                                                            </canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Feedback & Impressions (5 cols) --}}
                                            <div class="lg:col-span-12 p-6 bg-gray-50/50 space-y-6">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                                    {{-- Feedback column --}}
                                                    <div x-data="{ showAllFeedback: false }">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <h5 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span> Trainer Feedback
                                                            </h5>
                                                        </div>
                                                        <div class="space-y-3">
                                                            @php
                                                                $rawFeedbacks = (array) ($csiTrainer['feedback'] ?? []);
                                                                $aggregatedFeedbacks = [];
                                                                foreach ($rawFeedbacks as $f) {
                                                                    $f = trim($f);
                                                                    if (!isset($aggregatedFeedbacks[$f])) $aggregatedFeedbacks[$f] = 0;
                                                                    $aggregatedFeedbacks[$f]++;
                                                                }
                                                                arsort($aggregatedFeedbacks);
                                                                $feedbackItems = [];
                                                                foreach ($aggregatedFeedbacks as $text => $count) {
                                                                    $feedbackItems[] = $count > 1 ? "$text ($count peserta)" : $text;
                                                                }
                                                            @endphp

                                                            @forelse($feedbackItems as $index => $feedback)
                                                                <p
                                                                    class="text-[11px] text-gray-700 italic border-l-2 border-indigo-200 pl-3 leading-relaxed {{ $index >= 5 ? 'print:block' : '' }}"
                                                                    x-show="{{ $index >= 5 ? 'showAllFeedback' : 'true' }}"
                                                                    {{ $index >= 5 ? 'x-cloak' : '' }}>
                                                                    '{{ $feedback }}'
                                                                </p>
                                                            @empty
                                                                <p class="text-[11px] text-gray-400 italic">No feedback provided.</p>
                                                            @endforelse

                                                            @if(count($feedbackItems) > 5)
                                                                <button @click="showAllFeedback = !showAllFeedback" 
                                                                    class="text-[9px] font-bold text-indigo-400 hover:text-indigo-600 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
                                                                    <span x-text="showAllFeedback ? 'Tampilkan Lebih Sedikit' : 'Lihat ' + ({{ count($feedbackItems) }} - 5) + ' feedback lainnya'"></span>
                                                                    <svg class="w-3 h-3 transition-transform" :class="showAllFeedback ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Impression column --}}
                                                    <div x-data="{ showAllImpressions: false }">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <h5 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span> Trainer Impression
                                                            </h5>
                                                        </div>
                                                        <div class="space-y-3">
                                                            @php
                                                                $rawImpressions = (array) ($csiTrainer['impressions'] ?? []);
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
                                                                    class="text-[11px] font-semibold text-gray-700 border-l-2 border-indigo-200 pl-3 leading-relaxed {{ $index >= 5 ? 'print:block' : '' }}"
                                                                    x-show="{{ $index >= 5 ? 'showAllImpressions' : 'true' }}"
                                                                    {{ $index >= 5 ? 'x-cloak' : '' }}>
                                                                    "{{ $impression }}"
                                                                </p>
                                                            @empty
                                                                <p class="text-[11px] text-gray-400 italic">No impression provided.</p>
                                                            @endforelse

                                                            @if(count($impressionItems) > 5)
                                                                <button @click="showAllImpressions = !showAllImpressions" 
                                                                    class="text-[9px] font-bold text-indigo-400 hover:text-indigo-600 transition-colors uppercase tracking-wider mt-2 print:hidden flex items-center gap-1">
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Section D: Class Evaluation --}}
                    <div class="pdf-section mb-12">
                        <div class="w-12 h-1 bg-indigo-600 mb-2"></div>
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-700">
                            D. CLASS EVALUATION
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- D1. TRAINER --}}
                            <div class="space-y-4">
                                <h4
                                    class="text-[11px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-4 h-px bg-gray-300"></span> D1. TRAINER
                                </h4>
                                <div
                                    class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 h-full">
                                    <div style="height: 300px;">
                                        @php
                                            $allTrainerScores = [];
                                            foreach ($csiTrainersArr as $ct) {
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
                                        <canvas id="csiClassTrainerBar"
                                            data-scores="{{ json_encode($avgTrainerScores) }}">
                                        </canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- D2. SUBJECT --}}
                            <div class="space-y-4">
                                <h4
                                    class="text-[11px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-4 h-px bg-gray-300"></span> D2. SUBJECT
                                </h4>
                                <div
                                    class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 h-full">
                                    <div style="height: 300px;">
                                        <canvas id="csiSubjectBar"
                                            data-scores="{{ json_encode(array_values($evalData['subject'] ?? [])) }}">
                                        </canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- D3. OPERATIONAL --}}
                            <div class="space-y-4">
                                <h4
                                    class="text-[11px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-4 h-px bg-gray-300"></span> D3. OPERATIONAL
                                </h4>
                                <div
                                    class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 h-full">
                                    <div style="height: 300px;">
                                        <canvas id="csiOperationalBar"
                                            data-scores="{{ json_encode(array_values($evalData['operational'] ?? [])) }}">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section E: Training Atmosphere --}}
                    <div class="pdf-section mb-12">
                        <div class="mb-6">
                            <div class="w-12 h-1 bg-indigo-600 mb-2"></div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-700">
                                E. TRAINING ATMOSPHERE
                            </h3>
                        </div>
                        
                        @if($training->atmospheres->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($training->atmospheres as $atmosphere)
                                    <div class="relative group">
                                        <div
                                            class="bg-white rounded-2xl overflow-hidden shadow-xl border border-gray-100">
                                            <div class="aspect-video relative overflow-hidden">
                                                <img src="{{ asset('storage/' . $atmosphere->image_path) }}"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60">
                                                </div>
                                            </div>
                                            <div class="p-6 bg-white text-center">
                                                <p
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 leading-none">
                                                    {{ $atmosphere->title }}:
                                                </p>
                                                <h4
                                                    class="text-sm font-black text-black uppercase tracking-tight leading-tight">
                                                    {{ $atmosphere->subtitle }}
                                                </h4>
                                                @if(Storage::disk('public')->exists($atmosphere->image_path))
                                                    <p class="text-[9px] text-gray-400 mt-1 font-bold">
                                                        {{ number_format(Storage::disk('public')->size($atmosphere->image_path) / 1048576, 2) }}
                                                        MB
                                                    </p>
                                                @else
                                                    <p class="text-[9px] text-red-500 mt-1 font-bold">
                                                        [Missing File]
                                                    </p>
                                                @endif
                                                @if($atmosphere->description)
                                                    <p class="text-[10px] text-gray-500 mt-2 italic leading-relaxed">
                                                        "{{ $atmosphere->description }}"
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No atmosphere photos provided.</p>
                                </div>
                            </div>
                        @endif
                    </div>


                    {{-- Bottom area cleaned up --}}

                {{-- Datalist for Signers --}}
                <datalist id="users-datalist">
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->npk }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
</div>
</div>

    <style>
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            body {
                background-color: white !important;
                color: black !important;
            }
            .dark\:bg-gray-800 {
                background-color: white !important;
            }
            .dark\:bg-gray-900 {
                background-color: #f9fafb !important;
            }
            .dark\:bg-gray-900\/50 {
                background-color: #f9fafb !important;
            }
            .dark\:bg-gray-900\/20 {
                background-color: #f9fafb !important;
            }
            .dark\:bg-gray-900\/30 {
                background-color: #f9fafb !important;
            }
            .dark\:bg-gray-700 {
                background-color: #f3f4f6 !important;
            }
            .dark\:bg-gray-700\/50 {
                background-color: #f9fafb !important;
            }
            .dark\:text-gray-100, .dark\:text-white {
                color: #111827 !important;
            }
            .dark\:border-gray-700, .dark\:border-gray-600 {
                border-color: #e5e7eb !important;
            }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
             /* Force Section elements to white backgrounds */
            .bg-gray-900 {
                background-color: white !important;
                color: black !important;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Theme settings (Check print state or dark mode)
            const isDark = document.documentElement.classList.contains('dark') && !window.matchMedia('print').matches;
            const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)';
            const labelColor = isDark ? '#9CA3AF' : '#6B7280';
            const indigoPrimary = 'rgb(79, 70, 229)';
            const greenPrimary = '#10B981';
            const redPrimary = '#EF4444';





            // 4. Participant Score Mini Bar Charts
            // 4. Participant Score Mini Bar Charts — with passing grade line
            const barPassingLinePlugin = {
                id: 'barPassingLine',
                afterDraw(chart) {
                    const { ctx, chartArea: { left, right }, scales: { y } } = chart;
                    const pg = parseFloat(chart.canvas.dataset.passing);
                    if (isNaN(pg)) return;

                    const yPos = y.getPixelForValue(pg);
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(left, yPos);
                    ctx.lineTo(right, yPos);
                    ctx.lineWidth = 1.5;
                    ctx.strokeStyle = '#F97316'; // Orange line
                    ctx.setLineDash([4, 2]);
                    ctx.stroke();
                    ctx.restore();
                }
            };

            const barValueLabelsPlugin = {
                id: 'barValueLabelsPlugin',
                afterDatasetsDraw(chart) {
                    const { ctx, data } = chart;
                    ctx.save();
                    ctx.font = 'bold 8px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillStyle = '#374151'; // text-gray-700
                    
                    chart.getDatasetMeta(0).data.forEach((bar, index) => {
                        const val = data.datasets[0].data[index];
                        if (val !== null && !isNaN(val)) {
                            ctx.fillText(Math.round(val), bar.x, bar.y - 3);
                        }
                    });
                    ctx.restore();
                }
            };

            document.querySelectorAll('.participant-score-bar').forEach(canvas => {
                const ctx = canvas.getContext('2d');
                const pre = parseFloat(canvas.dataset.pre);
                const post = parseFloat(canvas.dataset.post);
                const pg = parseFloat(canvas.dataset.passing);

                new Chart(ctx, {
                    type: 'bar',
                    plugins: [barPassingLinePlugin, barValueLabelsPlugin],
                    data: {
                        labels: ['PRE', 'POST'],
                        datasets: [{
                            data: [pre, post],
                            backgroundColor: [
                                'rgba(30, 58, 138, 0.7)', // Dark blue for PRE
                                post >= pg ? 'rgba(34, 197, 94, 0.8)' : 'rgba(239, 68, 68, 0.8)' // Green/Red for POST
                            ],
                            borderRadius: 4,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 15 } },
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                ticks: { display: true, font: { size: 7 }, count: 5, color: '#9ca3af' },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            x: {
                                ticks: { display: true, font: { size: 8, weight: 'bold' }, color: '#6b7280' },
                                grid: { display: false }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            });

            // 5. Participant Radar Charts — with value labels on each axis
            // Custom plugin: draw the actual value at each data point's axis tip
            const radarValueLabelPlugin = {
                id: 'radarValueLabel',
                afterDraw(chart) {
                    const { ctx, scales: { r }, data } = chart;
                    const dataset = data.datasets[0];
                    const values = dataset.data.map(v => parseFloat(v));
                    const labels = data.labels;
                    const numPoints = labels.length;

                    for (let i = 0; i < numPoints; i++) {
                        const angle = r.getIndexAngle(i) - Math.PI / 2;
                        const maxR = r.drawingArea; // radius to outer edge

                        // Positioning Category Label & Score
                        const pad = 12; // Base padding from edge
                        let x = r.xCenter + Math.cos(angle) * (maxR + pad);
                        let y = r.yCenter + Math.sin(angle) * (maxR + pad);

                        const val = values[i];
                        const label = labels[i];
                        const color = val >= 2 ? '#10B981' : '#EF4444';

                        let labelY = y;
                        let scoreY = y;

                        // Categories: 0:Punctuality(Top), 1:Activeness(Right), 2:Cooperation(Bottom), 3:Attitude(Left)
                        if (i === 0) { // Top
                            labelY = y + 2;
                            scoreY = y - 8;
                        } else if (i === 2) { // Bottom
                            labelY = y - 2;
                            scoreY = y + 8;
                        } else { // Sides (Right/Left)
                            labelY = y - 5;
                            scoreY = y + 5;
                        }

                        ctx.save();
                        // Draw Category Name (Gray)
                        ctx.font = 'bold 8px sans-serif';
                        ctx.fillStyle = labelColor;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(label, x, labelY);

                        // Draw Score (Green/Red)
                        ctx.font = 'bold 10px sans-serif';
                        ctx.fillStyle = color;
                        ctx.fillText(val.toFixed(1), x, scoreY);
                        ctx.restore();
                    }
                }
            };

            document.querySelectorAll('.participant-radar').forEach(canvas => {
                const ctx = canvas.getContext('2d');
                const pun = parseFloat(canvas.dataset.pun);
                const act = parseFloat(canvas.dataset.act);
                const coo = parseFloat(canvas.dataset.coo);
                const att = parseFloat(canvas.dataset.att);

                new Chart(ctx, {
                    type: 'radar',
                    plugins: [radarValueLabelPlugin],
                    data: {
                        labels: ['Punctuality', 'Activeness', 'Co-operation', 'Attitude'],
                        datasets: [
                            {
                                label: 'Score',
                                data: [pun, act, coo, att],
                                backgroundColor: 'rgba(79, 70, 229, 0.15)',
                                borderColor: 'rgba(79, 70, 229, 0.9)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 1.5,
                                pointRadius: 3,
                            },
                            {
                                label: 'Min',
                                data: [2, 2, 2, 2],
                                backgroundColor: 'rgba(156,163,175,0.08)',
                                borderColor: 'rgba(156,163,175,0.5)',
                                borderWidth: 1,
                                borderDash: [3, 3],
                                pointRadius: 0,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: 35 }, // Further increased padding to 35
                        scales: {
                            r: {
                                min: 0, max: 4,
                                ticks: { display: false, stepSize: 1 },
                                grid: { color: gridColor },
                                angleLines: { color: 'rgba(0,0,0,0.15)', lineWidth: 1 },
                                pointLabels: {
                                    display: false // Hide default labels, plugin handles it better
                                }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            });

            // 6. CSI Trainer Radar Charts (Section C)
            document.querySelectorAll('.csi-trainer-radar').forEach(canvas => {
                let rawScores = [];
                try { rawScores = JSON.parse(canvas.dataset.scores || '[]'); } catch (e) { }
                const data8 = rawScores.slice(0, 8).map(v => parseFloat(v) || 0);

                new Chart(canvas.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: ['Sikap', 'Penguasaan Materi', 'Penyajian Materi', 'Antusiasme', 'Pengendalian Waktu', 'Penguasaan Kelas', 'Penampilan', 'Penyimpulan'],
                        datasets: [{
                            label: 'Score',
                            data: data8,
                            backgroundColor: 'rgba(99, 102, 241, 0.15)',
                            borderColor: 'rgba(99, 102, 241, 0.9)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                            pointRadius: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                min: 0, max: 5,
                                ticks: { stepSize: 1, display: false },
                                grid: { color: 'rgba(0,0,0,0.07)' },
                                pointLabels: { font: { size: 8, weight: 'bold' }, color: '#6b7280' }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            });

            // Custom plugin to draw indicator header exactly as requested
            const classEvalHeaderPlugin = {
                id: 'classEvalHeader',
                beforeDraw(chart) {
                    const { ctx, chartArea, scales: { x } } = chart;
                    // Ensure chartArea is defined
                    if (!chartArea || !x) return;
                    
                    const { top, left, right } = chartArea;
                    const headerHeight = 22;
                    const headerTop = top - headerHeight - 8;
                    
                    ctx.save();
                    
                    // Box background
                    ctx.fillStyle = '#ffffff';
                    
                    // Borders
                    ctx.strokeStyle = '#d1d5db';
                    ctx.lineWidth = 1;
                    
                    // Draw ITEM box
                    ctx.fillRect(0, headerTop, left, headerHeight);
                    ctx.strokeRect(0, headerTop, left, headerHeight);
                    
                    ctx.fillStyle = '#000000';
                    ctx.font = 'bold 9px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText("ITEM", left / 2, headerTop + headerHeight / 2);
                    
                    // Draw category boxes
                    const labels = ['VERY POOR', 'POOR', 'ENOUGH', 'GOOD', 'VERY GOOD'];
                    for(let i=0; i<5; i++) {
                        const xStart = x.getPixelForValue(i);
                        const xEnd = x.getPixelForValue(i+1);
                        
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(xStart, headerTop, xEnd - xStart, headerHeight);
                        ctx.strokeRect(xStart, headerTop, xEnd - xStart, headerHeight);
                        
                        ctx.fillStyle = '#000000';
                        ctx.fillText(labels[i], (xStart + xEnd) / 2, headerTop + headerHeight / 2);
                    }
            
                    ctx.restore();
                }
            };

            const barValueLabelPlugin = {
                id: 'barValueLabel',
                afterDatasetsDraw(chart) {
                    const { ctx, data } = chart;
                    const meta = chart.getDatasetMeta(0);
                    
                    ctx.save();
                    ctx.font = 'bold 10px sans-serif';
                    ctx.fillStyle = '#ffffff';
                    ctx.textAlign = 'right';
                    ctx.textBaseline = 'middle';
                    
                    meta.data.forEach((bar, index) => {
                        const val = data.datasets[0].data[index];
                        if (val > 0) {
                            const xPos = bar.x - 6; // slightly inside from the right edge
                            const yPos = bar.y;
                            ctx.fillText(val.toFixed(2), xPos, yPos);
                        }
                    });
                    ctx.restore();
                }
            };

            // 7. CSI Class Trainer Bar Chart (Section D1)
            const classTrainerCanvas = document.getElementById('csiClassTrainerBar');
            if (classTrainerCanvas) {
                let rawScores = [];
                try { rawScores = JSON.parse(classTrainerCanvas.dataset.scores || '[]'); } catch (e) { }
                const data8 = rawScores.slice(0, 8).map(v => parseFloat(v) || 0);

                new Chart(classTrainerCanvas.getContext('2d'), {
                    type: 'bar',
                    plugins: [classEvalHeaderPlugin, barValueLabelPlugin],
                    data: {
                        labels: ['Sikap', 'Penguasaan Materi', 'Penyajian Materi', 'Antusiasme', 'Pengendalian Waktu', 'Penguasaan Kelas', 'Penampilan', 'Penyimpulan'],
                        datasets: [{
                            data: data8,
                            backgroundColor: indigoPrimary,
                            borderRadius: 4,
                            barThickness: 10
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 35 } },
                        scales: {
                            x: { min: 0, max: 5, grid: { color: gridColor }, ticks: { font: { size: 8 } } },
                            y: { grid: { display: false }, ticks: { font: { size: 8, weight: 'bold' }, color: labelColor } }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        }
                    }
                });
            }

            // 8. CSI Subject Bar Chart (Section D2)
            const subCanvas = document.getElementById('csiSubjectBar');
            if (subCanvas) {
                let subScores = [];
                try { subScores = JSON.parse(subCanvas.dataset.scores || '[]'); } catch (e) { }
                const dataSub = subScores.slice(0, 4).map(v => parseFloat(v) || 0);

                new Chart(subCanvas.getContext('2d'), {
                    type: 'bar',
                    plugins: [classEvalHeaderPlugin, barValueLabelPlugin],
                    data: {
                        labels: ['Sistematika Penyampaian', 'Kesiapan Penyampaian', 'Manfaat Materi', 'Relevansi Materi'],
                        datasets: [{
                            data: dataSub,
                            backgroundColor: 'rgb(245, 158, 11)',
                            borderRadius: 4,
                            barThickness: 15
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 35 } },
                        scales: {
                            x: { min: 0, max: 5, grid: { color: gridColor }, ticks: { font: { size: 8 } } },
                            y: { grid: { display: false }, ticks: { font: { size: 8, weight: 'bold' }, color: labelColor } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // 9. CSI Operational Bar Chart (Section D3)
            const opsCanvas = document.getElementById('csiOperationalBar');
            if (opsCanvas) {
                let opsScores = [];
                try { opsScores = JSON.parse(opsCanvas.dataset.scores || '[]'); } catch (e) { }
                const dataOps = opsScores.slice(0, 5).map(v => parseFloat(v) || 0);

                new Chart(opsCanvas.getContext('2d'), {
                    type: 'bar',
                    plugins: [classEvalHeaderPlugin, barValueLabelPlugin],
                    data: {
                        labels: ['Waktu', 'Suasana', 'Konsumsi', 'Fasilitas Mengajar', 'Tempat Pelaksanaan'],
                        datasets: [{
                            data: dataOps,
                            backgroundColor: 'rgb(16, 185, 129)',
                            borderRadius: 4,
                            barThickness: 15
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 35 } },
                        scales: {
                            x: { min: 0, max: 5, grid: { color: gridColor }, ticks: { font: { size: 8 } } },
                            y: { grid: { display: false }, ticks: { font: { size: 8, weight: 'bold' }, color: labelColor } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // 10. Interactive Signatures AJAX
            document.querySelectorAll('.signer-trigger').forEach(input => {
                input.addEventListener('change', function () {
                    const field = this.dataset.field;
                    const value = this.value;
                    const trainingId = "{{ $training->id }}";

                    // Simple AJAX post
                    fetch(`/trainings/${trainingId}/summary`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            [field]: value
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Smoothly reload to refresh signature images
                                window.location.reload();
                            }
                        })
                        .catch(error => console.error('Error saving signer:', error));
                });
            });


        });
    </script>

    {{-- html2canvas + jsPDF for PDF download --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        async function downloadPdf() {
            const btn = document.getElementById('downloadPdfBtn');
            const icon = document.getElementById('pdfIcon');
            const spinner = document.getElementById('pdfSpinner');
            const btnText = document.getElementById('pdfBtnText');

            // Show loading state
            btn.disabled = true;
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            btnText.textContent = 'Generating...';

            try {
                const { jsPDF } = window.jspdf;

                // 1. Hide signature inputs & replace with text temporarily
                const signatureInputs = document.querySelectorAll('.signature-input');
                const tempDivs = [];
                signatureInputs.forEach(input => {
                    const div = document.createElement('div');
                    div.className = 'text-center font-bold text-[9px] w-full py-0.5 px-1';
                    div.style.textDecoration = 'underline';
                    div.innerText = input.value || '';
                    input.parentNode.insertBefore(div, input);
                    input.style.display = 'none';
                    tempDivs.push({ input: input, div: div });
                });

                // 2. Setup jsPDF
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a3'
                });

                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const margin = 10;
                const contentWidth = pageWidth - (margin * 2);
                const maxPageHeight = pageHeight - (margin * 2);

                let currentY = margin;

                // 3. Find all blocks to render
                // We use .pdf-section to identify atomic units that shouldn't be split
                const blocks = document.querySelectorAll('.pdf-section');
                
                for (let i = 0; i < blocks.length; i++) {
                    const block = blocks[i];
                    
                    // Capture block
                    const canvas = await html2canvas(block, {
                        scale: 2,
                        useCORS: true,
                        backgroundColor: '#ffffff',
                        logging: false
                    });

                    // Calculate dimensions in PDF mm
                    // Canvas scale is 2, so width in pixels / 2 is "CSS pixels"
                    // ratio is mm-per-pixel
                    const imgWidthCssPx = canvas.width / 2;
                    const imgHeightCssPx = canvas.height / 2;
                    
                    // Scale factor to fit contentWidth
                    const scaleFactor = contentWidth / imgWidthCssPx;
                    const imgWidthMm = contentWidth;
                    const imgHeightMm = imgHeightCssPx * scaleFactor;

                    // Check if block fits on current page with a tighter buffer (10mm)
                    const bottomBuffer = 10;
                    const maxAllowedY = pageHeight - margin - bottomBuffer;

                    if (currentY + imgHeightMm > maxAllowedY) {
                        pdf.addPage('a3', 'landscape');
                        currentY = margin;
                    }

                    // Add to PDF
                    const imgData = canvas.toDataURL('image/jpeg', 0.95);
                    pdf.addImage(imgData, 'JPEG', margin, currentY, imgWidthMm, imgHeightMm);
                    
                    // Add gap between blocks (8mm)
                    const blockGap = 8;
                    currentY += imgHeightMm + blockGap;
                }

                // 4. Cleanup & Save
                tempDivs.forEach(item => {
                    item.input.style.display = '';
                    item.div.remove();
                });

                const rawTitle = `{{ $training->title }}`;
                const safeTitle = rawTitle.replace(/[^a-z0-9]/gi, '_').toLowerCase();
                const filename = `summary_report_${safeTitle}.pdf`;
                pdf.save(filename);

            } catch (err) {
                console.error('PDF generation failed:', err);
                alert('An error occurred while generating the PDF. Please try again.');
            } finally {
                btn.disabled = false;
                icon.classList.remove('hidden');
                spinner.classList.add('hidden');
                btnText.textContent = 'Download PDF';
            }
        }
    </script>

    <style>
        @media print {
            @page {
                size: A3 landscape;
                margin: 10mm;
            }
            body { background-color: white !important; }
            .print\:hidden { display: none !important; }
        }
    </style>
</x-admin-layout>