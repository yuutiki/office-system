<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('showReport', $report) }}
            </h2>
            <x-message :message="session('message')" />
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />
                <x-button-save  onclick="location.href='{{route('reports.edit', $report)}}'">
                    {{ __('編集') }}
                </x-button-save>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto px-3 pb-4 md:w-5/6">
        <div class="rounded border-gray-500 border mb-4 overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <tbody class="">
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            報告種別
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class="flex items-center mr-12 ">
                                    <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ optional($report->reportType)->report_type_name }}</div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            報告タイトル
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $report->report_title }}</div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            対応日付/形式
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $report->contact_at }}/{{ optional($report->contactType)->contact_type_name }}</div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            取引先
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="sm:flex px-2 py-1.5 items-center">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $report->client->client_num }}：{{ $report->client->client_name }}</div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium sm:mx-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{ $report->client->tradeStatus->trade_status_name }}
                                </span>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            取引先担当者
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="sm:flex px-2 py-1.5 items-center">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $report->client_representative }}</div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            報告内容
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-pre-wrap">{{ $report->report_content }}</div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            特記事項
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-pre-wrap">{{ $report->report_notice }}</div>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pl-4 pr-2 border-r dark:border-gray-700 dark:bg-gray-800 whitespace-nowrap">
                            報告者
                        </th>
                        <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                            <div class="flex px-2 py-1.5">
                                <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-pre-wrap">{{ $report->reporter->user_name }} • {{ $report->updated_at->diffForHumans() }}</div>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @foreach($recipients as $recipient)
        <p class="text-gray-600 dark:text-white">{{ $recipient->user_name }}</p>
    @endforeach


    {{-- コメント参照 --}}
    <div class="md:w-5/6 flex justify-center md:mx-auto mt-8">
        <div class="w-full mx-auto">
            <h3 class="mt-8 ml-2 text-lg font-semibold dark:text-white">コメント</h3>
            <hr class="my-2">
    
            @foreach ($report->comments as $comment)
                <div class="flex @if ($comment->user_id === Auth::id()) justify-end @else justify-start @endif mt-4">
                    <div class="bg-white shadow-md rounded-md overflow-hidden w-auto">
                        <div class="px-4 py-1 bg-gray-300 flex @if ($comment->user_id === Auth::id()) justify-end @endif">
                            <strong class="text-blue-700 mr-3">{{ $comment->user->user_name }}</strong>
                            <div>{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
    
            {{-- <div class="bg-white shadow-md rounded-md overflow-hidden mt-4"> --}}
                {{-- コメント入力 --}}
                <div class="py-3 mt-8">
                    <form method="POST" action="{{ route('comment.store', $report->id) }}">
                        @csrf
                        
                        <label for="chat" class="sr-only">Your message</label>
                        <div class="items-center px-3 py-2 rounded-md bg-gray-50 dark:bg-gray-700">
                            {{-- <button type="button" class="inline-flex justify-center p-2 text-gray-500 rounded-md cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path fill="currentColor" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                </svg>
                                <span class="sr-only">Upload image</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded-md cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z"/>
                                </svg>
                                <span class="sr-only">Add emoji</span>
                            </button> --}}
                            <textarea id="auto-resize-textarea-chat" rows="2" name="content" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="コメント..."></textarea>
                            @error('content')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="flex justify-end">
                                <button type="submit" class="p-1.5 text-blue-600 rounded-md cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                        <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                                    </svg>
                                    <span class="sr-only">Send message</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            {{-- </div> --}}
        </div>
    </div>

    <script>
        const textareaChat = document.getElementById('auto-resize-textarea-chat');
        textareaChat.addEventListener('input', function() {
            // テキストエリアの高さを自動調整
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight + 2) + 'px';
        });
    </script>


<script>
// ページが読み込まれた後に一度だけ画面をリロードする関数
function reloadPage() {
    // ページをリロードする
    window.location.reload();
    console.log('再読み込み');
}

// ページが読み込まれた後に実行される処理
window.onload = function() {
    // ページが読み込まれた後にリロードを実行するために、setTimeoutを使用する
    setTimeout(reloadPage, 0);
};
</script>
    
</x-app-layout>
