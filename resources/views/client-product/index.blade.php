<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
                {{ Breadcrumbs::render('clientProducts') }}
                <div class="text-gray-900 dark:text-white ml-4 text-base hidden md:block">
                    - 選択中: <span id="selectedCount">0</span> 件
                </div>
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">

                <x-buttons.add-button :route="route('client-products.create')" gate="storeUpdate_client_products" :text="__('Add')" />

                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_client_products')
                                    {{-- <button type="button" onclick="location.href='{{ route('client-products.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                            </svg>
                                        </div>
                                        CSVアップロード
                                    </button> --}}
                                @else
                                    <button type="button" class="w-full flex items-center gap-x-2 py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center">
                                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @endcan
                            </li>
                            <li>
                                @can('download_client_products')
                                    {{-- <button type="button" onclick="location.href='{{ route('client-products.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                            </svg>
                                        </div>
                                        CSVダウンロード
                                    </button> --}}
                                @else
                                    <button type="button" class="w-full flex items-center gap-x-2 py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center">
                                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        CSVダウンロード
                                    </button>
                                @endcan
                            </li>
                            <li>
                                <button type="button" 
                                        onclick="showBulkUpdateModal()" 
                                        class="w-full flex items-center gap-x-2 py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                    </div>
                                    一括変更
                                </button>
                            </li>
                            <hr class="border-gray-300 dark:border-gray-500 mx-2">
                            <li>
                                @can('admin_client_products')
                                    <button type="button" data-modal-target="deleteModal-client-products" data-modal-show="deleteModal-client-products" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="flex items-center min-w-6">
                                            <svg aria-hidden="true" class="w-5 h-5 mx-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @else
                                    <button type="button" class="w-full flex items-center gap-x-2 py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center">
                                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        データ削除
                                    </button>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md lg:w-auto md:ml-14 lg:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 lg:flex-row  lg:space-y-0 lg:space-x-3">
            <div class="w-full">
                <form method="GET" action="{{ route('client-products.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col lg:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full mt-2 lg:ml-2 lg:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="顧客名称（カナ）、契約有無、CUS有無、バージョン、シリーズ、製品名、製品コード、顧客名、顧客コード、製品種別、製品内訳種別">
                        </div>
                        {{-- <div class="relative w-full mt-2 lg:ml-2 lg:mt-0">
                            <select name="selected_affiliation2" id="selected_affiliation2" class="block w-full p-2 pl-4 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400">
                                <option value="0"  @if($selectedAffiliation2 == 0) selected @endif>管轄事業部</option>
                                @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @if($selectedAffiliation2 == $affiliation2->id) selected @endif>
                                    {{ $affiliation2->affiliation2_name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="flex mt-2 lg:mt-0">
                            <div class="flex flex-col justify-end  w-full space-y-2 lg:w-auto lg:flex-row lg:space-y-0 lg:items-center lg:space-x-3">
                                <button type="button" onclick="showModal()" class="flex w-auto items-center justify-center lg:ms-2 px-4 py-2 text-sm font-medium text-white rounded-sm bg-indigo-700 hover:bg-indigo-800 focus:ring-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <div class="whitespace-nowrap">{{ __('詳細条件') }}</div>
                                </button>
                                <div class="flex mt-4 lg:mt-0">
                                    <!-- 検索ボタン -->
                                    <x-buttons.search-button />
                                    <!-- リセットボタン -->
                                    <x-buttons.reset-button />
                                </div>
                            </div>
                        </div>
                        <!-- 詳細検索 Modal -->
                        <div id="detailSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center overflow-y-scroll z-50 hidden animate-slide-in-top">
                            <div class="max-h-full w-full max-w-3xl">
                                <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
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
                                    <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">課税/免税</label>
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
                                    <div class="lg:mr-12">
                                        <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">
                                            顧客属性
                                        </h6>
                                        <ul class="mb-3 text-sm flex flex-wrap" aria-labelledby="dropdownDefault">
                                            <li class="flex items-center mr-4  w-24">
                                                <input type="checkbox" id="is_enduser" name="is_enduser" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_enduser" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">エンドユーザ</label>
                                            </li>
                                            <li class="flex items-center mr-4  w-24">
                                                <input type="checkbox" id="is_dealer" name="is_dealer" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_dealer" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">ディーラ</label>
                                            </li>
                                            <li class="flex items-center mr-4  w-24">
                                                <input type="checkbox" id="is_supplier" name="is_supplier" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_supplier" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">仕入外注先</label>
                                            </li>
                                            <li class="flex items-center mr-4  w-24">
                                                <input type="checkbox" id="is_lease" name="is_lease" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_lease" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">リース会社</label>
                                            </li>
                                            <li class="flex items-center mr-4  w-24">
                                                <input type="checkbox" id="is_other_partner" name="is_other_partner" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_other_partner" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">その他協業</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="md:mr-12 mt-4 md:mt-0">
                                        <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            取引状態
                                        </h6>
                                        <ul class="mb-3 text-sm flex flex-wrap" aria-labelledby="dropdownDefault">
                                            @foreach ($tradeStatuses as $tradeStatus)
                                            <li class="flex items-center mr-4 w-24">
                                                <input id="trade_status_{{ $tradeStatus->id }}" type="checkbox" name="trade_statuses[]" @if(in_array($tradeStatus->id, $selectedTradeStatuses)) checked @endif value="{{$tradeStatus->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                <label for="trade_status_{{ $tradeStatus->id }}" class="ml-2 text-sm whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $tradeStatus->trade_status_name }}</label>
                                            </li>                       
                                            @endforeach
                                        </ul>
                                    </div>
                                        
                                    <!-- Modal footer -->
                                    <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-gray-950 md:ml-9 my-2">
        <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
            <div class="ml-4">
                {{ $clientProducts->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
            </div>
        </h2>
    </div>

    <div class="md:w-auto md:ml-14 lg:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
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
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客No.')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('corporation.corporation_kana_name','製品名')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user.user_name','数量')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user.user_name','シリーズ')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user.user_name','バージョン')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            カスタマイズ
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            契約
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientProducts as $clientProduct)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox{{ $clientProduct->id }}" type="checkbox" name="selectedIds[]" value="{{ $clientProduct->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-3 pr-2 py-0.5 whitespace-nowrap">
                            <button onclick="location.href='{{ route('client-products.edit',$clientProduct) }}'" class="block whitespace-nowrap px-2 pl-3 md:pl-1.5  md:pr-1.5 py-[4.5px] text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-sm items-center text-sm text-center dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800" type="button">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                      
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $clientProduct->client->client_num }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $clientProduct->client->client_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap w-96">
                            {{ $clientProduct->product->product_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $clientProduct->quantity }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $clientProduct->productSeries->series_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $clientProduct->productVersion->version_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            @if($clientProduct->is_customized)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                    有り
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    標準
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            @if($clientProduct->is_contracted)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    契約済
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                    未契約
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($clientProducts->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $clientProducts->withQueryString()->links('vendor.pagination.custum-tailwind') }}
        </div>
    @endif

    <style>
        .active {
            text-decoration: underline
        }
    </style>

    <div id="deleteModal-client-products" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><span id="modalSelectedCount">0</span> 件を本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form id="bulkDeleteForm" action="{{ route('client-products.bulkDelete') }}" method="POST">
                            @csrf
                            <button type="submit" id="bulkDeleteButton" form="bulkDeleteForm" data-modal-hide="deleteModal-client-products" class="text-white  bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 dark:focus:ring-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('deleted') }} <!--削除-->
                            </button>
                        </form>
                        <button id="cancelButton-client-products" data-modal-hide="deleteModal-client-products" type="button" data-modal-cancel class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>







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

    <script src="{{ asset('assets/js/user-dropdown.js') }}"></script>

























<!-- 一括変更モーダル（既存の詳細検索モーダルの後に追加） -->
<div id="bulkUpdateModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center overflow-y-scroll z-50 hidden animate-slide-in-top">
    <div class="max-h-full w-full max-w-2xl">
        <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    一括変更
                </h3>
                <div class="text-gray-900 dark:text-white font-medium ml-4">
                    選択中: <span id="modalSelectedCount">0</span> 件
                </div>
                <button type="button" onclick="hideBulkUpdateModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal body -->
            <form id="bulkUpdateForm" action="{{ route('client-products.bulkUpdate') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <!-- 選択されたIDを格納する隠し要素 -->
                    <input type="hidden" id="selectedIdsInput" name="selected_ids" value="">
                    
                    <!-- バージョン -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="update_version" name="update_fields[]" value="product_version_id" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="update_version" class="ml-2 text-sm font-medium text-gray-900 dark:text-white w-20">バージョン</label>
                        </div>
                        <div class="flex-1">
                            <select name="product_version_id" id="product_version_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">選択してください</option>
                                @foreach ($productVersions as $version)
                                    <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- シリーズ -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="update_series" name="update_fields[]" value="product_series_id" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="update_series" class="ml-2 text-sm font-medium text-gray-900 dark:text-white w-20">シリーズ</label>
                        </div>
                        <div class="flex-1">
                            <select name="product_series_id" id="product_series_id_bulk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">選択してください</option>
                                @foreach ($productSeries as $series)
                                    <option value="{{ $series->id }}">{{ $series->series_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- カスタマイズ有無 -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="update_customized" name="update_fields[]" value="is_customized" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="update_customized" class="ml-2 text-sm font-medium text-gray-900 dark:text-white w-20">カスタマイズ</label>
                        </div>
                        <div class="flex-1">
                            <select name="is_customized" id="is_customized_bulk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">選択してください</option>
                                <option value="0">標準</option>
                                <option value="1">CUS</option>
                            </select>
                        </div>
                    </div>

                    <!-- 契約有無 -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="update_contracted" name="update_fields[]" value="is_contracted" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="update_contracted" class="ml-2 text-sm font-medium text-gray-900 dark:text-white w-20">契約</label>
                        </div>
                        <div class="flex-1">
                            <select name="is_contracted" id="is_contracted_bulk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">選択してください</option>
                                <option value="0">未契約</option>
                                <option value="1">契約済</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="hideBulkUpdateModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        キャンセル
                    </button> 
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        一括変更実行
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


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



<script>
    // 一括変更モーダル関連のJavaScript
// 既存のscriptタグ内に以下の関数を追加

/**
 * 一括変更モーダルを表示
 */
function showBulkUpdateModal() {
    const selectedCheckboxes = document.querySelectorAll('.checkbox-item:checked');
    
    if (selectedCheckboxes.length === 0) {
        alert('変更対象のデータを選択してください。');
        return;
    }
    
    // 選択されたIDを取得
    const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
    
    // 隠し要素に選択されたIDをセット
    document.getElementById('selectedIdsInput').value = selectedIds.join(',');
    
    // モーダル内の選択件数を更新
    document.getElementById('modalSelectedCount').textContent = selectedIds.length;
    
    // モーダルを表示
    const modal = document.getElementById('bulkUpdateModal');
    const overlay = document.getElementById('overlay');
    
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

/**
 * 一括変更モーダルを非表示
 */
function hideBulkUpdateModal() {
    const modal = document.getElementById('bulkUpdateModal');
    const overlay = document.getElementById('overlay');
    
    modal.classList.add('hidden');
    overlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    
    // フォームをリセット
    document.getElementById('bulkUpdateForm').reset();
}

/**
 * 一括変更フォーム送信前のバリデーション
 */
document.addEventListener('DOMContentLoaded', function() {
    const bulkUpdateForm = document.getElementById('bulkUpdateForm');
    
    if (bulkUpdateForm) {
        bulkUpdateForm.addEventListener('submit', function(e) {
            const checkedFields = document.querySelectorAll('input[name="update_fields[]"]:checked');
            
            if (checkedFields.length === 0) {
                e.preventDefault();
                alert('変更する項目を少なくとも1つ選択してください。');
                return false;
            }
            
            // 選択された項目の値が設定されているかチェック
            let hasValidValue = false;
            checkedFields.forEach(field => {
                const fieldValue = field.value;
                let selectElement;
                
                switch(fieldValue) {
                    case 'product_version_id':
                        selectElement = document.getElementById('product_version_id');
                        break;
                    case 'product_series_id':
                        selectElement = document.getElementById('product_series_id_bulk');
                        break;
                    case 'is_customized':
                        selectElement = document.getElementById('is_customized_bulk');
                        break;
                    case 'is_contracted':
                        selectElement = document.getElementById('is_contracted_bulk');
                        break;
                }
                
                if (selectElement && selectElement.value !== '') {
                    hasValidValue = true;
                }
            });
            
            if (!hasValidValue) {
                e.preventDefault();
                alert('選択した項目の値を設定してください。');
                return false;
            }
            
            // 確認ダイアログ
            if (!confirm(`選択した ${document.getElementById('modalSelectedCount').textContent} 件のデータを一括変更しますか？`)) {
                e.preventDefault();
                return false;
            }
        });
    }
});

// 既存のチェックボックス関連の関数も更新
document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAllCheckbox");
    const checkboxes = document.querySelectorAll(".checkbox-item");
    const selectedCountElement = document.getElementById("selectedCount");

    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll(".checkbox-item:checked").length;
        selectedCountElement.textContent = selectedCount;
        
        // モーダル内の選択数も更新（モーダルが表示されている場合）
        const modalSelectedCount = document.getElementById("modalSelectedCount");
        if (modalSelectedCount && !document.getElementById('bulkUpdateModal').classList.contains('hidden')) {
            modalSelectedCount.textContent = selectedCount;
        }
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