<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            {{-- @if ($errors->has('email'))
                <div>{{ $errors->first('email') }}</div>
            @endif --}}
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <!-- パスワード表示・非表示ボタン -->
            <button type="button" id="togglePasswordButton" class="absolute inset-y-0 right-0 px-3 flex items-center">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path id="showIcon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    <path id="hideIcon" stroke="currentColor" stroke-width="2" class="hidden" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                    <path id="eye" stroke="currentColor" stroke-width="2" class="hidden" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>
        
        <x-input-error :messages="$errors->get('credentials')" class="mt-2" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        @if (session('session_expired'))
            <div class="alert alert-danger">
                <p>{{ session('session_expired') }}</p>
            </div>
        @endif


        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>



    <script>
        // パスワード表示・非表示を切り替える関数
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var showIcon = document.getElementById("showIcon");
            var hideIcon = document.getElementById("hideIcon");
            var eyeIcon = document.getElementById("eye");
            
            if (passwordInput.type === "password") {
                // パスワードを表示する
                passwordInput.type = "text";
                showIcon.classList.add("hidden");
                hideIcon.classList.remove("hidden");
                eyeIcon.classList.remove("hidden");
            } else {
                // パスワードを非表示にする
                passwordInput.type = "password";
                showIcon.classList.remove("hidden");
                hideIcon.classList.add("hidden");
                eyeIcon.classList.add("hidden");
            }
        }
        
        // ボタンがクリックされたときにパスワード表示・非表示を切り替えるイベントリスナーを追加
        document.getElementById("togglePasswordButton").addEventListener("click", togglePasswordVisibility);
    </script>
    
    
</x-guest-layout>
