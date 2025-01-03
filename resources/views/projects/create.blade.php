<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createProject') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form id="form1" method="post" action="{{route('projects.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf
            <!-- 顧客検索ボタン -->
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button>
            <div class="grid gap-4 mb-4 sm:grid-cols-3">
                <div class="">
                    <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="corporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="corporation_name" value="{{old('corporation_name')}}" placeholder="顧客検索してください" readonly>
                    @error('corporation_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="hidden">
                    <label for="client_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                    <input type="text" name="client_num" id="client_num" value="{{old('client_num')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed">
                </div>
                <div class="">
                    <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="affiliation2_id" class="block text-sm  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                    <select id="affiliation2_id" name="affiliation2_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                        <option value="">未選択</option>
                        @foreach($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                        @endforeach
                    </select>
                    @error('affiliation2_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

                <div class="col-span-3">
                    <label for="project_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">プロジェクト名称<span class="text-red-500"> *</span></label>
                    <input type="text" name="project_name" class="input-secondary" id="project_name" value="{{old('project_name')}}" placeholder="">
                    @error('project_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                    </li>
                </ul>
            </div>


            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

                <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                    <div class="w-full flex flex-col">
                        <label for="sales_stage_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">営業段階<span class="text-red-500"> *</span></label>
                        <select id="sales_stage_id" name="sales_stage_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($salesStages as $salesStage)
                            <option value="{{ $salesStage->id }}" @selected($salesStage->id == old('sales_stage_id'))>{{ $salesStage->sales_stage_name }}</option>
                            @endforeach
                        </select>
                        @error('sales_stage_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="project_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">プロジェクト種別<span class="text-red-500"> *</span></label>
                        <select id="project_type_id" name="project_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($projectTypes as $projectType)
                            <option value="{{ $projectType->id }}" @if($projectType->id == old('project_type_id')) selected @endif>{{ $projectType->project_type_name }}</option>
                            @endforeach
                        </select>
                        @error('project_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="accounting_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上種別<span class="text-red-500"> *</span></label>
                        <select id="accounting_type_id" name="accounting_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($accountingTypes as $accountingType)
                            <option value="{{ $accountingType->id }}" @if($accountingType->id == old('accounting_type_id')) selected @endif>{{ $accountingType->accounting_type_name }}</option>
                            @endforeach
                        </select>
                        @error('accounting_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="distribution_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">商流<span class="text-red-500"> *</span></label>
                        <select id="distribution_type_id" name="distribution_type_id" class="input-primary">
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

                <div class="grid gap-2 mb-4 sm:grid-cols-5">
                    <div class="w-full flex flex-col">
                        <label for="proposed_order_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">受注予定月</label>
                        <input type="month" min="1900-01" max="2100-12" name="proposed_order_date" id="proposed_order_date" value="{{ old('proposed_order_date') }}" class="input-primary">
                    </div>
                    @error('proposed_order_date')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="w-full flex flex-col">
                        <label for="proposed_delivery_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">納品予定月</label>
                        <input type="month" min="1900-01" max="2100-12" name="proposed_delivery_date" id="proposed_delivery_date" value="{{ old('proposed_delivery_date') }}" class="input-primary">
                    </div>
                    @error('proposed_delivery_date')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="w-full flex flex-col">
                        <label for="proposed_accounting_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">検収/計上予定月</label>
                        <input type="month" min="1900-01" max="2100-12" name="proposed_accounting_date" id="proposed_accounting_date" value="{{ old('proposed_accounting_date') }}" class="input-primary">
                    </div>
                    @error('proposed_accounting_date')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="w-full flex flex-col">
                        <label for="proposed_payment_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">入金予定月</label>
                        <input type="month" min="1900-01" max="2100-12" name="proposed_payment_date" id="proposed_payment_date" value="{{ old('proposed_payment_date') }}" class="input-primary">
                    </div>
                    @error('proposed_payment_date')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>



                {{-- <div class="grid gap-2 mb-4 sm:grid-cols-4">
                    <div class="w-full flex flex-col">
                        <label for="total_revenue" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">案件全体金額（税抜）</label>
                        <input type="number" name="total_revenue" id="total_revenue" value="" class="dark:bg-gray-400 dark:text-white w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" disabled>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="total_revenue" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">会計期別金額（税抜）</label>
                        <input type="number" name="total_revenue" id="total_revenue" value="" class="bg-yellow-100 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" disabled>
                    </div>
                </div> --}}
                <button type="button"  onclick="showCorporationModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    請求先検索
                </button>

                <div class="grid gap-2 mb-4 sm:grid-cols-4">
                    <div class="w-full flex flex-col hidden">
                        <label for="billing_corporation_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人ID（非表示）</label>
                        <input type="text" name="billing_corporation_id" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_id" value="{{old('billing_corporation_id')}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="billing_corporation_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人№</label>
                        <input type="text" name="billing_corporation_num" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_num" value="{{old('billing_corporation_num')}}" placeholder="">
                        @error('billing_corporation_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="billing_corporation_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人名称</label>
                        <input type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_name" value="{{old('billing_corporation_name')}}" readonly>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="project_memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">プロジェクト備考</label>
                    <textarea name="project_memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400"data-auto-resize="true" data-auto-resize="true" id="project_memo" cols="30" rows="5">{{old('project_memo')}}</textarea>
                    @error('project_memo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="grid gap-4 my-4 sm:grid-cols-4">
                    <div>
                        <label for="account_affiliation1_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上所属1</label>
                        <select id="account_affiliation1_id" name="account_affiliation1_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($affiliation1s as $affiliation1)
                            <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == old('account_affiliation1_id', Auth::user()->affiliation1->id))>{{ $affiliation1->affiliation1_name }}</option>
                            @endforeach
                        </select>
                        @error('account_affiliation1_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="account_affiliation2_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上所属2</label>
                        <select id="account_affiliation2_id" name="account_affiliation2_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($affiliation2s as $affiliation2)
                            <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2', Auth::user()->affiliation2->id))>{{ $affiliation2->affiliation2_name }}</option>
                            @endforeach
                        </select>
                        @error('affiliation2')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="account_affiliation3_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上所属3</label>
                        <select id="account_affiliation3_id" name="account_affiliation3_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($affiliation3s as $affiliation3)
                            <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('account_affiliation3_id', Auth::user()->affiliation3->id))>{{ $affiliation3->affiliation3_name }}</option>
                            @endforeach
                        </select>
                        @error('account_affiliation3_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="account_user_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上担当者</label>
                        <select id="account_user_id" name="account_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id == old('account_user_id', Auth::user()->id))>{{ $user->user_name }}</option>
                            @endforeach
                        </select>
                        @error('account_user_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <x-primary-button class="mt-4" form="form1" id="saveButton">
                    新規登録する(s)
                </x-primary-button>
            </div>
        </form>
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
                            <label for="clientName" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="affiliation2Id" class="text-sm  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
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
                            <label for="corporationName" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="">
                            <label for="corporationNumber" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人番号</label>
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.corporation.corporation_name}', '${result.client_num}', '${result.client_name}', '${result.affiliation2_id}')">${result.client_name}</td>
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
    </script>


{{-- 4つの日付入力欄で入力が完了しフォーカスが外れたら次の入力欄に値をコピーする --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateFields = [
            'proposed_order_date',
            'proposed_delivery_date',
            'proposed_accounting_date',
            'proposed_payment_date'
        ];
    
        dateFields.forEach((fieldId, index) => {
            if (index === 0) return; // 最初のフィールドはスキップ
    
            const currentField = document.getElementById(fieldId);
            const previousField = document.getElementById(dateFields[index - 1]);
    
            // 前のフィールドの値が変更されたときに、次のフィールドに値をセット
            previousField.addEventListener('blur', function() {
                // 入力値が不完全な場合は処理しない
                if (!this.value.match(/^\d{4}-\d{2}$/)) return;
                if (!currentField.value) { // 現在のフィールドが空の場合のみ
                    currentField.value = this.value;
                }
            });
    
            // ページ読み込み時に、前のフィールドに値があり現在のフィールドが空の場合、値をコピー
            if (previousField.value && !currentField.value) {
                currentField.value = previousField.value;
            }
        });
    });
    </script>

<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>