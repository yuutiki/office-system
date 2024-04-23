<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        {{-- $passwordPolicy->min_length
        $passwordPolicy->max_length
        $passwordPolicy->require_uppercase
        $passwordPolicy->require_lowercase
        $passwordPolicy->require_numeric
        $passwordPolicy->require_symbol
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p> --}}
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __(':min 文字以上で、', ['min' => $passwordPolicy->min_length]) }}
            @if ($passwordPolicy->require_uppercase)
                {{ __('「英大文字」') }}
            @endif
            @if ($passwordPolicy->require_lowercase)
                {{ __('「英小文字」') }}
            @endif
            @if ($passwordPolicy->require_numeric)
                {{ __('「数字」') }}
            @endif
            @if ($passwordPolicy->require_symbol)
                {{ __('「記号」') }}
            @endif
            {{ __('をそれぞれ1つ以上含む必要があります。') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-1">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            {{-- <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" /> --}}
            @error('current_password')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                @error('password')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            {{-- <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" /> --}}
                @error('password_confirmation')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>