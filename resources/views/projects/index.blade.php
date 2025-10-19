<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('projects') }}
                {{-- <div class="ml-4 text-sm sm:text-lg">
                    {{ $count }}件
                    {{ number_format($totalAllRevenue) }}円
                    <span class="block md:inline text-sm">({{ number_format($totalRevenue) }}円)</span>
                </div> --}}
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">
                <x-buttons.add-button :route="route('projects.create')" gate="storeUpdate_projects" :text="__('Add')" />
                
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button type="button" onclick="location.href='{{ route('projects.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                        </svg>
                                    </div>
                                    CSVアップロード
                                </button>
                            </li>
                            <li>
                                <button type="button" onclick="location.href='{{ route('corporations.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                        </svg>
                                    </div>
                                    CSVダウンロード
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:ml-14 md:mr-2  shadow-md  dark:text-gray-900 mt-4">
        <div class="flex flex-col items-center justify-between p-4 space-y-3 md:space-y-0 md:space-x-4">
            <div class="w-full">
                <form method="GET" action="{{ route('projects.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col md:flex-row w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                {{-- <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg> --}}
                            </div>
                            <input type="search" id="project_num" name="project_num" value="@if (isset($projectNum)){{$projectNum}}@endif" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="プロジェクト№">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                {{-- <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg> --}}
                            </div>
                            <input type="search" id="project_name" name="project_name" value="@if (isset($projectName)){{$projectName}}@endif" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="プロジェクト名称">
                        </div>
                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                {{-- <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg> --}}
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客/法人名称">
                        </div>

                        <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                            <select name="selected_department" id="selected_department" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">営業担当</option>
                                {{-- @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if($selectedDepartment == $department->id) selected @endif>
                                    {{ $department->department_name }}
                                </option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="relative w-full md:w-1/2 mt-2 md:ml-2 md:mt-0">
                            <select name="accounting_period" id="accounting_period" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded-s rounded-e bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">計上期</option>
                                @foreach ($accountingPeriods as $accountingPeriod)
                                <option value="{{ $accountingPeriod->id }}" @if($selectedAccountingPeriod == $accountingPeriod->id) selected @endif>
                                    {{ $accountingPeriod->period_name }}
                                </option>
                                @endforeach
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
                            <div class="flex flex-col justify-end  w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                <button type="button" onclick="showModal()" class="flex w-auto items-center justify-center md:ms-2 px-4 py-2 text-sm font-medium text-white rounded-sm bg-blue-700 hover:bg-blue-800 focus:ring-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <div class="whitespace-nowrap">{{ __('詳細条件') }}</div>
                                </button>
                                <div class="flex mt-2 md:mt-0">
                                    {{-- 検索ボタン --}}
                                    <button type="submit" id="search-button" form="search_form" class="p-2.5 w-full md:ms-2 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" tabindex="">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                            <span class="md:hidden mx-auto">検索</span>
                                        </div>
                                    </button>
                                    {{-- リセットボタン --}}
                                    <button type="button" value="reset" id="clear" form="search-form" class="p-2.5 w-full ms-2 text-sm font-medium text-white bg-gray-500 rounded border border-gray-500 dark:border-gray-500 hover:bg-gray-600 focus:ring-2 focus:outline-none dark:bg-gray-500 dark:hover:bg-gray-700 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" tabindex="">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                            </svg>
                                            <span class="md:hidden mx-auto">リセット</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 詳細検索 Modal -->
                    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center overflow-y-scroll z-50 hidden animate-slide-in-top">
                        <div class="max-h-full w-full max-w-3xl">
                            <!-- Modal content -->
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
                                <div class="grid gap-3 mb-4 sm:grid-cols-3">
                                    <div class="w-full flex flex-col mx-2">
                                        <label for="clientName" class="dark:text-white text-sm text-gray-900 leading-none mt-4">計上年月（From）</label>
                                        <input type="month" name="clientName" id="clientName" class="mt-1 w-full p-2 pl-4 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" tabindex="1">
                                    </div>
                                    <div class="w-full flex flex-col mx-2">
                                        <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-4">計上年月（To）</label>
                                        <input type="month" name="clientNumber" id="clientNumber" class="mt-1 w-full p-2 pl-4 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" tabindex="1">
                                    </div>
                                </div>

                                <label for="" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">営業段階</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    @foreach ($salesStages as $salesStage)
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" name="sales_stage_ids[]" value="{{ $salesStage->id }}" @checked(in_array($salesStage->id, $filters['sales_stage_ids'] ?? [])) id="salesStage-{{ $salesStage->id }}" class="sr-only peer" tabindex="1">
                                            <label for="salesStage-{{ $salesStage->id }}" class="inline-flex justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600 border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600 bg-white dark:peer-checked:bg-blue-500 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600 focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 dark:peer-focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <div class="w-full text-sm font-medium text-center">{{ $salesStage->sales_stage_name }}</div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                <label for="" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">プロジェクト種別</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    @foreach ($projectTypes as $projectType)
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" name="project_type_ids[]" value="{{ $projectType->id }}" @checked(in_array($projectType->id, $filters['project_type_ids'] ?? [])) id="projectType-{{ $projectType->id }}" value="" class="sr-only peer" tabindex="1">
                                            <label for="projectType-{{ $projectType->id }}" class="inline-flex  justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600   border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600   bg-white dark:peer-checked:bg-blue-500  hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600 focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 dark:peer-focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <div class="w-full text-sm font-medium text-center">{{ $projectType->project_type_name }}</div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                <label for="" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">計上種別</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    @foreach ($accountingTypes as $accountingType)
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" name="accounting_type_ids[]" value="{{ $accountingType->id }}" @checked(in_array($accountingType->id, $filters['accounting_type_ids'] ?? [])) id="accountingType-{{ $accountingType->id }}" class="sr-only peer" tabindex="1">
                                            <label for="accountingType-{{ $accountingType->id }}" class="inline-flex justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600 border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600 bg-white dark:peer-checked:bg-blue-500 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600 focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 dark:peer-focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <div class="w-full text-sm font-medium text-center">{{ $accountingType->accounting_type_name }}</div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>


                                <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">請求種別</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    <li class="flex justify-center items-center">
                                        <input type="checkbox" id="first-billing" value="" class="hidden peer">
                                        <label for="first-billing" class="inline-flex  justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600   border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600   bg-white dark:peer-checked:bg-blue-500  hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600">
                                            <div class="w-full text-sm font-medium text-center">一括請求</div>
                                        </label>
                                    </li>
                                    <li class="flex justify-center items-center">
                                        <input type="checkbox" id="second-billing" value="" class="hidden peer">
                                        <label for="second-billing" class="inline-flex  justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600   border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600   bg-white dark:peer-checked:bg-blue-500  hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600">
                                            <div class="w-full text-sm font-medium text-center">分割請求</div>
                                        </label>
                                    </li>
                                </ul>

                                <label for="" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">計上所属</label>
                                <div class="grid gap-2 mb-4 md:grid-cols-1 p-2 rounded bg-gray-400 md:ml-2">
                                    <div class="relative w-full mt-2 md:mt-0">
                                        <select name="product_category_id" id="product_category_id" class="mt-1 w-full p-2 pl-4 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-400 transition ease-in-out duration-150 placeholder:text-gray-400" tabindex="1">
                                            <option value="">所属1</option>
                                            @foreach ($affiliation1s as $affiliation1)
                                            <option value="{{ $affiliation1->id }}" @if (isset($affiliation1Id) && $affiliation1Id == $affiliation1->id) selected @endif>
                                                {{ $affiliation1->affiliation1_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="relative w-full mt-2 md:mt-0">
                                        <select name="product_category_id" id="product_category_id" class="block w-full p-2 pl-4 rounded text-sm text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-600 focus:border-blue-500 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-400 transition ease-in-out duration-150" tabindex="1">
                                            <option value="">所属2</option>
                                            @foreach ($affiliation2s as $affiliation2)
                                            <option value="{{ $affiliation2->id }}" @if (isset($affiliation2Id) && $affiliation2Id == $affiliation2->id) selected @endif>
                                                {{ $affiliation2->affiliation2_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    
                                <!-- Modal footer -->
                                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        検索
                                    </button>
                                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        閉じる
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                <button type="button" onclick="location.href='{{ route('projects.create') }}'" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    {{ __('Add') }}
                </button>
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('Actions') }}
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button type="button" onclick="location.href='{{ route('projects.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                        </svg>
                                    </div>
                                    CSVアップロード
                                </button>
                            </li>
                            <li>
                                <button type="button" onclick="location.href='{{ route('corporations.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2m-1-5-4 5-4-5m9 8h0"/>
                                        </svg>
                                    </div>
                                    CSVダウンロード
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="flex items-center">
        <div class="text-gray-950 md:ml-9 my-2">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
                <div class="ml-4">
                    {{ $projects->withQueryString()->links('vendor.pagination.custom-tailwind') }}  
                </div>
            </h2>
        </div>
    </div>
            <div class="text-gray-950 md:ml-16 mb-2">
            <h2 class="md:font-semibold md:text-lg text-sm text-gray-900 dark:text-white flex items-center">
                <div class="text-gray-900 dark:text-white ml-2">
                    <div>{{ number_format($totalAllRevenue) }}円（{{ number_format($totalRevenue) }}円）</div>
                </div>
            </h2>
        </div>

    <div class="md:w-auto md:ml-14 md:mr-2 mb-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300">
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
                            @sortablelink('project_num','プロジェクト№')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            @sortablelink('corporation_kana_name','顧客名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            @sortablelink('project_name','プロジェクト名称')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            @sortablelink('sales_stage_id','営業段階')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap text-right">
                            案件金額
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            営業担当
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            商流
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 w-auto">
                        <div class="flex items-center whitespace-nowrap">
                            PJ種別
                        </div>
                    </th>
                    {{-- <th scope="col" class="px-1 py-3 w-auto">
                        <span class="sr-only">削除</span>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                        <td class="pl-4 py-1 whitespace-nowrap">
                            {{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->index + 1 }}
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox{{ $project->id }}" type="checkbox" name="selectedIds[]" value="{{ $project->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-4 py-1 whitespace-nowrap">
                            <button type="button" onclick="location.href='{{route('projects.edit',$project)}}'"  class="button-edit-primary">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    <span class=" md:block hidden">編集</span>
                                </div>
                            </button>
                        </td>
                        <td class="pl-1 py-1 whitespace-nowrap">
                            {{$project->project_num}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->client->client_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->project_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->salesStage->sales_stage_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            <div class="w-[75px] text-right">
                                {{ number_format($project->totalAmount) }}
                            </div>
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->accountUser->user_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->distributionType->distribution_type_name}}
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap">
                            {{$project->projectType->project_type_name}}
                        </td>
                        {{-- <td class="py-1">
                            <button type="button" data-modal-target="deleteModal-{{$project->id}}" data-modal-show="deleteModal-{{$project->id}}" class="button-delete-primary">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-ms ">削除</span>
                                </div>
                            </button>
                        </td> --}}
                    </tr>
                    {{-- 削除確認モーダル画面 Start --}}
                    <div id="deleteModal-{{$project->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                <button data-modal-hide="deleteModal-{{$project->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                    <form action="{{route('projects.destroy',$project->id)}}" method="POST" class="text-center m-auto">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" data-modal-hide="deleteModal-{{$project->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                            削除
                                        </button>
                                    </form>
                                    <button data-modal-hide="deleteModal-{{$project->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        やっぱやめます
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($projects->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $projects->withQueryString()->links('vendor.pagination.custom-tailwind') }}
        </div>
    @endif

    <style>
        .active {
            text-decoration: underline
        }
    </style>






    <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
    
            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }
    
        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
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