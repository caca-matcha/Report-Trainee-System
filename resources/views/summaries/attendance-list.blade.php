<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <a href="{{ route('admin.trainings.show', $training) }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                {{ __('Attendance List Report') }}
            </h2>
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
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1000px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-black" id="print-area">
                    
                    {{-- HEADER LOGOS & TITLE --}}
                    <div class="mb-6 relative text-black flex justify-center items-start min-h-[50px]">
                        {{-- Absolute Logo --}}
                        <div class="absolute left-0 top-0 flex items-center gap-2">
                            <img src="{{ asset('assets/dg-logo.png') }}" class="w-10 h-auto object-contain" alt="Dharma Group" onerror="this.onerror=null; this.src=''; this.className='hidden';">
                            <div>
                                <div class="text-[12px] font-bold text-blue-900 leading-tight tracking-tight">DHARMA GROUP</div>
                                <div class="text-[9px] text-green-600 font-bold leading-tight italic tracking-tight">Exist to Contribute</div>
                            </div>
                        </div>

                        {{-- Centered Title --}}
                        <div class="text-center w-full max-w-[60%]">
                            <div class="font-bold text-[16px] underline mb-1 leading-none">DAFTAR HADIR</div>
                            <div class="font-black text-[14px] uppercase leading-tight">{{ $training->title }}</div>
                        </div>
                    </div>

                    {{-- Left Aligned Date --}}
                    <div class="text-[10px] font-bold text-black border-2 border-b-0 border-black p-2 bg-white mt-8">
                        {{ \Carbon\Carbon::parse($training->start_date)->locale('id')->translatedFormat('l, d F Y') }}
                    </div>

                    {{-- TABLE --}}
                    <table class="w-full border-collapse border-2 border-black text-[11px] text-black bg-white mb-8 table-fixed">
                        <thead class="bg-gray-100 uppercase text-[10px] font-bold">
                            <tr>
                                <th class="border border-black px-1 py-3 w-[5%] text-center">No</th>
                                <th class="border border-black px-1 py-3 w-[12%] text-center">NPK</th>
                                <th class="border border-black px-2 py-3 w-[25%] text-left">NAMA</th>
                                <th class="border border-black px-2 py-3 w-[18%] text-left">BAGIAN</th>
                                <th class="border border-black px-1 py-3 w-[10%] text-center">SUB CO</th>
                                <th class="border border-black px-1 py-3 w-[10%] text-center">WAKTU</th>
                                <th class="border border-black px-1 py-3 w-[20%] text-center">TANDA TANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $participants = $training->participants;
                                $rowCount = max(10, $participants->count()); 
                            @endphp
                            
                            @for($i = 0; $i < $rowCount; $i++)
                                @php $p = $participants->get($i); @endphp
                                <tr class="h-14 border border-black relative">
                                    <td class="border border-black px-2 py-1 text-center font-black">{{ $i + 1 }}</td>
                                    <td class="border border-black px-2 py-1 text-center truncate">{{ $p->npk ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 font-bold whitespace-normal leading-tight">{{ $p->name ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-[9px] leading-tight">{{ $p->department ?? '' }}</td>
                                    <td class="border border-black px-2 py-1 text-center font-bold uppercase">{{ $p->subco ?? '' }}</td>
                                    <td class="border border-black px-1 py-1 text-center font-bold text-[9px] leading-tight">
                                        {{ $p && $p->is_present && $p->updated_at ? $p->updated_at->format('d/m H:i') : '' }}
                                    </td>
                                    <td class="border border-black p-0 relative">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="absolute top-0.5 {{ ($i + 1) % 2 != 0 ? 'left-1' : 'right-1' }} text-[9px] font-black text-gray-400">{{ $i + 1 }}</span>
                                            @if($p && $p->is_present && $p->signature_path)
                                                @php
                                                    $sigExists = Storage::disk('public')->exists($p->signature_path);
                                                @endphp
                                                @if($sigExists)
                                                    <img src="{{ asset('storage/' . $p->signature_path) }}" class="max-h-[85%] max-w-[85%] object-contain" alt="TTD">
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                    {{-- FOOTER / TRAINERS & PIC --}}
                    <div class="grid grid-cols-2 gap-12 mt-4 page-break-inside-avoid">
                        {{-- Trainers --}}
                        <div>
                            <h4 class="text-[11px] font-black uppercase mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 bg-black block"></span> TRAINER
                            </h4>
                            <table class="w-full border-collapse border-2 border-black text-xs text-black bg-white table-fixed">
                                <tbody>
                                    @php $trainers = $training->trainers ?? [['name' => '', 'npk' => '', 'department' => '', 'subco' => '']]; @endphp
                                    @foreach($trainers as $t)
                                    @php
                                        $trainerSignature = null;
                                        if (!empty($t['name'])) {
                                            $user = \App\Models\User::where('name', $t['name'])
                                                ->orderByRaw('signature IS NULL, signature = ""')
                                                ->first();
                                            if ($user && $user->signature) {
                                                $trainerSignature = $user->signature;
                                            }
                                        }
                                    @endphp
                                    <tr class="h-10 border border-black">
                                        <td class="border border-black p-1 w-[10%] text-center font-bold text-[10px]">{{ $loop->iteration }}</td>
                                        <td class="border border-black p-1 w-[60%] font-bold uppercase text-[10px] pl-2 truncate">{{ $t['name'] ?? '' }}</td>
                                        <td class="border border-black p-0 relative w-[30%]">
                                            <div class="absolute inset-0 flex items-center justify-center p-0.5">
                                                <span class="absolute top-0.5 left-1 text-[8px] font-black text-gray-400">{{ $loop->iteration }}</span>
                                                @if($trainerSignature && Storage::disk('public')->exists($trainerSignature))
                                                    <img src="{{ asset('storage/' . $trainerSignature) }}" class="h-full w-auto max-w-[90%] object-contain" alt="TTD" style="mix-blend-mode: multiply;">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- PIC --}}
                        <div>
                            <h4 class="text-[11px] font-black uppercase mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 bg-black block"></span> PIC / PENANGGUNG JAWAB
                            </h4>
                            <table class="w-full border-collapse border-2 border-black text-xs text-black bg-white table-fixed">
                                <tbody>
                                    @php 
                                        $pics = $training->pics ?? [['name' => $training->user->name ?? '']]; 
                                        if (empty($pics)) $pics = [['name' => $training->user->name ?? '']];
                                    @endphp
                                    @foreach($pics as $p)
                                    @php
                                        $picSignature = null;
                                        if (!empty($p['name'])) {
                                            $user = \App\Models\User::where('name', $p['name'])
                                                ->orderByRaw('signature IS NULL, signature = ""')
                                                ->first();
                                            if ($user && $user->signature) {
                                                $picSignature = $user->signature;
                                            }
                                        }
                                    @endphp
                                    <tr class="h-10 border border-black">
                                        <td class="border border-black p-1 w-[10%] text-center font-bold text-[10px]">{{ $loop->iteration }}</td>
                                        <td class="border border-black p-1 w-[60%] font-bold uppercase text-[10px] pl-2 truncate">{{ $p['name'] ?? '' }}</td>
                                        <td class="border border-black p-0 relative w-[30%]">
                                            <div class="absolute inset-0 flex items-center justify-center p-0.5">
                                                <span class="absolute top-0.5 left-1 text-[8px] font-black text-gray-400">{{ $loop->iteration }}</span>
                                                @if($picSignature && Storage::disk('public')->exists($picSignature))
                                                    <img src="{{ asset('storage/' . $picSignature) }}" class="h-full w-auto max-w-[90%] object-contain" alt="TTD" style="mix-blend-mode: multiply;">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- APPROVAL SECTION (BOSSES) --}}
                    <div class="grid grid-cols-2 gap-12 mt-8 page-break-inside-avoid">
                        {{-- Checked By --}}
                        <div>
                            <h4 class="text-[11px] font-black uppercase mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 bg-black block"></span> CHECKED BY (DEPT HEAD)
                            </h4>
                            <div class="border-2 border-black bg-white min-h-[80px] relative flex flex-col">
                                <div class="flex-1 flex items-center justify-center p-2">
                                    @if($training->is_approved)
                                        <div class="border-4 border-emerald-500 text-emerald-500 font-black text-[12px] px-2 py-0.5 rounded-md uppercase tracking-[0.2em] transform -rotate-12 opacity-80 flex flex-col items-center leading-none bg-white/50">
                                            <span>APPROVED</span>
                                            @if($training->approved_at)
                                                <span class="text-[7px] mt-1 tracking-normal font-bold">{{ $training->approved_at->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="border-t border-black p-1 text-center font-bold text-[10px] uppercase truncate">
                                    {{ $training->summary->checked_by ?? '................................' }}
                                </div>
                            </div>
                        </div>

                        {{-- Confirmed By --}}
                        <div>
                            <h4 class="text-[11px] font-black uppercase mb-1 flex items-center gap-2">
                                <span class="w-2 h-2 bg-black block"></span> CONFIRMED BY (DIV HEAD)
                            </h4>
                            <div class="border-2 border-black bg-white min-h-[80px] relative flex flex-col">
                                <div class="flex-1 flex items-center justify-center p-2">
                                    @if($training->is_approved)
                                        <div class="border-4 border-emerald-500 text-emerald-500 font-black text-[12px] px-2 py-0.5 rounded-md uppercase tracking-[0.2em] transform -rotate-12 opacity-80 flex flex-col items-center leading-none bg-white/50">
                                            <span>APPROVED</span>
                                            @if($training->approved_at)
                                                <span class="text-[7px] mt-1 tracking-normal font-bold">{{ $training->approved_at->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="border-t border-black p-1 text-center font-bold text-[10px] uppercase truncate">
                                    {{ $training->summary->confirmed_by ?? '................................' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background-color: white !important; color: black !important; }
            .print\:hidden { display: none !important; }
            .bg-white { background-color: white !important; }
            /* Tailwind light modes enforcement for dark mode print */
            .dark\:bg-gray-800, .dark\:bg-gray-900, .dark\:bg-gray-900\/50, .dark\:bg-gray-900\/20, .dark\:bg-gray-900\/30, .dark\:bg-gray-700, .dark\:bg-gray-700\/50 {
                background-color: white !important;
            }
            .dark\:text-gray-100, .dark\:text-white { color: #111827 !important; }
            .dark\:border-gray-700, .dark\:border-gray-600 { border-color: #000 !important; }
            
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl { 
                box-shadow: none !important; 
                margin: 0 !important; 
                max-width: 100% !important; 
                border: none !important; 
                border-radius: 0 !important; 
            }
            #print-area { padding: 0 !important; }
            .page-break-inside-avoid { page-break-inside: avoid; }
            @page { size: A4 portrait; margin: 10mm; }
        }
    </style>

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
                const printArea = document.getElementById('print-area');
                
                // Hide scrollbars temporarily
                printArea.style.overflow = 'hidden';

                const canvas = await html2canvas(printArea, {
                    scale: 2,           // higher resolution
                    useCORS: true,      // allow cross-origin images (photos, signatures, etc.)
                    allowTaint: false,
                    logging: false,
                    backgroundColor: '#ffffff'
                });

                printArea.style.overflow = '';

                const imgData = canvas.toDataURL('image/jpeg', 0.95);

                // A4 dimensions in mm (Portrait)
                const pdfWidth = 210;
                const pdfHeight = 297;
                const margin = 10;
                const contentWidth = pdfWidth - margin * 2;
                
                // Calculate dimensions
                const canvasW = canvas.width;
                const canvasH = canvas.height;
                const ratio = contentWidth / (canvasW / 2); // Divide by 2 because scale=2
                const scaledHeight = (canvasH / 2) * ratio; // Total height in mm
                const pageContentHeight = pdfHeight - margin * 2;
                const totalPages = Math.ceil(scaledHeight / pageContentHeight);

                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                for (let page = 0; page < totalPages; page++) {
                    if (page > 0) pdf.addPage();

                    // Calculate the clipping region for the current page
                    const sourceY = page * pageContentHeight / ratio * 2; // Original canvas pixels
                    const sourceH = Math.min(pageContentHeight / ratio * 2, canvasH - sourceY);

                    // Create a temporary canvas for this page segment
                    const pageCanvas = document.createElement('canvas');
                    pageCanvas.width = canvasW;
                    pageCanvas.height = sourceH;
                    const pageCtx = pageCanvas.getContext('2d');
                    
                    // Fill white background
                    pageCtx.fillStyle = '#ffffff';
                    pageCtx.fillRect(0, 0, canvasW, sourceH);
                    
                    // Draw the slice
                    pageCtx.drawImage(canvas, 0, sourceY, canvasW, sourceH, 0, 0, canvasW, sourceH);

                    const pageImgData = pageCanvas.toDataURL('image/jpeg', 0.95);
                    const pageImgHeight = sourceH / 2 * ratio; // Convert back to mm

                    pdf.addImage(pageImgData, 'JPEG', margin, margin, contentWidth, pageImgHeight);
                }

                // Generate filename dynamically
                const rawTitle = `{{ $training->title }}`;
                const safeTitle = rawTitle.replace(/[^a-z0-9]/gi, '_').toLowerCase();
                const filename = `attendance_list_${safeTitle}.pdf`;
                
                pdf.save(filename);
                
            } catch (err) {
                console.error('PDF generation failed:', err);
                alert('PDF generation failed. Please try again or use the standard Print Report option.');
            } finally {
                // Restore button state
                btn.disabled = false;
                icon.classList.remove('hidden');
                spinner.classList.add('hidden');
                btnText.textContent = 'Download PDF';
            }
        }
    </script>
</x-admin-layout>
