<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                営業報告登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onClick="history.back()">
                    {{-- <x-general-button onclick="location.href='{{route('report.index')}}'"> --}}
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form id="reoportForm" method="post" action="{{route('report.store')}}" enctype="multipart/form-data">
                @csrf

                <!-- 顧客検索ボタン -->
                <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    顧客検索
                </button>

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div class="">
                        <label for="client_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                        <input type="text" name="client_num" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_num" value="{{$clientNum}}" placeholder="顧客検索してください" readonly>
                    </div>     
                    <div class="">
                        <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                        <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{$clientName}}" readonly>
                    </div>
                </div>


                <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">

                    {{-- <div>
                        <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                        <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">営業報告</button>
                        </li>
                    </ul>
                </div>
                
                <div id="myTabContent">
                    <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="w-full flex flex-col">
                            <label for="report_type_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">報告種別</label>
                            <select id="report_type_id" name="report_type_id" class="block w-48 py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach ($reportTypes as $reportType)
                                    <option value="{{ $reportType->id }}" @selected($reportType->id == old('report_type_id'))>{{ $reportType->report_type_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-1">
                            <div class="w-full flex flex-col">
                                <label for="contact_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対応日付</label>
                                <input type="date" min="2000-01-01" max="2100-12-31" name="contact_at" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 p-locality p-street-address p-extended-address" id="contact_at" value="{{ old('contact_at', now()->format('Y-m-d')) }}" placeholder="">
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="contact_type_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対応形式</label>
                                <select id="contact_type_id" name="contact_type_id" class="w-auto py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach ($contactTypes as $contactType)
                                        <option value="{{ $contactType->id }}" @selected($contactType->id == old('contact_type_id'))>{{ $contactType->contact_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="client_representative" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客担当者</label>
                                <input type="text" name="client_representative" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_representative" value="{{old('client_representative')}}" placeholder="">
                            </div>
                        </div>

                        <div class="w-full flex flex-col">
                            <label for="report_title" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">報告タイトル</label>
                            <input type="text" name="report_title" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="report_title" value="{{old('report_title')}}" placeholder="">
                        </div>

                        <div class="relative mb-4 mt-4">
                            <label for="report_content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">報告内容</label>
                            <textarea name="report_content" id="auto-resize-textarea-content" data-auto-resize="true" class="resize-none block w-full py-1 border focus:outline-none focus:ring focus:border-blue-300 rounded mt-1" value="{{old('report_content')}}" rows="5"></textarea>
                        </div>

                        <div class="relative mb-4 mt-4">
                            <label for="report_notice" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">特記事項</label>
                            <textarea name="report_notice" id="auto-resize-textarea-notice" data-auto-resize="true" class="resize-none  block w-full py-1 border focus:outline-none focus:ring focus:border-blue-300 rounded mt-1" value="{{old('report_notice')}}" rows="5"></textarea>
                        </div>




                        {{-- <!-- ユーザ検索フォーム -->
                        <input type="text" id="userSearch" class="border border-gray-300 rounded px-3 py-1 w-full mb-2" placeholder="ユーザを検索...">

                        <!-- ユーザ検索結果のリスト -->
                        <ul id="userList" class="border border-gray-300 rounded px-3 py-2 h-60 overflow-y-scroll dark:text-white">
                            @foreach($users as $user)
                            <li data-user-id="{{ $user->id }}">
                                <label>
                                    <input type="checkbox" class="mr-2"  name="selectedRecipientsId[]" value="{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </li>
                            @endforeach
                        </ul>

                        <!-- 選択済みユーザーのリスト -->
                        <ul id="selectedUserList" class="border border-gray-300 rounded px-3 py-2 h-60 overflow-y-scroll dark:text-white">
                            <!-- ここに選択済みユーザーが追加されます -->
                        </ul> --}}

<div class="mt-8">
    <span class="dark:text-white">報告先設定</span>
    <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
</div>


<div class="grid gap-4 mb-4 sm:grid-cols-5">

    <!-- 検索フォーム -->
    <div class="w-full flex flex-col">
        <label for="company_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">氏名</label>
        <input type="text" id="searchQuery" class="block py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ユーザ名で検索">
    </div>

    <!-- 所属1選択フォーム -->
    <div class="w-full flex flex-col">
        <label for="company_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">所属1</label>
        <select id="company_id" name="company_id" class="block py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">未選択</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected($company->id == old('company_id'))>{{ $company->company_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- 部署選択フォーム -->
    <div class="w-full flex flex-col">
        <label for="department_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">所属2</label>
        <select id="department_id" name="department_id" class="block py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">未選択</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>{{ $department->department_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- 所属3選択フォーム -->
    <div class="w-full flex flex-col">
        <label for="affiliation3_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">所属3</label>
        <select id="affiliation3_id" name="affiliation3_id" class="block py-1 mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">未選択</option>
            @foreach ($affiliation3s as $affiliation3)
                <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('affiliation3_id'))>{{ $affiliation3->affiliation3_name }}</option>
            @endforeach
        </select>
    </div>

    {{-- <button id="searchUsersButton" type="button">検索</button> --}}
    <div class="w-full flex justify-self-end  flex-col  mt-auto">
        <button type="button" id="searchUsersButton" class="md:ml-1 md:mt-1 w-full h-10 md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
<input type="hidden" id="selectedUsers" name="selectedRecipientsId[]">

                    </div>
                </div>
                    <x-primary-button form-id="reportForm" class="mt-4">
                        新規登録する
                    </x-primary-button>
            </form>
        </div>


    <!-- Extra Large Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
    {{-- <div id="clientSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
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
                <form action="{{ route('clientcorporation.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-2 mb-4 sm:grid-cols-3">
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientName" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="departmentId" class="font-semibold  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.client_name}', '${result.client_num}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setCorporation(name, number) {
            document.getElementById('client_num').value = number;
            document.getElementById('client_name').value = name;

            hideModal();
            }
    </script>


<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //   const userSearchInput = document.getElementById('userSearch');
    //   const userList = document.getElementById('userList');
    //   const selectedUserList = document.getElementById('selectedUserList');
    //   const selectedUsers = [];
  
    //   userSearchInput.addEventListener('input', function() {
    //     const searchTerm = this.value.trim().toLowerCase();
  
    //     const users = userList.getElementsByTagName('li');
    //     for (const user of users) {
    //       const userName = user.textContent.trim().toLowerCase();
    //       const userId = user.getAttribute('data-user-id');
  
    //       if (userName.includes(searchTerm) && !selectedUsers.includes(userId)) {
    //         user.style.display = "block";
    //       } else {
    //         user.style.display = "none";
    //       }
    //     }
    //   });
  
    //   userList.addEventListener('click', function(event) {
    //     const target = event.target;
    //     if (target.tagName === 'LI') {
    //       const userId = target.getAttribute('data-user-id');
    //       const userName = target.textContent.trim();
  
    //       if (!selectedUsers.includes(userId)) {
    //         selectedUsers.push(userId);
    //         target.style.display = "none";
  
    //         const listItem = document.createElement('li');
    //         listItem.textContent = userName;
    //         listItem.setAttribute('data-user-id', userId);
    //         listItem.classList.add('selected-user');
    //         selectedUserList.appendChild(listItem);
    //       }
    //     }
    //   });
  
    //   selectedUserList.addEventListener('click', function(event) {
    //     const target = event.target;
    //     if (target.tagName === 'LI') {
    //       const userId = target.getAttribute('data-user-id');
    //       const userName = target.textContent.trim();
  
    //       const index = selectedUsers.indexOf(userId);
    //       if (index !== -1) {
    //         selectedUsers.splice(index, 1);
    //         userList.querySelector(`li[data-user-id="${userId}"]`).style.display = "block";
  
    //         // ユーザーを右側の欄から左側の欄に戻す
    //         selectedUserList.removeChild(target);
    //       }
    //     }
    //   });
    // });



    $(document).ready(function() {
        // ページ読み込み時にローカルストレージから選択されたユーザのIDを取得して隠しフィールドに設定
        var selectedUserIds = JSON.parse(localStorage.getItem('selectedUserIds')) || [];
        $('#selectedUsers').val(selectedUserIds.join(','));

        // ページ読み込み時にローカルストレージから選択されたユーザの情報を取得して表示
        selectedUserIds.forEach(function(userId) {
            var userName = localStorage.getItem('userName_' + userId);
            $('#selectedRecipients').prepend('<div class="selectedUser" data-user-id="' + userId + '">' + userName + '</div>');
        });

// ユーザを非同期で検索して検索結果表示部分に表示する
$('#searchUsersButton').click(function() {
    var searchQuery = $('#searchQuery').val();
    var companyId = $('#company_id').val();
    var departmentId = $('#department_id').val();
    var affiliation3Id = $('#affiliation3_id').val();
    $.ajax({
        url: '/search-users',
        method: 'GET',
        data: {
            query: searchQuery,
            company_id: companyId,
            department_id: departmentId,
            affiliation3_id: affiliation3Id
        },
        success: function(response) {
            // 検索結果をカナ名称順にソート
            response.sort(function(a, b) {
                var nameA = a.kana_name.toUpperCase(); // 大文字と小文字を区別しない
                var nameB = b.kana_name.toUpperCase(); // 大文字と小文字を区別しない
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
                    usersHtml += '<div class="selectUser cursor-pointer" data-user-id="' + user.id + '" data-user-name="' + user.name + '">' + user.name + '</div>';
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
                $(this).before('<div class="selectedUser pointer-" data-user-id="' + userId + '">' + userName + '</div>');
                inserted = true;
                return false; // Break the loop
            }
        });
        if (!inserted) {
            $('#selectedRecipients').append('<div class="selectedUser" data-user-id="' + userId + '">' + userName + '</div>');
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
            $('#searchResults').append('<div class="selectUser" data-user-id="' + userId + '" data-user-name="' + userName + '">' + userName + '</div>');
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
</x-app-layout>