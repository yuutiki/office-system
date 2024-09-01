<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createReport') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />
                <form method="post" action="{{ route('reports.store') }}" enctype="multipart/form-data" id="reoportForm" class="">
                    @csrf
                    {{-- @can('storeUpdate_corporations') --}}
                        <x-button-save form-id="reoportForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">登録</span>
                        </x-button-save>
                    {{-- @endcan --}}
                </form>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <!-- 顧客検索ボタン(画面小) -->
        <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap sm:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>

        <div class="grid gap-4 mb-4 sm:grid-cols-3">
            <div class="flex md:mt-4">
                <div class="w-full flex flex-col">
                    <label for="client_num" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客№<span class="text-red-500"> *</span></label>
                    <input type="text" form="reoportForm" form="reoportForm" name="client_num" id="client_num" value="{{ old('client_num', $clientNum) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
                </div>
                <!-- 顧客検索ボタン(画面中～) -->
                <button type="button" onclick="showModal()" data-form="reoportForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden sm:block">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
            <div class="w-full flex flex-col md:mt-4">
                <label for="client_name" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">顧客名称<span class="text-red-500"> *</span></label>
                <input type="text" form="reoportForm" form="reoportForm" name="client_name" id="client_name" value="{{ old('client_name', $clientName) }}" class="input-readonly pointer-events-none" placeholder="" readonly>
            </div>
            <div class="w-full flex flex-col md:mt-4">
                <label for="affiliation2_id" class="font-normal text-sm dark:text-red-500 text-red-700 leading-none">管轄事業部<span class="text-red-500"> *</span></label>
                <input type="text" form="reoportForm" form="reoportForm" name="affiliation2_id" id="affiliation2_id" value="{{ old('affiliation2_id') }}" class="input-readonly pointer-events-none" placeholder="" readonly>
            </div>
            @error('client_num')
                <div class="text-red-500">{{$message}}</div>
            @enderror
        </div>  
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">営業報告</button>
                </li>
            </ul>
        </div>
        
        <div id="myTabContent">
            <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-1 mt-4">

                    <div class="w-full flex flex-col">
                        <label for="report_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">報告種別<span class="text-red-500">*</span></label>
                        <select id="report_type_id" form="reoportForm" name="report_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach ($reportTypes as $reportType)
                                <option value="{{ $reportType->id }}" @selected($reportType->id == old('report_type_id'))>{{ $reportType->report_type_name }}</option>
                            @endforeach
                        </select>
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror                    
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="contact_at" class="text-sm dark:text-red-500 text-red-700 leading-none">対応日付<span class="text-red-500">*</span></label>
                        <input type="date" form="reoportForm" min="2000-01-01" max="2100-12-31" name="contact_at" class="input-primary" id="contact_at" value="{{ old('contact_at', now()->format('Y-m-d')) }}" placeholder="">
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="contact_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">対応形式<span class="text-red-500">*</span></label>
                        <select id="contact_type_id" form="reoportForm" name="contact_type_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach ($contactTypes as $contactType)
                                <option value="{{ $contactType->id }}" @selected($contactType->id == old('contact_type_id'))>{{ $contactType->contact_type_name }}</option>
                            @endforeach
                        </select>
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="client_representative" class="text-sm dark:text-gray-100 text-gray-900 leading-none">先方担当者</label>
                        <input type="text" form="reoportForm" name="client_representative" class="input-primary" id="client_representative" value="{{ old('client_representative') }}" placeholder="">
                    </div>
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_title" class="text-sm dark:text-red-500 text-red-700 leading-none mt-8">報告タイトル<span class="text-red-500">*</span></label>
                        <input type="text" form="reoportForm" name="report_title" class="input-primary" id="report_title" value="{{ old('report_title') }}" placeholder="">
                    </div>
                    @error('report_title')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_content" class="text-sm dark:text-red-500 text-red-700 leading-none mt-4">報告内容<span class="text-red-500">*</span></label>
                        <textarea name="report_content" form="reoportForm" id="auto-resize-textarea-content" data-auto-resize="true" class="input-secondary" value="{{ old('report_content') }}" rows="5"></textarea>
                    </div>
                    @error('report_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_notice" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">特記事項</label>
                        <textarea name="report_notice" form="reoportForm" id="auto-resize-textarea-notice" data-auto-resize="true" class="input-secondary" value="{{ old('report_notice') }}" rows="5"></textarea>
                    </div>
                    @error('report_notice')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-8">
                    <span class="dark:text-white">報告先設定</span>
                    <ul class="pt-4 space-y-2 border-t border-gray-200 dark:border-gray-700"></ul>
                </div>

                <div class="grid gap-4 mb-4 sm:grid-cols-5">
                    <!-- 検索フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="affiliation1_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">氏名</label>
                        <input type="text" form="reoportForm" id="user_name" class="input-secondary" placeholder="ユーザ名で検索">
                    </div>

                    <!-- 所属1選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="affiliation1_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属1</label>
                        <select id="affiliation1_id" name="affiliation1_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation1s as $affiliation1)
                                <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == old('affiliation1_id'))>{{ $affiliation1->affiliation1_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 部署選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="affiliation2_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属2</label>
                        <select id="affiliation2_id" name="affiliation2_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 所属3選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="affiliation3_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属3</label>
                        <select id="affiliation3_id" name="affiliation3_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation3s as $affiliation3)
                                <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('affiliation3_id'))>{{ $affiliation3->affiliation3_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <button id="searchUsersButton" type="button">検索</button> --}}
                    <div class="w-full flex justify-self-end  flex-col  mt-auto">
                        <button type="button" id="searchUsersButton" class="md:ml-1 md:mt-1 w-full h-10 md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            ユーザ検索
                        </button>
                    </div>
                </div>

                <div class="md:flex md:flex-row">
                    <!-- 検索結果表示部分 -->
                    <div class=" md:w-1/2">
                        <div class="text-white">検索結果</div>
                        <div id="searchResults" class="text-white border h-48 overflow-y-scroll p-2 text-base rounded">
                            <!-- 検索結果はここに表示されます -->
                        </div>
                    </div>
                    
                    <!-- 選択された報告先表示部分 -->
                    <div class=" md:w-1/2">
                        <div class="text-white md:ml-3 mt-3 md:mt-0">報告先</div>
                        <div id="selectedRecipients" class="text-white border overflow-y-scroll h-48  md:mt-0 p-2 md:ml-3 rounded">
                            <!-- 選択された報告先はここに表示されます -->
                        </div>
                    </div>
                </div>

                <!-- 選択されたユーザのIDを保持する隠しフィールド -->
                <input type="hidden" form="reoportForm" id="selectedUsers" name="selectedRecipientsId[]">
            </div>
        </div>
    </div>


    {{-- <!-- 顧客検索Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center hidden animate-slide-in-top px-2 z-[99999]">
        <div class="max-h-full w-full max-w-7xl">
            <div class="relative p-2 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <!-- 検索結果カウント表示 -->
                    <div id="searchResultCount" class="text-sm text-gray-600 dark:text-gray-300 mt-2 ml-2"></div>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="#" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-x-2 mb-4 grid-cols-2 sm:grid-cols-3">
                        <div class="w-full flex flex-col mx-2 pr-2">
                            <label for="clientName" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" form="reoportForm" name="clientName" id="clientName" class="input-secondary">
                        </div>
                        <div class="w-full flex flex-col mx-2 pr-2">
                            <label for="clientNumber" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" form="reoportForm" name="clientNumber" id="clientNumber" class="input-secondary">
                        </div>
                        <div class="w-full flex flex-col mx-2 pr-2 col-span-2 sm:col-span-1">
                            <label for="affiliation2Id" class=" dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="affiliation2Id" name="affiliation2Id" class="input-secondary">
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
                            <tr class="border-b dark:border-gray-400">
                                <th class="py-1 pl-5">顧客名称</th>
                                <th class="py-1 whitespace-nowrap">顧客№</th>
                                <th class="py-1 whitespace-nowrap">事業部</th>
                            </tr>
                        </thead>
                        <tbody class="" id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex justify-end items-center p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                    <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- ユーザ検索モーダル -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center hidden animate-slide-in-top px-2 z-[99999]">
        <div class="max-h-full w-full max-w-7xl">
            <div class="relative p-2 bg-white rounded shadow dark:bg-gray-700">
                <!-- モーダル header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <div class="text-white font-medium ml-4 flex">
                        <div id="searchResultCount"><!-- 検索結果件数をJSで取得し表示 --></div>
                        <span>件</span>
                    </div>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- 検索条件入力フォーム -->
                <div class="grid gap-x-2 mb-4 grid-cols-2 sm:grid-cols-3">
                    <div class="w-full flex flex-col mx-2 pr-2">
                        <label for="clientName" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                        <input type="text" form="reoportForm" name="clientName" id="clientName" class="input-secondary">
                    </div>
                    <div class="w-full flex flex-col mx-2 pr-2">
                        <label for="clientNumber" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                        <input type="text" form="reoportForm" name="clientNumber" id="clientNumber" class="input-secondary">
                    </div>
                    <div class="w-full flex flex-col mx-2 pr-2 col-span-2 sm:col-span-1">
                        <label for="affiliation2Id" class=" dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                        <select id="affiliation2Id" name="affiliation2Id" class="input-secondary">
                            <option selected value="">未選択</option>
                            @foreach($affiliation2s as $affiliation2)
                            <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == Auth::user()->affiliation2->id)>
                                {{ $affiliation2->affiliation2_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    検索
                </button>

                <div class="max-h-80 overflow-x-auto mt-4 rounded border dark:border-gray-600">
                    <table class="w-full text-white text-left text-sm">
                        <thead class="sticky top-0 bg-white dark:bg-gray-600 border-l dark:border-gray-600">
                            <tr class="whitespace-nowrap">

                                <th class="py-3 pl-5 whitespace-nowrap">顧客名称</th>
                                <th class="py-3 whitespace-nowrap">顧客No.</th>
                                <th class="py-3 whitespace-nowrap">所属2</th>
                                <th class="py-3 whitespace-nowrap">営業担当</th>
                            </tr>
                        </thead>
                        <tbody id="searchResultsContainer" class="overflow-y-auto whitespace-nowrap">
                            <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                <!-- モーダル footer -->
                <div class="flex justify-end items-center p-2 mt-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="hideModal()" onkeydown="stopTab(event)" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>
















<script>
    // モーダルを表示するための関数
function showModal() {
    const modal = document.getElementById('clientSearchModal');
    const overlay = document.getElementById('overlay');
    overlay.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    modal.classList.remove('hidden');

    // モーダル内の最初の入力フィールドにフォーカスを設定
    setTimeout(() => {
        const firstInput = modal.querySelector('input, select, button');
        if (firstInput) firstInput.focus();
    }, 100);

    // モーダル内の要素にのみタブ移動を制限
    modal.addEventListener('keydown', trapFocus);
}

// モーダルを非表示にするための関数
function hideModal() {
    const modal = document.getElementById('clientSearchModal');
    const overlay = document.getElementById('overlay');
    overlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    modal.classList.add('hidden');

    // イベントリスナーを削除
    modal.removeEventListener('keydown', trapFocus);
}

// モーダル外へのフォーカス移動を防ぐ関数（更新版）
function trapFocus(e) {
    if (e.key === 'Tab') {
        const modal = document.getElementById('clientSearchModal');
        const focusableElements = modal.querySelectorAll('input, select, button, [tabindex]:not([tabindex="-1"])');
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }
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

        // 検索結果のカウントを表示
        searchResultCount.textContent = `${data.length}`;

        data.forEach((result, index) => {
            const resultElement = document.createElement('tr');
            resultElement.classList.add('dark:border-gray-600', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white', 'cursor-pointer', 'border-b');
            resultElement.setAttribute('tabindex', '0');  // タブ移動可能にする
            resultElement.setAttribute('role', 'button');  // スクリーンリーダー用にボタンとして認識させる
            resultElement.setAttribute('aria-label', `${result.client_name} を選択`);  // スクリーンリーダー用の説明
            resultElement.innerHTML = `
                <td class="py-2 pl-5 w-96">${result.client_name}</td>
                <td class="py-2 ml-2 whitespace-nowrap">${result.client_num}</td>
                <td class="py-2 ml-2">${result.affiliation2.affiliation2_name_short}</td>
                <td class="py-2 ml-2">${result.user.user_name}</td>
            `;
            resultElement.addEventListener('click', () => setCorporation(result.client_name, result.client_num, result.affiliation2.affiliation2_name));
            resultElement.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setCorporation(result.client_name, result.client_num, result.affiliation2.affiliation2_name);
                }
            });
            searchResultsContainer.appendChild(resultElement);
        });

        // 検索結果が表示されたら、最初の結果にフォーカスを移動
        if (data.length > 0) {
            searchResultsContainer.firstElementChild.focus();
        }
    });
}

