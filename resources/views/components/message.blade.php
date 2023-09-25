@if(session('success'))
    <div class="fixed top-16 left-0 flex items-center justify-center w-screen z-50 pointer-events-none">
        <div id="flash-message" class="flex items-center md:w-1/4 w-3/4 p-4 rounded-lg bg-green-200 text-green-600 dark:text-green-400 animate-slide-out-top" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ml-3 text-md font-medium whitespace-nowrap">
                {{session('success')}}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-16 left-0 flex items-center justify-center w-screen z-50 pointer-events-none">
        <div id="flash-message" class="flex items-center md:w-1/4 w-3/4 p-4 rounded-lg bg-red-200 text-red-600 dark:text-red-400 animate-slide-out-top" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ml-3 text-md font-medium whitespace-nowrap">
                {{session('error')}}
            </div>
        </div>
    </div>
@endif

{{-- <script>
    //フラッシュメッセージのキャンセルボタン
    $('#flash-message-cancel').on('click', () => {
        $('#flash-message').slideUp()
    });

    //フラッシュメッセージの自動消去
    window.setTimeout(() => {
        $('#flash-message').slideUp()
    }, 4000);
</script> --}}