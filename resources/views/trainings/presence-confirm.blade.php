<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Training - {{ $training->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .participant-card.selected {
            border-color: #4f46e5;
            background-color: #f5f3ff;
            ring: 2px;
            ring-color: #4f46e5;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen pb-20">
    <div class="max-w-2xl mx-auto px-4 pt-8">
        
        <!-- Header Section -->
        <div class="text-center mb-10 animate-fade-in">
            <div class="inline-block p-3 bg-white rounded-3xl shadow-xl shadow-indigo-100 mb-6">
                <img src="{{ asset('assets/dg-logo.png') }}" class="h-8" alt="Logo">
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 leading-tight mb-2">{{ $training->title }}</h1>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-indigo-500">{{ $training->organizer }} • {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</p>
        </div>

        <div id="step-1" class="animate-fade-in">
            <!-- Search & Selection -->
            <div class="glass-card rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/60 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200">1</div>
                    <h2 class="text-xl font-extrabold text-slate-800">Cari Nama Anda</h2>
                </div>

                <div class="relative mb-6">
                    <input type="text" id="name-search" 
                        placeholder="Ketik NPK atau Nama Anda..."
                        class="w-full px-6 py-4 bg-slate-100 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                    <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>

                <div id="participants-container" class="space-y-3 max-h-[400px] overflow-y-auto px-1 pr-2 custom-scrollbar">
                    @foreach($participants as $p)
                        <div class="participant-card group relative p-4 bg-white border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all flex items-center justify-between {{ $p->is_present ? 'opacity-50 grayscale' : '' }}" 
                             data-id="{{ $p->id }}" 
                             data-name="{{ strtolower($p->name) }}" 
                             data-npk="{{ $p->npk }}"
                             onclick="{{ $p->is_present ? 'void(0)' : 'selectParticipant(this)' }}">
                            
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-indigo-600 font-bold group-hover:bg-indigo-50 transition-colors">
                                    {{ substr($p->name, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-slate-800 uppercase tracking-tight">{{ $p->name }}</p>
                                    <p class="text-[10px] font-mono text-slate-400 font-bold uppercase">{{ $p->npk }}</p>
                                </div>
                            </div>

                            @if($p->is_present)
                                <span class="bg-green-100 text-green-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Hadir</span>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 group-hover:border-indigo-400 flex items-center justify-center transition-all bg-white select-indicator">
                                    <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full scale-0 transition-transform duration-300"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="step-2" class="hidden animate-fade-in">
            <div class="glass-card rounded-[2.5rem] p-8 shadow-2xl shadow-indigo-200/40 border-indigo-100">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-200">2</div>
                        <h2 class="text-xl font-extrabold text-slate-800">Tanda Tangan</h2>
                    </div>
                    <button onclick="backToStep1()" class="text-xs font-bold text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Ganti Nama
                    </button>
                </div>

                <div class="bg-slate-50 rounded-3xl p-4 mb-4 text-center border-2 border-indigo-50">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-1">Presensi Atas Nama:</p>
                    <p id="selected-participant-name" class="text-xl font-extrabold text-indigo-900 uppercase"></p>
                    <p id="selected-participant-npk" class="text-xs font-mono font-bold text-indigo-400 mt-1"></p>
                </div>

                <div class="relative w-full aspect-[4/3] bg-white border-2 border-dashed border-indigo-200 rounded-3xl overflow-hidden mb-6 shadow-inner cursor-crosshair">
                    <canvas id="signature-pad" class="absolute inset-0 w-full h-full touch-none"></canvas>
                    <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-5 transition-opacity" id="pad-placeholder">
                        <p class="text-4xl font-black uppercase rotate-[-20deg]">Tanda Tangan Disini</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="button" id="clear-btn" class="py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all">
                        Ulangi
                    </button>
                    <button type="button" id="submit-btn" class="py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-200">
                        Kirim Presensi
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Modal (Hidden initially) -->
        <div id="success-state" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-[3rem] p-10 max-w-sm w-full text-center shadow-2xl animate-fade-in">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-2">Presensi Berhasil!</h2>
                <p class="text-sm text-slate-500 leading-relaxed mb-8">Terima kasih atas kehadiran Anda dalam pelatihan ini.</p>
                <button onclick="location.reload()" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl shadow-slate-200">
                    Kembali Ke Daftar
                </button>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        let selectedId = null;
        let signaturePad = null;
        const canvas = document.getElementById('signature-pad');

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Signature Pad
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(31, 41, 55)',
                minWidth: 1.5,
                maxWidth: 4.5
            });

            signaturePad.onBegin = () => {
                document.getElementById('pad-placeholder').style.opacity = '0';
            };

            // Resize canvas logic
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
                document.getElementById('pad-placeholder').style.opacity = '0.05';
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // Search Logic
            const searchInput = document.getElementById('name-search');
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('.participant-card').forEach(card => {
                    const name = card.dataset.name;
                    const npk = card.dataset.npk;
                    if (name.includes(term) || npk.includes(term)) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });

            // Clear Button
            document.getElementById('clear-btn').addEventListener('click', () => {
                signaturePad.clear();
                document.getElementById('pad-placeholder').style.opacity = '0.05';
            });

            // Submit Button
            document.getElementById('submit-btn').addEventListener('click', async () => {
                if (!selectedId) return alert('Silakan pilih nama terlebih dahulu.');
                if (signaturePad.isEmpty()) return alert('Silakan masukkan tanda tangan Anda.');

                const btn = document.getElementById('submit-btn');
                btn.disabled = true;
                btn.innerText = 'MENGIRIM...';

                try {
                    const response = await fetch('{{ route("trainings.submit_presence", $training) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            participant_id: selectedId,
                            signature: signaturePad.toDataURL()
                        })
                    });

                    const data = await response.json();
                    if (response.ok) {
                        document.getElementById('success-state').classList.remove('hidden');
                    } else {
                        alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        btn.disabled = false;
                        btn.innerText = 'KIRIM PRESENSI';
                    }
                } catch (err) {
                    console.error(err);
                    alert('Koneksi bermasalah. Pastikan internet Anda aktif.');
                    btn.disabled = false;
                    btn.innerText = 'KIRIM PRESENSI';
                }
            });
        });

        function selectParticipant(el) {
            selectedId = el.dataset.id;
            const name = el.querySelector('.text-slate-800').innerText;
            const npk = el.querySelector('.font-mono').innerText;

            document.getElementById('selected-participant-name').innerText = name;
            document.getElementById('selected-participant-npk').innerText = npk;

            // Transition to Step 2
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            
            // Re-draw placeholder set focus logic
            setTimeout(() => {
                // Resize if needed after unhiding
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
                document.getElementById('pad-placeholder').style.opacity = '0.05';
            }, 50);
        }

        function backToStep1() {
            selectedId = null;
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
            signaturePad.clear();
        }
    </script>
</body>
</html>