function setCorporation(name, number, affiliation2) {
    document.getElementById('client_num').value = number;
    document.getElementById('client_name').value = name;
    document.getElementById('affiliation2_id').value = affiliation2;

    hideModal();
}

// モーダル外の要素のtabindexを設定/解除する関数
function setOutsideElementsTabIndex(disable) {
    const outsideElements = document.querySelectorAll('body > *:not(#clientSearchModal)');
    outsideElements.forEach(element => {
        if (disable) {
            element.setAttribute('tabindex', '-1');
        } else {
            element.removeAttribute('tabindex');
        }
    });
}

// ページ読み込み時にイベントリスナーを設定
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('clientSearchModal');
    
    // モーダルが表示されたときの処理
    modal.addEventListener('show', () => {
        setOutsideElementsTabIndex(true);
    });

    // モーダルが非表示になったときの処理
    modal.addEventListener('hide', () => {
        setOutsideElementsTabIndex(false);
    });
});
</script>




    <script>
        $(document).ready(function() {
            // ページ読み込み時にローカルストレージから選択されたユーザのIDを取得して隠しフィールドに設定
            var selectedUserIds = JSON.parse(localStorage.getItem('selectedUserIds')) || [];
            $('#selectedUsers').val(selectedUserIds.join(','));

            // ページ読み込み時にローカルストレージから選択されたユーザの情報を取得して表示
            selectedUserIds.forEach(function(userId) {
                var userName = localStorage.getItem('userName_' + userId);
                $('#selectedRecipients').prepend('<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + userName + '</div>');
            });

            // ユーザを非同期で検索して検索結果表示部分に表示する
            $('#searchUsersButton').click(function() {
                var userNmae = $('#user_name').val();
                var affiliation1Id = $('#affiliation1_id').val();
                var affiliation2Id = $('#affiliation2_id').val();
                var affiliation3Id = $('#affiliation3_id').val();
                $.ajax({
                    url: '/search-users',
                    method: 'GET',
                    data: {
                        user_name: userNmae,
                        affiliation1_id: affiliation1Id,
                        affiliation2_id: affiliation2Id,
                        affiliation3_id: affiliation3Id
                    },
                    success: function(response) {
                        // 検索結果をカナ名称順にソート
                        response.sort(function(a, b) {
                            var nameA = a.user_kana_name.toUpperCase(); // 大文字と小文字を区別しない
                            var nameB = b.user_kana_name.toUpperCase(); // 大文字と小文字を区別しない
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0;
                        });
                        // 検索結果を表示する部分
                        var usersHtml = '';
                        response.forEach(function(user) {
                            // 重複するユーザを検索結果から除外する
                            if (!selectedUserIds.includes(user.id)) {
                                usersHtml += '<div class="selectUser cursor-pointer" data-user-id="' + user.id + '" data-user-name="' + user.user_name + '">' + user.user_name + '</div>';
                            }
                        });
                        $('#searchResults').html(usersHtml);
                    },
                    error: function(xhr) {
                        console.log('検索エラー:', xhr);
                    }
                });
            });

            // 検索結果表示部分のユーザ名をクリックまたはキーボードで選択・移動する
            $(document).on('click keydown', '.selectUser', function(e) {
                // キーボードイベントかどうかを確認
                var isKeyboardEvent = e.type === 'keydown';

                // エンターキーが押された場合、またはマウスクリックの場合の処理
                if (!isKeyboardEvent || (isKeyboardEvent && e.key === 'Enter')) {
                    var userId = $(this).data('user-id');
                    var userName = $(this).data('user-name');
                    // 選択されたユーザを表示
                    var selectedUsers = $('#selectedRecipients').children('.selectedUser');
                    var inserted = false;
                    selectedUsers.each(function() {
                        var selectedUserName = $(this).text();
                        if (userName.localeCompare(selectedUserName, 'ja', {sensitivity: 'base'}) < 0) {
                            $(this).before('<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + userName + '</div>');
                            inserted = true;
                            return false; // Break the loop
                        }
                    });
                    if (!inserted) {
                        $('#selectedRecipients').append('<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + userName + '</div>');
                    }
                    // 選択されたユーザの情報をローカルストレージに保存
                    selectedUserIds.push(userId);
                    localStorage.setItem('userName_' + userId, userName);
                    localStorage.setItem('selectedUserIds', JSON.stringify(selectedUserIds));
                    // 選択されたユーザを検索結果から削除
                    $(this).remove();
                    // 選択されたユーザのIDを隠しフィールドに設定
                    $('#selectedUsers').val(selectedUserIds.join(','));
                }
            });

            // 選択された報告先表示部分のユーザ名をクリックして検索結果に戻す
            $(document).on('click', '.selectedUser', function() {
                var userId = $(this).data('user-id');
                var userName = $(this).text();
                // 選択されたユーザを検索結果に追加
                $('#searchResults').append('<div class="selectUser cursor-pointer" data-user-id="' + userId + '" data-user-name="' + userName + '">' + userName + '</div>');
                // 選択されたユーザの情報をローカルストレージから削除
                var index = selectedUserIds.indexOf(userId);
                if (index !== -1) {
                    selectedUserIds.splice(index, 1);
                    localStorage.removeItem('userName_' + userId);
                    localStorage.setItem('selectedUserIds', JSON.stringify(selectedUserIds));
                }
                // 選択されたユーザを選択済みの報告先表示部分から削除
                $(this).remove();
                // 選択されたユーザのIDを隠しフィールドに設定
                $('#selectedUsers').val(selectedUserIds.join(','));
            });
        });
    </script>

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/stopTab.js') }}"></script>
</x-app-layout>