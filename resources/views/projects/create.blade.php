<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createProject') }}
            </h2>
            <div class="ml-auto flex">
                <form method="post" id="createForm" action="{{route('projects.store') }}" enctype="multipart/form-data" autocomplete="new-password">
                    @csrf
                    <x-buttons.save-button id="saveButton">
                        {{ __('save') }}
                    </x-buttons.save-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14 mb-4">
        <!-- 顧客検索ボタン(画面小) -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap md:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>

        <div class="mx-auto my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <div class="hidden">
                        <label for="client_id">顧客ID（非表示）</label>
                        <input type="hidden" form="createForm" name="client_id" id="client_id" value="{{ old('client_id') }}">
                    </div>
                    <!-- 顧客No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:py-0.5  md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <span>顧客No.</span>
                                <button type="button" onclick="ClientSearchModal.show('clientSearchModal')"  data-form="supportForm"
                                    class="ml-2 p-1.5 text-sm font-medium h-[30px] text-white bg-blue-700 rounded border border-blue-700 
                                        hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700
                                        dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 
                                        focus:ring-offset-2 dark:focus:ring-offset-gray-800 hidden md:block">
                                    {{-- <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg> --}}
                                    <x-icon name="ui/search" class="w-4 h-4"></x-icon>
                                </button>
                            </div>
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1.5 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="client_num" id="client_num" value="{{ old('client_num') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm pointer-events-none @error('client_id') input-error @enderror" placeholder="" tabindex="-1">
                        </td>
                    </tr>

                    <!-- 法人名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-48">
                            法人名称
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="corporation_name" id="corporation_name" value="{{ old('corporation_name') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm pointer-events-none @error('client_id') input-error @enderror" placeholder="" tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-48">
                            顧客名称
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="client_name" id="client_name" value="{{ old('client_name') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm pointer-events-none @error('client_id') input-error @enderror" placeholder="" tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 管轄部門 -->
                    <tr class="dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            管轄部門
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="createForm" name="department_path" id="department_path" value="{{ old('department_path') }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm pointer-events-none @error('client_id') input-error @enderror" placeholder="" tabindex="-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @error('client_id')
            <div class="validate-message">{{ $message }}</div>
        @enderror

        <div class="col-span-3">
            <label for="project_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">プロジェクト名称<span class="text-red-500"> *</span></label>
            <input form="createForm" type="text" name="project_name" class="input-secondary" id="project_name" value="{{ old('project_name') }}" placeholder="">
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

            <div class="grid gap-2 mb-4 md:grid-cols-4 grid-cols-2">
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

            <button type="button" onclick="CorporationSearchModal.show('corporationSearchModal')" class="sm:hidden md:ml-1 mt-8 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                請求先検索
            </button>

            <div class="grid gap-2 mb-4 sm:grid-cols-4">
                <div class="w-full flex flex-col hidden">
                    <label for="billing_corporation_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">請求先法人ID（非表示）</label>
                    <input form="createForm" type="text" name="billing_corporation_id" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_id" value="{{ old('billing_corporation_id') }}" placeholder="">
                </div>

                <div>
                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="billing_corporation_num" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1" autocomplete="new-password">請求先法人№</label>
                            <input type="text" form="createForm" name="billing_corporation_num" class="input-primary" id="billing_corporation_num" value="{{ old('billing_corporation_num') }}" placeholder="">
                        </div>
                        <button type="button" onclick="CorporationSearchModal.show('corporationSearchModal')" data-form="createForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[21px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                    <div>
                        @error('billing_corporation_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="w-full flex flex-col col-span-3">
                    <label for="billing_corporation_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">請求先法人名称</label>
                    <input form="createForm" type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_name" value="{{ old('billing_corporation_name') }}" readonly>
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="project_memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">プロジェクト備考</label>
                <textarea form="createForm" name="project_memo" class="input-secondary" data-auto-resize="true" id="project_memo" cols="30" rows="5">{{ old('project_memo') }}</textarea>
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
                        <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                            {{ $department->path }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid gap-4 my-4 sm:grid-cols-4">
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


    {{-- 顧客検索モーダル --}}
    <x-modals.client-search-modal
        modalId="clientSearchModal"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />

    <script>
        // コールバック関数の定義
        function handleClientSelect(client) {
            document.getElementById('client_id').value = client.id;
            document.getElementById('corporation_name').value = client.corporation.corporation_name;
            document.getElementById('client_num').value = client.client_num;
            document.getElementById('client_name').value = client.client_name;
            document.getElementById('department_path').value = client.department.path;
            // document.getElementById('sales_user').value = client.user.user_name;

            // 計上部門も先に埋める
            document.getElementById('department_id').value = client.department.id;

            // 請求先法人も先に埋める
            document.getElementById('billing_corporation_num').value = client.corporation.corporation_num;
            document.getElementById('billing_corporation_id').value = client.corporation.id;
            document.getElementById('billing_corporation_name').value = client.corporation.corporation_name;
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>


    {{-- 請求先検索モーダル --}}
    <x-modals.corporation-search-modal
        modalId="corporationSearchModal"
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
        window.corporationSearchModal_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/corporation-search-modal.js') }}"></script>



    @push('scripts')
        @vite('resources/js/pages/projects/create.js')
    @endpush
</x-app-layout>