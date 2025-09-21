<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
                {{ Breadcrumbs::render('products') }}
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">
                @can('storeUpdate_corporations')
                    <x-buttons.add-button :route="route('products.create')" gate="storeUpdate_clients" :text="__('Add')" />
                @else
                    <button type="button"  class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-blue-800 cursor-not-allowed" disabled>
                        <svg class="h-4 w-4 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('Add') }}
                    </button>
                @endcan
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_corporations')
                                    <button type="button" onclick="location.href='{{ route('products.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
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
                                @can('download_corporations')
                                    {{-- <button type="button" onclick="location.href='{{ route('products.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
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
            <div class="w-full ">
                <form method="GET" action="{{ route('products.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="product_code" name="product_code" value="@if (isset($productCode)){{ $productCode }}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="製品コード">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="product_name" name="product_name" value="@if (isset($productName)){{ $productName }}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="製品名称">
                        </div>

                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="product_type_id" id="product_type_id" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">製品種別</option>
                                @foreach ($productTypes as $productType)
                                <option value="{{ $productType->id }}" @if (isset($productTypeId) && $productTypeId == $productType->id) selected @endif>
                                    {{$productType->type_code}}：{{$productType->type_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="product_split_type_id" id="product_split_type_id" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">製品内訳種別</option>
                                @foreach ($productSplitTypes as $splitType)
                                <option value="{{ $splitType->id }}" @if (isset($splitTypeId) && $splitTypeId == $splitType->id) selected @endif>
                                    {{ $splitType->split_type_code }}：{{ $splitType->split_type_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="product_series_id" id="product_series_id" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">シリーズ</option>
                                @foreach ($productSeriess as $productSeries)
                                <option value="{{ $productSeries->id }}" @if (isset($productSeriesId) && $productSeriesId == $productSeries->id) selected @endif>
                                    {{$productSeries->series_code}}：{{$productSeries->series_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="affiliation2" id="affiliation2" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">管轄事業部</option>
                                @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @if (isset($affiliation2Id) && $affiliation2Id == $affiliation2->id) selected @endif>
                                    {{$affiliation2->affiliation2_prefix}}：{{$affiliation2->affiliation2_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="f_is_stop_selling" id="f_is_stop_selling" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                {{-- <option value="">製品種別</option> --}}
                                <option value=""{{ request('f_is_stop_selling') == '' ? 'selected':'' }}>販売状態全て</option>
                                <option value="0"{{ request('f_is_stop_selling') == '0' ? 'selected':'' }}>販売中</option>
                                <option value="1"{{ request('f_is_stop_selling') == '1' ? 'selected':'' }}>販売停止</option>
                            </select>
                        </div>

                        <div class="flex mt-2 md:mt-0">
                            {{-- <div class="w-full md:ml-2">
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="z-50 flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Filter') }}
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="filterDropdown" class="z-50 hidden w-56 p-3 bg-gray-100 rounded-e rounded-s shadow dark:bg-gray-600">
                                    <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                        製品系統
                                    </h6>
                                    <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                        @foreach ($productCategories as $productCategory)
                                        <li class="flex items-center">
                                            <input id="category-{{ $productCategory->id }}" type="checkbox" name="product_categories[]" @if(in_array($productCategory->id, $selectedProductCategories)) checked @endif value="{{$productCategory->id}}" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                            <label for="category-{{ $productCategory->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $productCategory->category_name }}</label>
                                        </li>                       
                                        @endforeach
                                    </ul>
                                    <ul class="border my-2"></ul>
                                    <div class="form-check mt-3">
                                        <input type="checkbox" id="unreturned_only" name="unreturned_only" value="1" {{ request()->input('unreturned_only') === '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="unreturned_only" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">返却済みも含む</label>
                                    </div>                                    
                                </div>
                            </div> --}}

                            {{-- 検索ボタン --}}
                            <button type="submit" id="search-button" form="search_form" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                            {{-- リセットボタン --}}
                            <button type="button" value="reset" id="clear" form="search-form" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="text-gray-950 md:ml-9 my-2">
        <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
            <div class="ml-4">
                {{ $products->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
            </div>
        </h2>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 mb-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300 js-scrollable">
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
                        <div class="whitespace-nowrap">（選択 <span id="selectedCount">0</span> 件）</div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center w-auto">
                            @sortablelink('product_code','製品コード')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            @sortablelink('product_type_id','内訳種別')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                           @sortablelink('product_series_id','シリーズ')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                           @sortablelink('product_name','製品名称')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                           @sortablelink('unit_price','標準単価')
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            管轄事業部
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ ($products->currentPage() - 1) * $products->perPage() + $loop->index + 1 }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox{{ $product->id }}" type="checkbox" name="selectedIds[]" value="{{ $product->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button type="button" onclick="location.href='{{route('products.edit', $product)}}'"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="pl-1 py-1 whitespace-nowrap">
                            {{$product->product_code}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap w-40">
                            {{$product->productsplittype->split_type_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$product->productSeries->series_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap w-96">
                            {{$product->product_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            <div class="w-[60px] text-right">
                                ￥{{ number_format($product->unit_price, 0, '.', ',')}}
                            </div>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$product->affiliation2->affiliation2_name}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($products->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $products->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div>         
    @endif


<script src="https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js"></script>

<script>
    new ScrollHint('.js-scrollable', {
        i18n: {
        scrollable: "スクロールできます"
    },
    });
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