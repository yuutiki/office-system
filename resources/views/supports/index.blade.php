<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
                {{ Breadcrumbs::render('supports') }}
                <div class="ml-4">
                    {{ $count }}件
                </div>
                <div class="text-gray-900 dark:text-white ml-4 text-base hidden md:block">
                    - 選択中: <span id="selectedCount">0</span> 件
                </div>
            </h2>
            <x-message :message="session('message')" />
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">

                <x-buttons.add-button :route="route('supports.create')" gate="storeUpdate_supports" :text="__('Add')" />

                <div class="items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded md:w-auto hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('Actions') }}
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_clients')
                                    <button type="button" onclick="location.href='{{ route('supports.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
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
                                @can('download_clients')
                                    {{-- <button type="button" onclick="location.href='{{ route('clients.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                            </svg>
                                        </div>
                                        CSVダウンロード
                                    </button> --}}
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
                            <input type="search" id="keywords" name="keywords" value="@if (isset($keywords)){{$keywords}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="キーワード（表題） 営業担当 バージョン">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="顧客名称/カナ名称/№">
                        </div>

                        <div id="user-dropdown" class="relative w-full md:ml-2 mt-2 md:mt-0">
                            <input type="hidden" id="selected-user-id" name="selected_user_id" value="{{ $selectedUserId }}">
                            <button type="button" id="dropdown-toggle" class="block w-full p-2 pl-4 text-sm text-left text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400">
                                <span id="selected-user-display" class="text-gray-800 dark:text-white whitespace-nowrap">
                                    @if($selectedUser)
                                        {{ $selectedUser->user_name }}
                                    @else
                                        <span>受付対応者</span><span class="text-gray-400 ml-2">を選択</span>
                                    @endif
                                </span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                            <div id="dropdown-menu" class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg hidden">
                                <div class="p-2">
                                    <input id="user-search" type="text" name="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-800 dark:text-white" placeholder="ユーザーを検索...">
                                </div>
                                <ul id="user-list" class="max-h-60 overflow-auto dark:text-white text-gray-700 hover:dark:text-white">
                                    <!-- ユーザーリストはJavaScriptで動的に追加されます -->
                                    <script src="{{ asset('assets/js/user-dropdown.js') }}"></script>
                                </ul>
                            </div>
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
                        <div id="detailSearchModal" tabindex="-1" class="fixed inset-0 items-center justify-center overflow-y-scroll z-50 hidden animate-slide-in-top overscroll-contain">
                            <div class="max-h-full w-full max-w-7xl">
                                <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-1 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-400">
                                            詳細検索画面
                                        </h3>
                                        <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                            <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="grid gap-3 mb-4 sm:grid-cols-3">
                                        <div class="w-full flex flex-col mx-2">
                                            <label for="received_at_from" class="dark:text-white text-sm text-gray-900 leading-none mt-4">受付日（From）</label>
                                            <input type="date" min="1900-01-01" max="3000-12-31" name="received_at_from" value="{{ $receivedAtFrom }}" id="received_at_from" class="input-secondary" tabindex="1">
                                        </div>
                                        <div class="w-full flex flex-col mx-2">
                                            <label for="received_at_to" class="dark:text-white text-sm text-gray-900 leading-none mt-4">受付日（To）</label>
                                            <input type="date" min="1900-01-01" max="3000-12-31" name="received_at_to" value="{{ $receivedAtTo }}" id="received_at_to" class="input-secondary" tabindex="1">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="status_id" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">ステータス</label>
                                        <ul class="grid w-full gap-3 lg:grid-cols-4 grid-cols-2 md:ml-2 mb-4">
                                            <li class="flex justify-center items-center">
                                                <input type="checkbox" id="status_id-1"  @checked(in_array(1, $statusIds ?? []))  value="1" name="status_ids[]" class="hidden peer touch-none">
                                                <label for="status_id-1" class="checkbox-label">
                                                    <div class="w-full text-sm font-medium text-center">{{ __('下書き') }}</div>
                                                </label>
                                            </li>
                                            <li class="flex justify-center items-center">
                                                <input type="checkbox" id="status_id-2"  @checked(in_array(0, $statusIds ?? []))  value="0" name="status_ids[]" class="hidden peer touch-none">
                                                <label for="status_id-2" class="checkbox-label">
                                                    <div class="w-full text-sm font-medium text-center">{{ __('入力完了') }}</div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-4">
                                        <label for="supportType" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">サポート種別</label>
                                        <ul class="grid w-full gap-3 lg:grid-cols-4 grid-cols-2 md:ml-2 mb-4">
                                            @foreach ($supportTypes as $supportType)
                                                <li class="flex justify-center items-center">
                                                    <input type="checkbox" id="supportType-{{ $supportType->id }}" 
                                                        @checked(in_array($supportType->id, $selectedSupportTypes ?? [])) 
                                                        value="{{ $supportType->id }}" 
                                                        name="support_types[]" 
                                                        class="hidden peer touch-none">
                                                    <label for="supportType-{{ $supportType->id }}" class="checkbox-label">
                                                        <div class="w-full text-sm font-medium text-center">{{ $supportType->type_name }}</div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <label for="productCategory" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">製品系統</label>
                                        <ul class="grid w-full gap-3 lg:grid-cols-4 grid-cols-2 md:ml-2 mb-4">
                                            @foreach ($productCategories as $productCategory)
                                                <li class="flex justify-center items-center">
                                                    <input type="checkbox" id="category-{{ $productCategory->id }}" 
                                                        @checked(in_array($productCategory->id, $selectedProductCategories ?? [])) 
                                                        value="{{ $productCategory->id }}"  name="product_categories[]" class="hidden peer touch-none">
                                                    <label for="category-{{ $productCategory->id }}" class="checkbox-label">
                                                        <div class="w-full text-sm font-medium text-center">{{ $productCategory->category_name }}</div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <label for="productSeries" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">製品シリーズ</label>
                                        <ul class="grid w-full gap-3 lg:grid-cols-4 grid-cols-2 md:ml-2 mb-4">
                                            @foreach ($productSeriess as $productSeries)
                                                <li class="flex justify-center items-center">
                                                    <input type="checkbox" id="series-{{ $productSeries->id }}" 
                                                        @checked(in_array($productSeries->id, $selectedProductSeriess ?? [])) 
                                                        value="{{ $productSeries->id }}" name="product_seriess[]" class="hidden peer touch-none">
                                                    <label for="series-{{ $productSeries->id }}" class="checkbox-label">
                                                        <div class="w-full text-sm font-medium text-center">{{ $productSeries->series_name }}</div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>



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

    <div class="md:w-auto md:ml-14 md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
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
                            @sortablelink('is_draft','ステータス')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client.client_num','顧客№')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client.client_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="pl-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('received_at','受付日')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('support_type_id','種別')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('title','表題')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('user_id','受付対応者')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_series_id','シリーズ')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_version_id','バージョン')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('product_category_id','系統')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @sortablelink('client_user_kana_name','営業担当')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                            </svg>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supports as $support)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 font-normal hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox{{ $support->id }}" type="checkbox" name="selectedIds[]" value="{{ $support->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button type="button" onclick="location.href='{{route('supports.edit',$support)}}'"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap mr-2">
                            @if($support->is_draft)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                    下書き
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    入力完了
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $support->client ? $support->client->client_num : '---' }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ $support->client ? $support->client->client_name : '---' }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ $support->received_at }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap font-medium">
                            {{ optional($support->supportType)->type_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap font-semibold">
                            {{ Str::limit($support->title, 80, '...') }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ optional($support->user)->user_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap mr-2">
                            {{ optional($support->productSeries)->series_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ optional($support->productVersion)->version_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ optional($support->productCategory)->category_name }}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{ optional($support->client->user)->user_name }}
                        </td>
                        {{-- <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit" type="button" data-drawer-target="dupdateModal-{{ $support->id}}" data-drawer-body-scrolling="false" data-drawer-show="dupdateModal-{{ $support->id}}" data-drawer-placement="right" aria-controls="dupdateModal-{{ $support->id}}">
                                    <div class="flex">
                                        <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                        </svg>
                                        <span class="text-ms">編集</span>
                                    </div>
                                </button>
                            </div>
                        </td> --}}
                        <td class="py-1">
                            <button type="button" data-modal-target="deleteModal-{{ $support->id}}" data-modal-show="deleteModal-{{ $support->id}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td>
                    </tr>
                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('supports.destroy',$support->id)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        やっぱやめます
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 削除確認モーダル画面 End --}}
                    <!-- 更新drawer --> 
                    {{-- <div id="dupdateModal-{{$support->id}}" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform md:w-1/2 translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal-{{$support->id}}">
                        <div class="">
                            <h5 id="dupdateModal-{{$support->id}}" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
                                サポート詳細
                            </h5>
                            <button type="button" data-drawer-hide="dupdateModal-{{$support->id}}" aria-controls="dupdateModal-{{$support->id}}" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <form id="updateForm-{{$support->id}}" method="POST" action="{{ route('supports.update', $support->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid  gap-4 my-4 md:grid-cols-4">
                                <div class="relative z-0">
                                    <input type="text" id="client_num" name="client_num" value="{{ $support->client->client_num }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="client_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">顧客番号</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="client_name" name="client_name" value="{{ $support->client->client_name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="client_name" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">顧客名称</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="sales_person" name="sales_person" value="{{ $support->client->user->user_name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="sales_person" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">営業担当</label>
                                </div>

                                <div class="relative z-0">
                                    <input type="text" id="affiliation2_id" name="affiliation2_id" value="{{ $support->client->affiliation2->affiliation2_name }}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                                    <label for="affiliation2_id" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">管轄事業部</label>
                                </div>
                            </div>

                            <div class="w-full flex flex-col col-span-2 mt-4">
                                <label for="title-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">表題</label>
                                <input type="text" maxlength="100" name="title_{{$support->id}}" id="title-{{$support->id}}" value="{{old('title' . $support->id, $support->title)}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                            </div>
                            @error('title_' . $support->id)
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <div class="grid gap-4 my-4 md:grid-cols-4">
                                <div class="w-full flex flex-col">
                                    <label for="received_at-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">受付日</label>
                                    <input type="date" maxlength="20" name="received_at_{{$support->id}}" id="received_at-{{$support->id}}" value="{{ old('received_at_' . $support->id, $support->received_at) }}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                                </div>
                                @error('received_at_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror

                                <div class="w-full flex flex-col">
                                    <label for="user_id" class="block font-medium text-gray-900 dark:text-white">受付対応者</label>
                                    <select name="user_id_{{$support->id}}" id="user_id-{{$support->id}}" value="{{old('user_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"  @selected($user->id == $support->user_id)>{{ $user->user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="request_content-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">内容</label>
                                <textarea name="request_content_{{$support->id}}" id="request_content-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('request_content_' . $support->id , $support->request_content) }}</textarea>
                                @error('request_content_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="response_content-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">回答</label>
                                <textarea name="response_content_{{$support->id}}" id="response_content-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('response_content_' . $support->id , $support->response_content) }}</textarea>
                                @error('response_content_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="internal_message-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">社内連絡欄</label>
                                <textarea name="internal_message_{{$support->id}}" id="internal_message-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('internal_message_' . $support->id , $support->internal_message) }}</textarea>
                                @error('internal_message_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="internal_memo1-{{$support->id}}" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">メモ欄</label>
                                <textarea name="internal_memo1_{{$support->id}}" id="internal_memo1-{{$support->id}}" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('internal_memo1_' . $support->id , $support->internal_memo1) }}</textarea>
                                @error('internal_memo1_' . $support->id)
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid gap-4 my-4 md:grid-cols-2">
                                <div class="w-full flex flex-col">
                                    <label for="support_type_id" class="block font-medium text-gray-900 dark:text-white">サポート種別</label>
                                    <select name="support_type_id_{{$support->id}}" id="support_type_id-{{$support->id}}" value="{{old('support_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($supportTypes as $supportType)
                                        <option value="{{ $supportType->id }}"  @selected($supportType->id == $support->support_type_id)>{{ $supportType->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_type_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror

                                <div class="w-full flex flex-col">
                                    <label for="support_time_id" class="block font-medium text-gray-900 dark:text-white">サポート時間</label>
                                    <select name="support_time_id_{{$support->id}}" id="support_time_id-{{$support->id}}" value="{{old('support_time_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($supportTimes as $supportTime)
                                        <option value="{{ $supportTime->id }}"  @selected($supportTime->id == $support->support_time_id)>{{ $supportTime->time_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_time_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="grid gap-4 my-4 md:grid-cols-3">
                                <div class="w-full flex flex-col">
                                    <label for="product_series_id" class="block font-medium text-gray-900 dark:text-white">製品シリーズ</label>
                                    <select name="product_series_id_{{$support->id}}" id="product_series_id-{{$support->id}}" value="{{old('product_series_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productSeriess as $productSeries)
                                        <option value="{{ $productSeries->id }}"  @selected($productSeries->id == $support->product_series_id)>{{ $productSeries->series_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_series_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                                <div class="w-full flex flex-col">
                                    <label for="product_version_id" class="block font-medium text-gray-900 dark:text-white">製品バージョン</label>
                                    <select name="product_version_id_{{$support->id}}" id="product_version_id-{{$support->id}}" value="{{old('product_version_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productVersions as $productVersion)
                                        <option value="{{ $productVersion->id }}"  @selected($productVersion->id == $support->product_version_id)>{{ $productVersion->version_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_version_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                                <div class="w-full flex flex-col">
                                    <label for="product_category_id" class="block font-medium text-gray-900 dark:text-white">製品系統</label>
                                    <select name="product_category_id_{{$support->id}}" id="product_category_id-{{$support->id}}" value="{{old('product_category_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @foreach($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}"  @selected($productCategory->id == $support->product_category_id)>{{ $productCategory->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_category_id_' . $support->id)
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </div>
                            <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_finished)
                                            <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_finished_{{ $support->id }}" name="is_finished_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_finished_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                                    </div>
                                    @error('is_finished_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_faq_target1_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_faq_target === 1)
                                            <input id="is_faq_target_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="checkbox" checked="checked" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_faq_target_{{ $support->id }}" name="is_faq_target_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_faq_target_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                                    </div>
                                    @error('is_faq_target_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_disclosured1_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_disclosured === 1)
                                            <input id="is_disclosured_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_disclosured_{{ $support->id }}" name="is_disclosured_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_disclosured_{{ $support->id }}" class="cursor-pointer    w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                                    </div>
                                    @error('is_disclosured_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_troubled1_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_troubled === 1)
                                            <input id="is_troubled_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @else
                                            <input id="is_troubled_{{ $support->id }}" name="is_troubled_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_troubled_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                                    </div>
                                    @error('is_troubled_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                                <li class="w-full dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="is_confirmed1_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @if($support->is_confirmed === 1)
                                            <input id="is_confirmed_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" >
                                        @else
                                            <input id="is_confirmed_{{ $support->id }}" name="is_confirmed_{{ $support->id }}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        @endif
                                        <label for="is_confirmed_{{ $support->id }}" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">上長確認済</label>
                                    </div>
                                    @error('is_confirmed_' . $support->id)
                                     <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </li>
                            </ul>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="button" onclick="submitAndUpdateDrawer({{$support->id}})" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('Update') }}
                                </button>
                                <button type="button" data-modal-target="deleteModal-{{$support->id}}" data-modal-show="deleteModal-{{$support->id}}" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </form>
                    </div> --}}
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{ $supports->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>



{{-- <script>
    function submitAndUpdateDrawer(supportId) {
        // 保存処理（ここではLocalStorageを使用）
        localStorage.setItem('updateDrawerId', supportId);

        // フォームのsubmit
        document.getElementById('updateForm-' + supportId).submit();
    }
</script>

<!-- バリデーションエラー時にDrawerを開くスクリプト -->
@if ($errors->any())
    <style>
        /* オーバーレイのスタイルを定義 */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* グレーで透過させる */
            /* z-index: 40; Drawerよりも大きな値 */
        }
    </style>
    <script>
        // ページ遷移後に初回のみ実行するための変数
        let isValidationProcessed = false;

        document.addEventListener('DOMContentLoaded', function () {
            let drawerId = localStorage.getItem('updateDrawerId');
            
            // ページ遷移後初回のみ実行
            if (!isValidationProcessed && drawerId !== null) {
                // オーバーレイを作成
                const overlay = document.createElement('div');
                overlay.classList.add('overlay'); // オーバーレイのクラスを追加
                document.body.appendChild(overlay); // bodyに追加

                // Drawerを表示
                const drawer = document.getElementById('dupdateModal-' + drawerId);
                drawer.classList.remove('translate-x-full');
                localStorage.removeItem('updateDrawerId');
                console.log(drawerId);
                
                // 変数をtrueに設定して初期化を行わないようにする
                isValidationProcessed = true;

                // bodyにoverflow-hiddenクラスを追加
                document.body.classList.add('overflow-hidden');

                // Drawerのz-indexよりも大きな値を設定
                const drawerZIndex = getComputedStyle(drawer).zIndex;
                const overlayZIndex = parseInt(drawerZIndex) - 1;
                overlay.style.zIndex = overlayZIndex;

                // オーバーレイをクリックしたときに閉じる
                overlay.addEventListener('click', function () {
                    closeDrawer();
                });

                // ボタンをクリックしたときにも閉じる
                const closeButton = document.querySelector('[data-drawer-hide="dupdateModal-' + drawerId + '"]');
                if (closeButton) {
                    closeButton.addEventListener('click', function () {
                        closeDrawer();
                    });
                }

                function closeDrawer() {
                    // Drawerを非表示にする
                    drawer.classList.add('translate-x-full');
                    
                    // オーバーレイを削除する
                    overlay.remove();
                    
                    // bodyのoverflow-hiddenクラスを削除
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });
    </script>
@endif --}}



{{-- 行がクリックされたときに発火するJavaScript --}}
{{-- <script>
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
</script> --}}

{{-- 選択された行に適用されるスタイル --}}
{{-- <style>
    .selected {
        background-color: #f0f0f0; /* 任意の背景色 */
    }
</style> --}}

<script>
    const overlay = document.getElementById('overlay');
    const modal = document.getElementById('detailSearchModal');

    // モーダルを表示するための関数
    function showModal() {
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // モーダルを非表示にするための関数
    function hideModal() {
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

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
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white');
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer"
                        onclick="setClient(
                            '${result.client_corporation?.corporation_name ?? ''}',
                            '${result.client_num}',
                            '${result.client_name}',
                            '${result.department_id}'
                        )">
                        ${result.client_name}
                    </td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department?.department_name ?? ''}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
            });
        });
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


{{-- <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script> --}}
</x-app-layout>