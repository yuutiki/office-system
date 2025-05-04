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
        <div class="mx-auto md:w-5/6 my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    <!-- 報告種別 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            報告種別
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300">{{ optional($report->reportType)->report_type_name }}</div>
                        </td>
                    </tr>
                    
                    <!-- 報告タイトル -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            報告タイトル
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300">{{ $report->report_title }}</div>
                        </td>
                    </tr>
                    
                    <!-- 対応日付/形式 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            対応日付/形式
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300">{{ $report->contact_at }}/{{ optional($report->contactType)->contact_type_name }}</div>
                        </td>
                    </tr>
                    
                    <!-- 取引先 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            取引先
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="flex items-center">
                                <div class="text-sm font-medium md:dark:text-gray-300">{{ $report->client->client_num }}：{{ $report->client->client_name }}</div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 inline-block px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{ $report->client->tradeStatus->trade_status_name }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- 取引先担当者 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            取引先担当者
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300">{{ $report->client_representative }}</div>
                        </td>
                    </tr>
                    
                    <!-- 報告内容 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            報告内容
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300 whitespace-pre-wrap">{{ $report->report_content }}</div>
                        </td>
                    </tr>
                    
                    <!-- 特記事項 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            特記事項
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300 whitespace-pre-wrap">{{ $report->report_notice }}</div>
                        </td>
                    </tr>
                    
                    <!-- 報告者 -->
                    <tr class=" dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            報告者
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm font-medium md:dark:text-gray-300">{{ $report->reporter->user_name }} • {{ $report->updated_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>






    <div class="mx-2">
        <div class="mx-auto md:w-5/6 my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <div class="bg-blue-600 text-white px-4 py-2 font-medium">
                報告先ユーザー
            </div>
            <div class="bg-white px-2">
                <ul class="divide-y divide-gray-200">
                    @foreach($recipients as $recipient)
                        <li class="p-1 flex items-center justify-between">
                            <span class="text-gray-800">
                                {{ $recipient->user_name }}
                            </span>
                            @if($recipient->pivot->is_read)
                                <span class="px-2 py-0.5 my-1 text-xs rounded bg-green-500 text-white">
                                    確認済み ({{ $recipient->pivot->read_at }})
                                </span>
                            @else
                                @if($recipient->id === Auth::id())
                                    <form action="{{ route('reports.mark-as-read', $report->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2 py-0.5 my-1 text-xs rounded bg-blue-500 hover:bg-blue-600 text-white">
                                            確認する
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2 py-0.5 my-1 text-xs rounded bg-gray-500 text-white">
                                        未確認
                                    </span>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


    {{-- コメント参照 --}}
{{-- コメント参照 --}}
<div class="md:w-5/6 flex justify-center md:mx-auto mt-8">
    <div class="w-full mx-auto">
        <h3 class="mt-8 ml-2 text-lg font-semibold dark:text-white">コメント</h3>
        <hr class="my-2">

        @foreach ($report->comments as $comment)
        <div class="flex @if ($comment->user_id === Auth::id()) justify-end ml-8 @else justify-start mr-8 @endif mx-2 mt-4">
            <div class="relative group">
                <div class="py-1 text-xs dark:bg-gray-900 dark:text-white flex @if ($comment->user_id === Auth::id()) justify-end @endif">
                    <div class="mr-3">{{ $comment->user->user_name }}</div>
                    <div class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                
                <div class="bg-white shadow-md rounded-md overflow-hidden w-auto">
                    <!-- インライン編集用のセクション -->
                    <div id="comment-view-{{ $comment->id }}" class="px-2 py-1">
                        <p class="text-gray-800 whitespace-pre-wrap text-sm">{{ optional($comment)->content }}</p>
                    </div>
                    
                    @if ($comment->user_id === Auth::id())
                        <div id="comment-edit-{{ $comment->id }}" class="hidden px-3 py-2">
                            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="inline-edit-form">
                                @csrf
                                @method('PUT')
                                <textarea name="content" rows="5" class="w-full min-w-[300px] md:min-w-[500px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ $comment->content }}</textarea>
                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="button" onclick="cancelEdit('{{ $comment->id }}')" class="px-3 py-1.5 text-xs bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                        キャンセル
                                    </button>
                                    <button type="submit" class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                        更新
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                
                <!-- 自分のコメントの場合のみ表示するメニュー -->
                @if ($comment->user_id === Auth::id())
                    <div class="absolute hidden group-hover:flex -top-2 right-0 bg-white shadow-lg rounded-md px-1 py-0.5 z-10 transition-all duration-200 opacity-0 group-hover:opacity-100">
                        <!-- 編集ボタン -->
                        <button onclick="showEdit('{{ $comment->id }}')" class="flex items-center text-blue-600 hover:text-blue-800 px-2 py-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="whitespace-nowrap">編集</span>
                        </button>
                        
                        <!-- 削除ボタン -->
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-800 px-2 py-1 text-sm" onclick="return confirm('このコメントを削除してもよろしいですか？')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="whitespace-nowrap">削除</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    
    <!-- インライン編集用のJavaScript -->
    <script>
        function showEdit(commentId) {
            document.getElementById('comment-view-' + commentId).classList.add('hidden');
            document.getElementById('comment-edit-' + commentId).classList.remove('hidden');
        }
        
        function cancelEdit(commentId) {
            document.getElementById('comment-edit-' + commentId).classList.add('hidden');
            document.getElementById('comment-view-' + commentId).classList.remove('hidden');
        }
    </script>








    
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
