<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createEstimate', $project) }}
            </h2>
            <div class="flex justify-end">

                <form id="estimateForm" method="post" action="{{route('estimate.store',['project' => $project])}}" enctype="multipart/form-data" autocomplete="new-password">
                    @csrf
                    <x-primary-button class="ml-2" form="estimateForm">
                        登録
                    </x-primary-button>
                </form>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-auto md:pl-16 pr-3 pl-3 pb-4">
            {{-- <form id="estimateForm" method="post" action="{{route('estimate.store',['project' => $project])}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf --}}

        <div class="grid gap-3 lg:grid-cols-3 grid-cols-1 mt-2">
            <div>
                <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                <input type="text" name="corporation_name" class="input-readonly" value="{{ old('corporation_name', $project->client->corporation->corporation_name) }}" readonly>
            </div>
            <div>
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">顧客名称</label>
                <input type="text" name="client_name" class="input-readonly" value="{{ old('client_name', $project->client->client_name) }}" readonly>
            </div>
            <div>
                <label for="project_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">プロジェクト名称</label>
                <input type="text" name="project_name" class="input-readonly" value="{{ old('project_name', $project->project_name) }}" readonly>
            </div>
        </div>

        <div class="grid gap-y-1 lg:gap-x-3 lg:grid-cols-3 grid-cols-1 mt-6">
            <div class="">
                <label for="estimate_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">見積番号</label>
                <input type="text" form="estimateForm" name="estimate_num" class="input-readonly cursor-not-allowed" id="estimate_num" value="{{old('estimate_num')}}" placeholder="登録時に自動採番されます" readonly>
                @error('estimate_num')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-2">
                <label for="estimate_recipient" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">宛名</label>
                <input type="text" form="estimateForm" name="estimate_recipient" class="input-secondary" id="estimate_recipient" value="白梅学園大学" placeholder="">
                @error('estimate_recipient')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-span-3">
            <label for="estimate_title" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">件名</label>
            <input type="text" form="estimateForm" name="estimate_title" class="input-secondary" id="estimate_title" value="{{ old('estimate_title') }}" placeholder="">
            @error('estimate_title')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid gap-2 lg:grid-cols-5 grid-cols-2 text-sm mt-2">
            <div class="">
                <label for="delivery_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">受渡期日</label>
                <input type="text" form="estimateForm" name="delivery_at" class="input-primary" id="delivery_at" value="御相談" placeholder="">
                @error('delivery_at')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="">
                <label for="delivery_place" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">受渡場所</label>
                <input type="text" form="estimateForm" name="delivery_place" class="input-primary" id="delivery_place" value="御指定場所" placeholder="">
                @error('delivery_place')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="">
                <label for="transaction_method" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">取引方法</label>
                <input type="text" form="estimateForm" name="transaction_method" class="input-primary" id="transaction_method" value="月末締翌月末迄現金" placeholder="">
                @error('transaction_method')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="">
                <label for="expiration_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">有効期限</label>
                <input type="text" form="estimateForm" name="expiration_at" class="input-primary" id="expiration_at" value="3ヶ月" placeholder="">
                @error('expiration_at')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="">
                <label for="estimate_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">見積作成日</label>
                <input type="date" form="estimateForm" name="estimate_at" class="input-primary" id="estimate_at" value="2024-01-04" placeholder="">
                @error('estimate_at')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="body-tab" data-tabs-target="#body" type="button" role="tab" aria-controls="body" aria-selected="false">見積書明細</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-print-property-tab" data-tabs-target="#estimate-print-property" type="button" role="tab" aria-controls="estimate-print-property" aria-selected="false">見積書設定</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-separate-sheet-tab" data-tabs-target="#estimate-separate-sheet" type="button" role="tab" aria-controls="estimate-separate-sheet" aria-selected="false">見積書別紙</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">注文書設定</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-attachment-tab" data-tabs-target="#estimate-attachment" type="button" role="tab" aria-controls="estimate-attachment" aria-selected="false">添付ファイル</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">決裁情報</button>
                </li>
            </ul>
        </div>

        <div id="myTabContent">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="body" role="tabpanel" aria-labelledby="body-tab">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

            <label>
                <a onclick="add()" class="rounded bg-blue-500 py-2 px-1 cursor-pointer text-white">明細追加</a>
            </label>
            <label>
                <a onclick="add()" class="rounded bg-blue-500 py-2 px-1 cursor-pointer text-white">CSV出力</a>
            </label>

            <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr>
                            <th scope="col" class="px-1 py-2 whitespace-nowrap border-x border-gray-600 text-center w-[40px]">複製</th>
                            <th scope="col" class="px-1 py-2 whitespace-nowrap border-x border-gray-600 w-[40px]"></th>
                            <th scope="col" class="px-1 py-2 whitespace-nowrap border-x border-gray-600 text-center w-[40px]">No.</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 hidden">並び順</th>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600 w-[140px]">商品CD*</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">品名</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">型番</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">標準単価</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">原価/個*</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[48px]">数量</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">標準価格</th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">提供価格</th>
                            <th scope="col" class="px-2 py-0.5 whitespace-nowrap border-x border-gray-600 text-xs w-[100px]">粗利額*<br>粗利率*</th>
                            <th scope="col" class="px-1 py-2 whitespace-nowrap border-x border-gray-600 text-center w-[40px]">削除</th>
                        </tr>
                    </thead>

                    <tbody id="input_plural">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-1 border border-gray-600 text-center">
                                <button type="button" class="copy-row p-1 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="copyRow(this)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </td>

                            <td class="px-1 border border-gray-600 text-center drag-handle">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white cursor-move mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3"/>
                                </svg>
                            </td>
                            
                            <td class="px-0.5 border border-gray-600 text-center">
                                1
                            </td>
                            
                            <td class="px-1 border border-gray-600 hidden">
                                <input type="hidden" form="estimateForm" name="sort-order-1" value="1">
                            </td>
                            
                            <td class="px-1 border border-gray-600 align-bottom pb-1">
                                <div class="flex w-full">
                                    <input type="text" form="estimateForm" value="{{ old('ing-cd-1') }}" class="input-estimate w-[110px] text-xs" name="ing-cd-1">
                                    <button type="button" id="invoiceApi" onclick="showProductModal(this)" class="p-1 ml-0.5 px-1.5 text-sm h-7 mt-1 font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="px-1 border border-gray-600 align-bottom pb-1"><div class="flex flex-col justify-end h-full"><input type="text" form="estimateForm" class="input-estimate min-w-[270px] w-full text-xs" name="ing-name-1"></div></td>
                            <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate text-xs min-w-[100px] w-full" name="ing-kataban-1"></td>
                            <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs text-right" name="ing-tanka-1" onchange="formatNumber(this); calculateAll(this)"></td>
                            <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs text-right" name="ing-genka-1" onchange="formatNumber(this); calculateAll(this)"></td>
                            <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="number" form="estimateForm" class="input-estimate min-w-[48px] w-full text-xs text-right" name="ing-suryo-1" min="0" max="999" oninput="javascript: this.value = this.value.slice(0, 3);" onchange="calculateAll(this)"></td>
                            <td class="px-1 border border-gray-600 readonly-cell hidden"><input type="text" form="estimateForm" class="input-estimate  min-w-[100px] text-xs readonly-cell pointer-events-none text-right" name="ing-hyojungenka-1" readonly tabindex="-1"></td>

                            <!-- 標準価格・値引額 -->
                            <td class="px-1 border border-gray-600 align-bottom pb-1 readonly-cell">
                                <div class="flex flex-col">
                                    <span class="input-estimate-arari min-w-[100px] w-full text-xs readonly-cell text-right py-0.5 block" data-name="ing-hyojun-1"></span>
                                    <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs dark:text-red-500 text-right py-0.5" name="ing-nebiki-1" onchange="formatNebiki(this); calculateAll(this)" placeholder="値引額">
                                </div>
                            </td>
                            
                            <!-- 提供価格 -->
                            <td class="px-1 border border-gray-600 readonly-cell">
                                <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs readonly-cell pointer-events-none text-right" name="ing-teikyo-1" readonly tabindex="-1">
                            </td>
                            
                            <!-- 粗利額・粗利率 -->
                            <td class="px-1 border border-gray-600 readonly-cell">
                                <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right block" name="ing-arari-1" readonly tabindex="-1">
                                <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right mt-0" name="ing-arariritu-1" readonly tabindex="-1">
                            </td>
                            
                            <!-- 削除ボタン -->
                            <td class="px-1 border border-gray-600 text-center">
                                <button type="button" class="delete-row p-1 text-sm font-medium text-white bg-red-700 rounded border border-red-700 hover:bg-red-800 focus:outline-none dark:bg-red-600 dark:hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="del(this)" tabindex="-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">項目</th>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-2 border-x border-gray-600">原価合計</td>
                            <td class="px-6 py-2 border-x border-gray-600">
                            <span id="total-cost">0</span>
                            <input type="hidden" form="estimateForm" name="total-cost" id="total-cost-input" value="0">
                        </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-2 border-x border-gray-600">粗利合計</td>
                        <td class="px-6 py-2 border-x border-gray-600">
                            <span id="total-profit">0</span>
                            <input type="hidden" form="estimateForm" name="total_profit" id="total-profit-input" value="0">
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-2 border-x border-gray-600">税抜合計</td>
                        <td class="px-6 py-2 border-x border-gray-600">
                            <span id="total-without-tax">0</span>
                            <input type="hidden" form="estimateForm" name="total_without_tax" id="total-without-tax-input" value="0">
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-2 border-x border-gray-600">消費税額</td>
                        <td class="px-6 py-2 border-x border-gray-600">
                            <span id="total-tax">0</span>
                            <input type="hidden" form="estimateForm" name="total_tax" id="total-tax-input" value="0">
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-2 border-x border-gray-600">税込合計</td>
                        <td class="px-6 py-2 border-x border-gray-600">
                            <span id="total-with-tax">0</span>
                            <input type="hidden" form="estimateForm" name="total_with_tax" id="total-with-tax-input" value="0">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full flex flex-col">
                <label for="estimate_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4">見積備考</label>
                <textarea name="estimate_memo" form="estimateForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-client_estimate_memo" value="{{old('estimate_memo')}}" cols="30" rows="5">■内容等変更が生じた場合は再度御見積りが必要となります。
                ■消費税率が改定される際は別途御見積り致します。</textarea>
            </div>

            <!-- Main modal -->
            <div id="searchProduct" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
                <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-blue-400  rounded dark:bg-gray-800 sm:p-5 shadow-xl ">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg text-gray-900 dark:text-white">
                                製品検索
                            </h3>
                            {{-- <button type="button" onclick="hideProductModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button> --}}
                        </div>
                        <!-- Modal body -->
                        <form action="#">
                            <div class="grid gap-4 mb-4 sm:grid-cols-3">
                                <div>
                                    <label for="productName" class="block mb-2 text-sm text-gray-900 dark:text-white">製品名称</label>
                                    <input type="text" id="productName" name="productName"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="製品名称">
                                </div>
                                <div>
                                    <label for="productSeriesId" class="block mb-2 text-sm text-gray-900 dark:text-white">シリーズ</label>
                                    <select id="productSeriesId" name="productSeriesId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="" value="">未選択</option>
                                        @foreach ($productSeries as $productSeries)
                                            <option value="{{ $productSeries->id }}" @selected($productSeries->id == old('productSeriesId'))>
                                                {{ $productSeries->series_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="productSplitTypeId" class="block mb-2 text-sm text-gray-900 dark:text-white">内訳種別</label>
                                    <select id="productSplitTypeId" name="productSplitTypeId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="" value="">未選択</option>
                                        @foreach ($productSplitTypes as $productSplitType)
                                            <option value="{{ $productSplitType->id }}" @selected($productSplitType->id == old('productSplitTypeId'))>
                                                {{ $productSplitType->split_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                            <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                                <thead>
                                <tr>
                                    {{-- <th class="py-1"></th> --}}
                                    <th class="py-1 pl-5">製品名称</th>
                                    <th class="py-1 whitespace-nowrap">シリーズ</th>
                                    <th class="py-1 whitespace-nowrap">内訳種別</th>
                                </tr>
                                </thead>
                                <tbody class="" id="searchResultsProductContainer">                          
                                        <!-- 検索結果がここに追加されます -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="button" onclick="searchProduct()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                検索
                            </button>
                            <button type="button" id="closeModalBtn" onclick="hideProductModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                閉じる
                            </button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- 決裁シート　レイアウト　注文書備考　採用フラグ --}}

        <!-- 見積設定タブ -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-print-property" role="tabpanel" aria-labelledby="estimate-print-property-tab">
            <div>
                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">住所</label>
                <input type="text" name="client_name" class="input-primary" id="client_name" value="3ヶ月" placeholder="">
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">担当者</label>
                <input type="text" name="client_name" class="input-primary" id="client_name" value="3ヶ月" placeholder="">
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">見積書表題</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="御　見　積　書" placeholder="">
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">注文書表題</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="注　文　書" placeholder="">
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 見積別紙タブ -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-separate-sheet" role="tabpanel" aria-labelledby="estimate-separate-sheet-tab">
            <textarea name="estimate_sheet" form="estimateForm" class="w-full h-[800px] py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-client_memo">{{ old('estimate_sheet') }}</textarea>
        </div>

        <!-- 添付ファイルタブ -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-attachment" role="tabpanel" aria-labelledby="estimate-attachment-tab">
            <div class="relative overflow-x-auto mt-8">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">
                                File name
                            </th>
                            <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                File size
                            </th>
                            <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                download
                            </th>
                            <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                delete
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($attachments as $attachment)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white border-x border-gray-600">
                                {{ basename($attachment->file_path) }}
                            </th>
                            <td class="px-3 py-2 border-x text-center border-gray-600">
                                {{ \App\Common\CommonFunction::formatBytes($attachment->file_size) }}
                            </td>
                            <td class="px-3 py-2 text-center border-x border-gray-600">
                                @if ($contractDetail->contract_pdf) 
                                <!-- ブラウザの別タブで一旦表示ボタン -->
                                    <button type="button" class="button-edit" onclick="window.open('{{ asset('storage/' . $attachment->file_path) }}', '_blank');">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                            </svg>
                                        </div>
                                    </button>

                                <!-- 直ダウンロードボタン -->
                                    <!-- <a href="{{ asset('storage/' . $contractDetail->pdf_file) }}" download class="button-edit inline-block">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                                            </svg>
                                        </div>
                                    </a> -->
                                @endif
                            </td>
                            <td class="px-3 py-2 text-center">
                                @if ($contractDetail->contract_pdf)
                                    <button type="button" data-modal-target="deleteModal" data-modal-show="deleteModal" class="button-delete-primary">
                                        <div class="flex">
                                            <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            <span class="text-ms ">削除</span>
                                        </div>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>


        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="order" role="tabpanel" aria-labelledby="order-tab">
            <button>generatePdf</button>
            <iframe src="{{ route('estimate.pdf.generate') }}" style="width:600px; height:500px;"></iframe>
        </div>
    </div>
    {{-- </div> --}}


    <script>
        let currentEditingRow = null;
        let rowCount = 1;
        
        // フォームデータを保存する関数
        function saveFormData() {
            const formData = [];
            const rows = document.querySelectorAll('#input_plural tr');
            rows.forEach((row, index) => {
                const rowData = {};
                row.querySelectorAll('input, select, span[data-name^="ing-hyojun-"]').forEach(element => {
                    if (element.tagName.toLowerCase() === 'span') {
                        rowData[element.dataset.name] = element.textContent;
                    } else {
                        rowData[element.name] = element.value;
                    }
                });
                formData.push(rowData);
            });
            localStorage.setItem('estimateFormData', JSON.stringify(formData));
            console.log('Saved form data:', formData); // デバッグ用
        }
        
        // 保存されたフォームデータを復元する関数
        function restoreFormData() {
            const savedData = localStorage.getItem('estimateFormData');
            console.log('Restored data from localStorage:', savedData); // デバッグ用
            if (savedData) {
                const formData = JSON.parse(savedData);
                const tbody = document.querySelector('#input_plural');
                tbody.innerHTML = ''; // 既存の行を全て削除
        
                formData.forEach((rowData, index) => {
                    add(false); // 新しい行を追加
                    const newRow = tbody.lastElementChild;
                    updateRowWithData(newRow, rowData);
                });
        
                // フォームデータを復元した後、保存されたデータを削除
                localStorage.removeItem('estimateFormData');
                // 復元後に計算を実行
                calculateAll();
                setupInputListeners();
                console.log('Form data restored and calculated'); // デバッグ用
            } else {
                console.log('No saved form data found'); // デバッグ用
            }
        }
        
        // 行のデータを更新するヘルパー関数
        function updateRowWithData(row, data) {
            Object.keys(data).forEach(key => {
                const input = row.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                } else if (key.startsWith('ing-hyojun-')) {
                    const span = row.querySelector(`[data-name="${key}"]`);
                    if (span) {
                        span.textContent = data[key];
                    }
                }
            });
            console.log('Updated row with data:', data); // デバッグ用
        }
        
        // 行を追加する関数
        function add(shouldSave = true) {
            const tbody = document.querySelector('#input_plural');
            const newRow = createNewRow(tbody.children.length + 1);
            tbody.appendChild(newRow);
            updateSortable();
            setupInputListeners();
        
            if (shouldSave) {
                saveFormData();
            }
        
            console.log('New row added:', newRow); // デバッグ用
        }
        
        // 新しい行を作成する関数
        function createNewRow(rowNumber) {
            const row = document.createElement('tr');
            row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap";
            row.innerHTML = `
                <td class="px-1 border border-gray-600 text-center">
                    <button type="button" class="copy-row p-1 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="copyRow(this)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </td>
                <td class="px-1 border border-gray-600 text-center drag-handle">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white cursor-move mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3"/>
                    </svg>
                </td>
                <td class="px-0.5 border border-gray-600 text-center">${rowNumber}</td>
                <td class="px-1 border border-gray-600 hidden">
                    <input type="hidden" form="estimateForm" name="sort-order-${rowNumber}" value="${rowNumber}">
                </td>
                <td class="px-1 border border-gray-600 align-bottom pb-1">
                    <div class="flex w-full">
                        <input type="text" form="estimateForm" class="input-estimate w-[110px] text-xs" name="ing-cd-${rowNumber}">
                        <button type="button" id="invoiceApi" onclick="showProductModal(this)" class="p-1 ml-0.5 px-1.5 text-sm h-7 mt-1 font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="px-1 border border-gray-600 align-bottom pb-1"><div class="flex flex-col justify-end h-full"><input type="text" form="estimateForm" class="input-estimate min-w-[270px] w-full text-xs" name="ing-name-${rowNumber}"></div></td>
                <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate text-xs min-w-[100px] w-full" name="ing-kataban-${rowNumber}"></td>
                <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs text-right" name="ing-tanka-${rowNumber}" onchange="formatNumber(this); calculateAll(this)"></td>
                <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs text-right" name="ing-genka-${rowNumber}" onchange="formatNumber(this); calculateAll(this)"></td>
                <td class="px-1 border border-gray-600 align-bottom pb-1"><input type="number" form="estimateForm" class="input-estimate min-w-[48px] w-full text-xs text-right" name="ing-suryo-${rowNumber}" min="0" max="999" oninput="javascript: this.value = this.value.slice(0, 3);" onchange="calculateAll(this)"></td>
                <td class="px-1 border border-gray-600 readonly-cell hidden"><input type="text" form="estimateForm" class="input-estimate  min-w-[100px] text-xs readonly-cell pointer-events-none text-right" name="ing-hyojungenka-${rowNumber}" readonly tabindex="-1"></td>
                <td class="px-1 border border-gray-600 align-bottom pb-1 readonly-cell">
                    <div class="flex flex-col">
                        <span class="input-estimate-arari min-w-[100px] w-full text-xs readonly-cell text-right py-0.5 block" data-name="ing-hyojun-${rowNumber}"></span>
                        <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs dark:text-red-500 text-right py-0.5" name="ing-nebiki-${rowNumber}" onchange="formatNebiki(this); calculateAll(this)" placeholder="値引額">
                    </div>
                </td>
                <td class="px-1 border border-gray-600 readonly-cell">
                    <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs readonly-cell pointer-events-none text-right" name="ing-teikyo-${rowNumber}" readonly tabindex="-1">
                </td>
                <td class="px-1 border border-gray-600 readonly-cell">
                    <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right block" name="ing-arari-${rowNumber}" readonly tabindex="-1">
                    <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right mt-0" name="ing-arariritu-${rowNumber}" readonly tabindex="-1">
                </td>
                <td class="px-1 border border-gray-600 text-center">
                    <button type="button" class="delete-row p-1 text-sm font-medium text-white bg-red-700 rounded border border-red-700 hover:bg-red-800 focus:outline-none dark:bg-red-600 dark:hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="del(this)" tabindex="-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            return row;
        }
        
        function del(button) {
            if (document.querySelectorAll('#input_plural tr').length > 1) {
                button.closest('tr').remove();
                renumberRows();
                calculateTotals();
            }
            saveFormData();
        }
        



        // デバッグ用のログ関数
        function log(message) {
            console.log(`[${new Date().toISOString()}] ${message}`);
        }
        
        function copyRow(button) {
        try {
            log('copyRow function started');
            const originalRow = button.closest('tr');
            const newRowNumber = document.querySelectorAll('#input_plural tr').length + 1;
            const newRow = createNewRow(newRowNumber);

            log('Copying values from original row to new row');
            originalRow.querySelectorAll('input, select, span[data-name^="ing-hyojun-"]').forEach(element => {
                let newElement;
                if (element.tagName.toLowerCase() === 'span' && element.dataset.name) {
                    newElement = newRow.querySelector(`[data-name="${element.dataset.name.replace(/\d+$/, newRowNumber)}"]`);
                } else if (element.name) {
                    newElement = newRow.querySelector(`[name="${element.name.replace(/\d+$/, newRowNumber)}"]`);
                }

                if (newElement) {
                    if (element.tagName.toLowerCase() === 'span') {
                        newElement.textContent = element.textContent;
                    } else {
                        newElement.value = element.value;
                    }
                }
            });

            log('Inserting new row after the original row');
            originalRow.parentNode.insertBefore(newRow, originalRow.nextSibling);

            updateSortable();
            renumberRows();
            calculateAll(newRow.querySelector('input[name^="ing-suryo-"]'));
            setupInputListeners();
            saveFormData();
            log('copyRow function completed successfully');
        } catch (error) {
            console.error('Error in copyRow function:', error);
        }
    }

    function renumberRows() {
        try {
            log('renumberRows function started');
            document.querySelectorAll('#input_plural tr').forEach((row, index) => {
                const rowNumber = index + 1;
                const noCell = row.querySelector('td:nth-child(3)');
                if (noCell) noCell.textContent = rowNumber;

                const hiddenInput = row.querySelector('input[type="hidden"]');
                if (hiddenInput) {
                    hiddenInput.name = `sort-order-${rowNumber}`;
                    hiddenInput.value = rowNumber;
                }

                row.querySelectorAll('input:not([type="hidden"]), select, span[data-name^="ing-hyojun-"]').forEach(element => {
                    if (element.tagName.toLowerCase() === 'span' && element.dataset.name) {
                        element.dataset.name = element.dataset.name.replace(/\d+$/, rowNumber);
                    } else if (element.name) {
                        element.name = element.name.replace(/\d+$/, rowNumber);
                    }
                });
            });
            rowCount = document.querySelectorAll('#input_plural tr').length;
            log('renumberRows function completed successfully');
        } catch (error) {
            console.error('Error in renumberRows function:', error);
        }
    }
        
        function formatNumber(input) {
            let value = input.value.replace(/[^\d.-]/g, '');
            if (value !== '' && !isNaN(value)) {
                input.value = Number(value).toLocaleString();
            }
        }
        
        function formatNebiki(input) {
            let value = input.value.replace(/[^\d.-]/g, '');
            if (value !== '' && !isNaN(value)) {
                if (value.startsWith('-')) {
                    input.value = '-' + Number(value.slice(1)).toLocaleString();
                } else {
                    input.value = '-' + Number(value).toLocaleString();
                }
            }
        }
        
        function calculateAll(changedInput) {
    const rows = document.querySelectorAll('#input_plural tr');
    rows.forEach(row => {
        const tanka = parseFloat(row.querySelector('input[name^="ing-tanka-"]').value.replace(/,/g, '')) || 0;
        const genka = parseFloat(row.querySelector('input[name^="ing-genka-"]').value.replace(/,/g, '')) || 0;
        const suryo = parseFloat(row.querySelector('input[name^="ing-suryo-"]').value) || 0;
        const nebiki = parseFloat(row.querySelector('input[name^="ing-nebiki-"]').value.replace(/,/g, '')) || 0;
    
        const hyojun = tanka * suryo;
        const hyojungenka = genka * suryo;
        const teikyo = hyojun + nebiki;
        const arari = teikyo - hyojungenka;
        const arariritu = teikyo !== 0 ? (arari / teikyo) * 100 : 0;
    
        row.querySelector('span[data-name^="ing-hyojun-"]').textContent = Math.round(hyojun).toLocaleString();  
        row.querySelector('input[name^="ing-hyojungenka-"]').value = Math.round(hyojungenka).toLocaleString();
        row.querySelector('input[name^="ing-teikyo-"]').value = Math.round(teikyo).toLocaleString();
        row.querySelector('input[name^="ing-arari-"]').value = Math.round(arari).toLocaleString();
        row.querySelector('input[name^="ing-arariritu-"]').value = arariritu.toFixed(2) + '%';
    });
    
    calculateTotals();
    saveFormData();
}

function calculateTotals() {
    let totalCost = 0;
    let totalProfit = 0;
    let totalWithoutTax = 0;

    document.querySelectorAll('#input_plural tr').forEach(row => {
        const genka = parseFloat(row.querySelector('input[name^="ing-genka-"]').value.replace(/,/g, '')) || 0;
        const suryo = parseFloat(row.querySelector('input[name^="ing-suryo-"]').value) || 0;
        const teikyo = parseFloat(row.querySelector('input[name^="ing-teikyo-"]').value.replace(/,/g, '')) || 0;

        totalCost += genka * suryo;
        totalProfit += teikyo - (genka * suryo);
        totalWithoutTax += teikyo;
    });

    const taxRate = 0.1; // 10%
    const totalTax = totalWithoutTax * taxRate;
    const totalWithTax = totalWithoutTax + totalTax;

    updateDisplayAndHiddenField('total-cost', Math.round(totalCost));
    updateDisplayAndHiddenField('total-profit', Math.round(totalProfit));
    updateDisplayAndHiddenField('total-without-tax', Math.round(totalWithoutTax));
    updateDisplayAndHiddenField('total-tax', Math.round(totalTax));
    updateDisplayAndHiddenField('total-with-tax', Math.round(totalWithTax));
}

function updateDisplayAndHiddenField(id, value) {
    const formattedValue = value.toLocaleString();
    document.getElementById(id).textContent = formattedValue;
    document.getElementById(id + '-input').value = value;
}

function updateSortable() {
    const tbody = document.querySelector('#input_plural');
    new Sortable(tbody, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            renumberRows();
            saveFormData();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded event fired');
    updateSortable();
    restoreFormData();
    calculateTotals();
});

document.addEventListener('submit', function(e) {
    if (e.target.id === 'estimateForm') {
        saveFormData();
    }
});

document.querySelector('#input_plural').addEventListener('change', function(e) {
    if (e.target.matches('input[name^="ing-tanka-"], input[name^="ing-genka-"], input[name^="ing-suryo-"], input[name^="ing-nebiki-"]')) {
        calculateAll(e.target);
    }
});

function handleKeyDown(e) {
    if (e.target.matches('#input_plural input[type="text"], #input_plural input[type="number"]') && e.key === 'Enter') {
        e.preventDefault();
        moveCell(e.shiftKey ? 'up' : 'down', e.target);
    }
}

function moveCell(direction, element) {
    const currentCell = element.closest('td');
    const currentRow = currentCell.parentElement;
    const cellIndex = Array.from(currentRow.cells).indexOf(currentCell);
    
    let targetRow;
    if (direction === 'down') {
        targetRow = currentRow.nextElementSibling;
        if (!targetRow) {
            targetRow = currentRow.parentElement.firstElementChild;
        }
    } else { // up
        targetRow = currentRow.previousElementSibling;
        if (!targetRow) {
            targetRow = currentRow.parentElement.lastElementChild;
        }
    }

    if (targetRow) {
        const targetCell = targetRow.cells[cellIndex];
        const targetInput = targetCell.querySelector('input[type="text"], input[type="number"]');
        if (targetInput) {
            targetInput.focus();
            targetInput.setSelectionRange(targetInput.value.length, targetInput.value.length);
        }
    }
}

function setupInputListeners() {
    const inputs = document.querySelectorAll('#input_plural input[type="text"], #input_plural input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('keydown', handleKeyDown);
    });
}

// 初期化
document.addEventListener('DOMContentLoaded', function() {
    try {
        log('DOMContentLoaded event fired');
        
        // URLパラメータをチェック
        const urlParams = new URLSearchParams(window.location.search);
        const isNewEntry = urlParams.get('new') === 'true';
        
        if (isNewEntry) {
            // 新規登録の場合、ローカルストレージをクリア
            log('New entry detected, clearing localStorage');
            localStorage.removeItem('estimateFormData');
            initializeNewForm();
        } else {
            // 通常のロード処理
            restoreFormData();
        }
        
        updateSortable();
        calculateTotals();
        setupInputListeners();
        log('Initialization completed successfully');
    } catch (error) {
        console.error('Error during initialization:', error);
    }
});


// 新規フォームの初期化
function initializeNewForm() {
    log('Initializing new form');
    const tbody = document.querySelector('#input_plural');
    tbody.innerHTML = ''; // 既存の行をすべて削除
    add(false); // 1行だけ追加
}

// 新規登録ボタンのイベントリスナー（HTMLに追加する必要があります）
document.getElementById('newEntryButton').addEventListener('click', function() {
    // 新規登録ページにリダイレクト（URLパラメータ付き）
    window.location.href = 'create.php?new=true';
});

</script>

        <script>
            const overlay = document.getElementById('overlay')
            const searchProductModal = document.getElementById('searchProduct');

            // 製品検索モーダルを表示するための関数
            function showProductModal(button) {
                currentEditingRow = button.closest('tr');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                searchProductModal.classList.remove('hidden');

                    // モーダル内のコンテンツ要素を取得
                    const modalContent = searchProductModal.querySelector('.bg-blue-400');

                    // Tabキーによるフォーカス移動をトラップする関数
                    function trapTabKey(e) {
                        if (e.key === 'Tab') {
                            const focusableElements = modalContent.querySelectorAll(
                                'a[href], button:not([disabled]), textarea, input:not([disabled]), select:not([disabled])'
                            );

                            const firstElement = focusableElements[0];
                            const lastElement = focusableElements[focusableElements.length - 1];

                            if (e.shiftKey) {
                                if (document.activeElement === firstElement) {
                                    e.preventDefault();
                                    lastElement.focus();
                                }
                            } else {
                                if (document.activeElement === lastElement) {
                                    e.preventDefault();
                                    firstElement.focus();
                                }
                            }
                        }
                    }

                    // Tabキーイベントをモーダル内で捕捉
                    modalContent.addEventListener('keydown', trapTabKey);

                    // モーダルが開かれたときに最初のフォーカス可能な要素にフォーカスを当てる
                    const productNameInput = document.getElementById('productName');
                    productNameInput.focus();
                }

                // 製品検索モーダルを非表示にする
                function hideProductModal() {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');

                    searchProductModal.classList.add('hidden');

                    const ProductButton = document.getElementById('searchProductButton');
                    ProductButton.focus();

                    // モーダル内のコンテンツ要素からTabキーイベントリスナーを削除
                    const modalContent = searchProductModal.querySelector('.bg-blue-400');
                    modalContent.removeEventListener('keydown', trapTabKey);
                }


                //製品検索ボタンを押下した際の処理
                function searchProduct() {
                    const productName = document.getElementById('productName').value;
                    const productSeriesId = document.getElementById('productSeriesId').value;
                    const productSplitTypeId = document.getElementById('productSplitTypeId').value;

                    fetch('/products/search', {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ productName, productSeriesId, productSplitTypeId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const searchResultsProductContainer = document.getElementById('searchResultsProductContainer');
                        searchResultsProductContainer.innerHTML = '';

                        data.forEach(result => {
                            const resultElement = document.createElement('tr');
                            resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                            resultElement.innerHTML = `
                                <td class="py-2 pl-5 cursor-pointer" onclick="setProduct('${result.product_name}', '${result.product_series.series_name}', '${result.product_split_type_id}', '${result.product_code}', '${result.unit_price}')">${result.product_name}</td>
                                <td class="py-2 ml-2">${result.product_series.series_name}</td>
                                <td class="py-2 ml-2">${result.product_split_type.split_type_name}</td>
                            `;
                            searchResultsProductContainer.appendChild(resultElement);
                        });
                    });
                }

                function setProduct(name, series, split, code, price) {
                    if (currentEditingRow) {
                        currentEditingRow.querySelector('input[name^="ing-cd-"]').value = code;
                        currentEditingRow.querySelector('input[name^="ing-name-"]').value = name;
                        currentEditingRow.querySelector('input[name^="ing-kataban-"]').value = series;
                        
                        // 小数点以下を取り除いて整数に変換し、カンマ区切りの文字列にフォーマット
                        const formattedPrice = parseInt(price).toLocaleString();
                        currentEditingRow.querySelector('input[name^="ing-tanka-"]').value = formattedPrice;
                        
                        currentEditingRow.querySelector('input[name^="ing-genka-"]').value = 0;
                        currentEditingRow.querySelector('input[name^="ing-suryo-"]').value = 1;
                        
                        // 値を更新した後、計算を実行
                        calculateAll(currentEditingRow.querySelector('input[name^="ing-suryo-"]'));
                    }

                    hideProductModal();
                    currentEditingRow = null;
                }
        </script>

    <style>
        .readonly-cell {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        .dark .readonly-cell {
            background-color: #374151;
            color: #9ca3af;
        }
        .input-estimate.text-right {
            text-align: right;
        }
        .input-estimate.text-xs {
            font-size: 0.75rem; /* テキストサイズを小さくする */
        }
        input {
        margin: 0;
        padding: 0;
        width: 300px;
        max-width: 100%;
        }
    </style>
</x-app-layout>