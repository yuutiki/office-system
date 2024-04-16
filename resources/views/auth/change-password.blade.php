<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="ml-4 text-xl text-gray-900 dark:text-white">
                パスワードの変更
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40"></div>



    <div class="flex flex-col justify-center items-center my-16 sm:pt-0 bg-gray-600 dark:bg-gray-900">
        {{-- <div class="font-medium mb-12">
            パスワードの変更
        </div> --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg z-[9999]">
            
            <form method="POST" action="{{ route('password.force.update') }}">
                @csrf
        
                <div class="mt-4">
                    <x-input-label for="current_password" :value="__('現在のパスワード')" />
                    <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required autocomplete="current_password" />
                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                </div>
        
        
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('新しいパスワード')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password"  name="password" required autocomplete="password" />
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('新しいパスワードの確認')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="password_confirmation" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
