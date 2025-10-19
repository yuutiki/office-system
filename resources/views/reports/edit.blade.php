{{-- resources/views/reports/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editReport') }}
            </h2>
            <div class="ml-auto flex">
                <form method="post" action="{{ route('reports.update', $report) }}" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('patch')
                    {{-- @can('storeUpdate_corporations') --}}
                        <x-button-save form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">更新</span>
                        </x-button-save>
                    {{-- @endcan --}}
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <!-- 顧客検索ボタン(画面小) -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap md:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>

        <div class="mx-auto my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <div class="hidden">
                        <label for="client_id">顧客ID（非表示）</label>
                        <input type="hidden" form="editForm" name="client_id" id="client_id" value="{{ old('client_id', $report->client_id) }}">
                    </div>
                    <!-- 顧客No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:py-0.5  md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <span>顧客No.</span>
                                <button type="button" onclick="ClientSearchModal.show('clientSearchModal')"  data-form="editForm"
                                    class="ml-2 p-1.5 text-sm font-medium h-[30px] text-white bg-blue-700 rounded border border-blue-700 
                                        hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700
                                        dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 
                                        focus:ring-offset-2 dark:focus:ring-offset-gray-800 hidden md:block">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1.5 md:px-2 md:py-1">
                            <input type="text" form="editForm" name="client_num" id="client_num" value="{{ old('client_num', $report->client->client_num) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-48">
                            顧客名称
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="editForm" name="client_name" id="client_name" value="{{ old('client_name', $report->client->client_name) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 管轄部門 -->
                    <tr class="dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800">
                            営業担当
                        </th>
                        <td class="dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="editForm" name="sales_user" id="sales_user" value="{{ old('sales_user', $report->client->user->user_name) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @error('client_id')
            <div class="validate-message">{{ $message }}</div>
        @enderror


        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">営業報告</button>
                </li>
            </ul>
        </div>

        <div id="myTabContent">
            <div class="hidden p-4 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="grid gap-4 mb-4 md:grid-cols-4 grid-cols-1 mt-4">
                    <div class="w-full flex flex-col">
                        <label for="report_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">報告種別<span class="text-red-500">*</span></label>
                        <select id="report_type_id" form="editForm" name="report_type_id" class="input-primary">
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
                        <input type="date" form="editForm" min="2000-01-01" max="2100-12-31" name="contact_at" class="input-primary" id="contact_at" value="{{ old('contact_at', $report->contact_at) }}" placeholder="">
                        @error('report_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="contact_type_id" class="text-sm dark:text-red-500 text-red-700 leading-none">対応形式<span class="text-red-500">*</span></label>
                        <select id="contact_type_id" form="editForm" name="contact_type_id" class="input-primary">
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
                        <label for="user_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none">報告者</label>
                        <input type="text" form="editForm" name="user_id" class="input-readonly" id="user_id" value="{{ old('user_id', $report->reporter->user_name) }}" disabled>
                    </div>
                </div>



        <!-- 顧客担当者アコーディオン -->
        <div id="accordion" class="w-full mx-auto space-y-2">
            <div class="border border-gray-600 rounded shadow-sm overflow-hidden">
                <button type="button" class="accordion-btn w-full text-left py-2 px-4 flex items-center justify-between bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors rounded"
                    aria-expanded="false" aria-controls="panel-2">
                    <span class="flex items-center text-gray-900 dark:text-gray-100 font-semibold text-sm md:text-base">
                        顧客担当者
                    </span>
                    <svg class="arrow w-5 h-5 transform transition-transform duration-300 text-white" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M6 8l4 4 4-4" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <div id="panel-2"
                    class="accordion-panel px-4 py-3 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm md:text-base hidden border-t border-gray-200 dark:border-gray-600 rounded-b">

                    <div id="clientContactsContainer" class="space-y-2">
                        <div id="clientContactsList"
                            class="border border-gray-600 rounded p-3 bg-white dark:bg-gray-800 max-h-52 overflow-y-auto space-y-1 shadow-inner">
                            <!-- チェックボックス動的生成 -->
                        </div>
                    </div>

                    <input type="hidden" form="editForm" name="client_contact_ids[]" id="selectedClientContacts">
                </div>
            </div>
        </div>




                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_title" class="text-sm dark:text-red-500 text-red-700 leading-none mt-8">報告タイトル<span class="text-red-500">*</span></label>
                        <input type="text" form="editForm" name="report_title" class="input-primary" id="report_title" value="{{ old('report_title', $report->report_title) }}" placeholder="">
                    </div>
                    @error('report_title')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_content" class="text-sm dark:text-red-500 text-red-700 leading-none mt-4">報告内容<span class="text-red-500">*</span></label>
                        <textarea name="report_content" form="editForm" id="auto-resize-textarea-content" data-auto-resize="true" class="input-secondary" rows="5">{{ old('report_content', $report->report_content) }}</textarea>
                    </div>
                    @error('report_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="w-full flex flex-col">
                        <label for="report_notice" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">特記事項</label>
                        <textarea name="report_notice" form="editForm" id="auto-resize-textarea-notice" data-auto-resize="true" class="input-secondary" rows="5">{{ old('report_notice', $report->report_notice) }}</textarea>
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

                    <input type="text" form="editForm" name="project_id" id="project_id" value="{{ old('project_id', optional($report->project)->project_id) }}" class="hidden">
    
                    <div class="flex md:mt-4">
                        <div class="w-full flex flex-col">
                            <label for="project_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none">プロジェクトNo.</label>
                            <input type="text" form="editForm" name="project_num" id="project_num" value="{{ old('project_num', optional($report->project)->project_num) }}" class="input-readonly" placeholder="" readonly tabindex="-1">
                        </div>
                        <!-- 顧客検索ボタン(画面中～) -->
                        <button type="button" onclick="ProjectSearchModal.show('projectSearchModal1')" data-form="editForm" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[18px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden sm:block">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex flex-col md:mt-4">
                        <label for="project_client_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">顧客名称</label>
                        <input type="text" form="editForm" name="project_client_name" id="project_client_name" value="{{ old('project_client_name', $report->project->client->client_name ?? '') }}" class="input-readonly" readonly tabindex="-1">
                    </div>
                    <div class="w-full flex flex-col md:mt-4 col-span-2">
                        <label for="project_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none">プロジェクト名称</label>
                        <input type="text" form="editForm" name="project_name" id="project_name" value="{{ old('project_name', optional($report->project)->project_name) }}" class="input-readonly" readonly tabindex="-1">
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
                        <input type="text" form="editForm" id="user_name" class="input-secondary" placeholder="ユーザ名で検索">
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

                    <!-- 所属2選択フォーム -->
                    <div class="w-full flex flex-col">
                        <label for="user_affiliation2_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">所属2</label>
                        <select id="user_affiliation2_id" name="user_affiliation2_id" class="input-secondary">
                            <option value="">未選択</option>
                            @foreach ($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('user_affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full flex justify-self-end flex-col mt-auto">
                        <button type="button" id="searchUsersButton" class="md:ml-1 md:mt-1 w-full h-10 md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            ユーザ検索
                        </button>
                    </div>
                </div>

                <div class="md:flex md:flex-row">

                    <!-- 検索結果表示部分 -->
                    <div class="md:w-1/2">
                        <div class="dark:text-white">検索結果</div>
                        <div id="searchResults" class="dark:text-white border h-48 overflow-y-scroll p-2 text-base rounded dark:bg-gray-600 border-gray-900">
                            <!-- 検索結果はここに表示されます -->
                        </div>
                    </div>

                    <!-- 選択された報告先表示部分 -->
                    <div class="md:w-1/2">
                        <div class="dark:text-white md:ml-3 mt-3 md:mt-0">報告先</div>
                        <div id="selectedRecipients" class="dark:text-white border overflow-y-scroll h-48 md:mt-0 p-2 md:ml-3 rounded dark:bg-gray-600 border-gray-900">
                            <!-- 初期表示用：保存済み報告先 -->
                            @foreach ($report->recipients as $user)
                                <div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="{{ $user->id }}">
                                    {{ $user->user_name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 選択されたユーザのIDを保持する隠しフィールド -->
                <input type="hidden" form="editForm" id="selectedUsers" name="selectedRecipientsId[]">
            </div>
        </div>
    </div>

    {{-- 各画面のBladeテンプレート --}}
    <x-modals.client-search-modal
        modalId="clientSearchModal"
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
    // ✅ 顧客選択モーダルから呼ばれるコールバック関数
    function handleClientSelect(client) {
        const clientIdInput = document.getElementById('client_id');
        const clientNumInput = document.getElementById('client_num');
        const clientNameInput = document.getElementById('client_name');
        const salesUserInput = document.getElementById('sales_user');

        // 変更前の顧客IDを保持
        const beforeClientId = clientIdInput.value;

        // 顧客が変更された場合に確認ダイアログを出す
        if (beforeClientId && beforeClientId != client.id) {
            const confirmChange = confirm('顧客を変更すると、現在の担当者選択はリセットされます。\n本当に変更しますか？');
            if (!confirmChange) {
                return; // キャンセルされた場合は処理を中断
            }
        }

        // 顧客情報をフォームに反映
        clientIdInput.value = client.id;
        clientNumInput.value = client.client_num;
        clientNameInput.value = client.client_name;
        salesUserInput.value = client.user.user_name;

        // ✅ 顧客変更イベントを強制発火して担当者リストを再取得
        clientIdInput.dispatchEvent(new Event('change'));
    }

    // グローバルコールバック登録
    window.clientSearchModal_onSelect = handleClientSelect;

    // ✅ DOMロード後に担当者リスト制御
    document.addEventListener('DOMContentLoaded', () => {
        const clientIdInput = document.getElementById('client_id');
        const container = document.getElementById('clientContactsList');
        const selectedInput = document.getElementById('selectedClientContacts');

        // 初期状態で登録済み担当者IDをセット（Laravelから埋め込む）
        let selectedIds = @json($report->clientContacts->pluck('id')->toArray());

        // 初期表示：既存の顧客担当者リストを取得
        if (clientIdInput.value) {
            fetchContacts(clientIdInput.value, selectedIds);
        }

        // ✅ 顧客変更時に担当者リストを再取得＆選択状態クリア
        clientIdInput.addEventListener('change', (e) => {
            selectedIds = []; // チェック状態リセット
            selectedInput.value = '';
            fetchContacts(e.target.value, selectedIds);
        });

        // ✅ 担当者リストをAjaxで取得して描画
        function fetchContacts(clientId, selectedIds) {
            if (!clientId) {
                container.innerHTML = '<p class="text-gray-400">顧客を選択してください。</p>';
                return;
            }

            fetch(`/client-contacts/ajax/${clientId}`)
                .then(res => res.json())
                .then(resData => {
                    const contacts = resData.data;
                    container.innerHTML = '';

                    if (!contacts.length) {
                        container.innerHTML = '<p class="text-gray-400">担当者が登録されていません。</p>';
                        return;
                    }

                    contacts.forEach(contact => {
                        const label = document.createElement('label');
                        label.classList.add('flex', 'items-center', 'mb-1', 'cursor-pointer');

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.value = contact.id;
                        checkbox.classList.add('mr-2', 'rounded', 'border-gray-300', 'focus:ring-indigo-500');

                        // ✅ 初期表示時のみチェックを反映
                        if (selectedIds.includes(contact.id)) {
                            checkbox.checked = true;
                        }

                        checkbox.addEventListener('change', () => {
                            if (checkbox.checked) {
                                selectedIds.push(contact.id);
                            } else {
                                selectedIds = selectedIds.filter(i => i !== contact.id);
                            }
                            selectedInput.value = selectedIds.join(',');
                        });

                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(`${contact.name} (${contact.department} / ${contact.position})`));
                        container.appendChild(label);
                    });

                    selectedInput.value = selectedIds.join(',');
                })
                .catch(err => console.error('顧客担当者取得エラー:', err));
        }
    });
</script>

<script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>



    @push('scripts')
        @vite('resources/js/pages/reports/edit.js')
    @endpush
</x-app-layout>