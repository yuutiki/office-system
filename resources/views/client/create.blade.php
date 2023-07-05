<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                顧客登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('client.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('client.store')}}" enctype="multipart/form-data">
            @csrf

            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                    <label for="clientcorporation_num" class="font-semibold text-gray-100 leading-none mt-4">法人番号</label>
                    <input type="text" name="clientcorporation_num" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_num" value="{{old('clientcorporation_num')}}" placeholder="法人番号を検索してください" >
                </div>

                <!-- Modal toggle -->
                {{-- <button id="openModal" data-modal-target="extralarge-modal" data-modal-toggle="extralarge-modal" class="md:ml-1 md:mt-9 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    法人検索
                </button> --}}
            </div>
           
            <div class="w-full flex flex-col">
                <label for="clientcorporation_name" class="font-semibold text-gray-100 leading-none mt-4">法人名称</label>
                <input type="text" name="clientcorporation_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="法人名称を検索してください" disabled readonly>
            </div>
            <!-- 法人検索ボタン -->
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-9 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                法人検索
            </button>

            {{-- <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                <label for="client_id" class="font-semibold text-gray-100 leading-none mt-4">顧客ID</label>
                <input type="text" name="client_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_id" value="{{old('client_id')}}" placeholder="例）0001">
                </div>
            </div> --}}

            <div class="w-full flex flex-col">
                <label for="client_name" class="font-semibold text-gray-100 leading-none mt-4">顧客名称</label>
                <input type="text" name="client_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name')}}" placeholder="例）学校顧客 烏丸大学">
            </div>

            <div class="w-full flex flex-col">
                <label for="client_kana_name" class="font-semibold text-gray-100 leading-none mt-4">顧客カナ名称</label>
                <input type="text" name="client_kana_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_kana_name" value="{{old('client_kana_name')}}" placeholder="例）ｶﾞｯｺｳﾎｳｼﾞﾝ ｶﾗｽﾏﾀﾞｲｶﾞｸ">
            </div>
            
            <div class="w-full flex flex-col">
                <label for="memo" class="font-semibold text-gray-100 leading-none mt-4">備考</label>
                <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo" value="{{old('memo')}}" cols="30" rows="10" placeholder="例）配下の学校"></textarea>
            </div>
            <x-primary-button class="mt-4">
                新規登録する
            </x-primary-button>           
        </form>
    </div>
</div>



    <!-- Extra Large Modal -->
    <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    {{-- <div id="corporationSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class=" w-70 max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        法人検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"  onclick="hideModal()"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('clientcorporation.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="flex flex-wrap justify-start ml-5">
                        <div class="w-full flex flex-col">
                            <label for="corporationName" class="font-semibold text-gray-100 leading-none mt-4">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="w-auto mt-1 mr-2 py-2 placeholder-gray-500 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="corporationNumber" class="font-semibold text-gray-100 leading-none mt-4">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="w-auto mt-1 mr-2 py-2 placeholder-gray-500 border border-gray-300 rounded-md">
                        </div>
                    </div>
                </form>

                <table class="w-full mt-4 text-white mb-5 text-left ml-3">
                    <thead>
                      <tr>
                        <th class="py-2">法人名称</th>
                        <th class="py-2">法人番号</th>
                        <th class="py-2"></th>
                      </tr>
                    </thead>
                    <tbody id="searchResultsContainer" class="">
                      <!-- 検索結果がここに追加されます -->
                    </tbody>
                  </table>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
        const modal = document.getElementById('corporationSearchModal');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('corporationSearchModal');

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
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.innerHTML = `
                    <td class="py-2">${result.clientcorporation_name}</td>
                    <td class="py-2">${result.clientcorporation_num}</td>
                    <td class="py-2">
                    <button type="button" onclick="setCorporation('${result.clientcorporation_name}', '${result.clientcorporation_num}')" class="font-bold text-blue-500 hover:underline">選択</button>
                    </td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setCorporation(name, number) {
            document.getElementById('clientcorporation_num').value = number;
            document.getElementById('clientcorporation_name').value = name;
            // document.getElementById('clientcorporation_name').textContent = name;
            // document.getElementById('clientcorporation_num').textContent = number;

            hideModal();
            }
    </script>
 
</x-app-layout>