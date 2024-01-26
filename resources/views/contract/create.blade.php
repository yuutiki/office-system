<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createContract') }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <!-- 顧客検索ボタン -->
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button>
            <div class="grid gap-4 mt-6 mb-4 sm:grid-cols-3">
                <div class="">
                    <label for="clientcorporation_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="clientcorporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1 " id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                <div class="hidden">
                    <label for="client_num" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                    <input type="text" name="client_num" id="client_num" value="{{old('client_num')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" form="updateForm">
                </div>
                <div class="">
                    <label for="client_name" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1 " id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                </div>
                {{-- <div>
                    <label for="department_id" class="block font-semibold  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                    <select id="department_id" name="department_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                        <option value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="">
                    <label for="project_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">契約連番</label>
                    <input type="text" name="project_num" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" id="project_num" value="{{old('project_num')}}" placeholder="登録時に自動採番されます"  form="updateForm" readonly>
                    @error('project_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="estimate-tab" data-tabs-target="#estimate" type="button" role="tab" aria-controls="estimate" aria-selected="false">契約詳細</button>
                    </li>
                </ul>
            </div>

            <div id="myTabContent">
                <div class="hidden p-4 rounded-s rounded-e bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        <div>
                            <label for="contract_type_id" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">契約種別</label>
                            <select form="updateForm" id="contract_type_id" name="contract_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($contractTypes as $contractType)
                                <option value="{{ $contractType->id }}" @selected($contractType->id == old('contract_type_id'))>{{ $contractType->contract_type_name }}</option>
                                @endforeach
                            </select>
                            @error('contract_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">契約日</label>
                            <input type="date" value="" readonly class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label for="" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">解約日</label>
                            <input type="date" value="" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label for="" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">更新月</label>
                            <input type="date" value="" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label for="" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">契約先種別</label>
                            <input type="date" value="" readonly class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        {{-- <div class="w-full flex flex-col">
                            <label for="total_revenue" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">PJ金額（税抜）</label>
                            <input type="text" name="total_revenue" id="total_revenue" value="{{ number_format($totalRevenue) }}" class="dark:bg-gray-400 text-right w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" disabled>
                        </div> --}}
                    </div>



                    {{-- テーブル表示 --}}
                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="pl-4 py-3 w-auto">
                                        <div class="flex items-center whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="pl-4 py-3 w-auto">
                                        <div class="flex items-center whitespace-nowrap">
                                            №
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            会計期
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            計上年月
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            計上金額
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap">
                                        <button data-modal-target="storeRevenueModal" data-modal-toggle="storeRevenueModal"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-4 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                            <div class="flex items-center">
                                                <svg class="h-3.5 w-3.5 mr-1.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                    </svg>
                                                <span class="text-ms">売上追加</span>
                                            </div>
                                        </button>
                                    </th>
                                    <th scope="col" class="flex items-center justify-center py-1">
                                        <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex py-1.5 px-4 text-sm m-auto font-medium text-gray-900 focus:outline-none bg-white rounded-s rounded-e border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            Actions
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach ($revenuesWithPeriod as $projectRevenue)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white">
                                        <td class="pl-4 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input id="checkbox{{ $projectRevenue['revenue']->id }}" type="checkbox" name="selectedIds[]" value="{{ $projectRevenue['revenue']->id }}" form="bulkDeleteForm" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                            </div>
                                        </td>
                                        <td class="pl-4 py-2 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$projectRevenue['belongingPeriod']}}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$projectRevenue['formatRevenueDate']}}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{number_format($projectRevenue['revenue']->revenue)}}
                                        </td>
                                        <td class="px-2 py-2">
                                            
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            <button id="updateProductButton" data-modal-target="updateRevenueModal-{{ $projectRevenue['revenue']->id }}" data-modal-show="updateRevenueModal-{{ $projectRevenue['revenue']->id }}"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">編集</span>
                                                </div>
                                            </button>
                                        </td>
                                        <td class="px-2 py-2">
                                            <button data-modal-target="deleteModal-{{$projectRevenue['revenue']->id}}" data-modal-toggle="deleteModal-{{$projectRevenue['revenue']->id}}"  class="block  m-auto whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-s rounded-e text-sm px-2 py-1.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                                    </svg>
                                                    <span class="text-ms ">削除</span>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div id="deleteModal-{{$projectRevenue['revenue']->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full animate-slide-in-top justify-center">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                                        <button data-modal-hide="deleteModal-{{$projectRevenue['revenue']->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-6 text-center">
                                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                            </svg>
                                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>

                                                            <div class="flex justify-center items-center">
                                                                <form action="{{route('projectrevenue.destroy',$projectRevenue['revenue']->id)}}" method="POST" class="">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" data-modal-hide="deleteModal-{{$projectRevenue['revenue']->id}}" class="mr-3 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm  items-center px-5 py-2.5 text-center">
                                                                        削除
                                                                    </button>
                                                                </form>
                                                                <button data-modal-hide="deleteModal-{{$projectRevenue['revenue']->id}}" type="button" class="items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                    やっぱやめます
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="updateRevenueModal-{{ $projectRevenue['revenue']->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative p-4 bg-white rounded-s rounded-e shadow dark:bg-gray-800 sm:p-5">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        売上編集
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="updateRevenueModal-{{ $projectRevenue['revenue']->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form method="POST" action="{{ route('projectrevenue.update',$projectRevenue['revenue']->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                        <div class="hidden">
                                                            <div class="w-full flex flex-col">
                                                                <div class="w-full flex flex-col">
                                                                    <label for="modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                                                    <input type="text" name="modalproject_id" id="modalproject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                                </div>
                                                            </div>
                                                            @error('department_id')
                                                                <div class="text-red-500">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <div class="md:flex items-center">
                                                                <div class="w-full flex flex-col">
                                                                <label for="revenue_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上金額</label>
                                                                <input type="text" onblur="formatNumberInput(this);" maxlength="9"   name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount',number_format($projectRevenue['revenue']->revenue))}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                                                </div>
                                                            </div>

                                                            @error('revenue_amount')
                                                                <div class="text-red-500">{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4 mt-2">
                                                        <x-primary-button class="mt-4" id="saveModalButton">
                                                            変更を確定
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody> --}}
                        </table>
                        <div class="mt-2 mb-2 px-4">
                        </div> 
                    </div>
                    {{-- テーブルヘッダアクションプルダウン --}}
                    <div id="actionsDropdown" class="hidden  w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 z-50">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <button data-modal-target="insertRevenueModal" data-modal-toggle="insertRevenueModal"  class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium  text-sm px-2 py-1 text-center m-auto" type="button">
                                    <div class="flex items-center">
                                        {{-- <svg class="h-3.5 w-3.5 mr-0.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg> --}}
                                        <span class="text-ms ml-4">一括追加</span>
                                    </div>
                                </button>
                                {{-- <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">一括追加</a> --}}
                            </li>
                        </ul>
                        <div class="py-1">
                            <form id="bulkDeleteForm" action="{{ route('projectrevenue.bulkDelete') }}" method="POST">
                                @csrf
                                @method('delete') <!-- 隠しフィールドを追加 -->
                                <button type="submit" id="bulkDeleteButton" form="bulkDeleteForm" class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium  text-sm px-2 py-1 text-center m-auto">
                                    <div class="flex items-center">
                                        {{-- <svg class="h-3.5 w-3.5 mr-0.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg> --}}
                                        <span class="text-ms ml-4">一括削除</span>
                                    </div>
                                </button>
                            </form>
                            {{-- <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a> --}}
                        </div>
                    </div>

                    <div id="accordion-arrow-icon" data-accordion="open" class="">
                        <h2 id="accordion-arrow-icon-heading-2">
                            <button type="button" class="flex items-center justify-between w-full p-2 rounded font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 gap-3 dark:bg-gray-700 mt-3" data-accordion-target="#accordion-arrow-icon-body-2" aria-expanded="false" aria-controls="accordion-arrow-icon-body-2">
                                <span>サポートページ</span>
                                <svg class="w-4 h-4 shrink-0 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-arrow-icon-body-2" class="hidden" aria-labelledby="accordion-arrow-icon-heading-2">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 grid  gap-4 mb-4 md:grid-cols-3 grid-cols-2">
                                <div>
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">SPページID</label>
                                        <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password" value="{{old('password')}}">
                                    </div>
                                    @error('password')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">SPページPW</label>
                                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
                                    </div>
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">SPページ備考</label>
                                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
                                    </div>
                                </div>

                                <div>
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">FAQページID</label>
                                        <input type="password" name="password" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password" value="{{old('password')}}">
                                    </div>
                                    @error('password')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">FAQページPW</label>
                                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
                                    </div>
                                    <div class="w-full flex flex-col">
                                        <label class="font-semibold dark:text-gray-100 leading-none mt-2">FAQページ備考</label>
                                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control w-auto py-1 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="password_confirmation" value="{{old('password_confirmation')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="w-full flex flex-col">
                            <label for="project_memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">契約備考</label>
                            <textarea form="updateForm" name="project_memo" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" data-auto-resize="true" id="auto-resize-textarea-content" value="{{old('project_memo')}}" cols="30" rows="5" data-auto-resize="true">{{old('project_memo')}}</textarea>
                        </div>

                        <form id="updateForm" method="post" action="{{route('project.create')}}" enctype="multipart/form-data" autocomplete="new-password">
                            @csrf
                            @method('patch')
                            <x-primary-button class="mt-4" form="updateForm" id="saveButton">
                                編集を確定する(s)
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded-s rounded-e bg-gray-50 dark:bg-gray-800" id="estimate" role="tabpanel" aria-labelledby="estimate-tab">
            </div>
        </div>
    </div>











     <!-- 顧客検索 Modal -->
     <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        {{-- <div id="clientSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
            <div class="max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            顧客検索画面
                        </h3>
                        <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="clientNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                                <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e">
                            </div>
                            <div class="w-full flex flex-col mx-2">
                                <label for="departmentId" class="font-semibold  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                                {{-- <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == Auth::user()->department->id)>
                                        {{ $department->department_name }}
                                    </option>
                                    @endforeach
                                </select> --}}
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
                        <button type="button" onclick="searchClient()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            検索
                        </button>
                        <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            閉じる
                        </button> 
                    </div>
                </div>
            </div>
        </div>

        <!-- 請求先法人検索 Modal -->
        <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
            {{-- <div id="corporationSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
                <div class="max-h-full w-full max-w-2xl">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                法人検索画面
                            </h3>
                            <button type="button" onclick="hideCorporationModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form action="{{ route('clientcorporation.search') }}" method="GET">
                            <!-- 検索条件入力フォーム -->
                            <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                            {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                                <div class="">
                                    <label for="corporationName" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                                    <input type="text" name="corporationName" id="corporationName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e">
                                </div>
                                <div class="">
                                    <label for="corporationNumber" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none">法人番号</label>
                                    <input type="text" name="corporationNumber" id="corporationNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e">
                                </div>
                            </div>
                        </form>
                        <div class=" max-h-80 overflow-y-auto overflow-x-hidden mt-4">
                            <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                                <thead>
                                <tr>
                                    {{-- <th class="py-1"></th> --}}
                                    <th class="py-1 pl-5">法人名称</th>
                                    <th class="py-1 whitespace-nowrap">法人番号</th>
                                </tr>
                                </thead>
                                <tbody class="" id="searchResultsCorporationContainer">                          
                                        <!-- 検索結果がここに追加されます -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                検索
                            </button>
                            <button type="button" onclick="hideCorporationModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                閉じる
                            </button> 
                        </div>
                    </div>
                </div>
            </div>



            {{-- <!-- 売上登録モーダル　Start -->
            <div id="storeRevenueModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-s rounded-e shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                売上登録
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="storeRevenueModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('projectrevenue.store') }}">
                            @csrf
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="hidden">
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                            <input type="text" name="modalproject_id" id="modalproject_id" value="{{ $cntract->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        </div>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="revenue_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上年月</label>
                                            <input type="month" name="revenue_date" id="revenue_date" min="2000-01" max="2100-12" value="{{old('revenue_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="md:flex items-center">
                                        <div class="w-full flex flex-col">
                                        <label for="revenue_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上金額</label>
                                        <input type="text" onblur="formatNumberInput(this);" maxlength="9"   name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                        </div>
                                    </div>

                                    @error('revenue_amount')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 mt-2">
                                <x-primary-button class="mt-4" id="saveModalButton">
                                    登録
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 売上登録モーダル　End --> --}}

    
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_corporation.clientcorporation_name}', '${result.client_num}', '${result.client_name}', '${result.department_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationname, clientnum, clientname, department) {
            document.getElementById('clientcorporation_name').value = corporationname;
            document.getElementById('client_num').value = clientnum;
            document.getElementById('client_name').value = clientname;
            document.getElementById('department_id').value = department;
            // document.getElementById('client_num').value = number;
            // document.getElementById('installation_type_id').value = installation;
            // document.getElementById('client_type_id').value = clienttype;
            // document.getElementById('user_id').value = user;

            hideModal();
            }
    </script>
    <script>
        // モーダルを表示するための関数
        function showCorporationModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('corporationSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideCorporationModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('corporationSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

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
                const searchResultsCorporationContainer = document.getElementById('searchResultsCorporationContainer');
                searchResultsCorporationContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.id}', '${result.clientcorporation_num}', '${result.clientcorporation_name}')">${result.clientcorporation_short_name}</td>
                    <td class="py-2 ml-2">${result.clientcorporation_num}</td>
                `;
                searchResultsCorporationContainer.appendChild(resultElement);
                });
            });
            }

        function setCorporation(id, number, name) {
            document.getElementById('billing_corporation_id').value = id;
            document.getElementById('billing_corporation_num').value = number;
            document.getElementById('billing_corporation_name').value = name;
            hideCorporationModal();
        }
    </script>


<script>
var selectedIds;

// $(document).ready(function () {
//     // 一括削除ボタンがクリックされたときの処理
//     $('#bulkDeleteButton').click(function () {
//         // 選択された項目のIDを取得
//         selectedIds = $('input[name="selectedIds[]"]:checked').map(function () {
//             return $(this).val();
//         }).get();

//         if (selectedIds.length > 0) {
//             // 選択されたIDをサーバーに送信
//             $.ajax({
//                 url: '/bulk-delete-revenues',
//                 type: 'DELETE',
//                 data: {
//                     selected_ids: selectedIds,
//                     _token: '{{ csrf_token() }}'
//                 },
//                 success: function (response) {
//                     // 成功時の処理（成功メッセージの表示など）
//                     console.log('Selected IDs:', selectedIds);
//                     alert(response.message);
//                     // ページのリロードなどの処理
//                     location.reload();
//                 },
//                 error: function (error) {
//                     // エラー時の処理
//                     alert('エラーが発生しました');
//                 }
//             });
//         }
//     });
// });




<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</script>
</x-app-layout>