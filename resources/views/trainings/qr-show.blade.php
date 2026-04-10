<x-admin-layout>
    <div class="min-h-screen bg-white dark:bg-gray-950 flex flex-col items-center justify-center p-6">
        <div class="max-w-2xl w-full text-center space-y-8">
            <div class="space-y-2">
                <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                    {{ $training->title }}</h2>
                <p
                    class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest px-4 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-full inline-block">
                    Absensi Kehadiran Peserta</p>
            </div>

            <div
                class="bg-white dark:bg-gray-900 p-12 rounded-[3rem] shadow-2xl border-8 border-gray-50 dark:border-gray-800 flex flex-col items-center justify-center relative overflow-hidden group">
                <div
                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                </div>

                <div class="bg-white p-4 rounded-3xl group-hover:scale-105 transition-transform duration-500">
                    {!! QrCode::size(400)->margin(2)->generate($url) !!}
                </div>

                <div class="mt-8 space-y-3">
                    <p class="text-lg font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">Scan QR
                        Code Di Atas</p>
                    <p class="text-xs text-gray-400 font-medium italic">Gunakan kamera HP atau fitur Scan di Dashboard
                    </p>
                    
                    {{-- Testing Link for Localhost --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-2">Simulasi untuk Testing (Link Hasil Scan):</p>
                        <a href="{{ $url }}" target="_blank" class="text-xs font-bold text-indigo-500 hover:text-indigo-700 underline break-all">
                            {{ $url }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-8">
                <div class="text-center">
                    <p class="text-2xl font-black text-gray-900 dark:text-white">
                        {{ $training->participants->where('is_present', true)->count() }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Hadir</p>
                </div>
                <div class="w-px h-8 bg-gray-100 dark:bg-gray-800"></div>
                <div class="text-center">
                    <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $training->participants->count() }}
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Peserta</p>
                </div>
            </div>

            <div class="pt-8">
                <a href="{{ route('admin.trainings.show', $training) }}"
                    class="text-xs font-black text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    Kembali Ke Detail Training
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto refresh setiap 10 detik untuk update jumlah yang hadir
            setTimeout(() => {
                window.location.reload();
            }, 10000);
        </script>
    @endpush
</x-admin-layout>