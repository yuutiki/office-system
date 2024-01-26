<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Belonging department') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Please contact your administrator if you need to change any of the information below.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="company" :value="__('所属1')" />
            <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $user->company->company_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('company')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="department" :value="__('所属2')" />
            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department', $user->department->department_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('department')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="division" :value="__('所属3')" />
            <x-text-input id="division" name="division" type="text" class="mt-1 block w-full" :value="old('division', $user->affiliation3->affiliation3_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('division')" class="mt-2" /> --}}
        </div>

        {{-- <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div> --}}

        {{-- <div class="flex items-center gap-4">
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
        </div> --}}
    </form>
</section>
