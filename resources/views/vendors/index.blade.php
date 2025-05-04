<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('vendors') }}
                <div class="ml-4">
                    {{ $count }}件
                </div>
            </h2>
            <x-message :message="session('message')" />
            <div class="flex flex-shrink-0 w-auto md:flex-row space-y-0 space-x-3 items-center">

                {{-- 新規登録 --}}
                <x-buttons.add-button :route="route('vendors.create')" gate="storeUpdate_vendors" :text="__('Add')" />
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('Actions') }}
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button type="button" onclick="location.href='{{ route('vendors.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                        </svg>
                                    </div>
                                    CSVアップロード
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <div class="w-full md:w-3/4">
                <form method="GET" action="{{ route('vendors.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="vendor_name" name="vendor_name" value="@if (isset($vendorName)){{$vendorName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="業者名称（カナ）">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="selected_affiliation2" id="selected_affiliation2" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0"  @if($selectedAffiliation2 == 0) selected @endif>管轄事業部</option>
                                @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @if($selectedAffiliation2 == $affiliation2->id) selected @endif>
                                    {{ $affiliation2->affiliation2_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="w-full md:ml-2">
                            <!-- Dropdown menu -->
                            <div id="filterDropdown" class="z-50 hidden w-2/3 md:w-1/3 p-3 bg-gray-100 rounded shadow dark:bg-gray-600">
                                <div class="md:flex">
                                    <div class="md:mr-12">
                                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                            業者属性
                                        </h6>
                                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                            <li>
                                                <input type="checkbox" id="is_dealer" name="is_dealer" @if($isDealer) checked @endif class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_dealer" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">ディーラ</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="is_supplier" name="is_supplier" @if($isSupplier) checked @endif class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_supplier" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">仕入外注先</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="is_lease" name="is_lease" @if($isLease) checked @endif class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_lease" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">リース会社</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="is_other_partner" name="is_other_partner" @if($isOtherPartner) checked @endif class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="is_other_partner" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">その他協業</label>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-4 md:mt-0">
                                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                            業者種別
                                        </h6>
                                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                            @foreach ($vendorTypes as $vendorType)
                                            <li class="flex items-center">
                                                <input id="vendor_type_{{ $vendorType->id }}" type="checkbox" name="vendor_types[]" @if(in_array($vendorType->id, $selectedVendorTypes)) checked @endif value="{{$vendorType->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                <label for="vendor_type_{{ $vendorType->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $vendorType->vendor_type_name }}</label>
                                            </li>      
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

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
                                    {{-- <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">課税/免税</label>
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
                                    </ul> --}}
                                    <div class="lg:mr-12">
                                        <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">
                                            業者属性
                                        </h6>
                                        <ul class="mb-3 text-sm flex flex-wrap" aria-labelledby="dropdownDefault">
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
                                    {{-- <div class="md:mr-12 mt-4 md:mt-0">
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
                                    <div class="md:mr-12 mt-4 md:mt-0">
                                        <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">
                                            設置種別
                                        </h6>
                                        <ul class="mb-3 text-sm flex flex-wrap" aria-labelledby="dropdownDefault">
                                            @foreach ($installationTypes as $installationType)
                                            <li class="flex items-center mr-4 w-24">
                                                <input id="installation_type_{{ $installationType->id }}" type="checkbox" name="installation_types[]" @if(in_array($installationType->id, $selectedInstallationTypes)) checked @endif value="{{$installationType->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                <label for="installation_type_{{ $installationType->id }}" class="ml-2 text-sm whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $installationType->type_name }}</label>
                                            </li>                       
                                            @endforeach
                                        </ul>
                                    </div> --}}
                                    <div class="mt-4 md:mt-0">
                                        <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">
                                            顧客種別
                                        </h6>
                                        <ul class="mb-3 text-sm flex flex-wrap" aria-labelledby="dropdownDefault">
                                            @foreach ($vendorTypes as $vendorType)
                                            <li class="flex items-center mr-4 break-words whitespace-pre-wrap w-24">
                                                <input id="vendor_type_{{ $vendorType->id }}" type="checkbox" name="client_types[]" @if(in_array($vendorType->id, $selectedVendorTypes)) checked @endif value="{{$vendorType->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                <label for="vendor_type_{{ $vendorType->id }}" class="ml-2 text-sm whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $vendorType->vendor_type_name }}</label>
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

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="md:w-auto md:ml-14 md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">編集</span>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('vendor_num','業者№')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('corporation_name','法人名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('vendor_name','業者名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            管轄事業部
                        </div>
                    </th>
                    @can('managerOrAbobe')
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">削除</span>
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button type="button" onclick="location.href='{{ route('vendors.edit', $vendor) }}'"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$vendor->vendor_num}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$vendor->corporation->corporation_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$vendor->vendor_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$vendor->affiliation2->affiliation2_name}}
                        </td>
                        <td class="py-1">
                            <button type="button" data-modal-target="deleteModal-{{$vendor->ulid}}" data-modal-show="deleteModal-{{$vendor->ulid}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td>
                    </tr>

                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$vendor->ulid}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$vendor->ulid}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>

                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('vendors.destroy',$vendor->ulid)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        @can('delete_corporations')
                                        <button type="submit" data-modal-hide="deleteModal-{{$vendor->ulid}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                        @endcan
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$vendor->ulid}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        やっぱやめます
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 削除確認モーダル画面 End --}}
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{ $vendors->withQueryString()->links('vendor.pagination.custum-tailwind') }} 
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
</x-app-layout>