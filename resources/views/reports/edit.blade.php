<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editreport') }}
            </h2>
            <div class="ml-auto flex">
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

        <div class="grid gap-4 mb-4 lg:grid-cols-3">
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



        {{-- <div class="text-black dark:bg-white w-10">
            {{ $report->notification }}
        </div> --}}


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
                    <div class="w-full flex flex-col">
                        <label for="user_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none">報告者</label>
                        <input type="text" form="reoportForm" name="user_id" class="input-primary" id="user_id" value="{{ old('user_id', $report->reporter->user_name) }}" disabled>
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

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <!-- 顧客検索ボタン(画面：小) -->
                    <button type="button" onclick="ClientSearchModal.show('projectSearchModal1')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap sm:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        プロジェクト検索
                    </button>

                    <input type="text" form="reoportForm" name="project_id" id="project_id" value="{{ old('project_id', optional($report->project)->project_id) }}" class="hidden">
    
                    <div class="flex md:mt-4">
                        <div class="w-full flex flex-col">
                            <label for="project_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none">プロジェクトNo.</label>
                            <input type="text" form="reoportForm" name="project_num" id="project_num" value="{{ old('project_num', optional($report->project)->project_num) }}" class="input-readonly" placeholder="" readonly tabindex="-1">
                        </div>
                        <!-- 顧客検索ボタン(画面中～) -->
                        <button type="button" onclick="ProjectSearchModal.show('projectSearchModal1')" data-form="reoportForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden sm:block">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex flex-col md:mt-4">
                        <label for="project_client_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">顧客名称</label>
                        <input type="text" form="reoportForm" name="project_client_name" id="project_client_name" value="{{ old('project_client_name', $report->project->client->client_name ?? '') }}" class="input-readonly" readonly tabindex="-1">
                    </div>
                    <div class="w-full flex flex-col md:mt-4">
                        <label for="project_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">プロジェクト名称</label>
                        <input type="text" form="reoportForm" name="project_name" id="project_name" value="{{ old('project_name', optional($report->project)->project_name) }}" class="input-readonly" readonly tabindex="-1">
                    </div>
                </div>
    

                <div class="mt-8">
                    <span class="dark:text-white">報告先設定</span>
                    <ul class="pt-4 space-y-2 border-t border-gray-200 dark:border-gray-700"></ul>
                </div>
    
                <div class="grid gap-4 mb-4 sm:grid-cols-5">
                    <!-- 検索フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="user_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">氏名</label>
                        <input type="text" form="reoportForm" id="user_name" class="input-secondary" placeholder="ユーザ名で検索">
                    </div>
    
                    <!-- 所属1選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="user_affiliation1_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属1</label>
                        <select id="user_affiliation1_id" name="user_affiliation1_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation1s as $affiliation1)
                                <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == old('user_affiliation1_id'))>{{ $affiliation1->affiliation1_name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- 部署選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="user_affiliation2_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属2</label>
                        <select id="user_affiliation2_id" name="user_affiliation2_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('user_affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- 所属3選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="user_affiliation3_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属3</label>
                        <select id="user_affiliation3_id" name="user_affiliation3_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation3s as $affiliation3)
                                <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('user_affiliation3_id'))>{{ $affiliation3->affiliation3_name }}</option>
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
                        <div class="dark:text-white">検索結果</div>
                        <div id="searchResults" class="dark:text-white border h-48 overflow-y-scroll p-2 text-base rounded border-gray-900">
                            <!-- 検索結果はここに表示されます -->
                        </div>
                    </div>
                    
                    <!-- 選択された報告先表示部分 -->
                    <div class=" md:w-1/2">
                        <div class="dark:text-white md:ml-3 mt-3 md:mt-0">報告先</div>
                        <div id="selectedRecipients" class="dark:text-white border overflow-y-scroll h-48 md:mt-0 p-2 md:ml-3 rounded border-gray-900">
                            <!-- 選択された報告先はここに表示されます -->
                        </div>
                    </div>
                </div>
    
                <!-- 選択されたユーザのIDを保持する隠しフィールド -->
                <input type="hidden" form="reoportForm" id="selectedUsers" name="selectedRecipientsId[]">
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

    <x-modals.project-search-modal 
        modalId="projectSearchModal1" 
        screenId="keepfile_create" 
        :users="$users" 
        onSelectCallback="handleProjectSelect" 
    />

<script>
    // プロジェクト選択時の処理を定義
    function handleProjectSelect(project) {
        // 選択されたプロジェクトの情報を各フィールドに設定
        document.getElementById('project_id').value = project.id;
        document.getElementById('project_num').value = project.project_num;
        document.getElementById('project_name').value = project.project_name;
        document.getElementById('project_client_name').value = project.client.client_name;
        // document.getElementById('project_manager').value = project.user.user_name;
    }
    // モーダルのコールバック関数を設定
    window.projectSearchModal1_onSelect = handleProjectSelect;
</script>
<script src="{{ asset('/assets/js/modal/project-search-modal.js') }}"></script>
        
        
        
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







    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // ストレージ管理用のオブジェクト
            var initialRecipients = @json($recipients);

            var storageManager = {
                selectedUserIds: [],
                
                // ストレージ全体を更新
                updateStorage: function() {
                    localStorage.setItem('selectedUserIds', JSON.stringify(this.selectedUserIds));
                    console.log('ストレージ更新後のselectedUserIds:', this.selectedUserIds);
                },

                // ユーザーを追加
                addUser: function(userId, userName) {
                    if (!this.selectedUserIds.includes(userId)) {
                        this.selectedUserIds.push(userId);
                        localStorage.setItem('userName_' + userId, userName);
                        this.updateStorage();
                    }
                },

                // ユーザーを削除
                removeUser: function(userId) {
                    var index = this.selectedUserIds.indexOf(userId);
                    if (index !== -1) {
                        this.selectedUserIds.splice(index, 1);
                        localStorage.removeItem('userName_' + userId);
                        this.updateStorage();
                    }
                },

                // ユーザー名を取得
                getUserName: function(userId) {
                    return localStorage.getItem('userName_' + userId);
                },

                // 初期データのロード
                loadInitialData: function(recipients) {
                    // LocalStorageをクリア
                    this.selectedUserIds.forEach(userId => {
                        localStorage.removeItem('userName_' + userId);
                    });
                    this.selectedUserIds = [];
                    
                    // 初期データをロード
                    recipients.forEach(recipient => {
                        this.selectedUserIds.push(recipient.id.toString());
                        localStorage.setItem('userName_' + recipient.id, recipient.user_name);
                    });
                    
                    this.updateStorage();
                }
            };

            // DOM要素
            var elements = {
                selectedUsers: document.getElementById('selectedUsers'),
                selectedRecipients: document.getElementById('selectedRecipients'),
                searchResults: document.getElementById('searchResults'),
                searchButton: document.getElementById('searchUsersButton'),
                userName: document.getElementById('user_name'),
                userAffiliation1: document.getElementById('user_affiliation1_id'),
                userAffiliation2: document.getElementById('user_affiliation2_id'),
                userAffiliation3: document.getElementById('user_affiliation3_id')
            };

            // 初期化処理
            function initialize() {
                elements.selectedUsers.value = storageManager.selectedUserIds.join(',');
                storageManager.selectedUserIds.forEach(function(userId) {
                    var userName = storageManager.getUserName(userId);
                    elements.selectedRecipients.insertAdjacentHTML(
                        'afterbegin',
                        '<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + userName + '</div>'
                    );
                });
            }

            // ユーザー検索
            elements.searchButton.addEventListener('click', function() {
                var params = new URLSearchParams({
                    user_name: elements.userName.value,
                    affiliation1_id: elements.userAffiliation1.value,
                    affiliation2_id: elements.userAffiliation2.value,
                    affiliation3_id: elements.userAffiliation3.value
                });

                fetch('/search-users?' + params)
                    .then(response => response.json())
                    .then(function(response) {
                        var filteredUsers = response.filter(function(user) {
                            return !storageManager.selectedUserIds.some(id => id == user.id);
                        });

                        var sortedUsers = filteredUsers.sort(function(a, b) {
                            return a.user_kana_name.toUpperCase()
                                .localeCompare(b.user_kana_name.toUpperCase());
                        });

                        var usersHtml = sortedUsers
                            .map(user => 
                                '<div class="selectUser cursor-pointer" data-user-id="' + 
                                user.id + '" data-user-name="' + user.user_name + '">' + 
                                user.user_name + '</div>'
                            ).join('');

                        elements.searchResults.innerHTML = usersHtml;
                    })
                    .catch(function(error) {
                        console.log('検索エラー:', error);
                    });
            });

            // ユーザー選択処理
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('selectUser')) {
                    handleUserSelection(e.target);
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.target.classList.contains('selectUser') && e.key === 'Enter') {
                    handleUserSelection(e.target);
                }
            });

            // 初期化処理
            function initialize() {
                // 更新画面の場合は初期データをロード
                if (typeof initialRecipients !== 'undefined') {
                    storageManager.loadInitialData(initialRecipients);
                } else {
                    // 新規作成の場合はLocalStorageから読み込む
                    storageManager.selectedUserIds = JSON.parse(localStorage.getItem('selectedUserIds')) || [];
                }
                
                // 選択済みユーザーを表示
                elements.selectedRecipients.innerHTML = '';
                elements.selectedUsers.value = storageManager.selectedUserIds.join(',');
                
                storageManager.selectedUserIds.forEach(function(userId) {
                    var userName = storageManager.getUserName(userId);
                    elements.selectedRecipients.insertAdjacentHTML(
                        'beforeend',
                        '<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + userName + '</div>'
                    );
                });
            }

            function handleUserSelection(element) {
                var userId = element.dataset.userId;
                var userName = element.dataset.userName;
                var selectedUsers = elements.selectedRecipients.querySelectorAll('.selectedUser');
                var inserted = false;

                for (var i = 0; i < selectedUsers.length; i++) {
                    var selectedUserName = selectedUsers[i].textContent;
                    if (userName.localeCompare(selectedUserName, 'ja', {sensitivity: 'base'}) < 0) {
                        selectedUsers[i].insertAdjacentHTML(
                            'beforebegin',
                            '<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + 
                            userName + '</div>'
                        );
                        inserted = true;
                        break;
                    }
                }

                if (!inserted) {
                    elements.selectedRecipients.insertAdjacentHTML(
                        'beforeend',
                        '<div class="selectedUser cursor-pointer" data-user-id="' + userId + '">' + 
                        userName + '</div>'
                    );
                }

                storageManager.addUser(userId, userName);
                element.remove();
                elements.selectedUsers.value = storageManager.selectedUserIds.join(',');
            }

            // ユーザー選択解除処理
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('selectedUser')) {
                    var userId = e.target.dataset.userId;
                    var userName = e.target.textContent;

                    elements.searchResults.insertAdjacentHTML(
                        'beforeend',
                        '<div class="selectUser cursor-pointer" data-user-id="' + userId + 
                        '" data-user-name="' + userName + '">' + userName + '</div>'
                    );

                    storageManager.removeUser(userId);
                    e.target.remove();
                    elements.selectedUsers.value = storageManager.selectedUserIds.join(',');
                }
            });

            // 初期化実行
            initialize();
        });
    </script>
</x-app-layout>