<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editSupport', $support) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')"/>
                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$support->id}}" data-modal-show="deleteModal-{{$support->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500" onclick="focusCancel()">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">削除</span>
                            </div>
                        </button>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $support->updated_at }}</span>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ optional($support->updatedBy)->user_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        {{-- <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div class="">
                <label for="client_num" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                <input type="text" name="client_num" class="w-full py-1 placeholder-red-500 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_num" value="{{ $support->client->client_num }}" placeholder="顧客を検索してください" readonly disabled>
            </div>
            <div class="">
                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" value="{{ $support->client->client_name }}" readonly disabled>
            </div>
        </div>

        <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
            <div class="">
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">設置種別</label>
                <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" value="{{ $support->client->installationType->type_name }}" readonly disabled>
            </div>
            <div class="">
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客種別</label>
                <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" value="{{ $support->client->clientType->client_type_name }}" readonly disabled>
            </div>
            <div class="">
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">管轄所属</label>
                <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" value="{{ $support->client->affiliation2->affiliation2_name }}" readonly disabled>
            </div>
            <div class="">
                <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">営業担当</label>
                <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" value="{{ $support->client->user->name }}" readonly disabled>
            </div>
        </div> --}}

        <div class="bg-gray-600 rounded px-4 py-4 mt-8 dark:text-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="whitespace-nowrap md:mt-3">
                    <div class="text-xs text-white">{{ $support->client->client_num }}</div>
                    <div class="text-white">{{ $support->client->client_name }}</div>
                </div>
                <div class="flex md:mt-3">
                    <div class="whitespace-nowrap mr-12">
                        <div class="text-xs text-gray-300">設置種別</div>
                        <div class="text-white">{{ $support->client->installationType->type_name }}</div>
                    </div>
                    <div class="whitespace-nowrap">
                        <div class="text-xs text-gray-300">顧客種別</div>
                        <div class="text-white">{{ $support->client->clientType->client_type_name }}</div>
                    </div>
                </div>
                <div class="whitespace-nowrap md:mt-3">
                    <div class="text-xs text-gray-300">管轄事業部</div>
                    <div class="text-white">{{ $support->client->affiliation2->affiliation2_name }}</div>
                </div>
                <div class="whitespace-nowrap md:mt-3">
                    <div class="text-xs text-gray-300">営業担当</div>
                    <div class="text-white">{{ $support->client->user->user_name }}</div>
                </div>
            </div>
        </div>

        {{-- タブボタン --}}
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">サポート内容</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="system-tab" data-tabs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">導入システム</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">導入システム</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">環境情報</button>
                </li> --}}
            </ul>
        </div>

            <!-- サポート情報タブ -->
        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 md:p-4 mb-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form id="form1" method="post" action="{{route('supports.update',$support)}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf
                @method('patch')

                <div class="grid gap-2 sm:grid-cols-6">
                    <div class="">
                        <label for="f_received_at" class="text-sm  dark:text-gray-100 text-gray-900 leading-none mt-4">受付日</label>
                        <input type="date" min="2000-01-01" max="2100-12-31" name="f_received_at" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_received_at" value="{{old('f_received_at',$support->received_at)}}" placeholder="">
                        @error('f_received_at')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_user_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">受付対応者</label>
                        <select id="f_user_id" name="f_user_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($user->id == $support->user_id) selected @endif>{{ $user->user_name }}</option>
                            @endforeach
                        </select>
                        @error('f_user_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_client_user_department" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客 部署</label>
                        <input type="text" name="f_client_user_department" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_client_user_department" value="{{old('f_client_user_department',$support->client_user_department)}}" placeholder="">
                        @error('f_client_user_department')
                        <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_client_user_kana_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客 氏名</label>
                        <input type="text" name="f_client_user_kana_name" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="f_client_user_kana_name" value="{{old('f_client_user_kana_name',$support->client_user_kana_name)}}" placeholder="">
                        @error('f_client_user_kana_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="f_title" class="dark:text-gray-100 text-gray-900 leading-none mt-4">タイトル</label>
                    <input type="text" name="f_title" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 " id="f_title" value="{{old('f_title',$support->title)}}" placeholder="">
                    @error('f_title')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="f_request_content" class="dark:text-gray-100 text-gray-900 leading-none mt-4">内容</label>
                    <textarea name="f_request_content" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" data-auto-resize="true" id="f_request_content" cols="30" rows="8">{{ old('f_request_content',$support->request_content) }}</textarea>
                    @error('f_request_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="f_response_content" class="dark:text-gray-100 text-gray-900 leading-none mt-4">回答</label>
                    <textarea name="f_response_content" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" data-auto-resize="true" id="f_response_content" cols="30" rows="8">{{ old('f_response_content',$support->response_content) }}</textarea>
                    @error('f_response_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="grid gap-2 mb-4 sm:grid-cols-2">
                    <div class="w-full flex flex-col">
                        <label for="f_internal_message" class="dark:text-red-400 text-red-400 leading-none mt-4">社内連絡欄</label>
                        <textarea name="f_internal_message" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" data-auto-resize="true" id="f_internal_message" cols="30" rows="5">{{ old('f_internal_message',$support->internal_message) }}</textarea>
                        @error('f_internal_message')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="f_internal_memo1" class="dark:text-red-400 text-red-400 leading-none mt-4">社内メモ欄</label>
                        <textarea name="f_internal_memo1" class="w-auto py-1 border text-sm border-gray-300 rounded mt-1 placeholder-gray-400" data-auto-resize="true" id="f_internal_memo1" cols="30" rows="5">{{ old('f_internal_memo1',$support->internal_memo1) }}</textarea>
                        @error('f_internal_memo1')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-2 mb-4 sm:grid-cols-5">
                    <div class="">
                        <label for="f_support_type_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">サポート種別</label>
                        <select id="f_support_type_id" name="f_support_type_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($supportTypes as $supportType)
                                <option value="{{ $supportType->id }}" @if($supportType->id == $support->support_type_id) selected @endif>{{ $supportType->type_name }}</option>
                            @endforeach
                        </select>
                        @error('f_support_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_support_time_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">所要時間</label>
                        <select id="f_support_time_id" name="f_support_time_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($supportTimes as $supportTime)
                                <option value="{{ $supportTime->id }}" @if($supportTime->id == $support->support_time_id) selected @endif>{{ $supportTime->time_name }}</option>
                            @endforeach
                        </select>
                        @error('f_support_time_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_product_series_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">シリーズ</label>
                        <select id="f_product_series_id" name="f_product_series_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($productSeriess as $productSeries)
                                <option value="{{ $productSeries->id }}" @if($productSeries->id == $support->product_series_id) selected @endif>{{ $productSeries->series_name }}</option>
                            @endforeach
                        </select>
                        @error('f_product_series_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_product_version_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">バージョン</label>
                        <select id="f_product_version_id" name="f_product_version_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($productVersions as $productVersion)
                                <option value="{{ $productVersion->id }}" @if($productVersion->id == $support->product_version_id) selected @endif>{{ $productVersion->version_name }}</option>
                            @endforeach
                        </select>
                        @error('f_product_version_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="f_product_category_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">系統</label>
                        <select id="f_product_category_id" name="f_product_category_id" class="block w-full py-1.5 border bg-gray-50 rounded mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($productCategories as $productCategory)
                                <option value="{{ $productCategory->id }}" @if($productCategory->id == $support->product_category_id) selected @endif>{{ $productCategory->category_name }}</option>
                            @endforeach
                        </select>
                        @error('f_product_category_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="f_is_finished1" name="f_is_finished" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @if($support->is_finished)
                                <input id="f_is_finished" name="f_is_finished" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input id="f_is_finished" name="f_is_finished" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="f_is_finished" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                        </div>
                        @error('f_is_finished')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="f_is_faq_target1" name="f_is_faq_target" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @if($support->is_faq_target === 1)
                                <input id="f_is_faq_target" name="f_is_faq_target" type="checkbox" checked="checked" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input id="f_is_faq_target" name="f_is_faq_target" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="f_is_faq_target" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                        </div>
                        @error('f_is_faq_target')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="f_is_disclosured1" name="f_is_disclosured" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @if($support->is_disclosured === 1)
                                <input id="f_is_disclosured" name="f_is_disclosured" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input id="f_is_disclosured" name="f_is_disclosured" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="f_is_disclosured" class="cursor-pointer    w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                        </div>
                        @error('f_is_disclosured')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="f_is_troubled1" name="f_is_troubled" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @if($support->is_troubled === 1)
                                <input id="f_is_troubled" name="f_is_troubled" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @else
                                <input id="f_is_troubled" name="f_is_troubled" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="f_is_troubled" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                        </div>
                        @error('f_is_troubled')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="f_is_confirmed1" name="f_is_confirmed" type="hidden" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @if($support->is_confirmed === 1)
                                <input id="f_is_confirmed" name="f_is_confirmed" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" >
                            @else
                                <input id="f_is_confirmed" name="f_is_confirmed" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            @endif
                            <label for="f_is_confirmed" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">上長確認済</label>
                        </div>
                        @error('f_is_confirmed')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>
                <x-primary-button class="mt-4">
                    変更を確定する
                </x-primary-button>
            </form>
        </div>


        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="system" role="tabpanel" aria-labelledby="system-tab">
            <div class="relative overflow-x-auto mt-8">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">
                                システム名称
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                シリーズ
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                バージョン
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                数量
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                契約状況
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                PKG/CUS
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientProducts as $clientProduct)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white border-x border-gray-600">
                                    {{ $clientProduct->product->product_name }}
                                </th>
                                <td class="px-2 py-2 text-center border-x border-gray-600">
                                    {{ $clientProduct->product->productSeries->series_name }}
                                </td>
                                <td class="px-2 py-2 text-center border-x border-gray-600">
                                    {{ $clientProduct->productVersion->version_name }}
                                </td>
                                <td class="px-2 py-2 text-center border-x border-gray-600">
                                    {{ $clientProduct->quantity }}
                                </td>
                                <td class="px-2 py-2 text-center border-x border-gray-600">
                                    @if ($clientProduct->is_contracted)
                                        <span class="bg-blue-100 text-blue-800 text-xs whitespace-nowrap font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                            契約済み
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs whitespace-nowrap font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                            未契約
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-x border-gray-600">
                                    @if ($clientProduct->is_customized)
                                        <span class="bg-red-100 text-red-800 text-xs whitespace-nowrap font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                            CUS
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs whitespace-nowrap font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                            PKG
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        </div>
        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
        </div> --}}
    </div>

    <!-- 不要？ -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class=" w-4/5  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"  onclick="hideModal()"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('client.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                    <div class="grid gap-2 mb-4 sm:grid-cols-3">
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientName" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="affiliation2Code" class=" dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="affiliation2Code" name="affiliation2Code" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->prefix_code }}">{{ $affiliation2->affiliation2_name }}</option>
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
                        </tr>
                        </thead>
                        <tbody class="" id="searchResultsContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>

    <!-- 削除モーダル -->
    <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                    <div class="flex justify-center">
                        <form action="{{route('supports.destroy',$support->id)}}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 dark:focus:ring-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                削除
                            </button>
                        </form>
                        <button id="cancelButton-{{$support->id}}" data-modal-hide="deleteModal-{{$support->id}}" type="button" onkeydown="stopTab(event)" class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            やっぱやめます
                        </button>
                    </div>
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
        function searchCorporation() {
            const clientName = document.getElementById('clientName').value;
            const clientNumber = document.getElementById('clientNumber').value;
            const affiliation2Code = document.getElementById('affiliation2Code').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, affiliation2Code })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_name}', '${result.client_num}', '${result.installation_type_id}', '${result.affiliation2_id}', '${result.client_type_id}', '${result.user_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.affiliation2_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

        function setClient(name, number, installation, affiliation2, clienttype, user) {
            document.getElementById('client_num').value = number;
            document.getElementById('client_name').value = name;
            document.getElementById('installation_type_id').value = installation;
            document.getElementById('affiliation2').value = affiliation2;
            document.getElementById('client_type_id').value = clienttype;
            document.getElementById('user_id').value = user;

            hideModal();
        }
    </script> 
    <script>
        function focusCancel(supportId) {
            setTimeout(() => {
            const cancelButton = document.getElementById('cancelButton-{{$support->id}}');
            if (cancelButton) {
                cancelButton.focus();
            }
        }, 200); // 100ミリ秒の遅延を設定
        }
    </script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
</x-app-layout>