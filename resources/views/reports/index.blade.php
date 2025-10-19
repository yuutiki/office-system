<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('reports') }}
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">
                @can('storeUpdate_corporations')
                    <x-buttons.add-button :route="route('reports.create')" gate="storeUpdate_reports" :text="__('Add')" />
                @else
                    <button type="button" onclick="location.href='{{ route('reports.create') }}'" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-blue-800 cursor-not-allowed" disabled>
                        <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        <div class="hidden sm:block">{{ __('Add') }}</div>
                    </button>
                @endcan
                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                        {{-- {{ __('Actions') }} --}}
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
                <form method="GET" action="{{ route('reports.index') }}" id="search_form" class="flex items-center">
                    @csrf
                    <div class="flex flex-col lg:flex-row w-full">

                        <div class="relative w-full mt-2 lg:mr-2 lg:mt-0">
                            <div class="absolute inset-y-0 flex items-center pl-3">
                                <x-icon name="ui/search" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                            </div>
                            <input type="search" id="keywords" name="keywords" value="@if(isset($keywords)){{ $keywords }}@endif" class="input-search" placeholder="キーワード">
                        </div>


                        {{-- <div class="relative w-full mt-2 lg:ml-2 lg:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="client_name" name="client_name" value="@if (isset($clientName)){{$clientName}}@endif" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="顧客名称（カナ）">
                        </div>
                        <div class="relative w-full mt-2 lg:ml-2 lg:mt-0">
                            <select name="selected_department" id="selected_department" class="block w-full p-2 pl-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0"  @if($selectedDepartment == 0) selected @endif>管轄事業部</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if($selectedDepartment == $department->id) selected @endif>
                                    {{ $department->department_name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}


                        <div id="user-dropdown" class="relative w-full lg:mr-2 lg:mt-0">
                            <input type="hidden" id="selected-user-id" name="selected_user_id" value="{{ $selectedUserId }}">
                            <button type="button" id="dropdown-toggle" class="w-full px-4 py-1.5 my-2 lg:my-0 text-left bg-gray-100  dark:bg-gray-700 border border-gray-400 dark:border-gray-600 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                                <span id="selected-user-display" data-default-main="営業担当" data-default-sub="を選択" class="text-gray-800 dark:text-white whitespace-nowrap">
                                    @if($selectedUserId)
                                        {{ $user->find($selectedUserId)->user_name ?? '営業担当を選択' }}
                                    @else
                                        <span>営業担当</span><span class="text-gray-400 ml-3">を選択</span>
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
                                    <input id="user-search" type="text" name="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-800 dark:text-white" placeholder="営業担当を検索...">
                                </div>
                                <ul id="user-list" class="max-h-60 overflow-auto dark:text-white text-gray-700 hover:dark:text-white">
                                    <!-- ユーザーリストはJavaScriptで動的に追加されます -->
                                    {{-- <script src="{{ asset('assets/js/user-dropdown.js') }}"></script> --}}
                                </ul>
                            </div>
                        </div>

                        <div class="flex mt-2 md:mt-0">
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

                                {{-- <label for="" class="dark:text-white text-sm text-gray-900 leading-none mt-1 mx-2">営業段階</label>
                                <ul class="grid w-full gap-3 md:grid-cols-3 sm:grid-cols-2 md:ml-2 mb-4">
                                    @foreach ($salesStages as $salesStage)
                                        <li class="flex justify-center items-center">
                                            <input type="checkbox" name="sales_stage_ids[]" value="{{ $salesStage->id }}" @checked(in_array($salesStage->id, $filters['sales_stage_ids'] ?? [])) id="salesStage-{{ $salesStage->id }}" class="sr-only peer" tabindex="1">
                                            <label for="salesStage-{{ $salesStage->id }}" class="inline-flex justify-between w-full p-2 rounded-lg cursor-pointer text-blue-600 dark:text-blue-500 dark:hover:text-white dark:peer-checked:text-white peer-checked:text-gray-600 border-2 border-gray-200 dark:border-blue-500 peer-checked:border-blue-500 peer-checked:hover:border-blue-500 dark:hover:border-blue-600 bg-white dark:peer-checked:bg-blue-500 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-blue-600 focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 dark:peer-focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <div class="w-full text-sm font-medium text-center">{{ $salesStage->sales_stage_name }}</div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul> --}}
                                    
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
                </form>
            </div>
        </div>
    </div>

    <div class="text-gray-950 md:ml-9 my-2">
        <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex items-center">
            <div class="ml-4">
                {{ $reports->withQueryString()->links('vendor.pagination.custom-tailwind') }}  
            </div>
        </h2>
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300">

        @if($reports->isEmpty())
            @if (collect(request()->except('page'))->filter()->isNotEmpty())
                {{-- 検索結果なしの表示 --}}
                <div class="flex flex-col items-center justify-center py-10">
                    <p class="text-gray-500 dark:text-white text-lg mt-4">検索条件に一致するデータが見つかりませんでした</p>
                    <a href="{{ route('reports.index') }}" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        検索条件をリセット
                    </a>
                </div>
            @else
                {{-- 初期データなしの表示 --}}
                <div class="flex flex-col items-center justify-center py-10">
                    <p class="text-gray-500 dark:text-white text-lg mt-4">まだデータがありません</p>
                    <a href="{{ route('reports.create') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        新規追加
                    </a>
                </div>
            @endif
        @else
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
                            <div class="flex items-center">
                                @sortablelink('is_draft','ステータス')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                            </div>
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
                        {{-- @can('managerOrAbobe')
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">
                            <span class="sr-only">削除</span>
                        </th>
                        @endcan --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                            <td class="pl-4 py-1 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>
                            <td class="pl-4 py-1 whitespace-nowrap">
                                <div class="flex items-center">
                                    <input id="checkbox{{ $report->id }}" type="checkbox" name="selectedIds[]" value="{{ $report->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                </div>
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
                                        <span class="text-ms">確認</span>
                                    </div>
                                </button>
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap mr-2">
                                @if($report->is_draft)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                        下書き
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                        報告済み
                                    </span>
                                @endif
                            </td>
                            <td class="px-1 py-1 text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $report->contact_at }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{ optional($report->reportType)->report_type_name }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{ $report->client->client_num }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{ $report->client->client_name }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{ $report->report_title }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap">
                                {{ $report->reporter->user_name }}
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
                            {{-- <td class="py-1">
                                <button type="button" data-modal-target="deleteModal-{{$report->id}}" data-modal-show="deleteModal-{{$report->id}}" class="button-delete-primary">
                                    <div class="flex">
                                        <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        <span class="text-ms ">削除</span>
                                    </div>
                                </button>
                            </td> --}}
                        </tr>
                        {{-- 削除確認モーダル画面 Start --}}
                        {{-- <div id="deleteModal-{{$report->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                                            <button type="submit" data-modal-hide="deleteModal-{{$report->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                削除
                                            </button>
                                        </form>
                                        <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            やっぱやめます
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- 削除確認モーダル画面 End --}}
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @if($reports->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $reports->withQueryString()->links('vendor.pagination.custom-tailwind') }}
        </div>
    @endif

<script src="{{ asset('assets/js/user-dropdown.js') }}"></script>









<script>
    // モーダル管理クラス
class ModalController {
    constructor(modalId, overlayId) {
        this.modal = document.getElementById(modalId);
        this.overlay = document.getElementById(overlayId);
        
        if (!this.modal || !this.overlay) {
            throw new Error('Modal or overlay element not found');
        }

        this.bindEvents();
    }

    bindEvents() {
        // ESCキーでモーダルを閉じる
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.hide();
            }
        });

        // オーバーレイクリックでモーダルを閉じる
        this.overlay.addEventListener('click', () => this.hide());

        // モーダル内のクローズボタンの処理
        const closeButtons = this.modal.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => this.hide());
        });
    }

    show() {
        document.body.classList.add('overflow-hidden');
        this.overlay.classList.remove('hidden');
        this.modal.classList.remove('hidden');
        
        // カスタムイベントの発火
        this.modal.dispatchEvent(new CustomEvent('modal:shown'));
    }

    hide() {
        document.body.classList.remove('overflow-hidden');
        this.overlay.classList.add('hidden');
        this.modal.classList.add('hidden');

        // カスタムイベントの発火
        this.modal.dispatchEvent(new CustomEvent('modal:hidden'));
    }

    // モーダルの表示状態を切り替える
    toggle() {
        if (this.modal.classList.contains('hidden')) {
            this.show();
        } else {
            this.hide();
        }
    }

    // モーダルの表示状態を取得
    isVisible() {
        return !this.modal.classList.contains('hidden');
    }
}

// 検索機能クラス
class SearchController {
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        this.endpoint = options.endpoint || '/client/search';
        this.method = options.method || 'POST';
        
        if (!this.form) {
            throw new Error('Search form not found');
        }

        this.setupEventListeners();
    }

    setupEventListeners() {
        // フォームのサブミット時の処理
        this.form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.handleSearch(new FormData(this.form));
        });

        // リセットボタンの処理
        const resetButton = this.form.querySelector('[data-action="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', () => this.resetForm());
        }
    }

    async handleSearch(formData) {
        try {
            const response = await this.search(formData);
            this.handleSearchResponse(response);
        } catch (error) {
            this.handleSearchError(error);
        }
    }

    async search(formData) {
        const params = Object.fromEntries(formData);
        
        try {
            const response = await fetch(this.endpoint, {
                method: this.method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(params)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Search error:', error);
            throw error;
        }
    }

    handleSearchResponse(response) {
        // 検索結果の処理（オーバーライド可能）
        console.log('Search results:', response);
    }

    handleSearchError(error) {
        // エラー処理（オーバーライド可能）
        console.error('Search error:', error);
    }

    resetForm() {
        this.form.reset();
        // カスタムイベントの発火
        this.form.dispatchEvent(new CustomEvent('search:reset'));
    }
}

// 初期化
document.addEventListener('DOMContentLoaded', () => {
    // モーダルの初期化
    const detailSearchModal = new ModalController('detailSearchModal', 'overlay');

    // // 検索コントローラーの初期化
    // const searchController = new SearchController('search_form', {
    //     endpoint: '/client/search',
    //     method: 'POST'
    // });

    // // 検索コントローラーの検索結果ハンドラーをカスタマイズ
    // Object.assign(searchController, {
    //     handleSearchResponse(results) {
    //         const searchResultsContainer = document.getElementById('searchResultsContainer');
    //         if (!searchResultsContainer) return;

    //         searchResultsContainer.innerHTML = '';
            
    //         results.forEach(result => {
    //             const row = this.createResultRow(result);
    //             searchResultsContainer.appendChild(row);
    //         });
    //     },

    //     createResultRow(result) {
    //         const row = document.createElement('tr');
    //         row.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white');
            
    //         row.innerHTML = `
    //             <td class="py-2 pl-5 cursor-pointer">${result.client_name}</td>
    //             <td class="py-2 ml-2">${result.client_num}</td>
    //             <td class="py-2 ml-2">${result.department?.department_name || ''}</td>
    //         `;

    //         return row;
    //     }
    // });

    // グローバルスコープに必要な関数をエクスポート
    window.showModal = () => detailSearchModal.show();
    window.hideModal = () => detailSearchModal.hide();
});
</script>


    @push('scripts')
        @vite('resources/js/pages/reports/index.js')
    @endpush
</x-app-layout>