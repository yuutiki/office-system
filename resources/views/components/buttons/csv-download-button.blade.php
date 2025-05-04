@props([
    'route',
    'gate' => 'download_masters',
    'text' => 'CSVダウンロード',
])

@php
    use Illuminate\Support\Facades\Gate;

    $canDownload = Gate::allows($gate);

    $buttonClasses = 'relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white';
    if (!$canDownload) {
        $buttonClasses .= ' cursor-not-allowed';
    }
@endphp

<button
    type="button"
    {{ $canDownload ? "onclick=location.href='" . $route . "'" : 'disabled' }}
    class="{{ $buttonClasses }}"
>
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        @if($canDownload)
            {{-- ダウンロード可能：下矢印＋トレイ --}}
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
            </svg>
        @else
            {{-- ダウンロード不可：ロックアイコン --}}
            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
            </svg>
        @endif
    </div>
    <div>{{ $text }}</div>
</button>

{{-- <x-buttons.csv-download-button :route="route('support-types.export')" gate="download_masters" /> --}}
