<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Belonging Infomation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Please contact your administrator if you need to change any of the information below.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="affiliation1" :value="__('所属1')" />
            <x-text-input id="affiliation1" name="affiliation1" type="text" class="mt-1 block w-full" :value="old('affiliation1', $user->affiliation1->affiliation1_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('affiliation1')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="department" :value="__('所属2')" />
            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department', $user->department->department_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('department')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="affiliation3" :value="__('所属3')" />
            <x-text-input id="affiliation3" name="affiliation3" type="text" class="mt-1 block w-full" :value="old('affiliation3', $user->affiliation3->affiliation3_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('affiliation3')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="affiliation3" :value="__('所属4')" />
            <x-text-input id="affiliation3" name="affiliation3" type="text" class="mt-1 block w-full" :value="old('affiliation3', $user->affiliation3->affiliation3_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('affiliation3')" class="mt-2" /> --}}
        </div>
        <div>
            <x-input-label for="affiliation3" :value="__('所属5')" />
            <x-text-input id="affiliation3" name="affiliation3" type="text" class="mt-1 block w-full" :value="old('affiliation3', $user->affiliation3->affiliation3_name)" disabled/>
            {{-- <x-input-error :messages="$errors->updatePassword->get('affiliation3')" class="mt-2" /> --}}
        </div>


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
