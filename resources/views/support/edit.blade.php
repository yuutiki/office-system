<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                サポート履歴編集
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="goBack()">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>
<script>
    function goBack() {
        window.history.back(2);
    }
</script>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">

        <form id="form1" method="post" action="{{route('support.update',$support)}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf
            @method('patch')

            <!-- 法人検索ボタン -->
            {{-- <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                顧客検索
            </button> --}}
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="">
                    <label for="client_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客番号</label>
                    <input type="text" name="client_num" class="w-full py-1 placeholder-red-500 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="client_num" value="{{old('client_num',$support->client->client_num)}}" placeholder="顧客を検索してください" readonly disabled>
                </div>
                <div class="">
                    <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name',$support->client->client_name)}}" placeholder="例）烏丸大学" readonly disabled>
                </div>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                <div>
                    <label for="installation_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                    <select id="installation_type_id" name="installation_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        <option selected value="">未選択</option>
                        @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType->id }}" @if( $installationType->id == $support->client->installation_type_id ) selected @endif>{{ $installationType->name }}</option>
                        @endforeach
                    </select>
                    @error('installation_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="client_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">顧客種別</label>
                    <select id="client_type_id" name="client_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        <option selected value="">未選択</option>
                        @foreach($clientTypes as $clientType)
                        <option value="{{ $clientType->id }}" @if($clientType->id == $support->client->client_type_id) selected @endif>{{ $clientType->name }}</option>
                        @endforeach
                    </select>
                    @error('client_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="department" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->prefix_code }}" @if($department->prefix_code == $support->client->department_name) selected @endif >{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                    <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                        <option selected value="">未選択</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" @if($user->id == $support->client->user_id) selected @endif>{{ $user->name }}</option>
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
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid gap-2 mb-4 sm:grid-cols-6">
                        <div class="">
                            <label for="f_received_at" class="font-semibold text-sm  dark:text-gray-100 text-gray-900 leading-none mt-4">受付日</label>
                            <input type="date" min="2000-01-01" max="2100-12-31" name="f_received_at" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="f_received_at" value="{{old('f_received_at',$support->received_at)}}" placeholder="">
                            @error('f_received_at')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_client_user_department" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客 部署</label>
                            <input type="text" name="f_client_user_department" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="f_client_user_department" value="{{old('f_client_user_department',$support->client_user_department)}}" placeholder="">
                            @error('f_client_user_department')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_client_user_kana_name" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">顧客 氏名</label>
                            <input type="text" name="f_client_user_kana_name" class="block w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="f_client_user_kana_name" value="{{old('f_client_user_kana_name',$support->client_user_kana_name)}}" placeholder="">
                            @error('f_client_user_kana_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="f_support_type_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">サポート種別</label>
                            <select id="f_support_type_id" name="f_support_type_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="f_support_time_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">所要時間</label>
                            <select id="f_support_time_id" name="f_support_time_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="f_user_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">受付対応者</label>
                            <select id="f_user_id" name="f_user_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($user->id == $support->user_id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('f_user_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="f_product_series_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">シリーズ</label>
                            <select id="f_product_series_id" name="f_product_series_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="f_product_version_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">バージョン</label>
                            <select id="f_product_version_id" name="f_product_version_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="f_product_category_id" class="font-semibold text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">系統</label>
                            <select id="f_product_category_id" name="f_product_category_id" class="block w-full py-1.5 border bg-gray-50 rounded-md mt-1 text-sm border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
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

                    <div class="w-full flex flex-col">
                        <label for="f_title" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">タイトル</label>
                        <input type="text" name="f_title" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 " id="f_title" value="{{old('f_title',$support->title)}}" placeholder="">
                        @error('f_title')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="f_request_content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">内容</label>
                        <textarea name="f_request_content" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" id="f_request_content" cols="30" rows="8">{{ old('f_request_content',$support->request_content) }}</textarea>
                        @error('f_request_content')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="f_response_content" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">回答</label>
                        <textarea name="f_response_content" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" id="f_response_content" cols="30" rows="8">{{ old('f_response_content',$support->response_content) }}</textarea>
                    </div>
                    @error('f_response_content')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="grid gap-2 mb-4 sm:grid-cols-2">
                        <div class="w-full flex flex-col">
                            <label for="f_internal_message" class="font-semibold dark:text-red-400 text-red-400 leading-none mt-4">社内連絡欄</label>
                            <textarea name="f_internal_message" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" id="f_internal_message" cols="30" rows="5">{{ old('f_internal_message',$support->internal_message) }}</textarea>
                        </div>
                        @error('f_internal_message')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="w-full flex flex-col">
                            <label for="f_internal_memo1" class="font-semibold dark:text-red-400 text-red-400 leading-none mt-4">社内メモ欄</label>
                            <textarea name="f_internal_memo1" class="w-auto py-1 border text-sm border-gray-300 rounded-md mt-1 placeholder-gray-400" id="f_internal_memo1" cols="30" rows="5">{{ old('f_internal_memo1',$support->internal_memo1) }}</textarea>
                        </div>
                        @error('f_internal_memo1')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                </div>
        </form>
                {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                </div> --}}
        </div>
    </div>
</div>

    <!-- Extra Large Modal -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    {{-- <div id="clientSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class=" w-4/5  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        顧客検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                            <label for="clientName" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="departmentCode" class="font-semibold  dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="departmentCode" name="departmentCode" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->prefix_code }}">{{ $department->department_name }}</option>
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
            const departmentCode = document.getElementById('departmentCode').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, departmentCode })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                searchResultsContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_name}', '${result.client_num}', '${result.installation_type_id}', '${result.department_name}', '${result.client_type_id}', '${result.user_id}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department_name}</td>
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
</x-app-layout>