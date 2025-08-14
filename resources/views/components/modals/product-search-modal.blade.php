@props([
    'modalId',
    'screenId',
    'title' => '製品検索',
    'productSeries' => [],
    'productTypes' => [],
    'productSplitTypes' => [],
    'onSelectCallback' => '', // 選択時のコールバック関数名
])

<div id="{{ $modalId }}" tabindex="-1" class="fixed inset-0 flex items-center justify-center hidden animate-slide-in-top px-2 z-[99999]">
    <div class="max-h-full w-full max-w-7xl overflow-y-auto">
        <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
            <!-- モーダルヘッダー -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <div class="dark:text-white text-gray-900 font-medium ml-4 flex">
                    <div id="{{ $modalId }}_count"></div>
                    <span>件</span>
                </div>
                <button type="button" onclick="ProductSearchModal.hide('{{ $modalId }}')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <!-- 検索条件入力フォーム -->
            <div class="grid gap-x-2 mb-4 grid-cols-1 sm:grid-cols-3">
                <!-- 製品名称 -->
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_product_name" class="dark:text-gray-100 text-gray-900 leading-none mt-4">製品名称</label>
                    <input type="text" id="{{ $modalId }}_product_name" class="input-secondary">
                </div>
                
                <!-- 製品シリーズ -->
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_product_series_id" class="dark:text-gray-100 text-gray-900 leading-none mt-4">シリーズ</label>
                    <select id="{{ $modalId }}_product_series_id" name="{{ $modalId }}_product_series_id" class="input-secondary">
                        <option selected="" value="">未選択</option>
                        @foreach ($productSeries as $productSeries)
                            <option value="{{ $productSeries->id }}" @selected($productSeries->id == old('{{ $modalId }}_product_series_id'))>
                                {{ $productSeries->series_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 製品種別 -->
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_product_type_id" class="dark:text-gray-100 text-gray-900 leading-none mt-4">製品種別</label>
                    <select id="{{ $modalId }}_product_type_id" name="{{ $modalId }}_product_type_id" class="input-secondary">
                        <option selected="" value="">未選択</option>
                        @foreach ($productTypes as $productType)
                            <option value="{{ $productType->id }}" @selected($productType->id == old('{{ $modalId }}_product_type_id'))>
                                {{ $productType->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- 製品内訳種別 -->
                <div class="w-full flex flex-col pr-2">
                    <label for="{{ $modalId }}_product_split_type_id" class="dark:text-gray-100 text-gray-900 leading-none mt-4">製品内訳種別</label>
                    <select id="{{ $modalId }}_product_split_type_id" name="{{ $modalId }}_product_split_type_id" class="input-secondary">
                        <option selected="" value="">未選択</option>
                        @foreach ($productSplitTypes as $productSplitType)
                            <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('{{ $modalId }}_product_split_type_id'))>
                                {{ $productSplitType->split_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="button" 
                        onclick="ProductSearchModal.search('{{ $modalId }}', '{{ $screenId }}')" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    検索
                </button>
                <button type="button" 
                        onclick="ProductSearchModal.clearSearch('{{ $modalId }}')"
                        class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                    クリア
                </button>
            </div>

            <!-- 検索結果テーブル -->
            <div class="max-h-80 overflow-x-auto mt-4 rounded border dark:border-gray-600">
                <table class="w-full text-white text-left text-sm">
                    <thead class="sticky top-0 dark:bg-gray-600 border-l dark:border-gray-600 dark:text-white text-gray-900 bg-gray-200">
                        <tr id="{{ $modalId }}_headers">
                            <!-- ヘッダーはJSで動的に生成 -->
                        </tr>
                    </thead>
                    <tbody id="{{ $modalId }}_results">
                        <!-- 検索結果はJSで動的に生成 -->
                    </tbody>
                </table>
            </div>

            <!-- モーダルフッターを追加 -->
            <div class="flex justify-end items-center p-4 mt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" 
                        onclick="ProductSearchModal.hide('{{ $modalId }}')"
                        class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded border border-gray-400 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    閉じる
                </button>
            </div>
        </div>
    </div>
</div>