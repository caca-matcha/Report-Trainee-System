<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Employee
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    @foreach ($employee as $key => $value)
                        @if (!is_array($value))
                            <div class="flex border-b pb-2">
                                <span class="w-1/3 font-medium text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                <span class="w-2/3 text-gray-800">{{ $value ?? '-' }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
