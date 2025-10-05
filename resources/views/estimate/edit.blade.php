<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editEstimate', $project, $estimate) }}
            </h2>
            <div class="ml-auto flex">
                <form id="estimateForm" method="POST" action="{{ route('estimates.update', ['projectId' => $project, 'estimateId' => $estimate]) }}" enctype="multipart/form-data" autocomplete="new-password">
                    @csrf
                    @method('patch')
                    <x-buttons.save-button form-id="estimateForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __("update") }}
                    </x-buttons.save-button>
                </form>
                {{-- <button onclick="estimatePreview()" class="text-white ml-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-xs px-3.5 py-1.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    見積印刷
                </button> --}}
                <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center ml-2 w-full sm:px-3.5 py-1.5 text-sm font-medium text-white bg-white border border-gray-200 rounded md:w-auto hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:bg-blue-600 dark:text-white dark:border-blue-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                    {{-- <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg> --}}
                    <svg class="w-5 h-5 ml-2 mr-2 sm:ml-0 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z"/>
                    </svg>
                    <span class="hidden sm:inline text-sm">{{ __('Print') }}</span>
                </button>
                <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                        <li>
                            <button type="button" onclick="estimatePreview()" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                    </svg>
                                </div>
                                見積書印刷
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="location.href='{{ route('corporations.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                    </svg>
                                </div>
                                注文書印刷
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>


    <div class="mx-auto md:pl-16 pr-3 pl-3 pb-4 xl:w-5/6">
            <div class="rounded border-gray-500 border mb-4 overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <tbody class="">
                        <tr class="border-b dark:border-gray-700">
                            <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44 whitespace-nowrap pr-2">
                                法人名称
                            </th>
                            <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                <div class="flex px-2 py-1.5">
                                    <div class="flex items-center mr-12 ">
                                        <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $project->client->corporation->corporation_name }}</div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44 whitespace-nowrap pr-2">
                                顧客名称
                            </th>
                            <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                <div class="flex px-2 py-1.5">
                                    <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $project->client->client_name }}</div>
                                </div>
                            </th>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <th class="pl-4 border-r dark:border-gray-700 dark:bg-gray-800 w-44 whitespace-nowrap pr-2">
                                プロジェクト名称
                            </th>
                            <th class="dark:bg-gray-700 border-b dark:border-gray-600">
                                <div class="flex px-2 py-1.5">
                                    <div class=" text-sm font-medium text-gray-900 dark:text-gray-300  whitespace-nowrap">{{ $project->project_name }}</div>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="grid gap-3 lg:grid-cols-3 grid-cols-1 mt-2">
                <div>
                    <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none ">法人名称</label>
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
            </div> --}}
    
            <div class="grid gap-y-1 lg:gap-x-3 lg:grid-cols-4 grid-cols-1 mt-6">
                <div class="">
                    <label for="estimate_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">見積番号</label>
                    <input type="text" form="estimateForm" name="estimate_num" class="input-readonly cursor-not-allowed" id="estimate_num" value="{{ $estimate->estimate_num }}" placeholder="登録時に自動採番されます" readonly>
                    @error('estimate_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="estimate_recipient" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">宛名</label>
                    <input type="text" form="estimateForm" name="estimate_recipient" class="input-secondary" id="estimate_recipient" value="{{ old('estimate_recipient', $estimate->estimate_recipient) }}" placeholder="">
                    @error('estimate_recipient')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="estimate_at" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">見積作成日</label>
                    <input type="date" form="estimateForm" name="estimate_at" class="input-primary" id="estimate_at" value="{{ old('estimate_at', $estimate->estimate_at) }}" placeholder="">
                    @error('estimate_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
    
            <div class="col-span-3">
                <label for="estimate_subject" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">見積件名</label>
                <input type="text" form="estimateForm" name="estimate_subject" class="input-secondary" id="estimate_subject" value="{{ old('estimate_subject',  $estimate->estimate_subject) }}" placeholder="">
                @error('estimate_subject')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="grid gap-2 lg:grid-cols-5 grid-cols-2 text-sm mt-2">

                <div class="">
                    <label for="estimate_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">見積作成日</label>
                    <input type="date" form="estimateForm" name="estimate_at" class="input-primary" id="estimate_at" value="{{ old('estimate_at', $estimate->estimate_at) }}" placeholder="">
                    @error('estimate_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="body-tab" data-tabs-target="#body" type="button" role="tab" aria-controls="body" aria-selected="false">見積書明細</button>
                    </li>
                    {{-- <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-separate-sheet-tab" data-tabs-target="#estimate-separate-sheet" type="button" role="tab" aria-controls="estimate-separate-sheet" aria-selected="false">見積書別紙</button>
                    </li> --}}
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-print-property-tab" data-tabs-target="#estimate-print-property" type="button" role="tab" aria-controls="estimate-print-property" aria-selected="false">見積書設定</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">注文書設定</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="estimate-attachment-tab" data-tabs-target="#estimate-attachment" type="button" role="tab" aria-controls="estimate-attachment" aria-selected="false">添付ファイル</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="approval-tab" data-tabs-target="#approval" type="button" role="tab" aria-controls="approval" aria-selected="false">決裁情報</button>
                    </li>
                </ul>
            </div>


            <div id="myTabContent">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="body" role="tabpanel" aria-labelledby="body-tab">

                    <div id="mytable"></div>

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
                                {{-- <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">値引き額</th> --}}
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 w-[100px]">提供価格</th>
                                <th scope="col" class="px-2 py-0.5 whitespace-nowrap border-x border-gray-600 text-xs w-[100px]">粗利額*<br>粗利率*</th>
                                <th scope="col" class="px-1 py-2 whitespace-nowrap border-x border-gray-600 text-center w-[40px]">削除</th>
                            </tr>
                        </thead>

                        <tbody id="input_plural">
                            @foreach($estimateDetails as $index => $detail)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">

                                <!-- 複写ボタン -->
                                <td class="px-1 border border-gray-600 text-center">
                                    <button type="button" class="copy-row p-1 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="copyRow(this)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </td>

                                <!-- 並び替えボタン -->
                                <td class="px-1 border border-gray-600 text-center drag-handle">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white cursor-move mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3"/>
                                    </svg>
                                </td>

                                <!-- インデックス -->
                                <td class="px-0.5 border border-gray-600 text-center">{{ $index + 1 }}</td>

                                <!-- 並び順（sort_order） -->
                                <td class="px-1 border border-gray-600 hidden">
                                    <input type="hidden" form="estimateForm" name="sort-order-{{ $index + 1 }}" value="{{ $index + 1 }}">
                                </td>
                                
                                <!-- 製品コード（product_code） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <div class="flex w-full">
                                        <input type="text" form="estimateForm" class="input-estimate w-[110px] text-xs" name="ing-cd-{{ $index + 1 }}" value="{{ optional($detail->product)->product_code }}">
                                        <button type="button" id="invoiceApi" onclick="showProductModal(this)" class="p-1 ml-0.5 px-1.5 text-sm h-7 mt-1 font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                <!-- 製品名称（product_name） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <input type="text" form="estimateForm" class="input-estimate text-xs w-full" name="product-name-{{ $index + 1 }}" value="{{ $detail->product_name }}">
                                </td>

                                <!-- 型番（product_model_num） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <input type="text" form="estimateForm" class="input-estimate text-xs w-full" name="model-number-{{ $index + 1 }}" value="{{ $detail->product_model_num }}">
                                </td>

                                <!-- 価格/個（unit-price） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <input type="text" form="estimateForm" class="input-estimate text-xs w-full text-right" name="unit-price-{{ $index + 1 }}" value="{{ number_format($detail->unit_price) }}" step="1" onchange="formatNumber(this); calculateAll(this)" >
                                </td>

                                <!-- 原価/個（unit-cost) -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <input type="text" form="estimateForm" class="input-estimate text-xs w-full text-right" name="unit-cost-{{ $index + 1 }}" value="{{ number_format($detail->unit_cost) }}" step="1" onchange="formatNumber(this); calculateAll(this)">
                                </td>

                                <!-- 数量（quantity） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1">
                                    <input type="number" form="estimateForm" class="input-estimate text-xs w-full text-right" name="quantity-{{ $index + 1 }}" value="{{ $detail->quantity }}" step="1" min="0" max="999" oninput="javascript: this.value = this.value.slice(0, 3);" onchange="calculateAll(this)">
                                </td>

                                <!-- 値引き前合計価格（standard-pricre）・値引額（discount） -->
                                <td class="px-1 border border-gray-600 align-bottom pb-1 readonly-cell">
                                    <div class="flex flex-col">
                                        <span class="input-estimate-arari min-w-[100px] w-full text-xs readonly-cell text-right py-0.5 block" name="standard-total-{{ $index + 1 }}"></span>
                                        <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs dark:text-red-500 text-right py-0.5" name="discount-{{ $index + 1 }}" value="{{number_format($detail->discount) }}" onchange="formatNebiki(this); calculateAll(this)" placeholder="値引額">
                                    </div>
                                </td>
                                {{-- <td class="px-1 border border-gray-600">
                                    <input type="text" form="estimateForm" class="input-estimate w-full text-right" name="discount-{{ $index + 1 }}" value="{{ $detail->discount }}" step="1" onchange="calculateAll(this)">
                                </td>
                                <td class="px-1 border border-gray-600">
                                    <input type="number" form="estimateForm" class="input-estimate w-full text-right" name="offer-price-{{ $index + 1 }}" value="{{ $detail->offer_price }}" step="1">
                                </td> --}}
                                {{-- <td class="px-1 border border-gray-600 align-bottom pb-1 readonly-cell">
                                    <div class="flex flex-col">
                                        <span class="input-estimate-arari min-w-[100px] w-full text-xs readonly-cell text-right py-0.5 block" data-name="ing-hyojun-{{ $index + 1 }}">{{ number_format($detail->standard_price * $detail->quantity) }}</span>
                                        <input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs dark:text-red-500 text-right py-0.5" name="discount-{{ $index + 1 }}" value="{{ number_format($detail->discount) }}" onchange="formatNebiki(this); calculateAll(this)" placeholder="値引額">
                                    </div>
                                </td> --}}
                                <td class="px-1 border border-gray-600 readonly-cell"><input type="text" form="estimateForm" class="input-estimate min-w-[100px] w-full text-xs readonly-cell pointer-events-none text-right" name="ing-teikyo-1" readonly tabindex="-1"></td>

                                <td class="px-1 border border-gray-600 align-bottom pb-1 readonly-cell">
                                    <div class="flex flex-col">
                                        {{-- <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right block" name="ing-arari-{{ $index + 1 }}" value="{{ number_format($detail->offer_price - ($detail->cost_price * $detail->quantity)) }}" readonly tabindex="-1">
                                        <input type="text" form="estimateForm" class="input-estimate-arari min-w-[100px] w-full text-xs py-0 readonly-cell pointer-events-none text-right mt-0" name="ing-arariritu-{{ $index + 1 }}" value="{{ $detail->offer_price > 0 ? number_format((($detail->offer_price - ($detail->cost_price * $detail->quantity)) / $detail->offer_price * 100), 2) : 0 }}%" readonly tabindex="-1"> --}}
                                    </div>
                                </td>
                                <td class="px-1 border border-gray-600 text-center">
                                    <button type="button" class="p-1 text-sm font-medium text-white bg-red-700 rounded border border-red-700 hover:bg-red-800 focus:outline-none dark:bg-red-600 dark:hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="del(this)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-end">
                        <table class="text-sm text-left text-gray-500 dark:text-gray-200 border border-gray-600">
                            <tr>
                                <th class="px-2 py-1 border border-gray-600">合計原価</th>
                                <td class="px-2 py-1 border border-gray-600">
                                    <span id="total-cost">0</span>
                                    <input type="hidden" form="estimateForm" name="total-cost" id="total-cost-input" value="0">
                                </td>
                            </tr>
                            {{-- <tr>
                                <th class="px-2 py-1 border border-gray-600">合計金額</th>
                                <td class="px-2 py-1 border border-gray-600">
                                    <span id="total-profit">0</span>
                                    <input type="hidden" form="estimateForm" name="total_profit" id="total-profit-input" value="0">
                                </td>
                            </tr> --}}
                            <tr>
                                <th class="px-2 py-1 border border-gray-600">税抜合計金額</th>
                                <td class="px-2 py-1 border border-gray-600">
                                    <span id="total-without-tax">0</span>
                                    <input type="hidden" form="estimateForm" name="total_without_tax" id="total-without-tax-input" value="0">
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2 py-1 border border-gray-600">消費税（10%）</th>
                                <td class="px-2 py-1 border border-gray-600">
                                    <span id="total-tax">0</span>
                                    <input type="hidden" form="estimateForm" name="total_tax" id="total-tax-input" value="0">
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2 py-1 border border-gray-600">税込合計金額</th>
                                <td class="px-2 py-1 border border-gray-600">
                                    <span id="total-with-tax">0</span>
                                    <input type="hidden" form="estimateForm" name="total_with_tax" id="total-with-tax-input" value="0">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="px-2">
                        <label for="estimate_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4">見積備考</label>
                        <textarea name="estimate_memo" data-auto-resize="true" form="estimateForm" class="input-secondary mr-2" id="auto-resize-textarea-estimate_memo" cols="30" rows="5">{{ $estimate->estimate_memo }}</textarea>
                    </div>
                    


                    <!-- ProductSearch modal -->
                    <div id="searchProduct" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
                        <div class="relative p-4 w-full max-w-7xl h-full md:h-auto">
                            <div class="relative p-4 bg-blue-400  rounded dark:bg-gray-800 sm:p-5 shadow-xl ">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                    <h3 class="text-lg text-gray-900 dark:text-white">
                                        製品検索
                                    </h3>
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
            </div>

                {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-separate-sheet" role="tabpanel" aria-labelledby="estimate-separate-sheet-tab">
                    <textarea name="estimate_sheet" form="estimateForm" class="w-full h-[800px] py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-client_memo">{{ old('estimate_sheet') }}</textarea>
                </div> --}}

                <!-- 見積設定タブ -->
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-print-property" role="tabpanel" aria-labelledby="estimate-print-property-tab">
                    <div class="grid md:grid-cols-4 grid-cols-1  gap-2">
                        <div class="">
                            <label for="delivery_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">受渡期日</label>
                            <input type="text" form="estimateForm" name="delivery_at" class="input-primary" id="delivery_at" value="{{ old('delivery_at', $estimate->delivery_at) }}" placeholder="">
                            @error('delivery_at')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="delivery_place" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">受渡場所</label>
                            <input type="text" form="estimateForm" name="delivery_place" class="input-primary" id="delivery_place" value="{{ old('delivery_place', $estimate->delivery_place) }}" placeholder="">
                            @error('delivery_place')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="transaction_method" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">取引方法</label>
                            <input type="text" form="estimateForm" name="transaction_method" class="input-primary" id="transaction_method" value="{{ old('transaction_method', $estimate->transaction_method) }}" placeholder="">
                            @error('transaction_method')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="expiration_at" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">有効期限</label>
                            <input type="text" form="estimateForm" name="expiration_at" class="input-primary" id="expiration_at" value="{{ old('expiration_at', $estimate->expiration_at) }}" placeholder="">
                            @error('expiration_at')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="estimate_address_id" class="block dark:text-gray-100 text-gray-900 leading-none">見積住所</label>
                            <select id="estimate_address_id" form="estimateForm" onchange="updateAddress()" name="estimate_address_id" class="input-secondary">
                                @foreach ($estimateAddresses as $estimateAddress)
                                    <option value="{{ $estimateAddress->ulid }}" 
                                            data-address1="{{ $estimateAddress->estimate_address_1 }}"
                                            data-address2="{{ $estimateAddress->estimate_address_2 }}"
                                            data-address3="{{ $estimateAddress->estimate_address_3 }}"
                                            data-tel="{{ $estimateAddress->estimate_address_tel }}"
                                            data-fax="{{ $estimateAddress->estimate_address_fax }}"
                                            data-mail="{{ $estimateAddress->estimate_address_mail }}"
                                            data-url="{{ $estimateAddress->estimate_address_url }}"
                                            @selected($estimateAddress->ulid == old('estimate_address_id', $estimate->estimate_address_id))>
                                        {{ $estimateAddress->estimate_address_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="user_position_name" class="block dark:text-gray-100 text-gray-900 leading-none">担当者役職名</label>
                            <input type="text" form="estimateForm" name="user_position_name" class="input-primary" id="user_position_name" value="{{ $estimate->user_position_name }}" placeholder="">
                            @error('user_position_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="custom_user_id" class="block dark:text-gray-100 text-gray-900 leading-none">カスタム担当者</label>
                            <select form="estimateForm" name="custom_user_id" id="custom_user_id" class="input-primary">
                                <option value="">未選択</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == old('custom_user_id', $estimate->custom_user_id))>{{ $user->user_name }}</option>
                                @endforeach
                            </select>
                            @error('custom_user_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="estimate_document_title" class="block dark:text-gray-100 text-gray-900 leading-none">見積書表題</label>
                            <input type="text" form="estimateForm" name="estimate_document_title" class="input-secondary" id="estimate_document_title" value="{{ old('estimate_document_title', $estimate->estimate_document_title) }}" placeholder="">
                            @error('estimate_document_title')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="text-white border rounded p-2 mt-6">
                        <div>{{ $estimate->project->accountAffiliation1->affiliation1_name }}</div>
                        <div id="selectedAddress">
                            <!-- ここに選択された住所情報が表示されます -->
                        </div>
                        <div>担当部署：{{ $estimate->project->accountAffiliation2->affiliation2_name }}</div>
                        @if ($estimate->custom_user_id)
                            <!-- custom_user_idが存在する場合 -->
                            <div class="text-red-500">担当氏名：@if($estimate->user_position_name)<span class="text-red-500">{{ $estimate->user_position_name }} </span>@endif{{ $estimate->customUser->user_name }}</div>
                        @else
                            <!-- custom_user_idが存在しない場合 -->
                            <div>担当氏名：@if($estimate->user_position_name)<span class="text-red-500">{{ $estimate->user_position_name }} </span>@endif{{ $estimate->project->accountUser->user_name }}</div>
                        @endif
                    </div>

                    
                    <script>
                        function updateAddress() {
                            var select = document.getElementById("estimate_address_id");
                            var selectedOption = select.options[select.selectedIndex];
                    
                            var address1 = selectedOption.getAttribute("data-address1");
                            var address2 = selectedOption.getAttribute("data-address2");
                            var address3 = selectedOption.getAttribute("data-address3");
                            var tel = selectedOption.getAttribute("data-tel");
                            var fax = selectedOption.getAttribute("data-fax");
                            var mail = selectedOption.getAttribute("data-mail");
                            var url = selectedOption.getAttribute("data-url");

                            var addressHTML = "";
                    
                            if (address1) addressHTML += address1 + "<br>";
                            if (address2) addressHTML += address2 + "<br>";
                            if (address3) addressHTML += address3 + "<br>";
                            if (tel || fax) {
                                addressHTML += "TEL: " + (tel ? tel : "") + "&nbsp;&nbsp;&nbsp;FAX: " + (fax ? fax : "") + "<br>";
                            }
                            if (mail) addressHTML += mail + "<br>";
                            if (url) addressHTML += url + "<br>";

                    
                            document.getElementById("selectedAddress").innerHTML = addressHTML;
                        }
                    
                        // ページが完全に読み込まれた後に関数を実行
                        document.addEventListener('DOMContentLoaded', function() {
                            updateAddress();
                        });
                    </script>
                </div>
                
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="order" role="tabpanel" aria-labelledby="order-tab">
                    <!-- 注文書設定の内容をここに追加 -->
                    <p>注文書設定の内容がここに表示されます。</p>
                    <div>
                        <label for="order_document_title" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">注文書表題</label>
                        <input type="text" form="estimateForm" name="order_document_title" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="order_document_title" value="注　文　書" placeholder="">
                        @error('order_document_title')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <iframe src="{{ route('estimate.pdf.preview', $estimate) }}" class="w-full h-screen"></iframe> --}}
                </div>
                
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="estimate-attachment" role="tabpanel" aria-labelledby="estimate-attachment-tab">
                    <!-- 添付ファイルの内容をここに追加 -->
                </div>
                
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="approval" role="tabpanel" aria-labelledby="approval-tab">
                    <!-- 決裁情報の内容をここに追加 -->
                    <p>決裁情報の内容がここに表示されます。</p>
                </div>
                

                <div id="estimatePreview" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
                    <div class="relative p-2 w-full max-w-7xl h-full md:h-auto">
                        <div class="relative bg-blue-400 rounded dark:bg-gray-700 sm:p-2 shadow-xl max-h-[95vh] flex flex-col">
                            <!-- Modal header -->
                            <div class="flex justify-between items-center p-2 border-b dark:border-gray-600 bg-blue-400 dark:bg-gray-700 z-10">
                                <h3 class="text-lg text-gray-900 dark:text-white">
                                    見積書プレビュー
                                </h3>
                            </div>
                
                            <!-- Modal body -->
                            <div class="flex-1 flex justify-center overflow-y-auto p-4">
                                <div id="pdf-viewer" class="w-full max-w-4xl mx-auto">
                                </div>
                            </div>

                            {{-- Script読み込み --}}
                
                            <!-- Modal footer -->
                            <div class="flex justify-end p-2 border-t dark:border-gray-600 bg-blue-400 dark:bg-gray-700 z-10">
                                <button type="button" onclick="window.location.href='{{ route('estimates.pdf.download', $estimate) }}'" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    見積印刷
                                </button>
                                <button type="button" onclick="hideEstimatePreview()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    閉じる
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
















    <script>
        let currentEditingRow = null;
        let rowCount = {{ count($estimateDetails) }};
    
        function add() {
            rowCount++;
            const newRow = document.querySelector('#input_plural tr').cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';
                const nameParts = input.name.split('-');
                input.name = `${nameParts[0]}-${nameParts[1]}-${rowCount}`;
            });
            newRow.querySelector('td:nth-child(3)').textContent = rowCount;
            newRow.querySelector('input[type="hidden"]').name = `sort-order-${rowCount}`;
            newRow.querySelector('input[type="hidden"]').value = rowCount;
            
            document.querySelector('#input_plural').appendChild(newRow);
            updateSortable();
            setupInputListeners();
            calculateAll(newRow.querySelector('input[name^="quantity-"]'));
        }
    
        function del(button) {
            if (document.querySelectorAll('#input_plural tr').length > 1) {
                button.closest('tr').remove();
                renumberRows();
                calculateTotals();
            }
        }
    
        function renumberRows() {
            document.querySelectorAll('#input_plural tr').forEach((row, index) => {
                const rowNumber = index + 1;
                row.querySelector('td:nth-child(3)').textContent = rowNumber;
                row.querySelector('input[type="hidden"]').name = `sort-order-${rowNumber}`;
                row.querySelector('input[type="hidden"]').value = rowNumber;
                row.querySelectorAll('input:not([type="hidden"])').forEach(input => {
                    const nameParts = input.name.split('-');
                    input.name = `${nameParts[0]}-${nameParts[1]}-${rowNumber}`;
                });
            });
            rowCount = document.querySelectorAll('#input_plural tr').length;
        }
    
        function copyRow(button) {
            const originalRow = button.closest('tr');
            const newRow = originalRow.cloneNode(true);
            rowCount++;

            newRow.querySelector('td:nth-child(3)').textContent = rowCount;

            newRow.querySelector('input[type="hidden"]').name = `sort-order-${rowCount}`;
            newRow.querySelector('input[type="hidden"]').value = rowCount;
            newRow.querySelectorAll('input:not([type="hidden"])').forEach(input => {
                const nameParts = input.name.split('-');
                input.name = `${nameParts[0]}-${nameParts[1]}-${rowCount}`;
            });

            originalRow.parentNode.insertBefore(newRow, originalRow.nextSibling);
            updateSortable();
            renumberRows();
            calculateAll(newRow.querySelector('input[name^="quantity-"]'));
            setupInputListeners();
        }
        
        function formatNumber(input) {
            let value = input.value.replace(/[^\d.-]/g, '');
            if (value !== '' && !isNaN(value)) {
                input.value = Number(value).toLocaleString();
            }
        }
        
        function calculateAll(changedInput) {
            const row = changedInput.closest('tr');
            const standardPrice = parseFloat(row.querySelector('input[name^="unit-price"]').value.replace(/,/g, '')) || 0;
            const costPrice = parseFloat(row.querySelector('input[name^="unit-cost-"]').value.replace(/,/g, '')) || 0;
            const quantity = parseInt(row.querySelector('input[name^="quantity-"]').value) || 0;
            const discount = parseFloat(row.querySelector('input[name^="discount-"]').value.replace(/,/g, '').replace('-', '')) || 0;

            const standardTotal = standardPrice * quantity;
            const offerPrice = standardTotal - discount;
            const profit = offerPrice - (costPrice * quantity);
            const profitRate = offerPrice !== 0 ? (profit / offerPrice) * 100 : 0;

            // 標準価格の更新（spanタグ）
            row.querySelector('span[name^="standard-total-"]').textContent = Math.round(standardTotal).toLocaleString();
            
            // 提供価格の更新
            row.querySelector('input[name^="ing-teikyo-"]').value = Math.round(offerPrice).toLocaleString();
            
            // 粗利額と粗利率の更新
            row.querySelector('input[name^="ing-arari-"]').value = Math.round(profit).toLocaleString();
            row.querySelector('input[name^="ing-arariritu-"]').value = profitRate.toFixed(2) + '%';

            calculateTotals();
        }

        function formatNebiki(input) {
            let value = input.value.replace(/[^\d.-]/g, '');
            if (value !== '' && !isNaN(value)) {
                value = parseFloat(value);
                if (value > 0) {
                    value = -value; // 正の値を負の値に変換
                }
                input.value = value.toLocaleString();
            }
        }
    
        function calculateTotals() {
            let totalAmount = 0;
            let totalCost = 0;
            let totalProfit = 0;
            let totalDiscount = 0;

            document.querySelectorAll('#input_plural tr').forEach(row => {
                const standardPrice = parseFloat(row.querySelector('input[name^="unit-price-"]').value.replace(/,/g, '')) || 0;
                const costPrice = parseFloat(row.querySelector('input[name^="unit-cost-"]').value.replace(/,/g, '')) || 0;
                const quantity = parseInt(row.querySelector('input[name^="quantity-"]').value) || 0;
                const discount = parseFloat(row.querySelector('input[name^="discount-"]').value.replace(/,/g, '').replace('-', '')) || 0;

                const offerPrice = (standardPrice * quantity) - discount;

                totalAmount += offerPrice;
                totalCost += costPrice * quantity;
                totalProfit += offerPrice - (costPrice * quantity);
                totalDiscount += discount;
            });

            const taxAmount = Math.round(totalAmount * 0.1);
            const totalWithTax = totalAmount + taxAmount;

            document.getElementById('total-cost').textContent = Math.round(totalCost).toLocaleString();
            // document.getElementById('total-profit').textContent = Math.round(totalProfit).toLocaleString();
            document.getElementById('total-without-tax').textContent = Math.round(totalAmount).toLocaleString();
            document.getElementById('total-tax').textContent = taxAmount.toLocaleString();
            document.getElementById('total-with-tax').textContent = Math.round(totalWithTax).toLocaleString();

            // 隠しフィールドの更新
            document.getElementById('total-cost-input').value = Math.round(totalCost);
            // document.getElementById('total-profit-input').value = Math.round(totalProfit);
            document.getElementById('total-without-tax-input').value = Math.round(totalAmount);
            document.getElementById('total-tax-input').value = taxAmount;
            document.getElementById('total-with-tax-input').value = Math.round(totalWithTax);
        }
        
        function updateSortable() {
            const tbody = document.querySelector('#input_plural');
            new Sortable(tbody, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function() {
                    renumberRows();
                }
            });
        }

        function setupInputListeners() {
            document.querySelectorAll('#input_plural input').forEach(input => {
                input.addEventListener('change', function() {
                    calculateAll(this.closest('tr'));
                    calculateTotals();
                });
                input.addEventListener('blur', function() {
                    if (this.name.startsWith('discount-')) {
                        formatNebiki(this);
                    } else {
                        formatNumber(this);
                    }
                    calculateAll(this.closest('tr'));
                    calculateTotals();
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateSortable();
            
            // 各行の計算を実行
            document.querySelectorAll('#input_plural tr').forEach(row => {
                const quantityInput = row.querySelector('input[name^="quantity-"]');
                calculateAll(quantityInput);
            });
            
            // 合計を計算
            calculateTotals();
            
            setupInputListeners();
        });
        


        function showProductModal(button) {
            currentEditingRow = button.closest('tr');
            // ここに製品検索モーダルを表示するロジックを実装
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
            font-size: 0.75rem;
        }
    </style>


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
                    currentEditingRow.querySelector('input[name^="product-name-"]').value = name;
                    currentEditingRow.querySelector('input[name^="model-number-"]').value = series;
                    
                    // 小数点以下を取り除いて整数に変換し、カンマ区切りの文字列にフォーマット
                    const formattedPrice = parseInt(price).toLocaleString();
                    currentEditingRow.querySelector('input[name^="unit-price-"]').value = formattedPrice;
                    
                    currentEditingRow.querySelector('input[name^="unit-cost-"]').value = 0;
                    currentEditingRow.querySelector('input[name^="quantity-"]').value = 1;
                    
                    // 値を更新した後、計算を実行
                    calculateAll(currentEditingRow.querySelector('input[name^="quantity-"]'));
                }

                hideProductModal();
                currentEditingRow = null;
            }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('overlay');
            const estimatePreviewModal = document.getElementById('estimatePreview');

            window.estimatePreview = function () {
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                estimatePreviewModal.classList.remove('hidden');
            };

            window.hideEstimatePreview = function () {
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');

                estimatePreviewModal.classList.add('hidden');

                // const ProductButton = document.getElementById('searchProductButton');
                // ProductButton.focus();

                // モーダル内のコンテンツ要素からTabキーイベントリスナーを削除
                // const modalContent = estimatePreviewModal.querySelector('.bg-blue-400');
                // modalContent.removeEventListener('keydown', trapTabKey);
            }
        });
    </script>



    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

        const url = '{{ route("estimate.pdf.preview", $estimate) }}';
        const scale = 1.5;
        const viewer = document.getElementById('pdf-viewer');

        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            const numPages = pdf.numPages;
            
            for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                pdf.getPage(pageNum).then(function(page) {
                    const viewport = page.getViewport({ scale: scale });

                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext);

                    const wrapper = document.createElement('div');
                    wrapper.style.marginBottom = '20px';
                    wrapper.appendChild(canvas);

                    viewer.appendChild(wrapper);
                });
            }
        }).catch(function(error) {
            console.error('PDFの読み込みエラー:', error);
        });
    </script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>