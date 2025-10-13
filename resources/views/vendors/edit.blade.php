<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editVendor', $vendor) }}
            </h2>
            <div class="ml-auto flex items-center">
                <form method="post" action="{{route('vendors.update',$vendor)}}" enctype="multipart/form-data" autocomplete="new-password" id="editForm">
                    @csrf
                    @method('patch')
                    <x-buttons.save-button id="saveButton">
                        {{ __('update') }}
                    </x-buttons.save-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mx-auto md:w-full my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <!-- 業者No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            業者No.
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $vendor->vendor_num }}</div>
                        </td>
                    </tr>

                    <!-- 法人名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            法人名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="flex items-center">
                                <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-nowrap">{{ $vendor->corporation->corporation_name }}</div>
                                {{-- <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 inline-block px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 whitespace-nowrap">
                                    {{ $support->client->tradeStatus->trade_status_name }}
                                </span> --}}
                            </div>
                        </td>
                    </tr>
                    
                    <!-- 業者名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            業者名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="flex items-center">
                                <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-nowrap">{{ $vendor->vendor_name }}</div>
                                {{-- <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 inline-block px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 whitespace-nowrap">
                                    {{ $support->client->tradeStatus->trade_status_name }}
                                </span> --}}
                            </div>
                        </td>
                    </tr>
                    
                    <!-- 管轄所属 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            管轄部門
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $vendor->department->path }}</div>
                        </td>
                    </tr>
                    
                    <!-- 業者種別 -->
                    <tr class="dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            法人種別
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-pre-wrap">{{ $vendor->vendorType->name }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- タブヘッダStart --}}
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTabs" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="basic-tab" data-tabs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="false">
                        基本情報
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="bank-tab" data-tabs-target="#bank" type="button" role="tab" aria-controls="bank" aria-selected="false">
                        口座情報
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="client-tab" data-tabs-target="#client" type="button" role="tab" aria-controls="client" aria-selected="false">
                        担当顧客
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="person-tab" data-tabs-target="#person" type="button" role="tab" aria-controls="person" aria-selected="false">
                        担当者
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="item-tab" data-tabs-target="#item" type="button" role="tab" aria-controls="item" aria-selected="false">
                        取扱製品
                    </button>
                </li>
            </ul>
        </div>

        {{-- タブコンテンツStart --}}
        <div id="myTabContent">
            {{-- 1つ目のタブコンテンツStart --}}
            <div class="hidden p-4 rounded bg-gray-50 mb-4 dark:bg-gray-800" id="basic" role="tabpanel" aria-labelledby="basic-tab">


            <div class="grid gap-3 mb-2 sm:grid-cols-2">
                <div>
                    <label for="vendor_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2 mt-2">業者名称</label>
                    <input type="text" form="editForm" name="vendor_name" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="vendor_name" value="{{old('vendor_name', $vendor->vendor_name)}}" placeholder="例）烏丸大学">
                    @error('vendor_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="hidden md:inline-block">
                    <label for="vendor_kana_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">業者カナ名称</label>
                    <input type="text" form="editForm" name="vendor_kana_name" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="vendor_kana_name" value="{{old('vendor_kana_name', $vendor->vendor_kana_name)}}" placeholder="例）カラスマダイガク">
                    @error('vendor_kana_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>



        <div class="grid gap-4 mb-4 grid-cols-2">
            <div>
                <label for="vendor_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">業者種別</label>
                <select form="editForm" id="vendor_type_id" name="vendor_type_id" class="input-secondary">
                    <option selected value="">---</option>
                    @foreach($vendorTypes as $vendorType)
                    <option value="{{ $vendorType->id }}" @selected( $vendorType->id == $vendor->vendor_type_id)>{{ $vendorType->name }}</option>
                    @endforeach
                </select>
                @error('vendor_type_id')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="department_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">管轄部門</label>
                <select form="editForm" id="department_id" name="department_id" class="input-secondary">
                    <option selected value="">---</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected( $department->id === (int)$vendor->department_id )>
                            {{ $department->path }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
        </div>



                <div class="grid gap-4 mb-4 lg:grid-cols-5 mt-2">

                    <div class="flex">
                        <div class="w-full flex flex-col">
                            <label for="post_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">郵便番号</label>
                            <input type="text" form="editForm"  name="post_code" class="input-primary" id="post_code" value="{{old('post_code', $vendor->post_code)}}" placeholder="">
                        </div>
                        <button type="button" id="ajaxzip" data-form="editForm"  class="p-2.5 text-sm font-medium h-[35px] text-white mt-[21px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="prefecture_id" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">都道府県</label>
                        <select id="prefecture_id" form="editForm"  name="prefecture_id" class="input-primary">
                            <option selected value="">---</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('prefecture_id',$vendor->prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full flex flex-col md:col-span-3">
                        <label for="address_1" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-1">所在地</label>
                        <input type="text" form="editForm"  name="address_1" id="address_1" value="{{old('address_1', $vendor->address_1)}}" class="input-primary" placeholder="">
                    </div>
                </div>

                {{-- <div class="grid gap-4 sm:grid-cols-2 mb-6">
                    <div class="col-span-2">
                        <label for="vendor_tel" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表TEL</label>
                        <input type="tel" form="editForm" name="vendor_tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="vendor_tel" value="{{old('vendor_tel', $vendor->vendor_tel)}}" onchange="validateAndFormat('vendor_tel')" class="input-secondary" placeholder="">
                    </div>
                    <div class="col-span-2">
                        <label for="vendor_fax" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表FAX</label>
                        <input type="tel" form="editForm" name="vendor_fax" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="vendor_fax" value="{{old('vendor_fax', $vendor->vendor_fax)}}" onchange="validateAndFormat('vendor_fax')" class="input-secondary"  placeholder="">
                    </div>
                </div> --}}

            <div class="grid gap-4 sm:grid-cols-2 mb-6">
                <div>
                    <div class="w-full flex flex-col">
                        <label for="vendor_tel" class="font-normal text-sm dark:text-white text-gray-900 leading-none">電話番号</label>
                        <input type="text" form="editForm" name="vendor_tel" id="vendor_tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" onchange="validateAndFormat('vendor_tel')" value="{{ old('vendor_tel', $vendor->vendor_tel) }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('vendor_tel')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <div class="w-full flex flex-col">
                        <label for="vendor_fax" class="font-normal text-sm dark:text-white text-gray-900 leading-none">FAX番号</label>
                        <input type="text" form="editForm" name="vendor_fax" id="vendor_fax" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" onchange="validateAndFormat('vendor_fax')" value="{{ old('vendor_fax', $vendor->vendor_fax) }}" class="input-secondary" placeholder="090-1234-5678">
                    </div>
                    @error('vendor_fax')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

                <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>

                <div class="grid gap-4 mb-1 sm:grid-cols-5 mt-1">
                    <div class="w-full flex flex-col">
                        <label for="number_of_employees" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">従業員数</label>
                        <input type="number" form="editForm" min="0" name="number_of_employees" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="number_of_employees" value="{{old('number_of_employees',$vendor->number_of_employees)}}">
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="vendor_memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                    <textarea name="vendor_memo" form="editForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea" data-auto-resize="true" cols="30" rows="5">{{old('vendor_memo', $vendor->vendor_memo)}}</textarea>
                </div>

                <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            @if ($vendor->is_dealer)
                                <input type="checkbox" form="editForm" id="is_dealer" name="is_dealer" value="1" checked="checked"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input type="checkbox" form="editForm" id="is_dealer" name="is_dealer" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">ディーラ</label>
                        </div>
                        @error('is_dealer')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            @if ($vendor->is_supplier)
                                <input type="checkbox" form="editForm" id="is_supplier" name="is_supplier" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input type="checkbox" form="editForm" id="is_supplier" name="is_supplier" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">仕入外注先</label>
                        </div>
                        @error('is_supplier')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            @if ($vendor->is_lease)
                                <input type="checkbox" form="editForm" id="is_lease" name="is_lease" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input type="checkbox" form="editForm" id="is_lease" name="is_lease" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="is_lease" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">リース会社</label>
                        </div>
                        @error('is_lease')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            @if ($vendor->is_other_partner)
                                <input type="checkbox" form="editForm" id="is_other_partner" name="is_other_partner" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input type="checkbox" form="editForm" id="is_other_partner" name="is_other_partner" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="is_other_partner" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">その他協業</label>
                        </div>
                        @error('is_other_partner')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>
            </div>
            {{-- 1つ目のタブコンテンツEnd --}}

            {{-- 2つ目のタブコンテンツStart --}}
            <div class="hidden p-4 rounded mb-4 bg-gray-50 dark:bg-gray-800" id="bank" role="tabpanel" aria-labelledby="bank-tab">

                <div class="md:flex">
                    <div class="bg-gray-400 p-3 rounded-md shadow-md w-full max-w-md mx-auto">
                        <div class="text-lg font-bold text-gray-800 mb-1">銀行名</div>
                        <div class="flex mb-2">
                            <div class="w-full flex flex-col">
                                <input type="text" form="corporationForm" name="bank_name" class="w-full py-2 px-3 border border-gray-300 rounded-md" id="bank_search" placeholder="銀行名または銀行コードを入力" value="{{ $vendor->bank_name ?? '' }}">
                            </div>
                            <button type="button" id="bank_search_button" class="p-2.5 text-sm font-medium h-[42px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </div>
                        <div id="bank_results" class="mb-4">
                            <select id="bank_select" form="editForm" name="bank_code" class="w-full py-2 px-3 border border-gray-300 rounded-md">
                                <option value="">銀行を選択してください</option>
                                @if($vendor->bank_code)
                                    <option value="{{ $vendor->bank_code }}" selected>{{ $vendor->bank_code }}：{{ $vendor->bank_name }}</option>
                                @endif
                            </select>
                        </div>
                    
                        <div class="text-lg font-bold text-gray-800 mb-1 hidden">支店名</div>
                        <div class="flex mb-2 hidden">
                            <div class="w-full flex flex-col">
                                <input type="text" class="w-full py-2 px-3 border border-gray-300 rounded-md" id="branch_search" placeholder="支店名を入力">
                            </div>
                            <button type="button" id="branch_search_button" class="p-2.5 text-sm font-medium h-[42px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </div>
                        <div id="branch_results" class="mb- hidden">
                            <select id="branch_select" class="w-full py-2 px-3 border border-gray-300 rounded-md">
                                <option value="">支店を選択してください</option>
                            </select>
                        </div>
                    
                        <div class="text-lg font-bold text-gray-800 mb-1 3">支店番号</div>
                        <div class="flex justify-center space-x-4 mb-2">
                            <input type="text" form="editForm" name="branch_code_1" class="branch-input block w-full h-12 py-3 px-6 text-lg font-extrabold text-center text-gray-900 dark:text-blue-600 bg-white border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" maxlength="1" inputmode="numeric" pattern="[0-9]" placeholder="1" value="{{ substr($vendor->branch_code ?? '', 0, 1) }}">
                            <input type="text" form="editForm" name="branch_code_2" class="branch-input block w-full h-12 py-3 px-6 text-lg font-extrabold text-center text-gray-900 dark:text-blue-600 bg-white border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" maxlength="1" inputmode="numeric" pattern="[0-9]" placeholder="2" value="{{ substr($vendor->branch_code ?? '', 1, 1) }}">
                            <input type="text" form="editForm" name="branch_code_3" class="branch-input block w-full h-12 py-3 px-6 text-lg font-extrabold text-center text-gray-900 dark:text-blue-600 bg-white border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" maxlength="1" inputmode="numeric" pattern="[0-9]" placeholder="3" value="{{ substr($vendor->branch_code ?? '', 2, 1) }}">
                        </div>
                        <div class="flex">
                            <div class="text-center text-sm font-semibold text-gray-700 mb-4">支店名：</div>
                            <div id="branch_name_result" class="text-center text-sm font-semibold text-gray-700 mb-4">{{ $vendor->branch_name ?? '' }}</div>
                        </div>
                        
                        <div class="text-lg font-bold text-gray-800 mb-1">預金種類</div>
                        <ul class="grid w-full gap-4 grid-cols-3 mb-6">
                            <li>
                                <input type="radio" form="editForm" id="ordinary" name="account_type" value="0" class="hidden peer" required {{ ($vendor->account_type ?? '0') == '0' ? 'checked' : '' }}>
                                <label for="ordinary" class="inline-flex items-center justify-center w-full py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-blue-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-100 focus:ring-4 focus:ring-indigo-300 focus:border-indigo-600" tabindex="0">                           
                                    <div class="block">
                                        <div class="w-full text-md">普通</div>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <input type="radio" form="editForm" id="current" name="account_type" value="1" class="hidden peer" {{ ($vendor->account_type ?? '0') == '1' ? 'checked' : '' }}>
                                <label for="current" class="inline-flex items-center justify-center w-full py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-blue-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-100 focus:ring-4 focus:ring-indigo-300 focus:border-indigo-600" tabindex="0">
                                    <div class="block">
                                        <div class="w-full text-md">当座</div>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <input type="radio" form="editForm" id="savings" name="account_type" value="2" class="hidden peer" {{ ($vendor->account_type ?? '0') == '2' ? 'checked' : '' }}>
                                <label for="savings" class="inline-flex items-center justify-center w-full py-3 text-gray-500 bg-white border border-gray-200 rounded-md cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-blue-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-100 focus:ring-4 focus:ring-indigo-300 focus:border-indigo-600" tabindex="0">
                                    <div class="block">
                                        <div class="w-full text-md">貯蓄</div>
                                    </div>
                                </label>
                            </li>
                        </ul>
                        
                        <script>
                            // 各ラベルにイベントリスナーを追加
                            document.querySelectorAll('label[tabindex="0"]').forEach(label => {
                                label.addEventListener('keydown', function(event) {
                                    if (event.key === ' ' || event.key === 'Enter') {
                                        event.preventDefault(); // ページスクロールを防ぐ
                                        const input = document.getElementById(this.getAttribute('for'));
                                        input.checked = true; // 対応するラジオボタンをチェックする
                                    }
                                });
                            });
                        
                            // ページロード時に初期選択されているラジオボタンの状態を強制的に変更
                            document.querySelector('input[name="account_type"]:checked').dispatchEvent(new Event('change'));
                        </script>
                    
                        <div class="text-lg font-bold text-gray-800 mb-1 flex items-center">口座番号
                            <div class="flex items-center">
                                <button data-tooltip-target="tooltip-top" data-tooltip-placement="top" type="button" class="ms-3 mr-2 md:mb-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-1.5 py-[1px] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" tabindex="-1">
                                    ?
                                </button>
                                <div class="text-sm">口座番号が7桁以外の場合は？</div>
                            </div>

                            <div id="tooltip-top" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-xl shadow-sm opacity-0 tooltip dark:bg-gray-600">
                                <span class="text-xs">
                                    ゆうちょ銀行で8桁の場合は最後の「1」を省略、
                                    <br>
                                    桁が足りない場合は先頭に「0」を追加してください。
                                </span>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-1.5 mb-6">
                            @for ($i = 1; $i <= 7; $i++)
                                <input type="text" form="editForm" name="account_number_{{ $i }}" class="account-input block w-full h-14 py-3 text-lg font-extrabold text-center text-gray-900 dark:text-blue-600 bg-white border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" maxlength="1" inputmode="numeric" pattern="[0-9]" placeholder="{{ $i }}" value="{{ substr($vendor->account_number ?? '', $i - 1, 1) }}">
                            @endfor
                        </div>
                    
                        <div class="text-lg font-bold text-gray-800 mb-1">口座名義</div>
                        <div class="grid w-full gap-6 grid-cols-2 mb-6">
                            <div class="w-full flex flex-col">
                                <input type="text" form="editForm" name="account_name_sei" class="w-full py-2 px-3 border border-gray-300 rounded-md" id="account_name_sei" placeholder="ヤマダ" value="{{ explode(' ', $vendor->account_name ?? '')[0] ?? '' }}">
                            </div>
                            <div class="w-full flex flex-col">
                                <input type="text" form="editForm" name="account_name_mei" class="w-full py-2 px-3 border border-gray-300 rounded-md" id="account_name_mei" placeholder="タロウ" value="{{ explode(' ', $vendor->account_name ?? '')[1] ?? '' }}">
                            </div>
                        </div>
                        <p id="result" class="text-center text-lg font-semibold text-gray-700"></p>
                    </div>

                    <div class="mx-auto md:pl-4">
                        <div class="mt-6">
                            <label for="" class="text-white text-sm">銀行番号：銀行名称</label>
                            <input type="text" class="input-readonly" value="{{ $vendor->bank_code }}：{{ $vendor->bank_name }}" tabindex="-1">
                        </div>
                        <div class="mt-3">
                            <label for="" class="text-white text-sm">支店番号：支店名称</label>
                            <input type="text" class="input-readonly" value="{{ $vendor->branch_code }}：{{ $vendor->branch_name }}" tabindex="-1">
                        </div>
                        <div class="mt-8">
                            <label for="" class="text-white text-sm">口座種別</label>
                            <input type="text" class="input-readonly" value="{{ $vendor->account_type }}" tabindex="-1">
                        </div>
                        <div class="mt-3">
                            <label for="" class="text-white text-sm">口座番号</label>
                            <input type="text" class="input-readonly" value="{{ $vendor->account_number }}" tabindex="-1">
                        </div>
                        <div class="mt-3">
                            <label for="" class="text-white text-sm">口座名義</label>
                            <input type="text" class="input-readonly" value="{{ $vendor->account_name }}" tabindex="-1">
                        </div>
                    </div>
                </div>
                
                


                </div>
                {{-- 2つ目のタブコンテンツEnd --}}
                
                {{-- 3つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="person" role="tabpanel" aria-labelledby="person-tab">
                    <p>ただの一覧表示</p>
                </div>
                {{-- 3つ目のタブコンテンツEnd --}}
                
                {{-- 4つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="client" role="tabpanel" aria-labelledby="client-tab">
                <p>ただの一覧表示</p>
                </div>
                {{-- 4つ目のタブコンテンツEnd --}}

                {{-- 5つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="item" role="tabpanel" aria-labelledby="item-tab">
                    <p>ただの一覧表示</p>
                </div>
                {{-- 5つ目のタブコンテンツEnd --}}  
        </div>
    </div>

    <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('corporationSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }

        // モーダルを非表示にするための関数
        function hideModal() {
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

            fetch('/corporation/search', {
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
                    <td class="py-2">${result.corporation_name}</td>
                    <td class="py-2">${result.corporation_num}</td>
                    <td class="py-2">
                    <button type="button" onclick="setCorporation('${result.corporation_name}', '${result.corporation_num}')" class="font-bold text-blue-500 hover:underline"  tabindex="-1">選択</button>
                    </td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setCorporation(name, number) {
            document.getElementById('corporation_num').value = number;
            document.getElementById('corporation_name').value = name;
            hideModal();
            }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankSearchInput = document.getElementById('bank_search');
            const bankSearchButton = document.getElementById('bank_search_button');
            const bankResults = document.getElementById('bank_results');
            const bankSelect = document.getElementById('bank_select');
            const branchSearchInput = document.getElementById('branch_search');
            const branchSearchButton = document.getElementById('branch_search_button');
            const branchResults = document.getElementById('branch_results');
            const branchSelect = document.getElementById('branch_select');
            const branchInputs = document.querySelectorAll('.branch-input');
            const accountInputs = document.querySelectorAll('.account-input');
            const resultElement = document.getElementById('result');
            const accountTypeInputs = document.querySelectorAll('input[name="account_type"]');
            const accountNameSeiInput = document.getElementById('account_name_sei');
            const accountNameMeiInput = document.getElementById('account_name_mei');
            const branchNameResult = document.getElementById('branch_name_result');

            // 状態変数
            let selectedBankCode = bankSelect.value || null;
            let selectedBank = bankSelect.selectedOptions[0] ? bankSelect.selectedOptions[0].text : null;
            let selectedBranch = null;
        
            bankSearchButton.addEventListener('click', searchBanks);
            bankSelect.addEventListener('change', handleBankSelection);
            branchSearchButton.addEventListener('click', searchBranches);
            branchSelect.addEventListener('change', handleBranchSelection);
        
            async function searchBanks() {
                let query = bankSearchInput.value.trim();
                if (query.length < 1) return;

                // 全角数字を半角数字に変換
                query = query.replace(/[０-９]/g, function(s) {
                    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
                });

                try {
                    let url;
                    // 入力が4桁の数字の場合は銀行コードとして扱う
                    if (/^\d{4}$/.test(query)) {
                        url = `https://bank.teraren.com/banks/${query}.json`;
                    } else {
                        // それ以外の場合は銀行名として検索
                        url = `https://bank.teraren.com/banks/search.json?name=${encodeURIComponent(query)}`;
                    }

                    const response = await fetch(url);
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    let banks;
                    if (/^\d{4}$/.test(query)) {
                        // 銀行コードでの検索結果は単一のオブジェクトなので配列に変換
                        const bank = await response.json();
                        banks = [bank];
                    } else {
                        banks = await response.json();
                    }

                    displayBankResults(banks);
                } catch (error) {
                    console.error('Error searching banks:', error);
                    // エラーメッセージをユーザーに表示
                    bankSelect.innerHTML = '<option value="">銀行が見つかりません</option>';
                    bankResults.classList.remove('hidden');
                }
            }

        
            function displayBankResults(banks) {
                bankSelect.innerHTML = '<option value="">銀行を選択してください</option>';
                banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank.code;
                    option.textContent = `${bank.code}： ${bank.normalize.name}`;
                    bankSelect.appendChild(option);
                });
                bankResults.classList.remove('hidden');
            }
        
            function handleBankSelection() {
                const selectedBankOption = bankSelect.selectedOptions[0];
                if (selectedBankOption) {
                    const newBankCode = selectedBankOption.value;
                    if (newBankCode !== selectedBankCode) {
                        // BankCodeが変更された場合、支店番号をクリア
                        clearBranchInfo();
                    }
                    selectedBank = selectedBankOption.text;
                    selectedBankCode = newBankCode;
                    branchSearchInput.disabled = false;
                    branchSearchButton.disabled = false;
                } else {
                    selectedBank = null;
                    selectedBankCode = null;
                    branchSearchInput.disabled = true;
                    branchSearchButton.disabled = true;
                    branchResults.classList.add('hidden');
                    clearBranchInfo();
                }
                validateInput();
            }

            function clearBranchInfo() {
                // 支店番号入力フィールドをクリア
                branchInputs.forEach(input => input.value = '');
                
                // 支店名表示をクリア
                branchNameResult.textContent = '';
                
                // 選択された支店情報をリセット
                selectedBranch = null;
                
                // 支店検索結果をクリア
                branchSelect.innerHTML = '<option value="">支店を選択してください</option>';
                branchResults.classList.add('hidden');
            }

            // 既存のコードに追加：支店番号入力欄のイベントリスナー
            branchInputs.forEach(input => {
                input.addEventListener('input', () => {
                    if (selectedBankCode) {
                        searchBranchByNumber();
                    } else {
                        clearBranchInfo();
                        alert('先に銀行を選択してください。');
                    }
                });
            });

            async function searchBranchByNumber() {
                const branchNumber = Array.from(branchInputs).map(input => input.value).join('');
                if (branchNumber.length === 3 && selectedBankCode) {
                    try {
                        const response = await fetch(`https://bank.teraren.com/banks/${selectedBankCode}/branches/${branchNumber}.json`);
                        if (!response.ok) {
                            throw new Error('Branch not found');
                        }
                        const branch = await response.json();
                        displayBranchNameResult(branch);
                    } catch (error) {
                        console.error('Error searching branch:', error);
                        branchNameResult.textContent = '支店が見つかりません';
                        selectedBranch = null;
                    }
                } else {
                    branchNameResult.textContent = '';
                    selectedBranch = null;
                }
                validateInput();
            }

            // 初期化時に支店番号で検索を実行
            searchBranchByNumber();

            function displayBranchNameResult(branch) {
                if (branch && branch.name) {
                    branchNameResult.textContent = `${branch.name}`;
                    selectedBranch = branch.name;
                } else {
                    branchNameResult.textContent = '支店が見つかりません';
                    selectedBranch = null;
                }
                validateInput();
            }
        
            async function searchBranches() {
                const query = branchSearchInput.value;
                const bankCode = bankSelect.value;
                if (query.length < 2 || !bankCode) return;
        
                try {
                    const response = await fetch(`https://bank.teraren.com/banks/${bankCode}/branches/search.json?name=${encodeURIComponent(query)}`);
                    const branches = await response.json();
                    displayBranchResults(branches);
                } catch (error) {
                    console.error('Error searching branches:', error);
                }
            }
        
            function displayBranchResults(branches) {
                branchSelect.innerHTML = '<option value="">支店を選択してください</option>';
                branches.forEach(branch => {
                    const option = document.createElement('option');
                    option.value = branch.code;
                    option.textContent = branch.name;
                    branchSelect.appendChild(option);
                });
                branchResults.classList.remove('hidden');
            }
        
            function handleBranchSelection() {
                const selectedBranchCode = branchSelect.value;
                if (selectedBranchCode) {
                    selectedBranch = branchSelect.options[branchSelect.selectedIndex].text;
                    const branchCode = selectedBranchCode.padStart(3, '0');
                    branchInputs.forEach((input, index) => {
                        input.value = branchCode[index];
                    });
                } else {
                    selectedBranch = null;
                    branchInputs.forEach(input => input.value = '');
                }
                validateInput();
            }
        
            function handleInput(inputs, isNumeric = false) {
                inputs.forEach((input, index) => {
                    input.addEventListener('input', function(e) {
                        if (isNumeric) {
                            const digit = e.data;
                            if (digit && /^\d$/.test(digit)) {
                                this.value = digit;
                                if (index < inputs.length - 1) {
                                    inputs[index + 1].focus();
                                    inputs[index + 1].select();
                                }
                            } else {
                                e.preventDefault();
                            }
                        } else {
                            if (this.value.length === this.maxLength && index < inputs.length - 1) {
                                inputs[index + 1].focus();
                                inputs[index + 1].select();
                            }
                        }

                        if (inputs === branchInputs) {
                            const branchNumber = Array.from(branchInputs).map(input => input.value).join('');
                            if (branchNumber.length === 3) {
                                searchBranchByNumber();
                            }
                        }
                    });

                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Backspace') {
                            if (this.value.length === 0 && index > 0) {
                                e.preventDefault();
                                inputs[index - 1].focus();
                                inputs[index - 1].select();
                            }
                        } else if (e.key === 'ArrowLeft' && index > 0) {
                            e.preventDefault();
                            inputs[index - 1].focus();
                            inputs[index - 1].select();
                        } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                            e.preventDefault();
                            inputs[index + 1].focus();
                            inputs[index + 1].select();
                        }
                    });

                    input.addEventListener('focus', function() {
                        this.select();
                    });
                });

                inputs[inputs.length - 1].addEventListener('blur', validateInput);
            }

            // 銀行プルダウンの変更イベントリスナー
            bankSelect.addEventListener('change', handleBankSelection);

            handleInput(branchInputs);
            handleInput(accountInputs);

            // リアルタイムバリデーション
            function validateInput() {
                const bankName = selectedBank ? selectedBank.split('：')[1].trim() : '';
                const branchName = selectedBranch || '';
                const branchNumber = Array.from(branchInputs).map(input => input.value).join('');
                const accountNumber = Array.from(accountInputs).map(input => input.value).join('');
                const accountType = Array.from(accountTypeInputs).find(input => input.checked)?.value || '';
                const accountNameSei = accountNameSeiInput.value.trim();
                const accountNameMei = accountNameMeiInput.value.trim();

                if (bankName && branchName && branchNumber.length === 3 && accountNumber.length === 7 && accountType && accountNameSei && accountNameMei) {
                    resultElement.textContent = `銀行名: ${bankName}, 支店名: ${branchName}, 支店番号: ${branchNumber}, 口座番号: ${accountNumber}, 預金種類: ${accountType}, 口座名義: ${accountNameSei} ${accountNameMei}`;
                    resultElement.classList.add('text-green-600', 'text-sm');
                    resultElement.classList.remove('text-red-600');
                } else {
                    resultElement.textContent = '全ての項目を正しく入力してください。';
                    resultElement.classList.add('text-red-600', 'text-sm');
                    resultElement.classList.remove('text-green-600');
                }
            }


            // 支店番号入力時のイベントリスナーを追加
            branchInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (index === 2 && this.value.length === 1) {
                        searchBranchByNumber();
                    }
                });
            });                        

            [bankSearchInput, branchSearchInput, ...branchInputs, ...accountInputs, ...accountTypeInputs, accountNameSeiInput, accountNameMeiInput].forEach(input => {
                input.addEventListener('change', validateInput);
                input.addEventListener('input', validateInput);
            });

            // 初期状態の設定
            branchSearchInput.disabled = true;
            branchSearchButton.disabled = true;
        });
    </script>

    <script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
@push('scripts')
    @vite(['resources/js/pages/vendors/edit.js'])
@endpush
</x-app-layout>