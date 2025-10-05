<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createProject') }}
            </h2>
            <div class="ml-auto flex">
                <form method="post" id="createForm" action="{{route('projects.store')}}" enctype="multipart/form-data" autocomplete="new-password">
                    @csrf
                    <x-buttons.save-button id="saveButton">
                        {{ __('save') }}
                    </x-buttons.save-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">


        <!-- 顧客検索ボタン -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>



        <div class="grid gap-4 mb-4 sm:grid-cols-3">
            <div class="">
                <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                <input form="createForm" type="text" name="corporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="corporation_name" value="{{old('corporation_name')}}" placeholder="顧客検索してください" readonly>
                @error('corporation_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="hidden">
                <label for="client_num" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                <input form="createForm" type="text" name="client_num" id="client_num" value="{{old('client_num')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed">
            </div>
            <div class="">
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                <input form="createForm" type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="affiliation2_id" class="block text-sm  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                <select form="createForm" id="affiliation2_id" name="affiliation2_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
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
                <input form="createForm" type="text" name="project_name" class="input-secondary" id="project_name" value="{{old('project_name')}}" placeholder="">
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

            <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="sales_stage_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">営業段階<span class="text-red-500"> *</span></label>
                    <select form="createForm" id="sales_stage_id" name="sales_stage_id" class="input-primary">
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
                    <select form="createForm" id="project_type_id" name="project_type_id" class="input-primary">
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
                    <select form="createForm" id="accounting_type_id" name="accounting_type_id" class="input-primary">
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
                    <select form="createForm" id="distribution_type_id" name="distribution_type_id" class="input-primary">
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
                    <label for="proposed_order_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">受注予定月</label>
                    <input form="createForm" type="month" min="1900-01" max="2100-12" name="proposed_order_date" id="proposed_order_date" value="{{ old('proposed_order_date') }}" class="input-primary">
                </div>
                @error('proposed_order_date')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="proposed_delivery_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">納品予定月</label>
                    <input form="createForm" type="month" min="1900-01" max="2100-12" name="proposed_delivery_date" id="proposed_delivery_date" value="{{ old('proposed_delivery_date') }}" class="input-primary">
                </div>
                @error('proposed_delivery_date')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="proposed_accounting_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">検収/計上予定月</label>
                    <input form="createForm" type="month" min="1900-01" max="2100-12" name="proposed_accounting_date" id="proposed_accounting_date" value="{{ old('proposed_accounting_date') }}" class="input-primary">
                </div>
                @error('proposed_accounting_date')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="proposed_payment_date" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-2">入金予定月</label>
                    <input form="createForm" type="month" min="1900-01" max="2100-12" name="proposed_payment_date" id="proposed_payment_date" value="{{ old('proposed_payment_date') }}" class="input-primary">
                </div>
                @error('proposed_payment_date')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

        <button type="button" onclick="CorporationSearchModal.show('corporationSearchModal1')" class="md:ml-1 mt-8 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            請求先検索
        </button>

            <div class="grid gap-2 mb-4 sm:grid-cols-4">
                <div class="w-full flex flex-col hidden">
                    <label for="billing_corporation_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人ID（非表示）</label>
                    <input form="createForm" type="text" name="billing_corporation_id" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_id" value="{{old('billing_corporation_id')}}" placeholder="">
                </div>
                <div class="w-full flex flex-col">
                    <label for="billing_corporation_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人№</label>
                    <input form="createForm" type="text" name="billing_corporation_num" class="input-secondary" id="billing_corporation_num" value="{{old('billing_corporation_num')}}" placeholder="">
                    @error('billing_corporation_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="billing_corporation_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人名称</label>
                    <input form="createForm" type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_name" value="{{old('billing_corporation_name')}}" readonly>
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="project_memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">プロジェクト備考</label>
                <textarea form="createForm" name="project_memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400"data-auto-resize="true" data-auto-resize="true" id="project_memo" cols="30" rows="5">{{old('project_memo')}}</textarea>
                @error('project_memo')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>


    <div class="mb-4 mt-4">
        <label for="department_id" class="text-sm text-gray-900 dark:text-white leading-none">
            計上部門
        </label>
        <select id="department_id" form="createForm" name="department_id" class="input-secondary w-full">
            <option value="">未選択</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', Auth::user()->department_id) == $department->id)>
                    {{ $department->path }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>


            <div class="grid gap-4 my-4 sm:grid-cols-4">
                {{-- <div>
                    <label for="account_affiliation1_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上所属1</label>
                    <select form="createForm" id="account_affiliation1_id" name="account_affiliation1_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <select form="createForm" id="account_affiliation2_id" name="account_affiliation2_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <select form="createForm" id="account_affiliation3_id" name="account_affiliation3_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('account_affiliation3_id', Auth::user()->affiliation3->id))>{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                    @error('account_affiliation3_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div>
                    <label for="account_user_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">計上担当者</label>
                    <select form="createForm" id="account_user_id" name="account_user_id" class="input-secondary">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected($user->id == old('account_user_id', Auth::user()->id))>{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                    @error('account_user_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>


    <x-modals.client-search-modal
        modalId="clientSearchModal1"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />

    <script>
        // コールバック関数の定義
        function handleClientSelect(client) {
            document.getElementById('client_num').value = client.client_num;
            document.getElementById('corporation_name').value = client.corporation.corporation_name;
            document.getElementById('client_name').value = client.client_name;
            document.getElementById('affiliation2_id').value = client.affiliation2.id;
            // document.getElementById('sales_user').value = client.user.user_name;
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>





    {{-- 各画面のBladeテンプレート --}}
    <x-modals.corporation-search-modal
        modalId="corporationSearchModal1"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />
        
    <script>
        // コールバック関数の定義
        function handleClientSelect(corporation) {
            document.getElementById('billing_corporation_num').value = corporation.corporation_num;
            document.getElementById('billing_corporation_id').value = corporation.id;
            document.getElementById('billing_corporation_name').value = corporation.corporation_name;
        }
        // モーダルのコールバック関数を設定
        window.corporationSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/corporation-search-modal.js') }}"></script>







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