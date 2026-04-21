<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 w-full">
            <div class="space-y-0.5">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1.5 px-2 py-0.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        System Online
                    </span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="text-xl lg:text-2xl font-black text-gray-900 dark:text-white tracking-tight leading-none mt-1">
                    Welcome Back, <span class="bg-gradient-to-r from-indigo-600 to-indigo-400 bg-clip-text text-transparent">{{ auth()->user()->name }}</span>!
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.master-trainings.index') }}" class="inline-flex items-center gap-2.5 px-6 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:shadow-[0_15px_30px_-5px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 active:scale-95 transition-all group">
                    <div class="flex items-center justify-center w-5 h-5 bg-white/20 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    Buat Training Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mb-12">
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-2xl font-medium leading-relaxed">
            Ringkasan performa sistem manajemen pelatihan hari ini. Anda memiliki <span class="text-indigo-600 dark:text-indigo-400 font-bold underline decoration-indigo-500/30 underline-offset-4">{{ $stats['ongoing'] }} sesi aktif</span> yang sedang berjalan di seluruh departemen.
        </p>
    </div>

    {{-- Stats Cards Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
        @php
            $cardConfigs = [
                [
                    'label' => 'Total Trainee', 
                    'value' => $stats['total_users'], 
                    'icon' => 'users', 
                    'color' => 'indigo', 
                    'sub' => 'Active System Members', 
                    'route' => 'admin.employees.index',
                    'gradient' => 'from-indigo-500/10 via-transparent to-transparent',
                    'active' => true
                ],
                [
                    'label' => 'Ongoing Now', 
                    'value' => $stats['ongoing'], 
                    'icon' => 'play-circle', 
                    'color' => 'blue', 
                    'sub' => 'Running Today', 
                    'route' => 'admin.trainings.index', 
                    'params' => ['status' => 'ongoing'],
                    'gradient' => 'from-blue-500/10 via-transparent to-transparent',
                    'active' => $stats['ongoing'] > 0
                ],
                [
                    'label' => 'Upcoming', 
                    'value' => $stats['upcoming'], 
                    'icon' => 'calendar', 
                    'color' => 'emerald', 
                    'sub' => 'Scheduled Sessions', 
                    'route' => 'admin.trainings.index', 
                    'params' => ['status' => 'upcoming'],
                    'gradient' => 'from-emerald-500/10 via-transparent to-transparent',
                    'active' => $stats['upcoming'] > 0
                ],
                [
                    'label' => 'Archive', 
                    'value' => $stats['archive'], 
                    'icon' => 'archive', 
                    'color' => 'slate', 
                    'sub' => 'Completed Tasks', 
                    'route' => 'admin.trainings.index', 
                    'params' => ['status' => 'archive'],
                    'gradient' => 'from-gray-500/10 via-transparent to-transparent',
                    'active' => false
                ]
            ];
        @endphp

        @foreach($cardConfigs as $card)
        <a href="{{ route($card['route'], $card['params'] ?? []) }}" 
           class="group relative bg-white/70 dark:bg-gray-800/60 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-sm border border-{{ $card['color'] }}-500/10 hover:border-{{ $card['color'] }}-500/50 hover:shadow-[0_20px_60px_rgba(0,0,0,0.1)] hover:-translate-y-1.5 transition-all duration-500 overflow-hidden">
            
            {{-- Decorative Accent Glow --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $card['gradient'] }} opacity-40 group-hover:opacity-100 transition-opacity duration-700 blur-2xl"></div>
            
            {{-- Subtle Background Mesh --}}
            <div class="absolute -left-12 -top-12 w-48 h-48 bg-{{ $card['color'] }}-500/[0.03] rounded-full blur-3xl group-hover:bg-{{ $card['color'] }}-500/[0.08] transition-all duration-1000"></div>

            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-center justify-between mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-{{ $card['color'] }}-500/20 blur-xl rounded-full"></div>
                        <div class="relative p-4 bg-{{ $card['color'] }}-500/10 dark:bg-{{ $card['color'] }}-500/20 rounded-2xl text-{{ $card['color'] }}-600 dark:text-white transition-all duration-500 group-hover:scale-110 group-hover:bg-{{ $card['color'] }}-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-{{ $card['color'] }}-500/40">
                            @if($card['icon'] === 'users')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            @elseif($card['icon'] === 'play-circle')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($card['icon'] === 'calendar')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @elseif($card['icon'] === 'archive')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            @endif
                        </div>
                    </div>
                    @if($card['active'])
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $card['color'] }}-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $card['color'] }}-500 shadow-[0_0_10px_rgba(var(--tw-color-{{ $card['color'] }}-500),0.5)]"></span>
                        </span>
                    @else
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 dark:bg-gray-700/50 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                            <i data-lucide="arrow-up-right" class="w-4 h-4 text-{{ $card['color'] }}-500"></i>
                        </div>
                    @endif
                </div>

                <div class="space-y-1 mt-auto">
                    <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">{{ $card['label'] }}</p>
                    <div class="flex flex-col">
                        <h3 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter mb-1 select-none">
                            {{ number_format($card['value']) }}
                        </h3>
                        <div class="flex items-center gap-2">
                             <div class="w-1.5 h-1.5 rounded-full bg-{{ $card['color'] }}-500 shadow-[0_0_8px_rgba(var(--tw-color-{{ $card['color'] }}-500),0.5)]"></div>
                             <span class="text-[9px] font-black text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400/80 uppercase tracking-widest">{{ $card['sub'] }}</span>
                        </div>
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
    <div class="bg-white/70 dark:bg-gray-800/60 backdrop-blur-2xl rounded-[3rem] shadow-2xl shadow-indigo-500/[0.03] border border-gray-100 dark:border-gray-700/50 overflow-hidden mb-12 transition-all duration-500 group/table">
        <div class="px-10 py-8 flex flex-col xl:flex-row xl:items-center justify-between gap-6 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-indigo-500 blur-xl opacity-10 group-hover/table:opacity-30 transition-opacity"></div>
                    <div class="relative w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-500/30 transform -rotate-3 group-hover/table:rotate-0 transition-all duration-700 ease-out">
                         <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                         </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight leading-none mb-2">Aktivitas Terkini</h2>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                        <p class="text-[10px] font-black text-indigo-500/60 dark:text-indigo-400/60 uppercase tracking-widest">Live System Feed</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.trainings.index') }}"
                class="group/btn inline-flex items-center justify-center px-8 py-3.5 bg-gray-900 dark:bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black dark:hover:bg-indigo-700 hover:shadow-2xl hover:shadow-indigo-500/40 active:scale-95 transition-all w-full xl:w-auto overflow-hidden relative">
                <span class="relative z-10 flex items-center gap-3">
                    Lihat Semua Rekaman
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover/btn:translate-x-1.5 transition-transform duration-300"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-50/50 dark:bg-gray-800/40">
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
                                    <span class="font-black text-gray-700 dark:text-gray-300 uppercase tracking-tighter leading-none">{{ \Carbon\Carbon::parse($training->start_date)->translatedFormat('d M Y') }}</span>
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
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group/btn shadow-sm">
                                    <span>Kelola Sesi</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
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