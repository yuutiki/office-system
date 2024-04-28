<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="text-sm text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createContract') }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-4 sm:pl-12 lg:w-1/2 lg:mx-auto">
        <!-- 顧客検索ボタン -->
        <button type="button"  onclick="showModal()" class="md:ml-1 mt-12 mb-2 w-full whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>
        <div class="grid gap-4 mt-6 mb-4 sm:grid-cols-1">
            <div>
                <div class="">
                    <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="corporation_name" class="input-readonly" id="corporation_name" value="{{old('corporation_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                @error('corporation_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="hidden">
                <div>
                    <label for="client_id" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客ID（非表示）</label>
                    <input form="storeForm" type="text" name="client_id" id="client_id" value="{{old('client_id')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1">
                </div>
                @error('client_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <div class="">
                    <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="input-readonly" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                @error('client_name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="department_id" class="block text-sm  text-gray-900 dark:text-white leading-none md:mt-2">管轄事業部</label>
                <select id="department_id" name="department_id" class="input-readonly" readonly>
                    <option value="">未選択</option>
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>{{ $department->department_name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="contract_type_id" class="text-sm text-gray-900 dark:text-red-400 leading-none mt-4">契約種別</label>
                <select form="storeForm" id="contract_type_id" name="contract_type_id" class="input-primary">
                    <option value="">未選択</option>
                    @foreach($contractTypes as $contractType)
                    <option value="{{ $contractType->id }}" @selected($contractType->id == old('contract_type_id'))>{{ $contractType->contract_type_name }}</option>
                    @endforeach
                </select>
                @error('contract_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <form id="storeForm" method="post" action="{{route('contracts.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf
            <x-primary-button class="mt-4 " form="storeForm" id="saveButton">
                登録して遷移(s)
            </x-primary-button>
        </form>
    </div>


     <!-- 顧客検索 Modal -->
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
                    <form action="{{ route('corporations.search') }}" method="GET">
                        <!-- 検索条件入力フォーム -->
                        <div class="grid gap-2 mb-4 sm:grid-cols-3">
                            <div class="w-full flex flex-col mx-2">
                                <label for="clientName" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                                <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="clientNumber" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                                <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="departmentId" class="text-sm  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.corporation.corporation_name}', '${result.id}', '${result.client_name}', '${result.department_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationName, clientId, clientname, department) {
            document.getElementById('corporation_name').value = corporationName;
            document.getElementById('client_id').value = clientId;
            document.getElementById('client_name').value = clientname;
            document.getElementById('department_id').value = department;
            // document.getElementById('installation_type_id').value = installation;
            // document.getElementById('client_type_id').value = clienttype;
            // document.getElementById('user_id').value = user;

            hideModal();
            }
    </script>

{{-- <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script> --}}

</x-app-layout>