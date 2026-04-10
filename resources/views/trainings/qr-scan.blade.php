<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 p-4 flex flex-col items-center justify-center">
        <div class="max-w-md w-full space-y-6">
            <div class="text-center space-y-2">
                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Scan QR Kehadiran
                </h3>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-widest">{{ $training->title }}</p>
            </div>

            <div
                class="overflow-hidden bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 relative">
                <div id="reader" class="w-full aspect-square md:aspect-video"></div>

                <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                    <div
                        class="w-64 h-64 border-2 border-indigo-500/50 rounded-3xl animate-pulse flex items-center justify-center">
                        <div class="w-full h-0.5 bg-indigo-500/30 absolute shadow-[0_0_15px_rgba(99,102,241,0.5)]">
                        </div>
                    </div>
                </div>
            </div>

            <div id="result"
                class="hidden p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl flex items-center gap-3 text-emerald-600 dark:text-emerald-400">
                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="text-xs font-black uppercase tracking-widest">Validasi Link Absensi...</p>
            </div>

            <div class="text-center py-4">
                <a href="{{ route('dashboard') }}"
                    class="text-[10px] font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">
                    Batal Dan Kembali
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            function onScanSuccess(decodedText, decodedResult) {
                // Hentikan camera
                html5QrcodeScanner.clear();

                // Tampilkan loading
                document.getElementById('result').classList.remove('hidden');

                // Redirect ke URL hasil scan (Signed URL)
                window.location.href = decodedText;
            }

            function onScanFailure(error) {
                // Abaikan error saat mencari QR
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    showTorchButtonIfSupported: true,
                    rememberLastUsedCamera: true
                },
                /* verbose= */ false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        </script>
    @endpush

    <style>
        #reader {
            border: none !important;
        }

        #reader video {
            border-radius: 2rem;
            object-fit: cover;
        }

        #reader__dashboard_section_csr button {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1rem;
        }

        #reader__camera_selection {
            background-color: transparent;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 10px;
            padding: 0.25rem 0.5rem;
        }
    </style>
</x-app-layout>