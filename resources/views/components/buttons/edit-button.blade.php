@props([
    'route',
    'text' => '編集',
    'icon' => true,
    'visible' => true,
])

<button
    type="button"
    onclick="location.href='{{ $route }}'"
    class="button-edit-primary"
    @if(!$visible) disabled class="opacity-50 cursor-not-allowed" @endif
>
    <div class="flex items-center">
        @if($icon)
            <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
            </svg>
        @endif
        <span class="md:block hidden">{{ $text }}</span>
    </div>
</button>

{{-- <x-buttons.edit-button :route="route('corporations.edit', $corporation)" /> --}}
