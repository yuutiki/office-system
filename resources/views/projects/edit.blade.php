<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white whitespace-nowrap overflow-hidden">
                プロジェクト編集
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('project.index')}}'">
                    見積作成
                </x-general-button>
                <x-general-button onclick="location.href='{{route('project.index')}}'" class="ml-2">
                    削除
                </x-general-button>
                {{-- <x-general-button onclick="location.href='{{route('project.index')}}'">
                    戻る
                </x-general-button> --}}
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <!-- 顧客検索ボタン -->
            {{-- <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button> --}}
            <div class="grid gap-4 mt-6 mb-4 sm:grid-cols-3">
                <div class="">
                    <label for="corporation_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="corporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1 " id="corporation_name" value="{{old('corporation_name',$project->client->corporation->corporation_name)}}" placeholder="顧客検索してください" readonly>
                    @error('corporation_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="hidden">
                    <label for="client_num" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                    <input type="text" name="client_num" id="client_num" value="{{old('client_num',$project->client->client_num)}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" form="updateForm">
                </div>
                <div class="">
                    <label for="client_name" class="block font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                    <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1 " id="client_name" value="{{old('client_name',$project->client->client_name)}}" placeholder="顧客検索してください" readonly>
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="department_id" class="block font-semibold  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                    <select id="department_id" name="department_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                        <option value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected($department->id == old('department_id',$project->client->department_id))>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="project_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">プロジェクト№</label>
                    <input type="text" name="project_num" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" id="project_num" value="{{old('project_num',$project->project_num)}}" placeholder="登録時に自動採番されます"  form="updateForm" readonly>
                    @error('project_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="project_name" class="block  font-semibold dark:text-red-400 text-gray-900 leading-none md:mt-4">プロジェクト名称</label>
                    <input type="text" name="project_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" id="project_name" value="{{old('project_name',$project->project_name)}}" placeholder=""  form="updateForm">
                    @error('project_name')
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
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="estimate-tab" data-tabs-target="#estimate" type="button" role="tab" aria-controls="estimate" aria-selected="false">見積一覧</button>
                    </li>
                </ul>
            </div>

            <div id="myTabContent">
                <div class="hidden p-4 rounded-s rounded-e bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        <div>
                            <label for="sales_stage_id" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">営業段階</label>
                            <select form="updateForm" id="sales_stage_id" name="sales_stage_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($salesStages as $salesStage)
                                <option value="{{ $salesStage->id }}" @selected($salesStage->id == old('sales_stage_id',$project->sales_stage_id))>{{ $salesStage->sales_stage_name }}</option>
                                @endforeach
                            </select>
                            @error('sales_stage_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="project_type_id" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">プロジェクト種別</label>
                            <select form="updateForm" id="project_type_id" name="project_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($projectTypes as $projectType)
                                <option value="{{ $projectType->id }}" @if($projectType->id == old('project_type_id',$project->project_type_id)) selected @endif>{{ $projectType->project_type_name }}</option>
                                @endforeach
                            </select>
                            @error('project_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="accounting_type_id" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">計上種別</label>
                            <select form="updateForm" id="accounting_type_id" name="accounting_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($accountingTypes as $accountingType)
                                <option value="{{ $accountingType->id }}" @if($accountingType->id == old('accounting_type_id',$project->accounting_type_id)) selected @endif>{{ $accountingType->accounting_type_name }}</option>
                                @endforeach
                            </select>
                            @error('accounting_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="distribution_type_id" class="font-semibold text-gray-900 dark:text-red-400 leading-none mt-4">商流</label>
                            <select form="updateForm" id="distribution_type_id" name="distribution_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($distributionTypes as $distributionType)
                                <option value="{{ $distributionType->id }}" @selected($distributionType->id == old('distribution_type_id',$project->distribution_type_id))>{{ $distributionType->distribution_type_name }}</option>
                                @endforeach
                            </select>
                            @error('distribution_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        <div class="w-full flex flex-col">
                            <label for="total_revenue" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">PJ金額（税抜）</label>
                            <input type="text" name="total_revenue" id="total_revenue" value="{{ number_format($totalRevenue) }}" class="dark:bg-gray-400 text-right w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" disabled>
                        </div>

                        {{-- <div class="w-full flex flex-col">
                            <label for="total_revenue" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">会計期別金額（税抜）</label>
                            <input type="number" name="total_revenue" id="total_revenue" value="" class="bg-yellow-100 w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" disabled>
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
                            <tbody>
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
                                            {{-- 削除確認モーダル画面 Start --}}
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
                                    {{-- 削除確認モーダル画面 End --}}
                                    <!-- 売上編集モーダル　Start -->
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
                                                                    <input type="text" name="modalproject_id" id="modalproject_id" value="{{ $project->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
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
                                                                    <input type="month" name="revenue_date" id="revenue_date" min="2000-01" max="2100-12" value="{{old('revenue_date',$projectRevenue['formatRevenueDate'])}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
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
                                                                {{-- <input type="number" min="0" max="999999999" name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
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
                                    <!-- 売上編集モーダル　End -->
                                @endforeach
                            </tbody>
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

                    <div>
                        <button type="button"  onclick="showCorporationModal()" class="md:mt-10 mt-6 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            法人検索
                        </button>
                        <div class="grid gap-4 mt-1 sm:grid-cols-6">
                            <div class="w-full flex flex-col hidden">
                                <label for="billing_corporation_id" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">請求先法人ID</label>
                                <input form="updateForm" type="text" name="billing_corporation_id" class="w-auto py-[2px] border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_id" value="{{old('billing_corporation_id',$project->billing_corporation_id)}}" placeholder="">
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="billing_corporation_num" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">請求先法人№</label>
                                <input type="text" name="billing_corporation_num" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_num" value="{{old('billing_corporation_num',$project->client->corporation->corporation_num)}}" disabled>
                            </div>
                            <div class="w-full flex flex-col col-span-2">
                                <label for="billing_corporation_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">法人名</label>
                                <input type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_name" value="{{old('billing_corporation_name',$project->client->corporation->corporation_name)}}" disabled>
                            </div>
                        </div>
                        <div class="grid gap-4 mt-1 sm:grid-cols-6">
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_name" class="font-semibold dark:text-red-400 text-gray-900 leading-none mt-1">請求先法人名</label>
                                <input type="text" name="billing_corporation_name" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_name" value="{{old('billing_corporation_name',$project->billing_corporation_name)}}">
                            </div>
                        </div>
                        <div class="grid gap-4 mt-1 sm:grid-cols-6">
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_division_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">請求先部署名</label>
                                <input type="text" name="billing_corporation_division_name" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_division_name" value="{{old('billing_corporation_division_name',$project->billing_corporation_dibvision_name)}}">
                            </div>
                        </div>
                        <div class="grid gap-4 mt-1 sm:grid-cols-6">
                            <div class="w-full flex flex-col col-span-3">
                                <label for="billing_corporation_person_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">請求先担当者名</label>
                                <input type="text" name="billing_corporation_person_name" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" id="billing_corporation_person_name" value="{{old('billing_corporation_person_name',$project->client->billing_corporation_person_name)}}">
                            </div>
                        </div>
                        <div class="grid gap-4 mt-1 sm:grid-cols-5">
                            <div class="">
                                <label for="billing_head_post_code" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">郵便番号</label>
                                <input type="text" name="billing_head_post_code" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e mt-1" id="billing_head_post_code" value="{{old('billing_head_post_code',$project->billing_head_post_code)}}" placeholder="" onKeyUp="AjaxZip3.zip2addr(this,'','billing_head_prefecture','billing_head_addre1','','',false);">
                            </div>
                            <div class="">
                                <label for="billing_head_prefecture" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                                <select id="billing_head_prefecture" name="billing_head_prefecture" class="w-full py-1.5  text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="">未選択</option>
                                    @foreach($prefectures as $prefecture)
                                        <option value="{{ $prefecture->id }}" @if( $prefecture->id == $project->head_prefecture ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid gap-4 mt-1 mb-4 sm:grid-cols-6">
                            <div class="col-span-3">
                                <label for="billing_head_addre1" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">代表所在地</label>
                                <input type="text" name="billing_head_addre1" id="billing_head_addre1" value="{{old('billing_head_addre1',$project->billing_head_address1)}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded-s rounded-e" placeholder="">
                            </div>
                        </div>
                        <div class="grid gap-4 mt-6 mb-4 sm:grid-cols-8">
                            <div class="w-full flex flex-col">
                                <label for="proposed_order_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">受注予定月</label>
                                <input form="updateForm" type="month" min="1900-01" max="2100-12" name="proposed_order_date" value="{{ old('proposed_order_date', \Carbon\Carbon::parse($project->proposed_order_date)->format('Y-m') ?? '') }}" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" required>
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="proposed_delivery_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">納品予定月</label>
                                <input form="updateForm" type="month" min="1900-01" max="2100-12"  name="proposed_delivery_date" value="{{ old('proposed_delivery_date', \Carbon\Carbon::parse($project->proposed_delivery_date)->format('Y-m') ?? '') }}" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" required>
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="proposed_accounting_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">計上予定月</label>
                                <input form="updateForm" type="month" min="1900-01" max="2100-12"  name="proposed_accounting_date" value="{{ old('proposed_accounting_date', \Carbon\Carbon::parse($project->proposed_accounting_date)->format('Y-m') ?? '') }}" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" required>
                            </div>
                            <div class="w-full flex flex-col">
                                <label for="proposed_payment_date" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-2">入金予定月</label>
                                <input form="updateForm" type="month" min="1900-01" max="2100-12"  name="proposed_payment_date" value="{{ old('proposed_payment_date', \Carbon\Carbon::parse($project->proposed_payment_date)->format('Y-m') ?? '') }}" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" required>
                            </div>
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="project_memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">プロジェクト備考</label>
                            <textarea form="updateForm" name="project_memo" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1" data-auto-resize="true" id="auto-resize-textarea-content" value="{{old('project_memo',$project->project_memo)}}" cols="30" rows="5" data-auto-resize="true">{{old('project_memo',$project->project_memo)}}</textarea>
                        </div>

                        <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_enduser" name="is_enduser" type="checkbox" value="1" {{ old('is_enduser') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_enduser" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">契約書取得</label>
                                </div>
                                @error('is_enduser')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_dealer" name="is_dealer" type="checkbox" value="1" {{ old('is_dealer') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">注文書取得</label>
                                </div>
                                @error('is_dealer')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="is_supplier" name="is_supplier" type="checkbox" value="1" {{ old('is_supplier') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">検収書取得</label>
                                </div>
                                @error('is_supplier')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </li>
                        </ul>
                        <div class="w-full flex flex-col">
                            <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">証票備考</label>
                            <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 placeholder-gray-400" id="auto-resize-textarea-content_2" value="{{old('memo')}}" cols="30" rows="2" data-auto-resize="true"></textarea>
                        </div>
                        <div class="grid gap-4 my-4 sm:grid-cols-4">
                            <div>
                                <label for="account_company_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属1</label>
                                <select form="updateForm" id="account_company_id" name="account_company_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected($company->id == old('account_company_id', $project->account_company_id))>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('account_company_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_department_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属2</label>
                                <select form="updateForm" id="account_department_id" name="account_department_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == old('department', $project->account_department_id))>{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_affiliation3_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上所属3</label>
                                <select form="updateForm" id="account_affiliation3_id" name="account_affiliation3_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($affiliation3s as $affiliation3)
                                    <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('account_affiliation3_id', $project->account_affiliation3_id))>{{ $affiliation3->affiliation3_name }}</option>
                                    @endforeach
                                </select>
                                @error('account_affiliation3_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="account_user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">計上担当者</label>
                                <select form="updateForm" id="account_user_id" name="account_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == old('account_user_id', $project->account_user_id))>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('account_user_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <form id="updateForm" method="post" action="{{route('project.update', $project)}}" enctype="multipart/form-data" autocomplete="new-password">
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
                    <form action="{{ route('corporations.search') }}" method="GET">
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
                                <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <form action="{{ route('corporations.search') }}" method="GET">
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



            <!-- 売上登録モーダル　Start -->
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
                        <!-- Modal body -->
                        <form method="POST" action="{{ route('projectrevenue.store') }}">
                            @csrf
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="hidden">
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                            <input type="text" name="modalproject_id" id="modalproject_id" value="{{ $project->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
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
                                        {{-- <input type="number" min="0" max="999999999" name="revenue_amount" id="revenue_amount" value="{{old('revenue_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
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
            <!-- 売上登録モーダル　End -->

            <!-- 売上一括登録モーダル　Start -->
            <div id="insertRevenueModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-s rounded-e shadow dark:bg-gray-800 sm:p-5">
                        <!-- Modal header -->
                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                売上一括登録
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="insertRevenueModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form method="POST" action="{{ route('projectrevenue.bulkInsert') }}">
                            @csrf
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="hidden">
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="Insert_modalproject_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">プロジェクトID</label>
                                            <input type="text" name="Insert_modalproject_id" id="Insert_modalproject_id" value="{{ $project->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        </div>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上開始年月</label>
                                            <input type="month" name="start_date" id="start_date" min="2000-01" max="2100-12" value="{{old('start_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="w-full flex flex-col">
                                        <div class="w-full flex flex-col">
                                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上終了年月</label>
                                            <input type="month" name="end_date" id="end_date" min="2000-01" max="2100-12" value="{{old('end_date')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                    </div>
                                    @error('department_id')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="md:flex items-center">
                                        <div class="w-full flex flex-col">
                                        <label for="total_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">売上総額</label>
                                        {{-- <input type="number" min="0" max="999999999" name="total_amount" id="total_amount" value="{{old('total_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required> --}}
                                        <input type="text" onblur="formatNumberInput(this);" maxlength="9" name="total_amount" id="total_amount" value="{{old('total_amount')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required>
                                        </div>
                                    </div>
                                    @error('total_amount')
                                        <div class="text-red-500">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 mt-2">
                                <x-primary-button class="mt-4" id="saveModalButton">
                                    一括登録
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 売上一括登録モーダル　End -->


    
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_corporation.corporation_name}', '${result.client_num}', '${result.client_name}', '${result.department_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(corporationname, clientnum, clientname, department) {
            document.getElementById('corporation_name').value = corporationname;
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

            fetch('/corporations/search', {
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
                    <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.id}', '${result.corporation_num}', '${result.corporation_name}')">${result.corporation_short_name}</td>
                    <td class="py-2 ml-2">${result.corporation_num}</td>
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