<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white whitespace-nowrap overflow-hidden">
                {{ Breadcrumbs::render('editProject', $project) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')"/>

                <form method="post" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data" id="corporationForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="corporationForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __("update") }}
                        </x-button-save>
                    @endcan
                </form>

                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>
            </div>

            {{-- <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                </svg>
            </button> --}}
            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-56 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$project->id}}" data-modal-show="deleteModal-{{$project->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">削除</span>
                            </div>
                        </button>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $project->updated_at }}</span>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ $project->updatedBy->user_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>
    <div class="max-w-7xl mx-auto px-2 md:pl-14">

    {{-- <div class="mx-auto sm:pl-16 pr-3 pl-3 pb-4"> --}}
        <div class="">
            <!-- 顧客検索ボタン -->
            {{-- <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button> --}}
            <div class="grid gap-3 mt-2 mb-4 sm:grid-cols-3 grid-cols-1">
                <div class="">
                    <label for="project_num" class="block dark:text-white text-sm text-gray-900 leading-none md:mt-4">プロジェクト№</label>
                    <input type="text" form="corporationForm" name="project_num" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="project_num" value="{{old('project_num',$project->project_num)}}" placeholder="登録時に自動採番されます" readonly>
                </div>
                <div class="sm:col-span-2">
                    <label for="project_name" class="block dark:text-white text-sm text-gray-900 leading-none md:mt-4">プロジェクト名称<span class="text-red-500"> *</span></label>
                    <input type="text" name="project_name" form="corporationForm" class="input-secondary" id="project_name" value="{{old('project_name',$project->project_name)}}" placeholder=""  form="updateForm">
                    @error('project_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                {{-- スマホ画面非表示 --}}
                <div class="hidden md:inline-block">
                    <label for="corporation_name" class="block dark:text-white text-sm text-gray-900 leading-none md:mt-1">法人名称</label>
                    <input type="text" name="corporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="corporation_name" value="{{old('corporation_name',$project->client->corporation->corporation_name)}}" readonly>
                </div>
                <div class="">
                    <label for="client_name" class="block dark:text-white text-sm text-gray-900 leading-none md:mt-1">顧客名称</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 " id="client_name" value="{{old('client_name',$project->client->client_name)}}" readonly>
                </div>
                {{-- スマホ画面非表示 --}}
                <div class="hidden md:inline-block">
                    <label for="affiliation2_id" class="block text-sm dark:text-white text-gray-900 leading-none md:mt-1">顧客管轄</label>
                    <select id="affiliation2_id" name="affiliation2_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                        <option value="">未選択</option>
                        @foreach($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2_id',$project->client->affiliation2_id))>{{ $affiliation2->affiliation2_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="estimate-tab" data-tabs-target="#estimate" type="button" role="tab" aria-controls="estimate" aria-selected="false">見積一覧</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="document-tab" data-tabs-target="#document" type="button" role="tab" aria-controls="document" aria-selected="false">証憑一覧</button>
                    </li>
                </ul>
            </div>

            <div class="hidden p-4 mb-2 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="grid gap-2 mb-4 md:grid-cols-4 grid-cols-1">
                    <div>
                        <label for="sales_stage_id" class="text-gray-900 text-sm dark:text-white leading-none mt-4">営業段階<span class="text-red-500"> *</span></label>
                        <select form="corporationForm" id="sales_stage_id" name="sales_stage_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($salesStages as $salesStage)
                            <option value="{{ $salesStage->id }}" @selected($salesStage->id == old('sales_stage_id',$project->sales_stage_id))>{{ $salesStage->sales_stage_name }}</option>
                            @endforeach
                        </select>
                        @error('sales_stage_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="project_type_id" class="text-gray-900 text-sm dark:text-white leading-none mt-4">プロジェクト種別<span class="text-red-500"> *</span></label>
                        <select form="corporationForm" id="project_type_id" name="project_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($projectTypes as $projectType)
                            <option value="{{ $projectType->id }}" @selected($projectType->id == old('project_type_id',$project->project_type_id))>{{ $projectType->project_type_name }}</option>
                            @endforeach
                        </select>
                        @error('project_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="accounting_type_id" class="text-gray-900 text-sm dark:text-white leading-none mt-4">計上種別<span class="text-red-500"> *</span></label>
                        <select form="corporationForm" id="accounting_type_id" name="accounting_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($accountingTypes as $accountingType)
                            <option value="{{ $accountingType->id }}" @selected($accountingType->id == old('accounting_type_id',$project->accounting_type_id))>{{ $accountingType->accounting_type_name }}</option>
                            @endforeach
                        </select>
                        @error('accounting_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="distribution_type_id" class="text-gray-900 text-sm dark:text-white leading-none mt-4">商流<span class="text-red-500"> *</span></label>
                        <select form="corporationForm" id="distribution_type_id" name="distribution_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($distributionTypes as $distributionType)
                            <option value="{{ $distributionType->id }}" @selected($distributionType->id == old('distribution_type_id',$project->distribution_type_id))>{{ $distributionType->distribution_type_name }}</option>
                            @endforeach
                        </select>
                        @error('distribution_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="">
                        <div class="relative w-full">
                            <label for="distribution_type_id" class="text-gray-900 text-sm dark:text-white leading-none">受注確度<span class="text-red-500"> *</span></label>
                            <input type="number" id="currency-input" class="block py-1 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Enter amount" value="50" required />
                        </div>
                        <div class="relative">
                            <label for="range-input" class="sr-only">Labels range</label>
                            <input id="range-input" type="range" value="50" min="0" max="100" step="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                            <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">0</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/2 -translate-x-1/2 -bottom-6">50</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">100</span>
                        </div>
                    </div> --}}
                </div>
                <script>
                    // Get the elements
                    var rangeInput = document.getElementById('range-input');
                    var currencyInput = document.getElementById('currency-input');

                    // Function to update the currency input
                    function updateCurrencyInput() {
                    currencyInput.value = rangeInput.value;
                    }

                    // Add event listener to the range input
                    rangeInput.addEventListener('input', updateCurrencyInput);
                </script>

                <div class="grid gap-2 mb-8 md:grid-cols-4 grid-cols-1">
                    <div class="w-full flex flex-col">
                        <label for="proposed_order_date" class="dark:text-white text-sm text-gray-900 leading-none mt-1">受注予定月</label>
                        <input form="corporationForm" type="month" min="1900-01" max="2100-12" name="proposed_order_date" value="{{ old('proposed_order_date', \Carbon\Carbon::parse($project->proposed_order_date)->format('Y-m') ?? '') }}" class="input-primary" required>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="proposed_delivery_date" class="dark:text-white text-sm text-gray-900 leading-none mt-1">納品予定月</label>
                        <input form="corporationForm" type="month" min="1900-01" max="2100-12"  name="proposed_delivery_date" value="{{ old('proposed_delivery_date', \Carbon\Carbon::parse($project->proposed_delivery_date)->format('Y-m') ?? '') }}" class="input-primary" required>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="proposed_accounting_date" class="dark:text-white text-sm text-gray-900 leading-none mt-1">計上予定月</label>
                        <input form="corporationForm" type="month" min="1900-01" max="2100-12"  name="proposed_accounting_date" value="{{ old('proposed_accounting_date', \Carbon\Carbon::parse($project->proposed_accounting_date)->format('Y-m') ?? '') }}" class="input-primary" required>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="proposed_payment_date" class="dark:text-white text-sm text-gray-900 leading-none mt-1">入金予定月</label>
                        <input form="corporationForm" type="month" min="1900-01" max="2100-12"  name="proposed_payment_date" value="{{ old('proposed_payment_date', \Carbon\Carbon::parse($project->proposed_payment_date)->format('Y-m') ?? '') }}" class="input-primary" required>
                    </div>
                </div>

                {{-- テーブル表示 --}}
                <div class="">
                    <div class="overflow-x-auto shadow-md rounded mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-gray-700 bg-gray-300 dark:bg-gray-700 dark:text-white border-b">
                                <tr>
                                    <th scope="col" class="pl-4 py-1 w-auto">
                                        <div class="flex items-center whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="pl-4 py-1 w-auto">
                                        <div class="flex items-center whitespace-nowrap font-normal ">
                                            №
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap font-normal">
                                        <div class="flex items-center">
                                            期
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap font-normal">
                                        <div class="flex items-center">
                                            計上年月
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap font-normal">
                                        <div class="w-[65px] text-right">
                                            金額
                                        </div>
                                    </th>
                                    <th scope="col" class="flex items-center py-1 whitespace-nowrap font-normal">
                                        <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-auto flex py-1 px-2 text-sm text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                            <svg class="-ml-1 mr-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            {{ __('Actions') }}
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($revenuesWithPeriod as $projectRevenue)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white">
                                        <td class="pl-4 py-1 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input id="checkbox{{ $projectRevenue['revenue']->id }}" type="checkbox" name="selectedIds[]" value="{{ $projectRevenue['revenue']->id }}" form="bulkDeleteForm" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                            </div>
                                        </td>
                                        <td class="pl-4 py-1 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $projectRevenue['belongingPeriod']}}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $projectRevenue['formatRevenueDate']}}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            <div class="w-[65px] text-right">
                                                {{ number_format($projectRevenue['revenue']->revenue) ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="flex justify-between">
                                                <button id="updateProductButton" data-modal-target="updateRevenueModal-{{ $projectRevenue['revenue']->id }}" data-modal-show="updateRevenueModal-{{ $projectRevenue['revenue']->id }}"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-sm text-sm px-2 py-[3px]  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                    <div class="flex items-center">
                                                        <svg class="mr-1 w-3 h-3 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                        </svg>
                                                        <span class="text-xs">編集</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                        {{-- <td class="px-2 py-1">
                                            <button data-modal-target="deleteModal-{{$projectRevenue['revenue']->id}}" data-modal-toggle="deleteModal-{{$projectRevenue['revenue']->id}}" class="button-delete-primary" type="button">
                                                <div class="flex items-center">
                                                    <svg aria-hidden="true" class="w-4 h-4 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-xs">削除</span>
                                                </div>
                                            </button>
                                        </td> --}}
                                    </tr>
                                    {{-- 削除確認モーダル画面 End --}}
                                    <!-- 売上編集モーダル　Start -->
                                    <div id="updateRevenueModal-{{ $projectRevenue['revenue']->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-800 sm:p-5">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                    <h3 class="text-lg text-gray-900 dark:text-white">
                                                        売上編集
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="updateRevenueModal-{{ $projectRevenue['revenue']->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form method="POST" action="{{ route('projectrevenue.update',$projectRevenue['revenue']->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">

                                                        <div class="hidden">
                                                            <div class="w-full flex flex-col">
                                                                <div class="w-full flex flex-col">
                                                                    <label for="modalproject_id">プロジェクトID</label>
                                                                    <input type="text" name="modalproject_id" id="modalproject_id" value="{{ $project->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="w-full flex flex-col">
                                                                <div class="w-full flex flex-col">
                                                                    <label for="revenue_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上年月</label>
                                                                    <input type="month" name="revenue_date" id="revenue_date" min="2000-01" max="2100-12" value="{{old('revenue_date',$projectRevenue['formatRevenueDate'])}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                                </div>
                                                            </div>
                                                            @error('affiliation2_id')
                                                                <div class="text-red-500">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <div class="md:flex items-center">
                                                                <div class="w-full flex flex-col">
                                                                <label for="revenue_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上金額</label>
                                                                {{-- <input type="number" min="0" max="999999999" name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
                                                                <input type="text" onblur="formatNumberInput(this);" maxlength="9" name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount',number_format($projectRevenue['revenue']->revenue))}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                                                </div>
                                                            </div>

                                                            @error('revenue_amount')
                                                                <div class="text-red-500">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4 mt-2">
                                                        <x-primary-button class="mt-4" id="saveModalButton">
                                                            変更を確定
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 売上編集モーダル　End -->
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-1 mb-1 px-4 dark:text-white text-right items-center">
                            <span>税抜合計：</span>
                            {{ number_format($totalRevenue) }}
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="grid gap-4 lg:grid-cols-5 mt-1">

                            <div class="w-full flex flex-col hidden">
                                <label for="billing_corporation_id" class="dark:text-white text-sm text-gray-900 leading-none mt-4">請求先法人ID</label>
                                <input form="corporationForm" type="text" name="billing_corporation_id" class="w-auto py-[2px] border border-gray-300 rounded mt-1 mb-1" id="billing_corporation_id" value="{{old('billing_corporation_id',$project->billing_corporation_id)}}" placeholder="">
                            </div>

                            <div class="flex w-full col-span-3 lg:col-span-1">
                                <div class="w-full flex flex-col">
                                    <label for="billing_corporation_num" class="dark:text-gray-100 text-gray-900 leading-none text-sm">請求先法人№</label>
                                    <input type="text" form="corporationForm" name="billing_corporation_num" id="billing_corporation_num" value="{{old('billing_corporation_num', $project->billingCorporation->corporation_num)}}" class="input-primary" disabled>
                                </div>
        
                                {{-- 法人検索用のボタン --}}
                                <button type="button" id="" onclick="showCorporationModal()" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none  dark:bg-blue-600 dark:hover:bg-blue-700  dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_name" class="dark:text-white text-sm text-gray-900 leading-none sm:mt-0">請求先法人名</label>
                                <input type="text" form="corporationForm" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded mt-1 mb-1" id="billing_corporation_name" value="{{old('billing_corporation_name', optional($project->billingCorporation)->corporation_name)}}" disabled>
                            </div>
                            <div class="w-full flex flex-col  col-span-3 lg:col-span-1">
                                <button type="button" class="rounded bg-gray-400 h-[34px] mt-4 hover:bg-gray-600 whitespace-nowrap">
                                    請求先情報を読み込む
                                </button>
                            </div>                        
                        </div>
                        <div class="grid gap-2 mt-1 md:grid-cols-3">
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_name" class="dark:text-white text-sm text-gray-900 leading-none mt-1">請求先名</label>
                                <input type="text" form="corporationForm" name="billing_corporation_name" class="input-secondary" id="billing_corporation_name" value="{{old('billing_corporation_name', $project->billing_corporation_name)}}">
                            </div>
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_division_name" class="dark:text-white text-sm text-gray-900 leading-none mt-1">請求先部署名</label>
                                <input type="text" form="corporationForm" name="billing_corporation_division_name" class="input-secondary" id="billing_corporation_division_name" value="{{old('billing_corporation_division_name', $project->billing_corporation_division_name)}}">
                            </div>
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_person_name" class="dark:text-white text-sm text-gray-900 leading-none mt-1">請求先担当者名</label>
                                <input type="text" form="corporationForm" name="billing_corporation_person_name" class="input-secondary" id="billing_corporation_person_name" value="{{old('billing_corporation_person_name',$project->billing_corporation_person_name)}}">
                            </div>
                        </div>


                        <div class="grid gap-4 mb-4 md:grid-cols-5 mt-4">
                            <div class="flex">
                                <div class="w-full flex flex-col">
                                    <label for="head_post_code" class="dark:text-white text-sm text-gray-900 leading-none sm:mt-1" autocomplete="new-password">郵便番号</label>
                                    <input type="text" id="head_post_code" form="corporationForm" name="head_post_code" class="input-secondary" value="{{old('head_post_code', $project->billing_head_post_code)}}" placeholder="">
                                </div>
                                <button type="button" id="project_ajaxzip3" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[21px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="w-full flex flex-col">
                                <label for="prefecture_id" class="dark:text-white text-sm text-gray-900 leading-none mt-1">都道府県</label>
                                <select id="prefecture_id" form="corporationForm" name="prefecture_id" class="input-secondary">
                                    <option selected value="">未選択</option>
                                    @foreach($prefectures as $prefecture)
                                        <option value="{{ $prefecture->id }}" @if( $prefecture->id == $project->billing_head_prefecture ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full flex flex-col col-span-3">
                                <label for="head_addre1" class="dark:text-white text-sm text-gray-900 leading-none mt-1">請求先住所</label>
                                <input type="text" form="corporationForm" name="head_addre1" id="head_addre1" value="{{old('head_addre1',$project->billing_head_address1)}}" class="input-secondary" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- テーブルヘッダアクションプルダウン --}}
                <div id="actionsDropdown" class="hidden w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 z-50">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                        <li>
                            <button data-modal-target="storeRevenueModal" data-modal-toggle="storeRevenueModal" class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm px-2 py-1 text-center m-auto" type="button">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <span class="ml-4">個別追加</span>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button data-modal-target="insertRevenueModal" data-modal-toggle="insertRevenueModal" class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm px-2 py-1 text-center m-auto" type="button">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <span class="ml-4">一括追加</span>
                                </div>
                            </button>
                        </li>
                        <li class="border-[0.25px] border-white border-opacity-20"></li>
                        <li>
                            <form id="bulkDeleteForm" action="{{ route('projectrevenue.bulkDelete') }}" method="POST">
                                @csrf
                                @method('delete') <!-- 隠しフィールドを追加 -->
                                <button type="submit" id="bulkDeleteButton" form="bulkDeleteForm" class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm px-2 py-1 text-center m-auto">
                                    <div class="flex items-center dark:text-red-500">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-4 text-base">削除</span>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="project_memo" class="dark:text-white text-sm text-gray-900 leading-none mt-4">プロジェクト備考</label>
                        <textarea form="corporationForm" name="project_memo" class="w-auto py-1 border border-gray-300 rounded mt-1" data-auto-resize="true" id="auto-resize-textarea-content" value="{{old('project_memo',$project->project_memo)}}" cols="30" rows="5" data-auto-resize="true">{{old('project_memo',$project->project_memo)}}</textarea>
                    </div>
                    <div class="grid gap-4 my-4 sm:grid-cols-4">
                        <div>
                            <label for="account_affiliation1_id" class="text-gray-900 dark:text-white text-sm leading-none mt-4">計上所属1</label>
                            <select form="corporationForm" id="account_affiliation1_id" name="account_affiliation1_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($companies as $affiliation1)
                                <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == old('account_affiliation1_id', $project->account_affiliation1_id))>{{ $affiliation1->affiliation1_name }}</option>
                                @endforeach
                            </select>
                            @error('account_affiliation1_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="account_affiliation2_id" class="text-gray-900 dark:text-white text-sm leading-none mt-4">計上所属2</label>
                            <select form="corporationForm" id="account_affiliation2_id" name="account_affiliation2_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2', $project->account_affiliation2_id))>{{ $affiliation2->affiliation2_name }}</option>
                                @endforeach
                            </select>
                            @error('affiliation2')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="account_affiliation3_id" class="text-gray-900 dark:text-white text-sm leading-none mt-4">計上所属3</label>
                            <select form="corporationForm" id="account_affiliation3_id" name="account_affiliation3_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($affiliation3s as $affiliation3)
                                <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('account_affiliation3_id', $project->account_affiliation3_id))>{{ $affiliation3->affiliation3_name }}</option>
                                @endforeach
                            </select>
                            @error('account_affiliation3_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="account_user_id" class="text-gray-900 dark:text-white text-sm leading-none mt-4">計上担当者</label>
                            <select form="corporationForm" id="account_user_id" name="account_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected($user->id == old('account_user_id', $project->account_user_id))>{{ $user->user_name }}</option>
                                @endforeach
                            </select>
                            @error('account_user_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 見積タブ -->
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="estimate" role="tabpanel" aria-labelledby="estimate-tab">

                <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto  md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-1">
                    <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                        <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button type="button" id="newEntryButton" onclick="newEstimate()" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                {{ __('Add') }}
                            </button>
                        </div>
                    </div>
                </div>
            
                <div class="md:w-auto md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th scope="col" class="pl-4 py-3 w-auto">
                                    <div class="flex items-center whitespace-nowrap">
                                        №
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('estimate_num','見積No.')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('estimate_title','件名')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        合計金額
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('create_at','作成日')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('_at','提出日')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('user_id','ボツ')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @sortablelink('is_finished','作成者')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                            <path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        添付
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estimates as $estimate)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 clickable-row">
                                    <td class="pl-4 py-1 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        <button type="button" onclick="location.href='{{ route('estimates.edit', ['projectId' => $project->id, 'estimateId' => $estimate->ulid]) }}'" class="button-edit-primary">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>
                                                <span class="md:block hidden">編集</span>
                                            </div>
                                        </button>
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        {{ $estimate->estimate_num }}
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        {{ $estimate->estimate_subject }}
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        {{-- <div class="text-right w-[65px] ">{{ number_format($estimate->subtotal_amount, 0) }}</div> --}}
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        {{$estimate->estimate_at}}
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        {{$estimate->submit_at}}
                                    </td>
                                    {{-- <td class="px-1 py-1 whitespace-nowrap">
                                        {{$estimate->user->user_name}}
                                    </td> --}}
                                    {{-- <td class="px-1 py-1 whitespace-nowrap">
                                        @if ($estimate->is_finished == "0")
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                未返却
                                            </span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                返却済
                                            </span>
                                        @endif
                                    </td> --}}
                                    {{-- <td class="px-1 py-1 whitespace-nowrap">
                                        @if ($estimate->pdf_file)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                有り
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                なし
                                            </span>
                                        @endif
                                    </td>                        
                                    <td class="px-1 py-1 whitespace-nowrap">
                                        @if ($estimate->pdf_file)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                有り
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                なし
                                            </span>
                                        @endif
                                    </td> --}}
                                    <td class="py-1">
                                        <button type="button" data-modal-target="deleteModal-{{ $estimate->ulid }}" data-modal-show="deleteModal-{{ $estimate->ulid }}" class="button-delete-primary" tabindex="-1">
                                            <div class="flex">
                                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                <span class="text-ms ">削除</span>
                                            </div>
                                        </button>
                                    </td>
                                </tr>
                                <div id="deleteModal-{{ $estimate->ulid }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                            <button data-modal-hide="deleteModal-{{ $estimate->ulid }}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            </button>
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                                <form action="{{ route('estimate.destroy',$estimate->ulid) }}" method="POST" class="text-center m-auto">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-modal-hide="deleteModal-{{ $estimate->ulid }}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        削除
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{ $estimate->ulid }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    やっぱやめます
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-1 mb-1 px-4">
                    {{-- {{ $estimates->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
                    </div> 
                </div>
            </div>

            <!-- 証憑タブ -->
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="document" role="tabpanel" aria-labelledby="document-tab">
                <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_enduser" name="is_enduser" type="checkbox" value="1" {{ old('is_enduser') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_enduser" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">契約書取得</label>
                        </div>
                        @error('is_enduser')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_dealer" name="is_dealer" type="checkbox" value="1" {{ old('is_dealer') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">注文書取得</label>
                        </div>
                        @error('is_dealer')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_supplier" name="is_supplier" type="checkbox" value="1" {{ old('is_supplier') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">検収書取得</label>
                        </div>
                        @error('is_supplier')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>
                <div class="w-full flex flex-col">
                    <label for="memo" class="dark:text-white text-sm text-gray-900 leading-none mt-4">証票備考</label>
                    <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-content_2" value="{{old('memo')}}" cols="30" rows="2" data-auto-resize="true"></textarea>
                </div>
            </div>
        </div>
    </div>






     <!-- 顧客検索 Modal -->
     <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('corporations.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-2 mb-4 sm:grid-cols-3">
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientName" class="dark:text-white text-sm text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="dark:text-white text-sm text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="affiliation2Id" class=" dark:text-white text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="affiliation2Id" name="affiliation2Id" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == Auth::user()->affiliation2->id)>
                                    {{ $affiliation2->affiliation2_name }}
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
                            <th class="py-1 pl-5">顧客名称</th>
                            <th class="py-1 whitespace-nowrap">顧客番号</th>
                            <th class="py-1 whitespace-nowrap">管轄事業部</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
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

    <!-- 請求先法人検索 Modal -->
    <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
    {{-- <div id="corporationSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class="max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        法人検索画面
                    </h3>
                    <button type="button" onclick="hideCorporationModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('corporations.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                    {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                        <div class="">
                            <label for="corporationName" class="block dark:text-white text-sm text-gray-900 leading-none">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="">
                            <label for="corporationNumber" class="block dark:text-white text-sm text-gray-900 leading-none">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden mt-4">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1"></th> --}}
                            <th class="py-1 pl-5">法人名称</th>
                            <th class="py-1 whitespace-nowrap">法人番号</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsCorporationContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideCorporationModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>

    <!-- 売上登録モーダル　Start -->
    <div id="storeRevenueModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg text-gray-900 dark:text-white">
                        売上登録
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="storeRevenueModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form method="POST" action="{{ route('projectrevenue.store') }}">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="hidden">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex flex-col">
                                    <label for="modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                    <input type="text" name="modalproject_id" id="modalproject_id" value="{{ $project->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </div>
                            @error('affiliation2_id')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="w-full flex flex-col">
                                <div class="w-full flex flex-col">
                                    <label for="revenue_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上年月</label>
                                    <input type="month" name="revenue_date" id="revenue_date" min="2000-01" max="2100-12" value="{{old('revenue_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                            </div>
                            @error('affiliation2_id')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="md:flex items-center">
                                <div class="w-full flex flex-col">
                                <label for="revenue_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上金額</label>
                                {{-- <input type="number" min="0" max="999999999" name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
                                <input type="text" onblur="formatNumberInput(this);" maxlength="9"   name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                </div>
                            </div>

                            @error('revenue_amount')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-primary-button class="mt-4" id="saveModalButton">
                            登録
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 売上登録モーダル　End -->

    <!-- 売上一括登録モーダル　Start -->
    <div id="insertRevenueModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg text-gray-900 dark:text-white">
                        売上一括登録
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="insertRevenueModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form method="POST" action="{{ route('projectrevenue.bulkInsert') }}">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="hidden">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex flex-col">
                                    <label for="Insert_modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                    <input type="text" name="Insert_modalproject_id" id="Insert_modalproject_id" value="{{ $project->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </div>
                            @error('affiliation2_id')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="w-full flex flex-col">
                                <div class="w-full flex flex-col">
                                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上開始年月</label>
                                    <input type="month" name="start_date" id="start_date" min="2000-01" max="2100-12" value="{{old('start_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                            </div>
                            @error('affiliation2_id')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="w-full flex flex-col">
                                <div class="w-full flex flex-col">
                                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上終了年月</label>
                                    <input type="month" name="end_date" id="end_date" min="2000-01" max="2100-12" value="{{old('end_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                            </div>
                            @error('affiliation2_id')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <div class="md:flex items-center">
                                <div class="w-full flex flex-col">
                                <label for="total_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上総額</label>
                                {{-- <input type="number" min="0" max="999999999" name="total_amount" id="total_amount" value="{{old('total_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
                                <input type="text" onblur="formatNumberInput(this);" maxlength="9" name="total_amount" id="total_amount" value="{{old('total_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                </div>
                            </div>
                            @error('total_amount')
                                <div class="text-red-500">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-primary-button class="mt-4" id="saveModalButton">
                            一括登録
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 売上一括登録モーダル　End -->

    {{-- 削除確認モーダル画面 Start --}}
    <div id="deleteModal-{{$project->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full animate-slide-in-top justify-center">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal-{{$project->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>

                    <div class="flex justify-center items-center">
                        <form action="{{route('projects.destroy',$project->id)}}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{$project->id}}" class="mr-3 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm  items-center px-5 py-2.5 text-center">
                                削除
                            </button>
                        </form>
                        <button data-modal-hide="deleteModal-{{$project->id}}" type="button" class="items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
            const affiliation2Id = document.getElementById('affiliation2Id').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, affiliation2Id })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_corporation.corporation_name}', '${result.client_num}', '${result.client_name}', '${result.affiliation2_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.affiliation2.affiliation2_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationname, clientnum, clientname, affiliation2) {
            document.getElementById('corporation_name').value = corporationname;
            document.getElementById('client_num').value = clientnum;
            document.getElementById('client_name').value = clientname;
            document.getElementById('affiliation2_id').value = affiliation2;
            // document.getElementById('client_num').value = number;
            // document.getElementById('installation_type_id').value = installation;
            // document.getElementById('client_type_id').value = clienttype;
            // document.getElementById('user_id').value = user;

            hideModal();
            }
    </script>
    <script>
        // モーダルを表示するための関数
        function showCorporationModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('corporationSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideCorporationModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('corporationSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }

        // 検索ボタンを押した時の処理
        function searchCorporation() {
            const corporationName = document.getElementById('corporationName').value;
            const corporationNumber = document.getElementById('corporationNumber').value;

            fetch('/corporations/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ corporationName, corporationNumber })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsCorporationContainer = document.getElementById('searchResultsCorporationContainer');
                searchResultsCorporationContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.id}', '${result.corporation_num}', '${result.corporation_name}')">${result.corporation_short_name}</td>
                    <td class="py-2 ml-2">${result.corporation_num}</td>
                `;
                searchResultsCorporationContainer.appendChild(resultElement);
                });
            });
            }

        function setCorporation(id, number, name) {
            document.getElementById('billing_corporation_id').value = id;
            document.getElementById('billing_corporation_num').value = number;
            document.getElementById('billing_corporation_name').value = name;
            hideCorporationModal();
        }


        function newEstimate() {
    // ローカルストレージをクリア
    localStorage.removeItem('estimateFormData');
    
    // 新規パラメータを追加してリダイレクト
    var url = "{{ route('estimate.create', $project->id) }}";
    location.href = url + (url.includes('?') ? '&' : '?') + 'new=true';
}

    </script>

    <script src="{{ asset('assets/js/autoresizetextarea.js') }}"></script>
    <script src="{{ asset('assets/js/addresssearchbutton.js') }}"></script>
</x-app-layout>