<x-admin-layout>
    {{-- Stunning Hero Greeting Section --}}
    <div class="relative overflow-hidden mb-12">
        {{-- Background Mesh Decor --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-8 py-8 px-2">
            <div class="space-y-2">
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200 dark:border-indigo-500/20">
                        System Online
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                    Welcome Home, <span class="bg-gradient-to-r from-indigo-600 to-indigo-400 bg-clip-text text-transparent">{{ auth()->user()->name }}</span>!
                </h1>
                <p class="text-gray-500 dark:text-gray-400 max-w-xl font-medium leading-relaxed">
                    Ringkasan performa sistem pelatihan hari ini. Anda memiliki <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $stats['ongoing'] }} sesi aktif</span> yang sedang berjalan.
                </p>
                <div class="flex items-center gap-4 mt-6">
                    <a href="{{ route('admin.trainings.index') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 active:scale-95 transition-all">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        Mulai Eksekusi
                    </a>
                    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-gray-700 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 active:scale-95 transition-all">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        Kelola User
                    </a>
                </div>
            </div>

            {{-- Quick Insights Mini Widget --}}
            <div class="hidden lg:flex items-center gap-6 p-2">
                <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl p-6 rounded-[2rem] border border-white dark:border-white/5 shadow-2xl shadow-indigo-500/5 flex items-center gap-6">
                    <div class="text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total</p>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total_users'] + $stats['ongoing'] + $stats['upcoming']) }}</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase">Artifacts</p>
                    </div>
                    <div class="w-px h-12 bg-gray-100 dark:bg-gray-700"></div>
                    <div class="text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</p>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <p class="text-sm font-black text-emerald-600 uppercase">Optimal</p>
                        </div>
                        <p class="text-[9px] font-bold text-gray-400 uppercase">Performance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
        @php
            $cardConfigs = [
                ['label' => 'Total Trainee', 'value' => $stats['total_users'], 'icon' => 'users', 'color' => 'indigo', 'sub' => 'Active System Members', 'route' => 'admin.employees.index'],
                ['label' => 'Ongoing Now', 'value' => $stats['ongoing'], 'icon' => 'play-circle', 'color' => 'blue', 'sub' => 'Running Today', 'route' => 'admin.trainings.index', 'params' => ['status' => 'ongoing']],
                ['label' => 'Upcoming', 'value' => $stats['upcoming'], 'icon' => 'calendar', 'color' => 'emerald', 'sub' => 'Scheduled Sessions', 'route' => 'admin.trainings.index', 'params' => ['status' => 'upcoming']],
                ['label' => 'Archive', 'value' => $stats['archive'], 'icon' => 'archive', 'color' => 'slate', 'sub' => 'Completed Tasks', 'route' => 'admin.trainings.index', 'params' => ['status' => 'archive']]
            ];
        @endphp

        @foreach($cardConfigs as $card)
        <a href="{{ route($card['route'], $card['params'] ?? []) }}" class="group relative bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 hover:shadow-[0_20px_60px_rgba(0,0,0,0.05)] hover:scale-[1.02] hover:border-{{ $card['color'] }}-500/50 transition-all duration-500 overflow-hidden">
            {{-- Card Decor --}}
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-{{ $card['color'] }}-500/[0.03] rounded-full group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative z-10 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="p-4 bg-{{ $card['color'] }}-500/10 rounded-2xl text-{{ $card['color'] }}-600 transition-all duration-500 group-hover:bg-{{ $card['color'] }}-600 group-hover:text-white">
                        <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-gray-200 dark:text-gray-700 group-hover:text-{{ $card['color'] }}-500 transition-colors"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $card['label'] }}</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($card['value']) }}</h3>
                        <span class="text-[10px] font-bold text-{{ $card['color'] }}-600 uppercase">{{ $card['sub'] }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Training Status Doughnut -->
        <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700/50 relative group">
            <div class="flex items-center justify-between mb-8 px-2">
                <div>
                    <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Status Distribution</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <i data-lucide="pie-chart" class="w-5 h-5 text-gray-400"></i>
                </div>
            </div>
            <div class="relative h-72">
                {{-- Center Label --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Sesi</span>
                    <span class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ $stats['ongoing'] + $stats['upcoming'] + $stats['archive'] }}</span>
                </div>
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Training Trend Bar Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-[3rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700/50 relative overflow-hidden group">
             <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/[0.02] rounded-full blur-3xl"></div>
             
             <div class="flex items-start justify-between mb-10 px-2 relative z-10 focus:outline-none">
                <div>
                    <h2 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Metrik Pelaksanaan</h2>
                    <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-tight opacity-70">Tren Pelaksanaan Training 6 Bulan Terakhir</p>
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700 rounded-xl">
                    <i data-lucide="trending-up" class="w-5 h-5 text-indigo-500"></i>
                </div>
            </div>
            <div class="relative h-72 z-10">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Trainings Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-[3rem] shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden mb-12">
        <div class="px-10 py-8 border-b border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-gray-50 dark:bg-gray-900 rounded-[1.5rem] flex items-center justify-center text-gray-400 shadow-inner">
                    <i data-lucide="activity" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider leading-none">Aktivitas Terkini</h2>
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mt-2">Recently Updated Sessions</p>
                </div>
            </div>
            <a href="{{ route('admin.trainings.index') }}"
                class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 active:scale-95 transition-all w-max self-start sm:self-center">
                Lihat Semua Rekaman
                <i data-lucide="arrow-right" class="w-4 h-4 ml-3"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-50/50 dark:bg-gray-800/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Informasi Program Training</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Mulai</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status Sesi</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($recent_trainings as $training)
                        <tr class="group hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition-all duration-300">
                             <td class="px-10 py-7">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-xs border border-indigo-100 dark:border-indigo-800 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                                        {{ substr($training->title, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors duration-200 truncate block max-w-sm">{{ $training->title }}</span>
                                        <div class="flex items-center gap-2 mt-1.5 text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                            <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-500"></i>
                                            <span>DIINPUT OLEH: {{ $training->user->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-10 py-7">
                                <div class="flex flex-col">
                                    <span class="font-black text-gray-700 dark:text-gray-300 uppercase tracking-tighter leading-none">{{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</span>
                                    <div class="flex items-center gap-1.5 mt-1.5">
                                        <i data-lucide="clock" class="w-3 h-3 text-gray-400"></i>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Scheduled Kickoff</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-7">
                                @php
                                    $now = \Carbon\Carbon::now()->startOfDay();
                                    $start = \Carbon\Carbon::parse($training->start_date)->startOfDay();
                                    $end = $training->end_date ? \Carbon\Carbon::parse($training->end_date)->startOfDay() : $start;
                                    
                                    if ($now->betweenIncluded($start, $end)) {
                                        $label = 'Ongoing';
                                        $class = 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-500 border-blue-200 dark:border-blue-500/30';
                                    } elseif ($start->gt($now)) {
                                        $label = 'Upcoming';
                                        $class = 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/30';
                                    } else {
                                        $label = 'Archive';
                                        $class = 'bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400 border-gray-200 dark:border-gray-700/50';
                                    }
                                @endphp
                                <div class="flex justify-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-[0.1em] border shadow-sm {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-right">
                                <a href="{{ route('admin.trainings.show', $training) }}"
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 text-gray-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95 transition-all duration-300">
                                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-6">
                                        <i data-lucide="database" class="w-10 h-10 text-gray-200 dark:text-gray-700"></i>
                                    </div>
                                    <p class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">No Records Found</p>
                                    <p class="text-xs text-gray-400 mt-2">System is ready for new training entries</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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