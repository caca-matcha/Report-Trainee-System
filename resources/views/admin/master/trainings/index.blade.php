<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-1">
                <h1 class="text-2xl font-black bg-gradient-to-r from-gray-900 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent tracking-tight">
                    Master Data Training
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Daftar template program pelatihan pusat yang siap untuk dieksekusi menjadi jadwal training.
                </p>
            </div>
            
            <div class="flex items-center gap-4 w-auto">

                {{-- Primary Action --}}
                <a href="{{ route('admin.master-trainings.create') }}"
                    class="inline-flex items-center gap-3 px-6 py-3.5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 active:scale-95 transition-all shrink-0">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Tambah Training
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($topTrainings as $index => $top)
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
            <div class="relative flex items-start justify-between">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-lg {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500' }} text-[10px] font-black">
                            #{{ $index + 1 }}
                        </span>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Most Frequent</p>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white line-clamp-1 text-sm">{{ $top->training_course }}</h3>
                    <div class="flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                        {{ $top->trainings_count }} Pelaksanaan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-6 overflow-x-auto scrollbar-hide">
        <div class="flex items-center gap-1 p-1 bg-gray-100 dark:bg-gray-800/50 rounded-2xl w-max">
            @php
                $categories = [
                    null => 'Semua',
                    'Mandatory' => 'Mandatory',
                    'Managerial' => 'Managerial',
                    'Technical' => 'Technical',
                    'Awareness' => 'Awareness',
                    'Certification' => 'Certification',
                    'Others' => 'Others'
                ];
                $activeCategory = request('category');
            @endphp

            @foreach($categories as $key => $label)
                <a href="{{ route('admin.master-trainings.index', array_merge(request()->query(), ['category' => $key, 'page' => 1])) }}"
                   class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-200 whitespace-nowrap
                          {{ $activeCategory == $key ? 'bg-white dark:bg-gray-700 text-indigo-600 dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="relative max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <form action="{{ route('admin.master-trainings.index') }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Cari training...">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase font-bold text-[10px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4">No. Training</th>
                        <th class="px-6 py-4">Nama Training</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4">Total Eksekusi</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                    @forelse($trainings as $training)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.master-trainings.show', $training) }}"
                                    class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $training->event_no }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $training->training_course }}</div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-tighter">{{ $training->training_topic }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'Mandatory' => 'bg-red-50 text-red-600 border-red-100',
                                        'Managerial' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'Technical' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Awareness' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                        'Certification' => 'bg-orange-50 text-orange-600 border-orange-100',
                                        'Others' => 'bg-gray-50 text-gray-600 border-gray-100'
                                    ];
                                    $color = $colors[$training->category] ?? 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                @endphp
                                <span class="px-2 py-1 {{ $color }} rounded text-[10px] font-black uppercase tracking-widest border">
                                    {{ $training->category ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-gray-600 dark:text-gray-400 font-bold border border-gray-200 dark:border-gray-700">{{ $training->provider_type }}</span>
                                <div class="mt-1 font-medium">{{ $training->provider }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-bold border border-indigo-100 dark:border-indigo-800/50">
                                    <i data-lucide="history" class="w-3.5 h-3.5 mr-1.5 opacity-70"></i>
                                    {{ $training->trainings_count }} Kali
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.master-trainings.execute', $training) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm transition-all active:scale-95">
                                        <i data-lucide="play-circle" class="w-3.5 h-3.5 mr-1.5"></i>
                                        Eksekusi
                                    </a>

                                    <div class="h-4 w-px bg-gray-200 dark:bg-gray-700"></div>

                                    <a href="{{ route('admin.master-trainings.edit', $training) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 transition-colors">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('admin.master-trainings.destroy', $training) }}" method="POST"
                                        onsubmit="confirmAction(event, 'Hapus data master training ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data training master.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trainings->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $trainings->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>