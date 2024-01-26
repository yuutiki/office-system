<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                サポート履歴登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('support.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">

        <form id="form1" method="post" action="{{route('support.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf

            <!-- 法人検索ボタン -->
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button>
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="">
                    <label for="client_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                    <input type="text" name="client_num" class="w-full py-1 placeholder-red-800 bg-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_num" value="{{$clientNum}}" placeholder="顧客を検索してください" readonly>
                </div>
                @error('client_num')
                <div class="text-red-500">{{ $message }}</div>
                @enderror

                <div class="">
                    <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="w-full py-1 placeholder-red-800 bg-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{$clientName}}" placeholder="顧客を検索してください" readonly>
                </div>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                <div>
                    <label for="installation_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                    <select id="installation_type_id" name="installation_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed pointer-events-none" readonly>
                        <option selected value="">未選択</option>
                        @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType->id }}" {{ old('installation_type_id') == $installationType->id ? 'selected' : '' }} >{{ $installationType->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="client_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">顧客種別</label>
                    <select id="client_type_id" name="client_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed pointer-events-none" readonly>
                        <option selected value="">未選択</option>
                        @foreach($clientTypes as $clientType)
                        <option value="{{ $clientType->id }}" @selected($clientType->id == old('client_type_id')) >{{ $clientType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="department" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed pointer-events-none" readonly>
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                    <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed pointer-events-none" readonly>
                        <option selected value="">未選択</option>
                        @foreach($users as $user)
                        {{-- <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option> --}}
                        <option value="{{ $user->id }}" @selected($user->id == old('user_id'))>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- タブボタン --}}
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">サポート内容</button>
                    </li>
                    {{-- <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">契約情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">導入システム</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">環境情報</button>
                    </li> --}}
                </ul>
            </div>
            <div id="myTabContent">
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid gap-2 mb-4 sm:grid-cols-5">
                        <div class="">
                            <label for="f_received_at" class="font-semibold text-sm  dark:text-gray-100 text-gray-900 leading-none mt-4">受付日</label>
                            <input type="date" min="2000-01-01" max="2100-12-31" name="f_received_at" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_received_at" value="{{ old('f_received_at', now()->format('Y-m-d')) }}" placeholder="">
                            @error('f_received_at')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_user_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">受付対応者</label>
                            <select id="f_user_id" name="f_user_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($user->id == Auth::user()->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('f_user_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_client_user_department" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">担当者 部署</label>
                            <input type="text" name="f_client_user_department" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_client_user_department" value="{{old('f_client_user_department')}}" placeholder="">
                            @error('f_client_user_department')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="">
                            <label for="f_client_user_kana_name" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">担当者 氏名</label>
                            <input type="text" name="f_client_user_kana_name" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_client_user_kana_name" value="{{old('f_client_user_kana_name')}}" placeholder="">
                            @error('f_client_user_kana_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="">
                            <label for="f_client_user_kana_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">担当者 氏名</label>
                            <div class="relative w-full">
                                <input type="text" name="f_client_user_kana_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-e rounded-s mt-1" id="f_client_user_kana_name" value="{{old('f_client_user_kana_name')}}" placeholder="">
                                <button type="button" onclick="showClientPersonModal()" class="absolute top-0 end-0 p-2 text-sm font-medium h-[34px] text-white mt-1 bg-blue-700 rounded-e border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                                @error('f_client_user_kana_name')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="f_title" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">タイトル</label>
                        <input type="text" name="f_title" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 " id="f_title" value="{{old('f_title')}}" placeholder="">
                        @error('f_title')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="f_request_content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">内容</label>
                        <textarea name="f_request_content" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" data-auto-resize="true" id="f_request_content" value="{{old('f_request_content')}}" cols="30" rows="8">{{ old('f_request_content') }}</textarea>
                        @error('f_request_content')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="f_response_content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">回答</label>
                            <textarea name="f_response_content" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" id="f_response_content" data-auto-resize="true" value="{{old('f_response_content')}}" cols="30" rows="8">{{ old('f_response_content') }}</textarea>
                        </div>
                        @error('f_response_content')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid gap-2 mb-4 mt-4 sm:grid-cols-5">
                        <div class="">
                            <label for="f_support_type_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">サポート種別</label>
                            <select id="f_support_type_id" name="f_support_type_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($supportTypes as $supportType)
                                    <option value="{{ $supportType->id }}" @selected($supportType->id == old('f_support_type_id'))>{{ $supportType->type_name }}</option>
                                @endforeach
                            </select>
                            @error('f_support_type_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_support_time_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">所要時間</label>
                            <select id="f_support_time_id" name="f_support_time_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($supportTimes as $supportTime)
                                    <option value="{{ $supportTime->id }}" @selected($supportTime->id == old('f_support_time_id'))>{{ $supportTime->time_name }}</option>
                                @endforeach
                            </select>
                            @error('f_support_time_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="f_product_series_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">シリーズ</label>
                            <select id="f_product_series_id" name="f_product_series_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($productSeriess as $productSeries)
                                    <option value="{{ $productSeries->id }}" @selected($productSeries->id == old('f_product_series_id'))>{{ $productSeries->series_name }}</option>
                                @endforeach
                            </select>
                            @error('f_product_series_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_product_version_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">バージョン</label>
                            <select id="f_product_version_id" name="f_product_version_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($productVersions as $productVersion)
                                    <option value="{{ $productVersion->id }}" @selected($productVersion->id == old('f_product_version_id'))>{{ $productVersion->version_name }}</option>
                                @endforeach
                            </select>
                            @error('f_product_version_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_product_category_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">系統</label>
                            <select id="f_product_category_id" name="f_product_category_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($productCategories as $productCategory)
                                    <option value="{{ $productCategory->id }}" @selected($productCategory->id == old('f_product_category_id'))>{{ $productCategory->category_name }}</option>
                                @endforeach
                            </select>
                            @error('f_product_category_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-2 mb-4 sm:grid-cols-2">
                        <div class="w-full flex flex-col">
                            <label for="f_internal_message" class="font-semibold dark:text-red-400 text-red-400 leading-none mt-4">社内連絡欄</label>
                            <textarea name="f_internal_message" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" id="f_internal_message" data-auto-resize="true" value="{{old('f_internal_message')}}" cols="30" rows="5">{{ old('f_internal_message') }}</textarea>
                        </div>
                        @error('f_internal_message')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="w-full flex flex-col">
                            <label for="f_internal_memo1" class="font-semibold dark:text-red-400 text-red-400 leading-none mt-4">社内メモ欄</label>
                            <textarea name="f_internal_memo1" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" id="f_internal_memo1" data-auto-resize="true" value="{{old('f_internal_memo1')}}" cols="30" rows="5">{{ old('f_internal_memo1') }}</textarea>
                        </div>
                        @error('f_internal_memo1')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="f_is_finished" name="f_is_finished" type="checkbox" value="1" {{ old('f_is_finished') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="f_is_finished" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                            </div>
                            @error('f_is_finished')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="f_is_faq_target" name="f_is_faq_target" type="checkbox" value="1" {{ old('f_is_faq_target') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="f_is_faq_target" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                            </div>
                            @error('f_is_faq_target')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="f_is_disclosured" name="f_is_disclosured" type="checkbox" value="1" {{ old('f_is_disclosured') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="f_is_disclosured" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                            </div>
                            @error('f_is_disclosured')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="f_is_troubled" name="f_is_troubled" type="checkbox" value="1" {{ old('f_is_troubled') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="f_is_troubled" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                            </div>
                            @error('f_is_troubled')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="f_is_confirmed" name="f_is_confirmed" type="checkbox" value="1" {{ old('f_is_confirmed') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="f_is_confirmed" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">上長確認済</label>
                            </div>
                            @error('f_is_confirmed')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                    </ul>
                    <x-primary-button class="mt-4">
                        新規登録する
                    </x-primary-button>
                </div>
        </form>
                {{-- <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                </div>
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                </div>
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                </div> --}}
        </div>
    </div>
</div>

    <!-- 顧客検索 Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                {{-- <form action="{{ route('client.search') }}" method="GET"> --}}
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
                {{-- </form> --}}
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1"></th> --}}
                            <th class="py-2 pl-5">顧客名称</th>
                            <th class="py-2 ml-2 whitespace-nowrap">顧客番号</th>
                            <th class="py-2 ml-2 whitespace-nowrap">管轄事業部</th>
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
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

        <!-- 顧客担当者検索 Modal -->
        <div id="clientPersonSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
                <div class="max-h-full w-full max-w-2xl">
                    <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                顧客担当者検索画面
                            </h3>
                            <button type="button" onclick="hideClientPersonModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
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
                        <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                            <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                                <thead>
                                <tr>
                                    {{-- <th class="py-1"></th> --}}
                                    <th class="py-2 pl-5">顧客名称</th>
                                    <th class="py-2 ml-2 whitespace-nowrap">顧客番号</th>
                                    <th class="py-2 ml-2 whitespace-nowrap">管轄事業部</th>
                                </tr>
                                </thead>
                                <tbody class="" id="searchResultsContainer">                          
                                        <!-- 検索結果がここに追加されます -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                検索
                            </button>
                            <button type="button" onclick="hideClientPersonModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_name}', '${result.client_num}', '${result.installation_type_id}', '${result.department_id}', '${result.client_type_id}', '${result.user_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(name, number, installation, department, clienttype, user) {
            document.getElementById('client_num').value = number;
            document.getElementById('client_name').value = name;
            document.getElementById('installation_type_id').value = installation;
            document.getElementById('department').value = department;
            document.getElementById('client_type_id').value = clienttype;
            document.getElementById('user_id').value = user;

            hideModal();
            }
    </script>

<script>
    // モーダルを表示するための関数
    function showClientPersonModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('clientPersonSearchModal');
        //背後の操作不可を有効
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');
    }

    // モーダルを非表示にするための関数
    function hideClientPersonModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('clientPersonSearchModal');
        //背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // モーダルを非表示にするためのクラスを削除
        modal.classList.add('hidden');
    }

    // 検索ボタンを押した時の処理
    function searchClientPerson() {
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
                <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_name}', '${result.client_num}', '${result.installation_type_id}', '${result.department_id}', '${result.client_type_id}', '${result.user_id}')">${result.client_name}</td>
                <td class="py-2 ml-2">${result.client_num}</td>
                <td class="py-2 ml-2">${result.department.department_name}</td>
            `;
            searchResultsContainer.appendChild(resultElement);
            });
        });
        }

        function setClientPerson(name, number, installation, department, clienttype, user) {
        document.getElementById('client_num').value = number;
        document.getElementById('client_name').value = name;
        document.getElementById('installation_type_id').value = installation;
        document.getElementById('department').value = department;
        document.getElementById('client_type_id').value = clienttype;
        document.getElementById('user_id').value = user;

        hideClientPersonModal();
        }
</script> 

    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>