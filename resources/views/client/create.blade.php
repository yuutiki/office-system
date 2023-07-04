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
                    <input type="text" name="clientcorporation_num" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_num" value="{{old('clientcorporation_num')}}" placeholder="法人番号を検索してください" disabled readonly>
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



            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                <label for="client_id" class="font-semibold text-gray-100 leading-none mt-4">顧客ID</label>
                <input type="text" name="client_id" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_id" value="{{old('client_id')}}" placeholder="例）0001">
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="client_name" class="font-semibold text-gray-100 leading-none mt-4">顧客名称</label>
                <input type="text" name="client_name" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name')}}" placeholder="例）学校顧客 烏丸大学">
            </div>

            <div class="w-full flex flex-col">
                <label for="client_kana" class="font-semibold text-gray-100 leading-none mt-4">顧客カナ名称</label>
                <input type="text" name="client_kana" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="client_kana" value="{{old('client_kana')}}" placeholder="例）ｶﾞｯｺｳﾎｳｼﾞﾝ ｶﾗｽﾏﾀﾞｲｶﾞｸ">
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



<!-- create.blade.php -->

<!-- 顧客新規登録フォームのコード -->

    <!-- 法人検索モーダル -->
    <!-- モーダルのコンテンツ -->
    <div id="corporationSearchModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white w-1/2 p-6 rounded shadow-lg">
        <!-- モーダルのコンテンツをここに追加 -->
            <!-- 検索フォームのコード -->
            <form action="{{ route('clientcorporation.search') }}" method="GET">
                <!-- 検索条件入力フォーム -->
                <div class="mb-4">
                    <label for="corporationName" class="block mb-2">法人名称</label>
                    <input type="text" name="corporationName" id="corporationName" class="form-input">
                </div>
                <div class="mb-4">
                    <label for="corporationNumber" class="block mb-2">法人番号</label>
                    <input type="text" name="corporationNumber" id="corporationNumber" class="form-input">
                </div>
                <!-- 検索ボタン -->
                <div class="flex justify-end">
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="searchCorporation()">
                        検索
                    </button>
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="hideModal()">
                        閉じる
                    </button>
                </div>
            </form>
            <div id="searchResultsContainer"></div>
            {{-- <div>
                <span>法人名称:</span>
                <span id="corporationNameDisplay"></span>
            </div>
            <div>
                <span>法人番号:</span>
                <span id="corporationNumberDisplay"></span>
            </div> --}}
        </div>
        <div>
            <!-- モーダルのフッター -->
            {{-- <button @click="hide('corporationSearchModal')" class="btn btn-secondary">閉じる</button> --}}
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
                const resultElement = document.createElement('div');
                resultElement.innerHTML = `
                    <div>
                    <span>${result.clientcorporation_name}</span>
                    <span>${result.clientcorporation_num}</span>
                    <button type="button" onclick="setCorporation('${result.clientcorporation_name}', '${result.clientcorporation_num}')">選択</button>
                    </div>
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