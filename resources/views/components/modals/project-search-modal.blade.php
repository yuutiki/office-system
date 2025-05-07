@props([
    'modalId',      // モーダルの一意の識別子
    'screenId',     // 画面の識別子
    'title' => 'プロジェクト検索',  // モーダルのタイトル（デフォルト値あり）
    'users' => [],  // 担当者一覧
    'onSelectCallback' => '', // 選択時のコールバック関数名
])

{{-- モーダル全体のコンテナ --}}
<div id="{{ $modalId }}" tabindex="-1" class="fixed inset-0 flex items-center justify-center hidden animate-slide-in-top px-2 z-[99999]">
    <div class="max-h-full w-full max-w-7xl overflow-y-auto">
        <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
            {{-- モーダルヘッダー：タイトルと検索結果件数、閉じるボタンを含む --}}
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <div class="dark:text-white text-gray-900 font-medium ml-4 flex">
                    <div id="{{ $modalId }}_count"></div>
                    <span>件</span>
                </div>
                <button type="button" 
                        onclick="ProjectSearchModal.hide('{{ $modalId }}')" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        aria-label="モーダルを閉じる">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            {{-- 検索条件入力フォーム：レスポンシブグリッドレイアウトを使用 --}}
            <div class="grid gap-x-2 mb-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                {{-- プロジェクト名称入力フィールド --}}
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_project_name" class="dark:text-gray-100 text-gray-900 leading-none mt-4">
                        プロジェクト名
                    </label>
                    <input type="text" 
                           id="{{ $modalId }}_project_name" 
                           class="input-secondary"
                           aria-label="プロジェクト名で検索">
                </div>
                
                {{-- プロジェクト№入力フィールド --}}
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_project_num" class="dark:text-gray-100 text-gray-900 leading-none mt-4">
                        プロジェクト№
                    </label>
                    <input type="text" id="{{ $modalId }}_project_num" class="input-secondary" aria-label="プロジェクト№で検索">
                </div>

                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_client_name" class="dark:text-gray-100 text-gray-900 leading-none mt-4">
                        顧客名
                    </label>
                    <input type="text" id="{{ $modalId }}_client_name" class="input-secondary" aria-label="顧客名で検索">
                </div>
                
                {{-- ステータス選択ドロップダウン --}}
                {{-- <div class="w-full flex flex-col pr-2">
                    <input type="hidden" id="{{ $modalId }}_status" name="selected_status" value="">
                    <label for="{{ $modalId }}_status_dropdown_toggle" class="dark:text-gray-100 text-gray-900 leading-none mt-4">
                        ステータス
                    </label>
                    <div class="relative w-full mt-1">
                        <button type="button" 
                                id="{{ $modalId }}_status_dropdown_toggle" 
                                class="w-full px-4 py-1 text-left bg-white border border-gray-700 dark:border-gray-700 rounded shadow-sm dark:focus:ring-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400"
                                aria-haspopup="listbox"
                                aria-expanded="false">
                            <span id="{{ $modalId }}_selected_status_display">
                                ステータスを選択
                            </span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div id="{{ $modalId }}_status_dropdown_menu" 
                             class="absolute z-10 w-full mt-1 bg-white border border-gray-300 dark:border-gray-600 rounded-md shadow-lg hidden"
                             role="listbox">
                            <ul id="{{ $modalId }}_status_list" class="max-h-60 overflow-auto py-1">
                            </ul>
                        </div>
                    </div>
                </div> --}}

                {{-- 担当者選択ドロップダウン --}}
                <div class="w-full flex flex-col pr-2">
                    <input type="hidden" id="{{ $modalId }}_user_id" name="selected_user_id" value="">
                    <label for="{{ $modalId }}_dropdown_toggle" class="dark:text-gray-100 text-gray-900 leading-none mt-4">
                        営業担当
                    </label>
                    <div class="relative w-full mt-1">
                        <button type="button" 
                                id="{{ $modalId }}_dropdown_toggle" 
                                class="w-full px-4 py-1 text-left bg-white border border-gray-700 dark:border-gray-700 rounded shadow-sm dark:focus:ring-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400"
                                aria-haspopup="listbox"
                                aria-expanded="false">
                            <span id="{{ $modalId }}_selected_user_display">
                                営業担当を選択
                            </span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div id="{{ $modalId }}_user_dropdown_menu" 
                             class="absolute z-10 w-full mt-1 bg-white border border-gray-300 dark:border-gray-600 rounded-md shadow-lg hidden"
                             role="listbox">
                            <div class="p-2">
                                <input type="text" 
                                       id="{{ $modalId }}_user_search" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md"
                                       placeholder="営業担当を検索..."
                                       aria-label="営業担当を検索">
                            </div>
                            <ul id="{{ $modalId }}_user_list" class="max-h-60 overflow-auto py-1">
                                {{-- ユーザーリストはJavaScriptで動的に生成 --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 検索ボタンエリア --}}
            <div class="flex gap-2">
                <button type="button" 
                        onclick="ProjectSearchModal.search('{{ $modalId }}', '{{ $screenId }}')" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    検索
                </button>
                <button type="button" 
                        onclick="ProjectSearchModal.clearSearch('{{ $modalId }}')"
                        class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                    クリア
                </button>
            </div>

            {{-- 検索結果テーブル：スクロール可能な固定ヘッダー付きテーブル --}}
            <div class="max-h-80 overflow-x-auto mt-4 rounded border dark:border-gray-600">
                <table class="w-full text-white text-left text-sm">
                    <thead class="sticky top-0 dark:bg-gray-600 dark:border-gray-600 dark:text-white text-gray-900 bg-gray-200">
                        <tr id="{{ $modalId }}_headers">
                            {{-- ヘッダーはJavaScriptで動的に生成 --}}
                        </tr>
                    </thead>
                    <tbody id="{{ $modalId }}_results" class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- 検索結果はJavaScriptで動的に生成 --}}
                    </tbody>
                </table>
            </div>

            {{-- モーダルフッター --}}
            <div class="flex justify-end items-center p-4 mt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" 
                        onclick="ProjectSearchModal.hide('{{ $modalId }}')"
                        class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded border border-gray-400 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    閉じる
                </button>
            </div>
        </div>
    </div>
</div>