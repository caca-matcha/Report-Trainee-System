<x-admin-layout>
    <div x-data="{ 
        showSyncModal: false, 
        isSyncing: false, 
        syncMessage: '',
        totalUsers: {{ $totalUsers }},
        runSync() {
            Swal.fire({
                title: 'Jalankan Sinkronisasi?',
                text: 'Sistem akan mengambil data terbaru dari API pusat. Proses ini mungkin memakan waktu beberapa detik.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Sinkronkan!',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#f8fafc',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isSyncing = true;
                    this.syncMessage = 'Sedang menyinkronkan data dari API pusat... Mohon tunggu.';
                    
                    fetch('{{ route('admin.import-users.run') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(text || response.statusText) });
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.isSyncing = false;
                        this.syncMessage = data.message;
                        this.totalUsers = data.total_users;
                        // Auto refresh after success
                        setTimeout(() => { window.location.reload(); }, 2000);
                    })
                    .catch(error => {
                        this.isSyncing = false;
                        this.syncMessage = 'Kesalahan: ' + (error.message.substring(0, 100) || 'Koneksi terputus atau server error.');
                        console.error(error);
                    });
                }
            });
        }
    }">
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-1">
                <h1 class="text-2xl font-black bg-gradient-to-r from-gray-900 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent tracking-tight">
                    Master Trainee
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Database profil seluruh peserta pelatihan dari seluruh unit bisnis <span class="text-indigo-600 dark:text-indigo-400 font-bold underline decoration-indigo-500/30 underline-offset-4 tracking-tight">Dharma Group</span>.
                </p>
            </div>
            
            <div class="flex items-center gap-4 w-auto">
                {{-- Utility Actions Group --}}
                <div class="flex items-center gap-2 p-1 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm shrink-0">
                    <form action="{{ route('admin.employees.bulk-photo') }}" method="POST" enctype="multipart/form-data" id="bulkPhotoForm">
                        @csrf
                        <input type="file" name="photos[]" id="bulkPhotos" class="hidden" multiple accept="image/*" onchange="document.getElementById('bulkPhotoForm').submit()">
                        <button type="button" onclick="document.getElementById('bulkPhotos').click()" 
                                class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 transition-all shadow-sm border border-transparent hover:border-indigo-100 dark:hover:border-indigo-800">
                            <i data-lucide="images" class="w-4 h-4 mr-2 text-indigo-500"></i>
                            Bulk Photos
                        </button>
                    </form>
                    
                    <button @click="showSyncModal = true"
                            class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all shadow-sm border border-transparent hover:border-emerald-100 dark:hover:border-emerald-800">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                        Sync API
                    </button>
                </div>

                {{-- Primary Action --}}
                <a href="{{ route('admin.employees.create') }}"
                   class="inline-flex items-center gap-3 px-6 py-3.5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 active:scale-95 transition-all shrink-0">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Tambah Trainee
                </a>
            </div>
        </div>
    </x-slot>

    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    @endpush
        @if(session('warning'))
            <div
                class="mt-4 px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg text-amber-700 dark:text-amber-400 text-sm">
                {{ session('warning') }}
            </div>
        @endif

        <div class="space-y-6">
            {{-- Filter & Search --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form action="{{ route('admin.employees.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[300px] space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Cari
                            Trainee</label>
                        <div class="relative group">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama atau NPK..."
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700/50 dark:text-white border-0 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
                            <div
                                class="absolute left-3.5 top-2.5 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none min-w-[200px] space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Sub Company</label>
                        <select name="subco" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700/50 dark:text-white border-0 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 transition-all font-medium appearance-none">
                            <option value="">Semua Subco</option>
                            @foreach($subcos as $subco)
                                <option value="{{ $subco }}" {{ request('subco') == $subco ? 'selected' : '' }}>{{ $subco }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-none min-w-[200px] space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Departemen</label>
                        <select name="department" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700/50 dark:text-white border-0 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 transition-all font-medium appearance-none">
                            <option value="">Semua Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-none min-w-[150px] space-y-1.5">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700/50 dark:text-white border-0 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 transition-all font-medium appearance-none">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                            Cari
                        </button>
                        @if(request('q') || request('subco') || request('department') || request('status'))
                            <a href="{{ route('admin.employees.index') }}"
                                class="px-6 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">#
                                </th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Nama
                                </th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">NPK
                                </th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Departemen</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Sub
                                    Company</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                <th
                                    class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($employees as $index => $employee)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $employees->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($employee->photo)
                                                <img src="{{ asset('storage/' . $employee->photo) }}" alt=""
                                                    class="w-8 h-8 rounded-lg object-cover">
                                            @else
                                                <div
                                                    class="w-8 h-8 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-black">
                                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span
                                                class="font-bold text-gray-900 dark:text-white">{{ $employee->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium text-xs">
                                        {{ $employee->npk ?: $employee->email }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium text-xs">
                                        {{ $employee->department ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium text-xs">
                                        {{ $employee->subco ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-xs">
                                        @if($employee->employee_status == 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-[10px] font-black uppercase tracking-widest">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-[10px] font-black uppercase tracking-widest">
                                                {{ $employee->employee_status ?: 'Inactive' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.employees.edit', $employee) }}"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST"
                                                onsubmit="confirmAction(event, 'Hapus trainee {{ $employee->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/40 rounded-lg transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="w-12 h-12 opacity-20" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-xs font-black uppercase tracking-widest">Tidak ada trainee
                                                ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($employees->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                        {{ $employees->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal Sinkronisasi --}}
        <div x-show="showSyncModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showSyncModal" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="if(!isSyncing) showSyncModal = false"
                    class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showSyncModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700">
                    
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Sinkronisasi Trainee</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Impor data trainee terbaru dari API pusat Dharma Group.</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-6 mb-8">
                            <h4 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-3 flex items-center gap-2 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Penting
                            </h4>
                            <ul class="text-xs text-blue-800 dark:text-blue-400 space-y-2 font-medium">
                                <li class="flex items-center gap-2 italic">• User baru akan dibuat otomatis dengan password default: <span class="font-black text-blue-900 dark:text-blue-300">NPK</span></li>
                                <li class="flex items-center gap-2 italic">• User yang sudah ada akan diperbarui nama, departemen, subcompany, dan statusnya</li>
                                <li class="flex items-center gap-2 italic">• Riwayat training peserta yang sudah ada <span class="font-black text-blue-900 dark:text-blue-300 uppercase underline">TIDAK AKAN HILANG</span></li>
                            </ul>
                        </div>

                        {{-- Status/Feedback Message --}}
                        <template x-if="syncMessage">
                            <div class="mb-6 p-4 rounded-xl text-sm font-medium" 
                                 :class="isSyncing ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800'">
                                <div class="flex items-center gap-3">
                                    <template x-if="isSyncing">
                                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <span x-text="syncMessage"></span>
                                </div>
                            </div>
                        </template>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 p-6 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <button type="button"
                                    @click="runSync()"
                                    :disabled="isSyncing"
                                    class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 dark:shadow-none disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!isSyncing">Jalankan Sinkronisasi</span>
                                <span x-show="isSyncing">Memproses...</span>
                            </button>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status Database</p>
                                <p class="text-xl font-black text-indigo-600 dark:text-indigo-400">
                                    <span x-text="totalUsers"></span> 
                                    <span class="text-xs font-bold text-gray-500 uppercase ml-1">Total Users</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-8 py-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700">
                        <button @click="showSyncModal = false" 
                                :disabled="isSyncing"
                                class="px-6 py-2 text-xs font-black uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition-colors disabled:opacity-50">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>