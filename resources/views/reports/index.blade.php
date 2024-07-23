<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('reports') }}
                <div class="ml-4">
                    {{ $count }}件
                </div>
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
            <div class="w-full md:w-3/4">
                <form method="GET" action="{{ route('reports.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="keywords" name="keywords" value="" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="キーワード">
                        </div>
                        {{-- <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客名称（カナ）">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="selected_department" id="selected_department" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0"  @if($selectedDepartment == 0) selected @endif>管轄事業部</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if($selectedDepartment == $department->id) selected @endif>
                                    {{ $department->department_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="custom-select" id="customSelect">
                                <input type="text" placeholder="営業担当" autocomplete="off" id="searchInput" name="" value="{{ $salesUserId }}" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <ul id="optionsList" class="z-50 overflow-y-auto dark:bg-gray-700 text-white text-sm h-40 whitespace-nowrap"></ul>
                                <input type="hidden" name="user_id" id="selectedUserId">
                            </div> --}}
                        {{-- </div> --}}
                        <div class="flex mt-2 md:mt-0">
                            <div class="w-full md:ml-2">
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="z-50 flex items-center justify-center w-full px-4 py-2 text-sm text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Filter') }}
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="filterDropdown" class="z-50 hidden w-2/3 md:w-1/3 p-3 bg-gray-100 rounded shadow dark:bg-gray-600">
                                    <div class="md:flex">
                                        <div class="md:mr-12">
                                            <h6 class="mb-3 text-sm text-gray-900 dark:text-white">
                                                顧客属性
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                <li>
                                                    <input type="checkbox" id="is_enduser" name="is_enduser" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="is_enduser" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">エンドユーザ</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="is_dealer" name="is_dealer" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="is_dealer" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">ディーラ</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="is_supplier" name="is_supplier" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="is_supplier" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">仕入外注先</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="is_lease" name="is_lease" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="is_lease" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">リース会社</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="is_other_partner" name="is_other_partner" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="is_other_partner" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">その他協業</label>
                                                </li>
                                            </ul>
                                        </div>
                                        {{-- <ul class="border my-2 mx-4"></ul> --}}
                                        {{-- <div class="md:mr-12 mt-4 md:mt-0">
                                            <h6 class="mb-3 text-sm text-gray-900 dark:text-white">
                                                取引状態
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                @foreach ($tradeStatuses as $tradeStatus)
                                                <li class="flex items-center">
                                                    <input id="trade_status_{{ $tradeStatus->id }}" type="checkbox" name="trade_statuses[]" @if(in_array($tradeStatus->id, $selectedTradeStatuses)) checked @endif value="{{$tradeStatus->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                    <label for="trade_status_{{ $tradeStatus->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $tradeStatus->trade_status_name }}</label>
                                                </li>                       
                                                @endforeach
                                            </ul>
                                        </div> --}}
                                        {{-- <ul class="border my-2 mx-4"></ul> --}}
                                        {{-- <div class="md:mr-12 mt-4 md:mt-0">
                                            <h6 class="mb-3 text-sm text-gray-900 dark:text-white">
                                                設置種別
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                @foreach ($installationTypes as $installationType)
                                                <li class="flex items-center">
                                                    <input id="installation_type_{{ $installationType->id }}" type="checkbox" name="installation_types[]" @if(in_array($installationType->id, $selectedInstallationTypes)) checked @endif value="{{$installationType->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                    <label for="installation_type_{{ $installationType->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $installationType->type_name }}</label>
                                                </li>                       
                                                @endforeach
                                            </ul>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- 検索ボタン --}}
                            <button type="submit" id="search-button" form="search_form" class="p-2.5 ms-2 text-sm text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                            {{-- リセットボタン --}}
                            <button type="button" value="reset" id="clear" form="search-form" class="p-2.5 ms-2 text-sm text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <button type="button" onclick="location.href='{{ route('reports.create') }}'" class="flex items-center justify-center px-4 py-2 text-sm text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    {{ __('Add') }}
                </button>
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('Actions') }}
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="block w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    CSV一括登録
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            №
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">参照</span>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('contact_at','対応日付')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('type','報告区分')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客番号')
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
                            @sortablelink('title','タイトル')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user_id','報告者')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">編集</span>
                    </th>
                    @can('managerOrAbobe')
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <span class="sr-only">削除</span>
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            <button onclick="location.href='{{route('reports.show',$report)}}'"  class="block whitespace-nowrap text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-sm text-sm px-2 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                <div class="flex items-center">
                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 14">
                                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                          <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                          <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z"/>
                                        </g>
                                      </svg>
                                    <span class="text-ms">コメント</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-1 text-gray-900 whitespace-nowrap dark:text-white">
                            {{$report->contact_at}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$report->reportType->report_type_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$report->client->client_num}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$report->client->client_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$report->report_title}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$report->reporter->user_name}}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button onclick="location.href='{{route('reports.edit',$report)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-sm text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                <div class="flex">
                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                    </svg>
                                    <span class="text-ms">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="py-1">
                            <button type="button" data-modal-target="deleteModal-{{$report->id}}" data-modal-show="deleteModal-{{$report->id}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td>
                    </tr>
                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$report->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>

                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('reports.destroy',$report->id)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        @can('managerOrAbobe')
                                        <button type="submit" data-modal-hide="deleteModal-{{$report->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                        @endcan
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
        {{ $reports->withQueryString()->links('vendor.pagination.custum-tailwind') }}
        </div> 
    </div>


    <!-- CSV一括登録 modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        CSV一括アップロード
                    </h3>
                    <button type="button" id="close_button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6 mr-20 mt-4">
                    <form action="{{ route('clients.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center" id="csv_form1">
                        @csrf
                        <label class="block mb-2 text-sm text-gray-900 dark:text-white" for="csv_upload"></label>
                        <input type="file" name="csv_upload"  id="csv_upload_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_upload_help">
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" form="csv_form1" id="upload-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        アップロード
                    </button>
                    <button disabled type="button" id="spinner" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 items-center">
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                        アップロード中...
                    </button>
                    <div id="uploadOverlay" style="display: none"></div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const uploadForm = document.getElementById('csv_form1');
        const uploadButton = document.getElementById('upload-button');
        const spinner = document.getElementById('spinner');
        const uploadOverlay = document.getElementById('uploadOverlay');
        const fileInput = document.getElementById('csv_upload_file');
        const closeButton = document.getElementById('close_button');

            uploadForm.addEventListener('submit', function (event) {
                // // ファイルが添付されているかを確認
                // if (fileInput.files.length === 0) {
                //     // ファイル未添付の場合は処理を中止
                //     event.preventDefault();
                //     return;
                // }

                // アップロードボタンを非表示にし、スピナーを表示
                uploadButton.style.display = 'none';
                closeButton.style.display = 'none';
                spinner.style.display = 'block';
                fileInput.readOnly = true;

                // 画面をロック
                uploadOverlay.style.display = 'block';

                // フォームをサブミット
                uploadForm.submit();
            });
        });
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var selectContainer = document.getElementById("customSelect");
        var searchInput = document.getElementById("searchInput");
        var optionsList = document.getElementById("optionsList");
        var selectedUserIdInput = document.getElementById("selectedUserId");
        var highlightedOption = null;

        // カスタムセレクトボックスの表示・非表示
        selectContainer.addEventListener("click", function () {
            optionsList.style.display = (optionsList.style.display === "block") ? "none" : "block";
            searchInput.focus();
        });

        // 選択肢がクリックされたときの処理
        optionsList.addEventListener("click", function (event) {
            // 選択肢がクリックされたら選択肢を非表示にする
            optionsList.style.display = "none";
        });

        document.addEventListener("click", function (event) {
        var selectContainer = document.getElementById("customSelect");
        var optionsList = document.getElementById("optionsList");

        // クリックされた要素がカスタムセレクトボックス内かどうかを確認
        var isInsideSelect = event.target.closest("#customSelect");

        if (!isInsideSelect) {
            // カスタムセレクトボックス外がクリックされた場合は選択肢を非表示にする
            optionsList.style.display = "none";
        }
    });

        // 検索欄の入力に応じてオプションを絞り込む
        searchInput.addEventListener("input", function () {
            var searchTerm = searchInput.value.toLowerCase();
            filterOptions(searchTerm);
        });

        // キーボードでのオプションの選択
        searchInput.addEventListener("keydown", function (event) {
            switch (event.key) {
                case "ArrowDown":
                    event.preventDefault();
                    highlightNextOption();
                    break;
                case "ArrowUp":
                    event.preventDefault();
                    highlightPreviousOption();
                    break;
                case "Enter":
                    event.preventDefault();
                    selectHighlightedOption();
                    break;
            }
        });

        // Ajaxを使用して選択肢を取得
        fetch('/search-users')
            .then(response => response.json())
            .then(data => {
                // 取得したデータをセレクトボックスに追加
                populateOptions(data);
            })
            .catch(error => console.error('Error fetching data:', error));

        // オプションを絞り込む関数
        function filterOptions(searchTerm) {
            Array.from(optionsList.children).forEach(function (option) {
                var optionText = option.innerText.toLowerCase();
                option.style.display = optionText.includes(searchTerm) ? "block" : "none";
            });
            highlightedOption = null; // 絞り込み時にハイライトをリセット
        }

        // オプションをセレクトボックスに追加する関数
        function populateOptions(options) {
            options.forEach(function (option, index) {
                var li = document.createElement("li");
                li.textContent = option.name; // ここで適切なプロパティを指定
                li.dataset.value = option.id; // ここで適切なプロパティを指定
                li.addEventListener("click", function () {
                    searchInput.value = option.name; // 選択されたオプションの名前をセット
                    selectedUserIdInput.value = option.id; // hidden inputに選択されたオプションのidをセット

                    // Ajaxリクエストでサーバーに選択されたオプションのidを送信
                    sendSelectedOption(option.id);

                    optionsList.style.display = "none";
                });

                li.addEventListener("mouseenter", function () {
                    highlightedOption = index;
                    highlightOption();
                });

                optionsList.appendChild(li);
            });
        }

        // オプションをハイライトする関数
        function highlightOption() {
            Array.from(optionsList.children).forEach(function (option, index) {
                if (index === highlightedOption) {
                    option.classList.add("highlighted");
                } else {
                    option.classList.remove("highlighted");
                }
            });
        }

        // 次のオプションをハイライトする関数
        function highlightNextOption() {
            highlightedOption = (highlightedOption === null || highlightedOption === optionsList.children.length - 1) ? 0 : highlightedOption + 1;
            highlightOption();
        }

        // 前のオプションをハイライトする関数
        function highlightPreviousOption() {
            highlightedOption = (highlightedOption === null || highlightedOption === 0) ? optionsList.children.length - 1 : highlightedOption - 1;
            highlightOption();
        }

        // ハイライトされているオプションを選択する関数
        function selectHighlightedOption() {
            if (highlightedOption !== null) {
                var selectedOption = optionsList.children[highlightedOption];
                searchInput.value = selectedOption.innerText;
                selectedUserIdInput.value = selectedOption.dataset.value;

                // Ajaxリクエストでサーバーに選択されたオプションのidを送信
                sendSelectedOption(selectedOption.dataset.value);

                optionsList.style.display = "none";
            }
        }

        // 選択されたオプションのidをサーバーに送信する関数
        function sendSelectedOption(selectedId) {
            // ここでAjaxリクエストを作成してサーバーに選択されたオプションのidを送信
            // 例えば、fetchやXMLHttpRequestを使用してサーバーに送信できます
            console.log("Sending selected option id to server:", selectedId);
        }

        // フォームのサブミット時に選択されたオプションをコンソールに表示
        document.getElementById("myForm").addEventListener("submit", function (event) {
            event.preventDefault();
            console.log("Form submitted. Selected option id:", selectedUserIdInput.value);
            // ここでフォームを実際にサブミットするか、別途処理を追加することができます
        });
    });
</script>
<style>
    /* スタイルの定義 */
    .custom-select {
        position: relative;
        display: inline-block;
        width: 200px;
        /* padding: 10px; */
        /* border: 1px solid #ccc; */
        /* border-radius: 5px; */
        cursor: pointer;
        /* background-color: #fff; */
    }

    /* .custom-select input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 5px;
    } */

    .custom-select ul {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 5px 5px;
        display: none;
    }

    .custom-select li {
        padding: 4px;
        cursor: pointer;
    }

    .custom-select li:hover {
        background-color: blue;
    }
</style>
</x-app-layout>