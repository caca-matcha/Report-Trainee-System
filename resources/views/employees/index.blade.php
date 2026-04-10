<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Employees
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 border">No</th>
                                <th class="px-4 py-3 border">Nama</th>
                                <th class="px-4 py-3 border">Email</th>
                                <th class="px-4 py-3 border">Departemen</th>
                                <th class="px-4 py-3 border">Jabatan</th>
                                <th class="px-4 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $i => $emp)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $emp['name'] ?? $emp['full_name'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $emp['email'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $emp['department'] ?? $emp['dept_name'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $emp['position'] ?? $emp['job_title'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('employees.show', $emp['id'] ?? $emp['employee_id'] ?? 0) }}"
                                           class="text-blue-600 hover:underline text-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-400">Tidak ada data employee.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
