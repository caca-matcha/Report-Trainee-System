<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Participant') }} - {{ $training->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('trainings.participants.store', $training) }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Participant Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- NPK -->
                        <div class="mt-4">
                            <x-input-label for="npk" :value="__('NPK')" />
                            <x-text-input id="npk" class="block mt-1 w-full" type="text" name="npk" :value="old('npk')"
                                required />
                            <x-input-error :messages="$errors->get('npk')" class="mt-2" />
                        </div>

                        <!-- Department -->
                        <div class="mt-4">
                            <x-input-label for="department" :value="__('Department')" />
                            <x-text-input id="department" class="block mt-1 w-full" type="text" name="department"
                                :value="old('department')" required />
                            <x-input-error :messages="$errors->get('department')" class="mt-2" />
                        </div>

                        <!-- Pre Test Score -->
                        <div class="mt-4">
                            <x-input-label for="pre_test_score" :value="__('Pre Test Score (Optional)')" />
                            <x-text-input id="pre_test_score" class="block mt-1 w-full" type="number" step="0.01"
                                name="pre_test_score" :value="old('pre_test_score')" />
                            <x-input-error :messages="$errors->get('pre_test_score')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('trainings.show', $training) }}"
                                class="mr-4 text-gray-600 hover:text-gray-900">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Add Participant') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>