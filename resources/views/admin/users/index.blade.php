<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent mb-1">
                    User Management
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kelola akun pengguna, hak akses (role), dan konfigurasi profil admin.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 active:scale-95 transition-all">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Tambah User
            </a>
        </div>
    </x-slot>

    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('quick-add-search');
            const suggestions = document.getElementById('quick-add-suggestions');
            const quickAddForm = document.getElementById('form-quick-add');
            const quickAddNpk = document.getElementById('input-quick-add-npk');

            const performSearch = (query) => {
                if (query.length < 3) {
                    suggestions.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('admin.search-users') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            suggestions.innerHTML = data.map(user => `
                                <div class="quick-add-item px-5 py-4 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-4 group/item transition-colors" 
                                     data-npk="${user.npk}">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 font-black border border-indigo-200 dark:border-indigo-800 text-xs shrink-0 overflow-hidden">
                                        ${user.photo ? `<img src="${user.photo}" class="w-full h-full object-cover">` : (user.name ? user.name.charAt(0) : '?')}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">${user.npk}</p>
                                            <span class="text-gray-300">•</span>
                                            <p class="text-[9px] text-gray-400 font-bold truncate uppercase">${user.department}</p>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white truncate">${user.name}</p>
                                    </div>
                                    <div class="opacity-0 group-hover/item:opacity-100 transition-all flex items-center">
                                        <span class="text-[9px] font-black bg-indigo-600 text-white px-3 py-1.5 rounded-lg shadow-lg shadow-indigo-500/20">TAMBAH ADMIN</span>
                                    </div>
                                </div>
                            `).join('');
                            suggestions.classList.remove('hidden');
                        } else {
                            suggestions.innerHTML = '<div class="px-5 py-4 text-xs text-gray-500 italic text-center">Data karyawan tidak ditemukan.</div>';
                            suggestions.classList.remove('hidden');
                        }
                    });
            };

            let timeout = null;
            searchInput.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(timeout);
                timeout = setTimeout(() => performSearch(query), 300);
            });

            suggestions.addEventListener('click', function(e) {
                const item = e.target.closest('.quick-add-item');
                if (item) {
                    const npk = item.dataset.npk;
                    quickAddNpk.value = npk;
                    suggestions.classList.add('hidden');
                    searchInput.value = 'Sedang menambahkan...';
                    quickAddForm.submit();
                }
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#quick-add-search') && !e.target.closest('#quick-add-suggestions')) {
                    suggestions.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush

    {{-- Quick Add Banner --}}
    <div class="mb-10 bg-indigo-600 rounded-3xl md:rounded-[2.5rem] p-6 md:p-10 shadow-2xl shadow-indigo-500/20 relative group">
        {{-- Decorative Background (Clipped) --}}
        <div class="absolute inset-0 rounded-3xl md:rounded-[2.5rem] overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 -tranyate-y-1/2 translate-x-1/2 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>
        </div>
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 items-center gap-8">
            <div>
                <h2 class="text-white text-lg md:text-xl font-black uppercase tracking-widest mb-2 flex items-center gap-3">
                    <i data-lucide="zap" class="w-6 h-6 fill-yellow-400 text-yellow-400"></i>
                    Quick Add Admin
                </h2>
                <p class="text-indigo-100 text-xs md:text-sm font-medium leading-relaxed max-w-md">Cari NPK atau Nama karyawan untuk langsung memberikan hak akses Admin tanpa input manual secara cepat dan instan.</p>
            </div>
            
            <div class="relative">
                <div class="relative z-20">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i data-lucide="user-plus" class="w-6 h-6 text-indigo-300"></i>
                    </div>
                    <input type="text" id="quick-add-search" placeholder="Ketik NPK atau Nama Admin..." 
                           class="block w-full pl-14 pr-6 py-4.5 bg-white/10 border-2 border-white/20 hover:border-white/40 focus:border-white rounded-2xl text-white placeholder:text-indigo-200 focus:ring-0 transition-all text-sm font-bold backdrop-blur-sm">
                </div>
                {{-- Suggestions Dropdown - Increased Z-Index and handled clipping --}}
                <div id="quick-add-suggestions" class="absolute z-[100] w-full bg-white dark:bg-gray-800 border-2 border-indigo-50 dark:border-gray-700 rounded-2xl shadow-2xl mt-4 hidden max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700/50 overflow-x-hidden"></div>
            </div>
        </div>
    </div>

    <form id="form-quick-add" action="{{ route('admin.users.quick-add') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="npk" id="input-quick-add-npk">
    </form>

    {{-- Filter Bar --}}
    <div class="mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Search Account</label>
                <div class="relative group">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Search by name, NPK, or email..."
                           class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                </div>
            </div>
            <div class="w-full md:w-64">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Filter Role</label>
                <select name="role" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="deputy" {{ request('role') === 'deputy' ? 'selected' : '' }}>Deputy</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">
                    Apply
                </button>
                @if(request()->anyFilled(['q', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">#</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">User Profile</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">NPK / Identification</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">Account Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($users as $index => $user)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all duration-200">
                            <td class="px-8 py-5 text-gray-400 font-bold tabular-nums">
                                {{ sprintf('%02d', $users->firstItem() + $index) }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-xs font-black text-indigo-600 border border-indigo-500/10 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 dark:text-white mb-0.5 truncate max-w-[200px]">{{ $user->name }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">{{ $user->department ?? 'No Department' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-700 dark:text-gray-300 tabular-nums tracking-wider">{{ $user->npk ?: '-' }}</span>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase">{{ $user->email ?: 'NO EMAIL RECORD' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $roleStyles = [
                                        'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400',
                                        'deputy' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 thick',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] {{ $roleStyles[$user->role] ?? 'bg-gray-100 text-gray-500 dark:bg-gray-700/50 dark:text-gray-400' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="w-9 h-9 bg-gray-50 dark:bg-gray-700 text-gray-500 hover:bg-indigo-600 hover:text-white rounded-xl flex items-center justify-center transition-all duration-300"
                                       title="Edit User">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="confirmAction(event, 'Arsipkan user {{ $user->name }}? Aksi ini bisa dipulihkan kembali oleh tim support.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 bg-gray-50 dark:bg-gray-700 text-gray-500 hover:bg-red-600 hover:text-white rounded-xl flex items-center justify-center transition-all duration-300"
                                                    title="Delete User">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700/50 rounded-[2rem] flex items-center justify-center text-gray-200 dark:text-gray-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                                        <i data-lucide="user-x" class="w-10 h-10"></i>
                                    </div>
                                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-1">Account not found</h3>
                                    <p class="text-xs text-gray-500 font-medium tracking-tight">Try refining your search or add a new account.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-50 dark:border-gray-700/30">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">
                    Showing results {{ $users->firstItem() }} to {{ $users->lastItem() }}
                </p>
                <div class="custom-pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>