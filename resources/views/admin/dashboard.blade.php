<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent mb-1">
                    Dashboard Overview
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Statistik ringkasan aktivitas pelatihan dan performa sistem secara keseluruhan.</p>
            </div>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">
                Last updated: {{ now()->format('d M Y, H:i') }}
            </p>
        </div>
    </x-slot>

    <!-- Lucide Icons & Chart.js -->
    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        lucide.createIcons();
    </script>
    @endpush

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <a href="{{ route('admin.employees.index') }}" class="block relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group hover:shadow-xl hover:scale-[1.02] hover:border-indigo-500/50 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Users</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ number_format($stats['total_users']) }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/10 rounded-2xl text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400">
                <span>Active System Members</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 group-hover:-translate-y-1 transition-all"></i>
            </div>
        </a>



        <!-- Ongoing Training -->
        <a href="{{ route('admin.trainings.index', ['status' => 'ongoing']) }}" class="block relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group hover:shadow-xl hover:scale-[1.02] hover:border-blue-500/50 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Ongoing Now</p>
                    <h3 class="text-3xl font-black text-blue-600 dark:text-blue-500 leading-none">{{ number_format($stats['ongoing']) }}</h3>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-2xl text-blue-600 dark:text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="play-circle" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-blue-600">
                <span>Running Today</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 group-hover:-translate-y-1 transition-all"></i>
            </div>
        </a>

        <!-- Upcoming Training -->
        <a href="{{ route('admin.trainings.index', ['status' => 'upcoming']) }}" class="block relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group hover:shadow-xl hover:scale-[1.02] hover:border-emerald-500/50 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Upcoming</p>
                    <h3 class="text-3xl font-black text-emerald-600 dark:text-emerald-500 leading-none">{{ number_format($stats['upcoming']) }}</h3>
                </div>
                <div class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-600 dark:text-emerald-500 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-emerald-600">
                <span>Scheduled Sessions</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 group-hover:-translate-y-1 transition-all"></i>
            </div>
        </a>

        <!-- Archive -->
        <a href="{{ route('admin.trainings.index', ['status' => 'archive']) }}" class="block relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group hover:shadow-xl hover:scale-[1.02] hover:border-slate-500/50 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-500/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Archive</p>
                    <h3 class="text-3xl font-black text-slate-600 dark:text-slate-500 leading-none">{{ number_format($stats['archive']) }}</h3>
                </div>
                <div class="p-3 bg-slate-500/10 rounded-2xl text-slate-600 dark:text-slate-50 group-hover:bg-slate-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="archive" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-400">
                <span>Completed Tasks</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 group-hover:-translate-y-1 transition-all"></i>
            </div>
        </a>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Training Status Doughnut -->
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Status Distribution</h2>
                <i data-lucide="pie-chart" class="w-5 h-5 text-gray-400"></i>
            </div>
            <div class="relative h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Training Trend Bar Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Training Trends</h2>
                    <p class="text-xs text-gray-500 font-medium">Session enrollment over last 6 months</p>
                </div>
                <i data-lucide="trending-up" class="w-5 h-5 text-indigo-500"></i>
            </div>
            <div class="relative h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Trainings Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-50 dark:bg-gray-900 rounded-xl flex items-center justify-center text-gray-400">
                    <i data-lucide="list" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider leading-none">Recent Trainings</h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Lates activities updated in real-time</p>
                </div>
            </div>
            <a href="{{ route('admin.trainings.index') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-50 dark:bg-gray-700/50 text-xs font-black text-gray-600 dark:text-gray-300 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all duration-300">
                View All Records
                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">Training Information</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30">Scheduled Date</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30 text-center">Status</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700/30 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($recent_trainings as $training)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                             <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors duration-200 truncate block max-w-xs">{{ $training->title }}</span>
                                    <div class="flex items-center gap-2 mt-1 text-[10px] font-bold text-gray-400">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-500/50"></i>
                                        <span>{{ $training->user->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</span>
                                    <span class="text-[10px] text-gray-400 uppercase">Started</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
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
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('admin.trainings.show', $training) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="database" class="w-12 h-12 text-gray-200 mb-4"></i>
                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No Records Found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Ongoing', 'Upcoming', 'Archive'],
                    datasets: [{
                        data: [
                            {{ $stats['ongoing'] }}, 
                            {{ $stats['upcoming'] }}, 
                            {{ $stats['archive'] }}
                        ],
                        backgroundColor: ['#6366f1', '#10b981', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold' } } }
                    }
                }
            });

            // Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($trend_data['labels']) !!},
                    datasets: [{
                        label: 'Total Training',
                        data: {!! json_encode($trend_data['data']) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 12,
                        barThickness: 32
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { display: false }, ticks: { font: { weight: 'bold' } } },
                        x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>