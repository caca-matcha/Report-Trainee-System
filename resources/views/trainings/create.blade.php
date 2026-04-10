<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Training') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="POST" action="{{ route('trainings.store') }}">
                @csrf

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Training Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                        :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Organizer -->
                <div class="mt-4">
                    <x-input-label for="organizer" :value="__('Organizer (Penyelenggara)')" />
                    <x-text-input id="organizer" class="block mt-1 w-full" type="text" name="organizer"
                        :value="old('organizer')" placeholder="Contoh: Dharma Learning Center" />
                    <x-input-error :messages="$errors->get('organizer')" class="mt-2" />
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date"
                            :value="old('start_date')" required />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('End Date (Optional)')" />
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date"
                            :value="old('end_date')" />
                        <p class="text-[10px] text-gray-500 mt-1 italic">*Kosongkan jika hanya 1 hari.</p>
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>

                <!-- Training Type -->
                <div class="mt-4">
                    <x-input-label for="training_type" :value="__('Training Type')" />
                    <select id="training_type" name="training_type"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="In House Training">In House Training</option>
                        <option value="Public Training">Public Training</option>
                    </select>
                    <x-input-error :messages="$errors->get('training_type')" class="mt-2" />
                </div>

                <!-- Passing Grade -->
                <div class="mt-4">
                    <x-input-label for="passing_grade" :value="__('Passing Grade (0-100)')" />
                    <x-text-input id="passing_grade" class="block mt-1 w-full" type="number"
                        name="passing_grade" :value="old('passing_grade', 70)" min="0" max="100" required />
                    <p class="text-xs text-gray-500 mt-1">Nilai minimal POST test untuk dinyatakan Lulus.</p>
                    <x-input-error :messages="$errors->get('passing_grade')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Create Training') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>