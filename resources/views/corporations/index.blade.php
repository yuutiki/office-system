<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center py-1">
                {{ Breadcrumbs::render('corporations', $searchParams) }}
                <div class="ml-4">
                    {{ $count }}件
                </div>
                <div class="text-gray-900 dark:text-white ml-2 text-sm hidden md:block">
                    <div>（選択中： <span id="selectedCount">0</span> 件）</div>
                </div>
            </h2>
            <x-message :message="session('message')" />
            <div class="flex flex-shrink-0 w-auto md:flex-row space-y-0 space-x-3 items-center">

                {{-- 新規登録 --}}
                <x-buttons.add-button :route="route('corporations.create')" gate="storeUpdate_corporations" :text="__('Add')" />

                <div class="flex items-center space-x-3 w-auto hidden md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_corporations')
                                    <button type="button" onclick="location.href='{{ route('corporations.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                            </svg>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @else
                                    <button type="button" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @endcan
                            </li>
                            <li>
                                @can('download_corporations')
                                    <button type="button" onclick="location.href='{{ route('corporations.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/download" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div class="">CSVダウンロード</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div>CSVダウンロード</div>
                                    </button>
                                @endcan
                            </li>
                            <li>
                                <button type="button" data-modal-target="select-modal" data-modal-toggle="select-modal" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="flex items-center min-w-6">
                                        <x-icon name="icons/nav-setting" class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-white" />
                                    </div>
                                    <div class="ml-2">一覧表示設定</div>
                                </button>
                                {{-- <button data-modal-target="select-modal" data-modal-toggle="select-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Toggle modal
                                  </button> --}}
                            </li>
                            <hr class="border-gray-300 dark:border-gray-500 mx-2">

                            <li>
                                @can('admin_corporations')
                                    <button type="button" data-modal-target="deleteModal-corporations" data-modal-show="deleteModal-corporations" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/delete" class="flex-shrink-0" />
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <!-- ヘッダ：検索欄 -->
            <div class="w-full">
                <form method="GET" action="{{ route('corporations.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        
                        <div class="relative w-full mt-2 md:mr-2 md:mt-0">
                            <div class="absolute inset-y-0 flex items-center pl-3">
                                <x-icon name="ui/search" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                            </div>
                            <input type="search" id="corporation_num" name="corporation_num" value="@if(isset($CorporationNum)){{ $CorporationNum }}@endif" class="input-search" placeholder="法人№">
                        </div>

                        <div class="relative w-full mt-2 md:mr-2 md:mt-0">
                            <div class="absolute inset-y-0 flex items-center pl-3">
                                <x-icon name="ui/search" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                            </div>
                            <input type="search" id="corporation_name" name="corporation_name" value="@if(isset($CorporationName)){{ $CorporationName }}@endif" class="input-search" placeholder="法人名称 / カナ名称 / 法人略称">
                        </div>

                        <div class="relative w-full mt-2 md:mr-2 md:mt-0">
                            <div class="absolute inset-y-0 flex items-center pl-3">
                                <x-icon name="ui/search" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                            </div>
                            <input type="search" id="invoice_num" name="invoice_num" value="@if(isset($invoiceNum)){{ $invoiceNum }}@endif" class="input-search" placeholder="インボイス番号">
                        </div>

                        <div class="flex mt-2 md:mt-0">
                            <div class="flex flex-col justify-end  w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                <button type="button" onclick="showModal()" class="flex w-auto items-center justify-center md:ms-2 px-4 py-2 text-sm font-medium text-white rounded-sm bg-indigo-700 hover:bg-indigo-800 focus:ring-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <div class="whitespace-nowrap">{{ __('詳細条件') }}</div>
                                </button>
                                <div class="flex mt-4 md:mt-0">
                                    <!-- 検索ボタン -->
                                    <x-buttons.search-button />
                                    <!-- リセットボタン -->
                                    <x-buttons.reset-button />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 詳細検索 Modal -->
                    <div id="detailSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center overflow-y-scroll z-50 hidden animate-slide-in-top">
                        <div class="max-h-full w-full max-w-3xl">
                            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-1 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        詳細検索画面
                                    </h3>
                                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="mt-4">
                                    <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mx-2">課税/免税</label>
                                    <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" id="tax_status-1" @checked(in_array(0, $filters['tax_status_ids'] ?? [])) value="0" name="tax_status_ids[]" class="hidden peer touch-none">
                                            <label for="tax_status-1" class="checkbox-label">
                                                <div class="w-full text-sm font-medium text-center">未確認</div>
                                            </label>
                                        </li>
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" id="tax_status-2" @checked(in_array(1, $filters['tax_status_ids'] ?? [])) value="1" name="tax_status_ids[]" class="hidden peer touch-none">
                                            <label for="tax_status-2" class="checkbox-label">
                                                <div class="w-full text-sm font-medium text-center">課税</div>
                                            </label>
                                        </li>
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" id="tax_status-3" @checked(in_array(2, $filters['tax_status_ids'] ?? [])) value="2" name="tax_status_ids[]" class="hidden peer touch-none">
                                            <label for="tax_status-3" class="checkbox-label">
                                                <div class="w-full text-sm font-medium text-center">免税</div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">取引状況</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    <li class="flex justify-center items-center">
                                        <input type="checkbox" id="trade_status-1" @checked(in_array(0, $filters['trade_status_ids'] ?? [])) value="0" name="trade_status_ids[]" class="hidden peer">
                                        <label for="trade_status-1" class="checkbox-label">
                                            <div class="w-full text-sm font-medium text-center">取引中</div>
                                        </label>
                                    </li>
                                    <li class="flex justify-center items-center">
                                        <input type="checkbox" id="trade_status-2" @checked(in_array(1, $filters['trade_status_ids'] ?? [])) value="1" name="trade_status_ids[]" class="hidden peer">
                                        <label for="trade_status-2" class="checkbox-label">
                                            <div class="w-full text-sm font-medium text-center">取引停止中</div>
                                        </label>
                                    </li>
                                </ul>

                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        閉じる
                                    </button> 
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        検索
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-gray-950 md:ml-16 my-2">
        <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
            <div class="ml-4">
                {{ $count }}件
            </div>
            <div class="text-gray-900 dark:text-white ml-2 text-sm">
                <div>（選択中： <span id="selectedCount">0</span> 件）</div>
            </div>
        </h2>
    </div>


    <div class="md:w-auto md:ml-14 md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300 js-scrollable">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="pl-4 py-1 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <span class="sr-only">編集</span>
                    </th>

                    {{-- <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center w-auto">
                            @sortablelink('corporation_num','法人№', 'asc')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            @sortablelink('corporation_kana_name','法人名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            @sortablelink('corporation_prefecture_id','都道府県')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            @sortablelink('tax_status','課税/免税')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            インボイス番号
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            @sortablelink('is_stop_trading','取引状況')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            与信限度額
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            顧客/業者
                        </div>
                    </th> --}}
                    <!-- 動的に表示する列 -->
                    @foreach($allColumns as $key => $label)
                        @if(in_array($key, $visibleColumns))
                            <th scope="col">
                                <div class="flex items-center whitespace-nowrap">
                                    @sortablelink($key, $label)
                                    <!-- ソートアイコン -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                </div>
                            </th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($corporations as $corporation)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ ($corporations->currentPage() - 1) * $corporations->perPage() + $loop->index + 1 }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox{{ $corporation->id }}" type="checkbox" name="selectedIds[]" value="{{ $corporation->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <x-buttons.edit-button :route="route('corporations.edit', $corporation)" />
                        </td>
                        @if(in_array('corporation_num', $visibleColumns))
                            <td class="pl-1 py-1 whitespace-nowrap">
                                {{$corporation->corporation_num}}
                            </td>
                        @endif
                        @if(in_array('corporation_name', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap w-96">
                                {{$corporation->corporation_name}}
                            </td>
                        @endif
                        @if(in_array('corporation_kana_name', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap w-96">
                                {{$corporation->corporation_kana_name}}
                            </td>
                        @endif
                        @if(in_array('corporation_prefecture_id', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{optional($corporation->prefecture)->prefecture_code .':'}}
                                {{optional($corporation->prefecture)->prefecture_name}}
                            </td>
                        @endif
                        @if(in_array('tax_status', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap w-44">
                                @if ($corporation->tax_status == 1)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                        課税事業者
                                    </span>
                                @elseif ($corporation->tax_status == 2)
                                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                        免税事業者
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-400">
                                        未確認
                                    </span>
                                @endif
                            </td>
                        @endif
                        @if(in_array('invoice_num', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap w-44 items-center">
                                {{$corporation->invoice_num}}
                                @if ($corporation->invoice_num && $corporation->is_active_invoice)
                                    <span class="inline-flex items-center justify-center w-5 h-5 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                        <svg class="w-2.5 h-2.5 text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                        </svg>
                                    </span>
                                @endif
                            </td>
                        @endif
                        @if(in_array('is_stop_trading', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap w-44">
                                @if ($corporation->is_stop_trading == 1)
                                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                        取引停止中
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                        取引中
                                    </span>
                                @endif
                            </td>
                        @endif
                        @if(in_array('latest_credit_limit', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap">
                                <div class="w-[65px] text-right">
                                    {{ number_format($corporation->latest_credit_limit ?? 0) }}
                                </div>
                            </td>
                        @endif
                        @if(in_array('clients_count', $visibleColumns))
                            <td class="px-1 py-1 whitespace-nowrap">
                                <div class="w-[58px] text-right">
                                    {{ $corporation->clients_count }}
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{ $corporations->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>

    <!-- Main modal -->
    <div id="select-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        一覧表示項目個人設定
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    {{-- <p class="text-gray-500 dark:text-gray-400 mb-4">一覧に表示する項目を以下から選択してください</p> --}}
                    <form action="{{ route('user-settings.columns') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page_identifier" value="corporations_index">
                        @foreach($allColumns as $key => $label)
                            <div class="flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700">
                                <input id="col_{{ $key }}" type="checkbox" value="{{ $key }}" name="visible_columns[]" {{ in_array($key, $visibleColumns) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="col_{{ $key }}" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</label>
                            </div>
                        @endforeach
                        <button type="submit" class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div> 


    <div id="deleteModal-corporations" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><span id="modalSelectedCount">0</span> 件を本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form id="bulkDeleteForm" action="{{ route('corporations.bulkDelete') }}" method="POST">
                            @csrf
                            <button type="submit" id="bulkDeleteButton" form="bulkDeleteForm" data-modal-hide="deleteModal-corporations" class="text-white  bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 dark:focus:ring-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('deleted') }} <!--削除-->
                            </button>
                        </form>
                        <button id="cancelButton-corporations" data-modal-hide="deleteModal-corporations" type="button" data-modal-cancel class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js"></script>
    <script> new ScrollHint('.js-scrollable', {});</script>
    <style>
        .active {
            text-decoration: underline
        }
    </style>



    <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('detailSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
    
            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }
    
        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('detailSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
    
            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }
    </script>

    <script>
        // 一覧画面のチェックボックス関連の操作　カウントしたり、一括でチェックを付けたり
        document.addEventListener("DOMContentLoaded", function () {
            const selectAllCheckbox = document.getElementById("selectAllCheckbox");
            const checkboxes = document.querySelectorAll(".checkbox-item");
            const selectedCountElement = document.getElementById("selectedCount");
            const modalSelectedCount = document.getElementById("modalSelectedCount");

            function updateSelectedCount() {
                const selectedCount = document.querySelectorAll(".checkbox-item:checked").length;
                selectedCountElement.textContent = selectedCount;
                modalSelectedCount.textContent = selectedCount;  // モーダル内の選択数を更新
            }

            selectAllCheckbox.addEventListener("change", function () {
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                updateSelectedCount();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateSelectedCount);
            });
        });
    </script>
    
</x-app-layout>