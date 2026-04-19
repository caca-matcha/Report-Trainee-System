<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Sinkronisasi User dari API</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Import / Sinkronisasi User</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Klik tombol di bawah untuk mengimpor data karyawan terbaru dari API pusat.</p>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-6 mb-8">
                    <h4 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Penting
                    </h4>
                    <ul class="text-xs text-blue-800 dark:text-blue-400 space-y-2 font-medium">
                        <li class="flex items-center gap-2 italic">• User baru akan dibuat otomatis dengan password default: <span class="font-black text-blue-900 dark:text-blue-300">NPK</span></li>
                        <li class="flex items-center gap-2 italic">• User yang sudah ada akan diperbarui nama, departemen, dan subcompany-nya</li>
                        <li class="flex items-center gap-2 italic">• Password user yang sudah ada <span class="font-black text-blue-900 dark:text-blue-300 uppercase">TIDAK AKAN BERUBAH</span></li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 p-6 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <form method="POST" action="{{ route('admin.import-users.run') }}" onsubmit="confirmAction(event, 'Yakin ingin menjalankan sinkronisasi user dari API? Proses ini mungkin memakan waktu beberapa saat.', 'info', 'Ya, Jalankan!')">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 dark:shadow-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Jalankan Sinkronisasi
                        </button>
                    </form>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status Database</p>
                        <p class="text-xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($totalUsers) }} <span class="text-xs font-bold text-gray-500 uppercase ml-1">Total Users</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
