<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Trainings') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Training List</h3>
                <a href="{{ route('trainings.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + New Training
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <thead>
                        <tr
                            class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Nama Training</th>
                            <th class="py-3 px-6 text-left">Start Date</th>
                            <th class="py-3 px-6 text-center">Type</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-gray-200 text-sm font-light">
                        @forelse($trainings as $index => $training)
                            <tr
                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 text-left font-bold">{{ $training->title }}</td>
                                <td class="py-3 px-6 text-left">
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-6 text-center">{{ $training->training_type }}</td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $now = \Carbon\Carbon::now()->startOfDay();
                                        $start = \Carbon\Carbon::parse($training->start_date)->startOfDay();
                                        $end = $training->end_date ? \Carbon\Carbon::parse($training->end_date)->startOfDay() : $start;
                                        $isOngoing = ($training->status === 'approved' && $now->betweenIncluded($start, $end));
                                        $statusLabel = $isOngoing ? 'Ongoing' : ucfirst(str_replace('_', ' ', $training->status));
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                                {{ $training->status == 'draft' && !$isOngoing ? 'bg-gray-200 text-gray-700' : '' }}
                                                {{ $training->status == 'pending_approval' && !$isOngoing ? 'bg-yellow-200 text-yellow-700' : '' }}
                                                {{ $training->status == 'approved' && !$isOngoing ? 'bg-green-200 text-green-700' : '' }}
                                                {{ $training->status == 'rejected' && !$isOngoing ? 'bg-red-200 text-red-700' : '' }}
                                                {{ $isOngoing ? 'bg-blue-200 text-blue-700' : '' }}
                                            ">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('trainings.show', $training) }}"
                                            class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if ($training->status == 'draft' || $training->status == 'rejected')
                                            <a href="{{ route('trainings.edit', $training) }}"
                                                class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-6 text-center">No trainings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>