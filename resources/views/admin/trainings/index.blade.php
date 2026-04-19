<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent mb-1">
                    Oversight Training
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Monitoring pelaksanaan training, kehadiran, dan evaluasi hasil belajar secara real-time.</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">
                <i data-lucide="shield-check" class="w-4 h-4 text-indigo-500"></i>
                Admin Management
            </div>
        </div>
    </x-slot>

    <!-- Lucide Icons -->
    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    @endpush

    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Sessions -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600">
                <i data-lucide="library" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Active</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ number_format($stats['ongoing'] + $stats['upcoming']) }}</h3>
            </div>
        </div>

        <!-- Ongoing Sessions -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-600">
                <i data-lucide="play-circle" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Ongoing Now</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['ongoing'] }}</h3>
            </div>
        </div>

        <!-- Upcoming Sessions -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600">
                <i data-lucide="calendar" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Upcoming</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['upcoming'] }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="mb-6">
        <form action="{{ route('admin.trainings.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700/50">
            <div class="flex-[3] w-full">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Search Training</label>
                <div class="relative group">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by title, topic..."
                           class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                </div>
            </div>
            <div class="w-full md:w-44">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Filter Status</label>
                <select name="status" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                    <option value="all">All Records</option>
                    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="archive" {{ request('status') === 'archive' ? 'selected' : '' }}>Archive</option>
                </select>
            </div>
            <div class="w-full md:w-40">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Periode Bulan</label>
                <select name="month" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-32">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Tahun</label>
                <select name="year" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-semibold dark:text-white">
                    <option value="">Semua</option>
                    @php $startYear = 2024; $endYear = date('Y') + 1; @endphp
                    @for($y = $endYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 active:scale-95 transition-all">
                    Apply
                </button>
                @if(request()->anyFilled(['search', 'status', 'month', 'year']))
                    <a href="{{ route('admin.trainings.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
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
                    <tr class="text-left bg-gray-50/50 dark:bg-gray-700/50">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30">#</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30">Training Information</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30 text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30">Type</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30">Participants</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700/30 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($trainings as $index => $training)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all duration-200">
                            <td class="px-6 py-4 text-gray-400 font-bold tabular-nums">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.trainings.show', $training) }}" class="flex flex-col group/title">
                                    <span class="font-bold text-gray-900 dark:text-white group-hover/title:text-indigo-600 transition-colors duration-200 mb-1 max-w-[200px] truncate block">
                                        {{ $training->title }}
                                    </span>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400">
                                            <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-500/50"></i>
                                            <span class="truncate">{{ $training->user->name ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-400/50"></i>
                                            {{ \Carbon\Carbon::parse($training->start_date)->translatedFormat('d M Y') }}
                                            @if(\Carbon\Carbon::parse($training->start_date)->isToday())
                                                <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-500/20 font-black tracking-wider">
                                                    <span class="relative flex h-1.5 w-1.5">
                                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                                    </span>
                                                    HARI INI
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $now = \Carbon\Carbon::now()->startOfDay();
                                    $start = \Carbon\Carbon::parse($training->start_date)->startOfDay();
                                    $end = $training->end_date ? \Carbon\Carbon::parse($training->end_date)->startOfDay() : $start;
                                    
                                    if ($now->betweenIncluded($start, $end)) {
                                        $label = 'Ongoing';
                                        $class = 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-500';
                                    } elseif ($start->gt($now)) {
                                        $label = 'Upcoming';
                                        $class = 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400';
                                    } else {
                                        $label = 'Archive';
                                        $class = 'bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400';
                                    }
                                @endphp
                                <div class="flex justify-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                    {{ $training->training_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 font-black text-gray-900 dark:text-white">
                                    <i data-lucide="users" class="w-4 h-4 text-gray-400"></i>
                                    {{ $training->participants->count() }}
                                    <span class="text-[9px] text-gray-400 uppercase font-bold">Pax</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <form action="{{ route('admin.trainings.destroy', $training) }}" method="POST"
                                        onsubmit="confirmAction(event, 'Data training ini akan dihapus secara permanen. Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 bg-gray-50 dark:bg-gray-700/50 text-gray-400 hover:bg-red-500 hover:text-white rounded-xl flex items-center justify-center transition-all duration-300"
                                                title="Delete Record">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700/50 rounded-[2rem] flex items-center justify-center text-gray-200 dark:text-gray-600 mb-6 group-hover:scale-110 transition-transform duration-500">
                                        <i data-lucide="search" class="w-10 h-10"></i>
                                    </div>
                                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-1">No Trainings Found</h3>
                                    <p class="text-xs text-gray-500 font-medium">Try adjusting your filters or check back later.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($trainings->hasPages())
            <div class="p-6 border-t border-gray-100 dark:border-gray-700/50 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $trainings->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>