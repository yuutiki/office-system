<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                営業報告登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('report.index')}}'">
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
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button>

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="">
                    <label for="client_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                    <input type="text" name="client_num" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="client_num" value="{{old('client_num')}}" placeholder="法人検索してください" readonly>
                </div>     
                <div class="">
                    <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name')}}" placeholder="例）烏丸大学">
                </div>
            </div>


            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">

                {{-- <div>
                    <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                    <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <div class="w-full flex flex-col">
                        <label for="type" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">報告種別</label>
                        <select id="type" name="type" class="block w-48 p-1.5 text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                                <option value="新規受注報告">新規受注報告</option>
                                <option value="新規失注報告">新規失注報告</option>
                                <option value="既存解約報告">既存解約報告</option>
                                <option value="営業活動報告">営業活動報告</option>
                        </select>
                    </div>

{{-- 初期値で今日の日付突っ込む --}}
                    <div class="w-full flex flex-col">
                        <label for="contact_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対応日付</label>
                        <input type="date" name="contact_at" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 p-locality p-street-address p-extended-address" id="contact_at" value="{{old('contact_at')}}" placeholder="">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="title" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-8">報告タイトル</label>
                        <input type="text" name="title" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="title" value="{{old('title')}}" placeholder="">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="contact_type" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対応形式</label>
                        <select id="contact_type" name="contact_type" class="block w-48 p-1.5 text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                                <option value="オンライン">オンライン</option>
                                <option value="現地訪問">現地訪問</option>
                                <option value="来社対応">来社対応</option>
                                <option value="電話対応">電話対応</option>
                                <option value="メール対応">メール対応</option>
                                <option value="資料送付">資料送付</option>
                                <option value="その他">その他</option>
                        </select>
                    </div>

                    
                    <div class="w-full flex flex-col">
                        <label for="client_representative" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客担当者（代表）</label>
                        <input type="text" name="client_representative" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_representative" value="{{old('client_representative')}}" placeholder="">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">報告内容</label>
                        <textarea name="content" class="w-auto py-1.5 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="content" value="{{old('content')}}" cols="30" rows="5"></textarea>
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="notice" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">特記事項</label>
                        <textarea name="notice" class="w-auto py-1.5 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="notice" value="{{old('notice')}}" cols="30" rows="5"></textarea>
                    </div>






                <!-- ユーザ検索フォーム -->
                <input type="text" id="userSearch" class="border border-gray-300 rounded px-3 py-1.5 w-full mb-2" placeholder="ユーザを検索...">

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
                </ul>
                    




                </div>
                    <x-primary-button form-id="reportForm" class="mt-4">
                        新規登録する
                    </x-primary-button>
        </form>
    </div>
</div>


    <!-- Extra Large Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    {{-- <div id="clientSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class=" w-4/5  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"  onclick="hideModal()"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('clientcorporation.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="flex flex-wrap justify-start mx-5">
                        <div class="w-full flex flex-col">
                            <label for="clientName" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-2 py-1.5 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="clientNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-2 py-1.5 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1.5"></th> --}}
                            <th class="py-1.5 pl-5">顧客名称</th>
                            <th class="py-1.5 whitespace-nowrap">顧客番号</th>
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

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber })
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
    document.addEventListener("DOMContentLoaded", function() {
      const userSearchInput = document.getElementById('userSearch');
      const userList = document.getElementById('userList');
      const selectedUserList = document.getElementById('selectedUserList');
      const selectedUsers = [];
  
      userSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim().toLowerCase();
  
        const users = userList.getElementsByTagName('li');
        for (const user of users) {
          const userName = user.textContent.trim().toLowerCase();
          const userId = user.getAttribute('data-user-id');
  
          if (userName.includes(searchTerm) && !selectedUsers.includes(userId)) {
            user.style.display = "block";
          } else {
            user.style.display = "none";
          }
        }
      });
  
      userList.addEventListener('click', function(event) {
        const target = event.target;
        if (target.tagName === 'LI') {
          const userId = target.getAttribute('data-user-id');
          const userName = target.textContent.trim();
  
          if (!selectedUsers.includes(userId)) {
            selectedUsers.push(userId);
            target.style.display = "none";
  
            const listItem = document.createElement('li');
            listItem.textContent = userName;
            listItem.setAttribute('data-user-id', userId);
            listItem.classList.add('selected-user');
            selectedUserList.appendChild(listItem);
          }
        }
      });
  
      selectedUserList.addEventListener('click', function(event) {
        const target = event.target;
        if (target.tagName === 'LI') {
          const userId = target.getAttribute('data-user-id');
          const userName = target.textContent.trim();
  
          const index = selectedUsers.indexOf(userId);
          if (index !== -1) {
            selectedUsers.splice(index, 1);
            userList.querySelector(`li[data-user-id="${userId}"]`).style.display = "block";
  
            // ユーザーを右側の欄から左側の欄に戻す
            selectedUserList.removeChild(target);
          }
        }
      });
    });
  </script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
      // ...
  
      userList.addEventListener('click', function(event) {
        const target = event.target;
        if (target.tagName === 'LI') {
          const userId = target.getAttribute('data-user-id');
          const userName = target.textContent.trim();
  
          if (!selectedUsers.includes(userId)) {
            selectedUsers.push(userId);
            target.style.display = "none";
  
            const listItem = document.createElement('li');
            listItem.textContent = userName;
            listItem.setAttribute('data-user-id', userId);
            listItem.classList.add('selected-user');
            selectedUserList.appendChild(listItem); // 右側の欄に選択済みのユーザを追加
          }
        }
      });
  
      // ...
    });
  </script> --}}
{{-- 
<script>
    document.addEventListener("DOMContentLoaded", function() {
      // ...
  
      userList.addEventListener('change', function(event) {
        const target = event.target;
        if (target.tagName === 'INPUT' && target.type === 'checkbox') {
          const userId = target.getAttribute('data-user-id');
          const userName = target.getAttribute('data-user-name');
  
          if (target.checked && !selectedUsers.includes(userId)) {
            selectedUsers.push(userId);
  
            const listItem = document.createElement('li');
            listItem.textContent = userName;
            listItem.setAttribute('data-user-id', userId);
            listItem.classList.add('selected-user');
            selectedUserList.appendChild(listItem); // 右側の欄に選択済みのユーザを追加
          } else if (!target.checked && selectedUsers.includes(userId)) {
            const index = selectedUsers.indexOf(userId);
            if (index !== -1) {
              selectedUsers.splice(index, 1);
            }
            const selectedUserListItem = selectedUserList.querySelector(`li[data-user-id="${userId}"]`);
            selectedUserList.removeChild(selectedUserListItem); // 右側の欄から選択解除されたユーザを削除
          }
        }
      });
  
      // ...
    });
  </script> --}}
  
  
  


 
</x-app-layout>