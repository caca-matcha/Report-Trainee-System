<x-guest-layout>
    {{-- Welcome Header --}}
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-black text-indigo-600 dark:text-white uppercase tracking-tighter mb-1">
            Report Training
        </h1>
        <h2 class="text-xl font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">
            Welcome Back
        </h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- NPK -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">NPK Identification</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 group-focus-within:text-indigo-500">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input id="email" 
                       type="text" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       placeholder="Enter your NPK number"
                       class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 rounded-2xl text-sm font-semibold text-gray-900 dark:text-white placeholder-gray-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between ml-1">
                <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[9px] font-black text-indigo-500 hover:text-indigo-600 uppercase tracking-widest transition-colors">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 group-focus-within:text-indigo-500">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                       class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700/50 rounded-2xl text-sm font-semibold text-gray-900 dark:text-white placeholder-gray-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Actions -->
        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <div class="relative">
                    <input id="remember_me" type="checkbox" name="remember" class="sr-only peer">
                    <div class="w-4 h-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-300"></div>
                    <i data-lucide="check" class="absolute inset-0 w-3 h-3 m-auto text-white scale-0 peer-checked:scale-100 transition-transform duration-300"></i>
                </div>
                <span class="ms-2 text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <button type="submit" 
                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
            <span>{{ __('Authenticate Access') }}</span>
            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        </button>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    @endpush
</x-guest-layout>