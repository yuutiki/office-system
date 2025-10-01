<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Belonging Infomation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Please contact your administrator if you need to change any of the information below.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-3">
        @csrf
        @method('put')

        @foreach ($user->getDepartmentHierarchy() as $index => $dept)
            <div>
                <x-input-label for="department_{{ $index }}" :value="__('所属') . ($index + 1)" />
                <x-text-input 
                    id="department_{{ $index }}" 
                    name="department_{{ $index }}" 
                    type="text" 
                    class="mt-1 block w-full" 
                    :value="$dept->name" 
                    disabled 
                />
            </div>
        @endforeach


        {{-- <div>
            <x-input-label for="affiliation3" :value="__('所属4')" />
            <x-text-input id="affiliation3" name="affiliation3" type="text" class="mt-1 block w-full" :value="old('affiliation3', $user->affiliation3->affiliation3_name)" disabled/>
        </div>
        <div>
            <x-input-label for="affiliation3" :value="__('所属5')" />
            <x-text-input id="affiliation3" name="affiliation3" type="text" class="mt-1 block w-full" :value="old('affiliation3', $user->affiliation3->affiliation3_name)" disabled/>
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
