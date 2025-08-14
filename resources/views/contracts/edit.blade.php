<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editContract', $contract) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('contracts.update', $contract) }}" enctype="multipart/form-data" id="updateForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_corporations')
                        <x-buttons.save-button form-id="updateForm" id="saveButton" class="">
                            {{ __("update") }}
                        </x-buttons.save-button>
                    @endcan
                </form>

                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2.5 text-sm font-medium text-center hover:bg-[#313a48] bg-[#364050] text-white rounded focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>    
            </div>
            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$contract->id}}" data-modal-show="deleteModal-{{$contract->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-red-500 dark:text-red-500">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">削除</span>
                            </div>
                        </button>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $contract->updated_at }}</span>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ $contract->updatedBy->user_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div class="mx-2 md:pl-12 pb-2">
        <div class="mx-auto md:w-full my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    <!-- 顧客No. -->
                    {{-- <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            顧客No.
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $client->client_num }}</div>
                        </td>
                    </tr> --}}

                    
                    <!-- 法人名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            法人名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $client->corporation->corporation_name }}</div>
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            顧客名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="flex items-center">
                                <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $client->client_num }}：{{ $client->client_name }}</div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 inline-block px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{ $client->tradeStatus->trade_status_name }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- 管轄所属 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            管轄所属
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $client->affiliation2->affiliation2_name }}</div>
                        </td>
                    </tr>
                    
                    <!-- 営業担当 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            営業担当
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-pre-wrap">{{ $client->user->user_name }}</div>
                        </td>
                    </tr>

                    <!-- 契約連番 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            契約連番
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $contract->contract_num }}</div>
                        </td>
                    </tr>                        
                </tbody>
            </table>
        </div>




            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="client-tab" data-tabs-target="#client" type="button" role="tab" aria-controls="client" aria-selected="false">顧客情報</button>
                    </li>
                    @if ($client->dealer_id)
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dealer-tab" data-tabs-target="#dealer" type="button" role="tab" aria-controls="dealer" aria-selected="false">ディーラ情報</button>
                    </li>
                    @endif
                </ul>
            </div>

            <div id="myTabContent">
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid gap-4 mb-4 lg:grid-cols-5 grid-cols-1">
                        {{-- <div>
                            <label for="contract_type_id" class="text-gray-900 dark:text-white leading-none mt-4 text-sm">契約種別<span class="text-red-500"> *</span></label>
                            <select form="updateForm" id="contract_type_id" name="contract_type_id" class="input-secondary">
                                <option value="">未選択</option>
                                @foreach($contractTypes as $contractType)
                                <option value="{{ $contractType->id }}" @selected($contractType->id == old('contract_type_id', $contract->contract_type_id))>{{ $contractType->contract_type_name }}</option>
                                @endforeach
                            </select>
                            @error('contract_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div>
                            <div>
                                <label class="text-gray-900 dark:text-white leading-none mt-4 text-sm">契約種別</label>
                                <input type="text" value="{{ $contract->contractType->contract_type_name }}" class="input-readonly" readonly>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label class="text-gray-900 dark:text-white leading-none mt-4 text-sm">契約先区分</label>
                                <input type="text" value="{{ $oldestContractPartnerTypeName }}" class="input-readonly" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-900 dark:text-white leading-none mt-4 text-sm">初回契約日</label>
                            <input type="date" value="{{ $firstContractStartAt }}" class="input-readonly" readonly>
                        </div>
                        <div>
                            <label for="cancelled_at" class="text-gray-900 dark:text-white leading-none mt-4 text-sm">解約日</label>
                            <input type="date" form="updateForm" min="1900-01-01" max="2200-12-31" value="{{ old('cancelled_at', $contract->cancelled_at) }}" name="cancelled_at" class="input-primary">
                        </div>
                    </div>
                    <div>
                        <span class="text-white">
                            契約期間: {{ $periodString }}
                        </span>
                    </div>


                    <div class="relative bg-white dark:bg-gray-900 rounded-t-md md:w-auto m-auto shadow-md  dark:text-gray-900 mt-4">
                        <div class="flex flex-col items-center justify-between px-4 py-2 space-y-1 md:flex-row md:space-y-0 md:space-x-4">
                            <div class="w-full md:w-1/2">
                                <span class="dark:text-white">契約詳細</span>
                            </div>
                            <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-1 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                <button type="button" onclick="location.href='{{ route('contracts.details.create', $contract->id) }}'" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-s rounded-e bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                    {{ __('Add') }}
                                </button>
                                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        {{ __('Actions') }}
                                    </button>
                                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                                            <li>
                                                {{-- <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="block w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                                    CSV一括登録
                                                </button> --}}
                                            </li>
                                            <li>
                                                <form id="bulkDeleteForm" action="{{ route('projectrevenue.bulkDelete') }}" method="POST">
                                                    @csrf
                                                    @method('delete') <!-- 隠しフィールドを追加 -->
                                                    <button type="submit" id="bulkDeleteButton" form="bulkDeleteForm" class="block whitespace-nowrap w-full focus:ring-4 focus:outline-none focus:ring-blue-300 py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                                            <span class="text-ms">一括削除</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <div>
                                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s rounded-e md:w-auto focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                            </svg>
                                            Filter
                                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="filterDropdown" class="z-10 hidden w-56 p-3 bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                                事業部
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                @foreach ($affiliation2s as $affiliation2)
                                                <li class="flex items-center">
                                                    <input id="{{ $affiliation2->id }}" type="checkbox" value=""class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                                    <label for="{{ $affiliation2->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $affiliation2->affiliation2_name }}</label>
                                                </li>                       
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- テーブル表示 --}}
                     {{-- <div class="md:w-auto md:ml-14 md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700  dark:text-gray-900 bg-gray-300"> --}}

                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-gray-700 bg-gray-300 dark:bg-gray-700 dark:text-gray-100">
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
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            契約開始日
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            契約終了日
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            更新月
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            契約金額
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            自動更新
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            新規/更新/変更
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            添付
                                        </div>
                                    </th>
                                    {{-- <th scope="col" class="flex items-center py-1">
                                        <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex py-1.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            Actions
                                        </button>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contractDetails as $contractDetail)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white">
                                        <td class="pl-4 py-1 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input id="checkbox{{ $contractDetail->id }}" type="checkbox" name="selectedIds[]" value="{{ $contractDetail->id }}" form="bulkDeleteForm" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                                            </div>
                                        </td>
                                        <td class="pl-4 py-1 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-2 py-1 text-center">
                                            <button id="" onclick="location.href='{{ route('contracts.details.edit', ['contract' => $contract, 'contractDetail' => $contractDetail]) }}'"  class="button-edit-primary" type="button">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                    </svg>
                                                    <span class=" md:block hidden">編集</span>
                                                </div>
                                            </button>
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $contractDetail->contract_start_at }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $contractDetail->contract_end_at }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($contractDetail->contract_end_at)->endOfMonth()->addDay()->format('n') }}月
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ number_format($contractDetail->contract_amount) }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $contractDetail->contractUpdateType->contract_update_type_name }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            @if ($contractDetail->contract_change_type_id == 1)
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                    {{ $contractDetail->contractChangeType->contract_change_type_name }}
                                                </span>
                                            @elseif ($contractDetail->contract_change_type_id == 3)
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                                    {{ $contractDetail->contractChangeType->contract_change_type_name }}
                                                </span>
                                            @else
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                    {{ $contractDetail->contractChangeType->contract_change_type_name }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            @if ($contractDetail->attachments->isNotEmpty())
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                                    有り
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                    なし
                                                </span>
                                            @endif
                                        </td>

                                        {{-- <td class="px-2 py-1">
                                            <button data-modal-target="deleteModal-{{$contractDetail->id}}" data-modal-toggle="deleteModal-{{$contractDetail->id}}"  class="button-delete-primary" type="button">
                                                <div class="flex items-center">
                                                    <svg aria-hidden="true" class="w-[17px] h-[17px] mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                    <span class="text-ms ">削除</span>
                                                </div>
                                            </button>
                                        </td> --}}
                                    </tr>
                                    {{-- <tr>
                                        <td>
                                            <div id="deleteModal-{{$contractDetail->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full animate-slide-in-top justify-center">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                                        <button data-modal-hide="deleteModal-{{$contractDetail->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                                                <form action="{{route('projectrevenue.destroy',$contractDetail->id)}}" method="POST" class="">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" data-modal-hide="deleteModal-{{$contractDetail->id}}" class="mr-3 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm  items-center px-5 py-2.5 text-center">
                                                                        削除
                                                                    </button>
                                                                </form>
                                                                <button data-modal-hide="deleteModal-{{$contractDetail->id}}" type="button" class="items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                    やっぱやめます
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
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
                                <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="text-center">
                                        {{-- <button class="block whitespace-nowrap w-full text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium  text-sm px-2 py-1 text-center m-auto" type="button" data-drawer-target="dupdateModal" data-drawer-body-scrolling="false" data-drawer-show="dupdateModal" data-drawer-placement="right" aria-controls="dupdateModal">
                                            <div class="flex">
                                                <span class="text-ms">追加</span>
                                            </div>
                                        </button> --}}
                                        <a href="{{ route('contracts.details.create', $contract->id) }}">契約詳細新規登録画面へ</a>
                                    </div>
                                </td>
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
                        </div>
                    </div>

                    {{-- <div id="accordion-arrow-icon" data-accordion="open" class="">
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
                    </div> --}}

                    <div>
                        <div class="w-full flex flex-col">
                            <label for="contract_memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4">契約備考</label>
                            <textarea form="updateForm" name="contract_memo" class="input-secondary" data-auto-resize="true" id="auto-resize-textarea-content" value="{{old('contract_memo')}}" cols="30" rows="5" data-auto-resize="true">{{old('contract_memo', $contract->contract_memo)}}</textarea>
                        </div>


                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="estimate" role="tabpanel" aria-labelledby="estimate-tab">
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="client" role="tabpanel" aria-labelledby="client-tab">
                <div>
                    {{ $client->post_code }}
                </div>
                <div>
                    {{ $client->prefecture_id }}
                </div>
                <div>
                    {{ $client->address_1 }}
                </div>
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="dealer" role="tabpanel" aria-labelledby="dealer-tab">
            </div>
    </div>



    {{-- <!-- 追加drawer --> 
    <div id="dupdateModal" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform md:w-1/2 translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal">
        <div class="">
            <h5 id="dupdateModal" class="inline-flex items-center mb-4 text-sm text-xl text-gray-500 dark:text-gray-400">
                契約詳細
            </h5>
            <button type="button" data-drawer-hide="dupdateModal" aria-controls="dupdateModal" class="text-gray-400 bg-transparent ml-8 hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <form id="updateForm" method="POST" action="{{ route('support.create') }}">
            @csrf

            <div class="grid gap-4 my-4 md:grid-cols-2">
                <div>
                    <div class="w-full flex flex-col col-span-2 mt-4">
                        <label for="contract_start_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約開始日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_start_at" id="contract_start_at" value="{{old('contract_start_at')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                    </div>
                    @error('contract_start_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col col-span-2 mt-4">
                        <label for="contract_end_at" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約終了日</label>
                        <input type="date" min="1900-01-01" max="2200-12-31" name="contract_end_at" id="contract_end_at" value="{{old('contract_end_at')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                    </div>
                    @error('contract_end_at')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <div class="w-full flex flex-col col-span-2 mt-4">
                    <label for="contract_amount" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1">契約金額</label>
                    <input type="text" maxlength="100" name="contract_amount" id="contract_amount" value="{{old('contract_amount')}}" class="dark:bg-white w-auto py-1 border border-gray-300 rounded-s rounded-e mt-1 mb-1" required>
                </div>
                @error('contract_amount')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="w-full flex flex-col">
                <label for="target_system" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">対象システム</label>
                <textarea name="target_system" id="target_system" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('target_system') }}</textarea>
                @error('target_system_')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="target_system" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">契約詳細備考</label>
                <textarea name="target_system" id="target_system" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" data-auto-resize="true"  cols="30" rows="8">{{ old('target_system') }}</textarea>
                @error('target_system_')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-4 my-4 md:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="contract_update_type_id" class="block font-medium text-gray-900 dark:text-white">契約更新区分</label>
                    <select name="contract_update_type_id" id="contract_update_type_id" value="{{old('contract_update_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        @foreach($contractUpdateTypes as $contractUpdateType)
                        <option value="{{ $contractUpdateType->id }}"  @selected($contractUpdateType->id == old('contract_update_type_id'))>{{ $contractUpdateType->contract_update_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('contract_update_type_id_')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="contract_sheet_status_id" class="block font-medium text-gray-900 dark:text-white">契約書状態</label>
                    <select name="contract_sheet_status_id" id="contract_sheet_status_id" value="{{old('contract_sheet_status_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        @foreach($contractSheetStatuses as $contractSheetStatus)
                        <option value="{{ $contractSheetStatus->id }}"  @selected($contractSheetStatus->id == old('contract_sheet_status_id'))>{{ $contractSheetStatus->contract_sheet_status_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('contract_sheet_status_id_')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="contract_partner_type_id" class="block font-medium text-gray-900 dark:text-white">契約先区分</label>
                    <select name="contract_partner_type_id" id="contract_partner_type_id" value="{{old('contract_partner_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        @foreach($contractPartnerTypes as $contractPartnerType)
                        <option value="{{ $contractPartnerType->id }}"  @selected($contractPartnerType->id == old('contract_partner_type_id'))>{{ $contractPartnerType->contract_partner_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('contract_partner_type_id_')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="contract_change_type_id" class="block font-medium text-gray-900 dark:text-white">契約先区分</label>
                    <select name="contract_change_type_id" id="contract_change_type_id" value="{{old('contract_change_type_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-s rounded-e focus:ring-primary-600 focus:border-primary-600 block w-full py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        @foreach($contractChangeTypes as $contractChangeType)
                        <option value="{{ $contractChangeType->id }}"  @selected($contractChangeType->id == old('contract_change_type_id'))>{{ $contractChangeType->contract_change_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('contract_change_type_id_')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
                
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <button type="button" onclick="submitAndUpdateDrawer()" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Update') }}
                </button>
                <button type="button" data-modal-target="deleteModal" data-modal-show="deleteModal" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-s rounded-e text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ __('Delete') }}
                </button>
            </div>
        </form>
    </div> --}}



<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>