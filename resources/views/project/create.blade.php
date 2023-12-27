<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                プロジェクト登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('client.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form id="form1" method="post" action="{{route('project.store')}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf
                <!-- 顧客検索ボタン -->
                <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    顧客検索
                </button>
                <div class="grid gap-4 mb-4 sm:grid-cols-3">
                    <div class="">
                        <label for="clientcorporation_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                        <input type="text" name="clientcorporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="顧客検索してください" readonly>
                        @error('clientcorporation_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hidden">
                        <label for="client_num" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                        <input type="text" name="client_num" id="client_num" value="{{old('client_num')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed">
                    </div>
                    <div class="">
                        <label for="client_name" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="department_id" class="block font-semibold  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                        <select id="department_id" name="department_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                            <option value="">未選択</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="project_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">プロジェクト№（自動採番）</label>
                        <input type="text" name="project_num" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="project_num" value="{{old('project_num')}}" placeholder="登録時に自動採番されます" readonly>
                        @error('project_num')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="project_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">プロジェクト名称</label>
                        <input type="text" name="project_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="project_name" value="{{old('project_name')}}" placeholder="">
                        @error('project_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                        </li>
                    </ul>
                </div>

                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                            <div>
                                <label for="sales_stage_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業段階</label>
                                <select id="sales_stage_id" name="sales_stage_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($salesStages as $salesStage)
                                    <option value="{{ $salesStage->id }}" @if($salesStage->id == old('sales_stage_id')) selected @endif>{{ $salesStage->sales_stage_name }}</option>
                                    @endforeach
                                </select>
                                @error('sales_stage_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="project_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">プロジェクト種別</label>
                                <select id="project_type_id" name="project_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($projectTypes as $projectType)
                                    <option value="{{ $projectType->id }}" @if($projectType->id == old('project_type_id')) selected @endif>{{ $projectType->project_type_name }}</option>
                                    @endforeach
                                </select>
                                @error('project_type_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="accounting_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上種別</label>
                                <select id="accounting_type_id" name="accounting_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($accountingTypes as $accountingType)
                                    <option value="{{ $accountingType->id }}" @if($accountingType->id == old('accounting_type_id')) selected @endif>{{ $accountingType->accounting_type_name }}</option>
                                    @endforeach
                                </select>
                                @error('accounting_type_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="distribution_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">商流</label>
                                <select id="distribution_type_id" name="distribution_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($distributionTypes as $distributionType)
                                    <option value="{{ $distributionType->id }}" @selected($distributionType->id == old('distribution_type_id'))>{{ $distributionType->distribution_type_name }}</option>
                                    @endforeach
                                </select>
                                @error('distribution_type_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-2 mb-4 sm:grid-cols-4">
                            <div class="w-full flex flex-col">
                                <label for="total_revenue" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">案件全体金額（税抜）</label>
                                <input type="number" name="total_revenue" id="total_revenue" value="" class="dark:bg-gray-400 dark:text-white w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" disabled>
                            </div>
                            {{-- <div class="w-full flex flex-col">
                                <label for="total_revenue" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">会計期別金額（税抜）</label>
                                <input type="number" name="total_revenue" id="total_revenue" value="" class="bg-yellow-100 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" disabled>
                            </div> --}}
                        </div>
                        <button type="button"  onclick="showCorporationModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            法人検索
                        </button>

                        <div class="grid gap-2 mb-4 sm:grid-cols-4">

                            <div class="w-full flex flex-col hidden">
                                <label for="billing_corporation_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人ID</label>
                                <input type="text" name="billing_corporation_id" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 mb-2" id="billing_corporation_id" value="{{old('billing_corporation_id')}}" placeholder="">
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="billing_corporation_num" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人№</label>
                                <input type="text" name="billing_corporation_num" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 mb-2" id="billing_corporation_num" value="{{old('billing_corporation_num')}}" placeholder="">
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="billing_corporation_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人名称</label>
                                <input type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 mb-2" id="billing_corporation_name" value="{{old('billing_corporation_name')}}" disabled>
                            </div>
                        </div>
                        <div class="grid gap-2 mb-4 sm:grid-cols-5">
                            <div class="w-full flex flex-col">
                                <label for="proposed_order_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">受注予定月</label>
                                <input type="month" min="1900-01" max="2100-12" name="proposed_order_date" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1">
                            </div>
                            @error('proposed_order_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="proposed_delivery_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">納品予定月</label>
                                <input type="month" min="1900-01" max="2100-12"  name="proposed_delivery_date" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1">
                            </div>
                            @error('proposed_delivery_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="proposed_accounting_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">検収/計上予定月</label>
                                <input type="month" min="1900-01" max="2100-12"  name="proposed_accounting_date" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1">
                            </div>
                            @error('proposed_accounting_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="w-full flex flex-col">
                                <label for="proposed_payment_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">入金予定月</label>
                                <input type="month" min="1900-01" max="2100-12"  name="proposed_payment_date" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1">
                            </div>
                            @error('proposed_payment_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="project_memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">プロジェクト備考</label>
                            <textarea name="project_memo" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="project_memo" value="{{old('project_memo')}}" cols="30" rows="5"></textarea>
                            @error('project_memo')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grid gap-4 my-4 sm:grid-cols-4">
                            <div>
                                <label for="account_company_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属1</label>
                                <select id="account_company_id" name="account_company_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected($company->id == old('account_company_id', Auth::user()->company->id))>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('account_company_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_department_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属2</label>
                                <select id="account_department_id" name="account_department_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == old('department', Auth::user()->department->id))>{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_division_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属3</label>
                                <select id="account_division_id" name="account_division_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" @selected($division->id == old('account_division_id', Auth::user()->division->id))>{{ $division->division_name }}</option>
                                    @endforeach
                                </select>
                                @error('account_division_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上担当者</label>
                                <select id="account_user_id" name="account_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == old('account_user_id', Auth::user()->id))>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('account_user_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <x-primary-button class="mt-4" form="form1">
                            新規登録する
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>











     <!-- 顧客検索 Modal -->
     <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        {{-- <div id="clientSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
            <div class="max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            顧客検索画面
                        </h3>
                        <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ route('clientcorporation.search') }}" method="GET">
                        <!-- 検索条件入力フォーム -->
                        <div class="grid gap-2 mb-4 sm:grid-cols-3">
                            <div class="w-full flex flex-col mx-2">
                                <label for="clientName" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                                <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="clientNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                                <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="departmentId" class="font-semibold  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                                <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == Auth::user()->department->id)>
                                        {{ $department->department_name }}
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
                        <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            検索
                        </button>
                        <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                法人検索画面
                            </h3>
                            <button type="button" onclick="hideCorporationModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form action="{{ route('clientcorporation.search') }}" method="GET">
                            <!-- 検索条件入力フォーム -->
                            <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                            {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                                <div class="">
                                    <label for="corporationName" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                                    <input type="text" name="corporationName" id="corporationName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                                </div>
                                <div class="">
                                    <label for="corporationNumber" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">法人番号</label>
                                    <input type="text" name="corporationNumber" id="corporationNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
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
                            <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                検索
                            </button>
                            <button type="button" onclick="hideCorporationModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                閉じる
                            </button> 
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_corporation.clientcorporation_name}', '${result.client_num}', '${result.client_name}', '${result.department_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationname, clientnum, clientname, department) {
            document.getElementById('clientcorporation_name').value = corporationname;
            document.getElementById('client_num').value = clientnum;
            document.getElementById('client_name').value = clientname;
            document.getElementById('department_id').value = department;
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

            fetch('/clientcorporation/search', {
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
                    <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.id}', '${result.clientcorporation_num}', '${result.clientcorporation_name}')">${result.clientcorporation_short_name}</td>
                    <td class="py-2 ml-2">${result.clientcorporation_num}</td>
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
    </script>
</x-app-layout>