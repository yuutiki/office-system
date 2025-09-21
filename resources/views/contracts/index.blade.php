<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('contracts') }}
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">
                <x-buttons.add-button :route="route('contracts.create')" gate="storeUpdate_contracts" :text="__('Add')" />

                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_contracts')
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
                                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @endcan
                            </li>
                            <li>
                                @can('download_contracts')
                                    <button type="button" onclick="location.href='{{ route('corporations.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                            </svg>
                                        </div>
                                        CSVダウンロード
                                    </button>
                                @else
                                    <button type="button" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        CSVダウンロード
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
            <div class="w-full">
                <form method="GET" action="{{ route('supports.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="keywords" name="keywords" value="@if (isset($keywords)){{$keywords}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="キーワード">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客名称">
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="text-gray-950 md:ml-9 my-2">
        <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
            <div class="ml-4">
                {{ $contracts->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
            </div>
        </h2>
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

                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_num','顧客番号')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('received_at','契約連番')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('received_at','契約種別')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $contract)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button type="button" onclick="location.href='{{route('contracts.edit',$contract)}}'"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$contract->client->client_num}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$contract->client->client_name}}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$contract->contract_num}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$contract->contractType->contract_type_name}}
                        </td>
                        <td class="py-1">
                            <button type="button" data-modal-target="deleteModal-{{$contract->id}}" data-modal-show="deleteModal-{{$contract->id}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td>
                    </tr>
                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$contract->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$contract->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('contracts.destroy',$contract->id)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" data-modal-hide="deleteModal-{{$contract->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$contract->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        やっぱやめます
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 削除確認モーダル画面 End --}}
                    <!-- 更新drawer --> 
                   
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{-- {{ $contracts->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
        </div> 
    </div>
    @if($contracts->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $contracts->withQueryString()->links('vendor.pagination.custum-tailwind') }}
        </div>
    @endif

<!-- CSV一括登録 modal -->
<div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    CSV一括アップロード
                </h3>
                <button type="button" id="close_button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 mr-20 mt-4">
                <form action="{{ route('supports.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center" id="csv_form1">
                    @csrf
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="csv_upload"></label>
                    <input type="file" name="csv_upload"  id="csv_upload_file"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-s rounded-e cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="csv_upload_help">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" form="csv_form1" id="upload-button"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    アップロード
                </button>
                <button disabled type="button" id="spinner" class="hidden  text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 items-center">
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


{{-- 行がクリックされたときに発火するJavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 各行のクリックイベントを設定
        var rows = document.querySelectorAll('.clickable-row');

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                // 選択された行に 'selected' クラスを追加
                this.classList.toggle('selected');
            });
        });
    });
</script>

{{-- 選択された行に適用されるスタイル --}}
<style>
    .selected {
        background-color: #f0f0f0; /* 任意の背景色 */
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

    // 検索ボタンを押した時の処理
    function searchClient() {
        const clientName = document.getElementById('clientName').value;
        const clientNumber = document.getElementById('clientNumber').value;
        const departmentId = document.getElementById('departmentId').value;

        fetch('/client/search', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ clientName, clientNumber, departmentId })
        })
        .then(response => response.json())
        .then(data => {
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            searchResultsContainer.innerHTML = '';

            data.forEach(result => {
            const resultElement = document.createElement('tr');
            resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
            resultElement.innerHTML = `
                <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_corporation.corporation_name}', '${result.client_num}', '${result.client_name}', '${result.department_id}')">${result.client_name}</td>
                <td class="py-2 ml-2">${result.client_num}</td>
                <td class="py-2 ml-2">${result.department.department_name}</td>
            `;
            searchResultsContainer.appendChild(resultElement);
            });
        });
        }
</script>


</x-app-layout>