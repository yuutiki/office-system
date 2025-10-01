<button {{ $attributes->merge([
    'type' => 'button',
    'text' => __('階層確認'),
    'class' => 'flex items-center pl-2 sm:px-4 py-1.5 text-sm text-white rounded hover:bg-[#313a48] bg-[#364050] focus:ring-2 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800',
    ])}} >

    {{-- <svg class="w-5 h-5 text-white my-0.5 ml-1 sm:mr-1 mr-2 sm:ml-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
    </svg> --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white my-0.5 sm:mr-1 mr-2 sm:ml-0" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
        <path d="M610-130v-120H450v-400H350v120H90v-300h260v120h260v-120h260v300H610v-120H510v340h100v-120h260v300H610ZM150-770v180-180Zm520 400v180-180Zm0-400v180-180Zm0 180h140v-180H670v180Zm0 400h140v-180H670v180ZM150-590h140v-180H150v180Z"/>
    </svg>

    <span class="hidden sm:inline text-sm whitespace-nowrap">{{ $text }}</span>
</button>