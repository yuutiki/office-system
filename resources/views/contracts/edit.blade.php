<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editContract', $contract) }}
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="grid gap-4 mb-4 md:grid-cols-4">
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2 mt-4">顧客番号</label>
                    <input type="text" name="client_num"  value="{{ $client->client_num }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2">契約連番</label>
                    <input type="text" name="contract_num" value="{{ $contract->contract_num }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
            </div>
            <div class="grid gap-4 mb-4 md:grid-cols-4">
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2">法人名称</label>
                    <input type="text" name="corporation_name" value="{{ $client->corporation->corporation_name }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2">顧客名称</label>
                    <input type="text" name="client_name" value="{{ $client->client_name }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2">管轄所属</label>
                    <input type="text" name="user_name" value="{{ $client->department->department_name }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
                <div class="">
                    <label class="block font-semibold dark:text-gray-100 text-gray-900 leading-none sm:mt-2">営業担当</label>
                    <input type="text" name="user_name" value="{{ $client->user->name }}" class="dark:bg-gray-400 w-full py-0.5 px-1 rounded mt-1" readonly>
                </div>
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
                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        <div>
                            <label for="contract_type_id" class="text-gray-900 dark:text-white leading-none mt-4 text-sm">契約種別<span class="text-red-500"> *</span></label>
                            <select form="updateForm" id="contract_type_id" name="contract_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">未選択</option>
                                @foreach($contractTypes as $contractType)
                                <option value="{{ $contractType->id }}" @selected($contractType->id == old('contract_type_id', $contract->contract_type_id))>{{ $contractType->contract_type_name }}</option>
                                @endforeach
                            </select>
                            @error('contract_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <div>
                                <label class="text-gray-900 dark:text-white leading-none mt-4 text-sm">契約先区分(参照)</label>
                                <input type="text" value="{{ $oldestContractPartnerTypeName }}" class="input-primary" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 md:grid-cols-6 grid-cols-2">
                        <div>
                            <label class="text-gray-900 dark:text-white leading-none mt-4 text-sm">初回契約日(参照)</label>
                            <input type="date" value="{{ $firstContractStartAt }}" class="input-primary" readonly>
                        </div>
                        <div>
                            <label for="cancelled_at" class="text-gray-900 dark:text-white leading-none mt-4 text-sm">解約日</label>
                            <input type="date" form="updateForm" min="1900-01-01" max="2200-12-31" value="{{ old('cancelled_at', $contract->cancelled_at) }}" name="cancelled_at" class="input-primary">
                        </div>
                        {{-- <div>
                            <label for="contract_type_id" class="text-gray-900 dark:text-white leading-none mt-4 text-sm">更新月</label>
                            <select form="updateForm" id="contract_type_id" name="contract_type_id" class="bg-gray-400 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none">
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
                            契約期間: {{ $periodString }}
                        </div>

                    </div>


                    {{-- テーブル表示 --}}
                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto mt-8 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">
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
                                    {{-- <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th> --}}
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap">
                                        {{-- <button data-modal-target="storeRevenueModal" data-modal-toggle="storeRevenueModal"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                            <div class="flex items-center">
                                                <svg class="h-3.5 w-3.5 mr-1.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                    </svg>
                                                <span class="text-ms">追加</span>
                                            </div>
                                        </button> --}}
                                    </th>
                                    <th scope="col" class="flex items-center justify-center py-1">
                                        <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex py-1.5 px-4 text-sm m-auto font-medium text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            Actions
                                        </button>
                                    </th>
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
                                        <td class="px-2 py-1 text-center">
                                            <button id="" onclick="location.href='{{ route('contracts.details.edit', ['contract' => $contract, 'detail' => $contractDetail]) }}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-2 py-0.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                                <div class="flex items-center">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">編集</span>
                                                </div>
                                            </button>
                                        </td>
                                        <td class="px-2 py-1">
                                            <button data-modal-target="deleteModal-{{$contractDetail->id}}" data-modal-toggle="deleteModal-{{$contractDetail->id}}"  class="block m-auto whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded text-sm px-2 py-0.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                                <div class="flex items-center">
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
                                    </tr>
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
                            <label for="project_memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">契約備考</label>
                            <textarea form="updateForm" name="project_memo" class="w-auto py-1 border border-gray-300 rounded mt-1" data-auto-resize="true" id="auto-resize-textarea-content" value="{{old('project_memo')}}" cols="30" rows="5" data-auto-resize="true">{{old('project_memo')}}</textarea>
                        </div>

                        <form id="updateForm" method="post" action="{{route('contracts.update', $contract)}}" enctype="multipart/form-data" autocomplete="new-password">
                            @csrf
                            @method('patch')
                            <x-primary-button class="mt-4" form="updateForm" id="saveButton">
                                編集を確定する(s)
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="estimate" role="tabpanel" aria-labelledby="estimate-tab">
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="client" role="tabpanel" aria-labelledby="client-tab">
                <div>
                    {{ $client->head_post_code }}
                </div>
                <div>
                    {{ $client->head_prefecture }}
                </div>
                <div>
                    {{ $client->head_address1 }}
                </div>
            </div>
            <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="dealer" role="tabpanel" aria-labelledby="dealer-tab">
            </div>
        </div>
    </div>



    <!-- 追加drawer --> 
    <div id="dupdateModal" class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform md:w-1/2 translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="dupdateModal">
        <div class="">
            <h5 id="dupdateModal" class="inline-flex items-center mb-4 font-semibold text-xl text-gray-500 dark:text-gray-400">
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
    </div>



<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>