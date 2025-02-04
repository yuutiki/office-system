<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editreport') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />
                <form method="post" action="{{ route('reports.update', $report) }}" enctype="multipart/form-data" id="reoportForm" class="">
                    @csrf
                    @method('patch')
                    {{-- @can('storeUpdate_corporations') --}}
                        <x-button-save form-id="reoportForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">更新</span>
                        </x-button-save>
                    {{-- @endcan --}}
                </form>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <!-- 顧客検索ボタン(画面小) -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap sm:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>

        <div class="grid gap-4 mb-4 lg:grid-cols-4">
            <div class="flex lg:mt-4">
                <div class="w-full flex flex-col">
                    <label for="client_num" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客№<span class="text-red-500"> *</span></label>
                    <input type="text" form="reoportForm" name="client_num" id="client_num" value="{{ old('client_num', $report->client->client_num) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
                </div>
                <!-- 顧客検索ボタン(画面中～) -->
                <button type="button" onclick="ClientSearchModal.show('clientSearchModal1')" data-form="reoportForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden sm:block">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
            <div class="w-full flex flex-col lg:mt-4">
                <label for="client_name" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客名称<span class="text-red-500"> *</span></label>
                <input type="text" form="reoportForm" name="client_name" id="client_name" value="{{ old('client_name', $report->client->client_name) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
            </div>
            {{-- <div class="w-full flex flex-col lg:mt-4">
                <label for="affiliation2_id" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">管轄事業部<span class="text-red-500"> *</span></label>
                <input type="text" form="reoportForm" name="affiliation2_id" id="affiliation2_id" value="{{ old('affiliation2_id', $report->client->affiliation2->affiliation2_name) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
            </div> --}}
            <div class="w-full flex flex-col lg:mt-4">
                <label for="sales_user" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">営業担当<span class="text-red-500"> *</span></label>
                <input type="text" form="reoportForm" name="sales_user" id="sales_user" value="{{ old('sales_user', $report->client->user->user_name) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
            </div>
            @error('client_num')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>



        <div class="text-black dark:bg-white w-10">
            {{ $report->notification }}
        </div>


        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">営業報告</button>
                </li>
            </ul>
        </div>

        <div id="myTabContent">
            <div class="hidden p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-1 mt-4">
                    <div class="w-full flex flex-col">
                        <label for="report_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">報告種別<span class="text-red-500">*</span></label>
                        <select id="report_type_id" form="reoportForm" name="report_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach ($reportTypes as $reportType)
                                <option value="{{ $reportType->id }}" @selected($reportType->id == old('report_type_id', $report->report_type_id ))>{{ $reportType->report_type_name }}</option>
                            @endforeach
                        </select>
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror                    
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="contact_at" class="text-sm dark:text-red-500 text-red-700 leading-none">対応日付<span class="text-red-500">*</span></label>
                        <input type="date" form="reoportForm" min="2000-01-01" max="2100-12-31" name="contact_at" class="input-primary" id="contact_at" value="{{ old('contact_at', $report->contact_at) }}" placeholder="">
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="contact_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">対応形式<span class="text-red-500">*</span></label>
                        <select id="contact_type_id" form="reoportForm" name="contact_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach ($contactTypes as $contactType)
                                <option value="{{ $contactType->id }}" @selected($contactType->id == old('contact_type_id', $report->contact_type_id))>{{ $contactType->contact_type_name }}</option>
                            @endforeach
                        </select>
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="client_representative" class="text-sm dark:text-gray-100 text-gray-900 leading-none">先方担当者</label>
                        <input type="text" form="reoportForm" name="client_representative" class="input-primary" id="client_representative" value="{{ old('client_representative', $report->client_representative) }}" placeholder="">
                    </div>
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_title" class="text-sm dark:text-red-500 text-red-700 leading-none mt-8">報告タイトル<span class="text-red-500">*</span></label>
                        <input type="text" form="reoportForm" name="report_title" class="input-primary" id="report_title" value="{{ old('report_title', $report->report_title) }}" placeholder="">
                    </div>
                    @error('report_title')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_content" class="text-sm dark:text-red-500 text-red-700 leading-none mt-4">報告内容<span class="text-red-500">*</span></label>
                        <textarea name="report_content" form="reoportForm" id="auto-resize-textarea-content" data-auto-resize="true" class="input-secondary" rows="5">{{ old('report_content', $report->report_content) }}</textarea>
                    </div>
                    @error('report_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_notice" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">特記事項</label>
                        <textarea name="report_notice" form="reoportForm" id="auto-resize-textarea-notice" data-auto-resize="true" class="input-secondary" rows="5">{{ old('report_notice', $report->report_notice) }}</textarea>
                    </div>
                    @error('report_notice')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                                

                {{-- <!-- ユーザ検索フォーム -->
                <input type="text" id="userSearch" class="border border-gray-300 rounded px-3 py-1 w-full mb-2" placeholder="ユーザを検索...">

                <!-- ユーザ検索結果のリスト -->
                <ul id="userList" class="border border-gray-300 rounded px-3 py-2 h-60 overflow-y-scroll dark:text-white">
                    @foreach($users as $user)
                    <li data-user-id="{{ $user->id }}">
                        <label>
                            <input type="checkbox" class="mr-2"  name="selectedRecipientsId[]" value="{{ $user->id }}">
                            {{ $user->user_name }}
                        </label>
                    </li>
                    @endforeach
                </ul>

                <!-- 選択済みユーザーのリスト -->
                <ul id="selectedUserList" class="border border-gray-300 rounded px-3 py-2 h-60 overflow-y-scroll dark:text-white">
                    <!-- ここに選択済みユーザーが追加されます -->
                </ul> --}}
            </div>
        </div>
    </div>

    {{-- 各画面のBladeテンプレート --}}
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
            document.getElementById('client_name').value = client.client_name;
            document.getElementById('sales_user').value = client.user.user_name;
        }
        // モーダルのコールバック関数を設定
        window.clientSearchModal1_onSelect = handleClientSelect;
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>
    <script src="{{ asset('assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>