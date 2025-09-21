<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editSupport', $support) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')"/>
                <form method="post" action="{{ route('supports.update', $support) }}" enctype="multipart/form-data" id="supportForm" class="flex">
                    @csrf
                    @method('patch')
                    <x-button-save form-id="supportForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __('登録') }}
                    </x-button-save>
                    
                    <x-buttons.draft-button form-id="supportForm" id="saveButton" class="ml-2" onclick="document.getElementById('isDraft').value = '1'; document.getElementById('supportForm').submit();">
                        {{ __('下書き') }}
                    </x-buttons.draft-button>
                </form>
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

    {{-- 下書きフラグ用の隠しフィールド --}}
    <input type="hidden" form="supportForm" name="is_draft" id="isDraft" value="0">
    <input type="hidden" form="supportForm" name="client_id" id="client_id" value="{{ $support->client->id }}">

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mx-auto md:w-full my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <!-- 顧客No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            顧客No.
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $support->client->client_num }}</div>
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            顧客名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="flex items-center">
                                <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-nowrap">{{ $support->client->client_name }}</div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium ml-2 inline-block px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400 whitespace-nowrap">
                                    {{ $support->client->tradeStatus->trade_status_name }}
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
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300">{{ $support->client->affiliation2->affiliation2_name }}</div>
                        </td>
                    </tr>
                    
                    <!-- 営業担当 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            営業担当
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            <div class="text-sm md:font-medium md:ml-0 ml-4 md:dark:text-gray-300 whitespace-pre-wrap">{{ $support->client->user->user_name }}</div>
                        </td>
                    </tr>

                    <!-- 契約連番 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            ステータス
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-3 md:px-2 md:py-1.5">
                            @if($support->is_draft)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                                    下書き
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    入力完了
                                </span>
                            @endif
                        </td>
                    </tr>                        
                </tbody>
            </table>
        </div>

        {{-- <div class="dark:bg-gray-600 bg-gray-100 rounded pl-4 py-4 mt-8 dark:text-gray-200 shadow-md">
            <div class="grid gap-4">
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">顧客No.</span>
                    <span class="text-gray-600 dark:text-gray-200">{{ $support->client->client_num }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">顧客名</span>
                    <span class="text-gray-600 dark:text-gray-200">{{ $support->client->client_name }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">管轄事業部</span>
                    <span class="text-gray-600 dark:text-gray-200">{{ $support->client->affiliation2->affiliation2_name }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">営業担当</span>
                    <span class="text-gray-600 dark:text-gray-200">{{ $support->client->user->user_name }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">ステータス</span>
                    @if($support->is_draft)
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                            下書き
                        </span>
                    @else
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                            入力完了
                        </span>
                    @endif
                </div>
            </div>
        </div> --}}

        {{-- タブボタン --}}
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">サポート内容</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="system-tab" data-tabs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">導入システム</button>
                </li>
            </ul>
        </div>

            <!-- サポート情報タブ -->
        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 md:p-4 mb-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid gap-2 mb-4 sm:grid-cols-4">
                <div class="">
                    <label for="received_at" class="label-primary">受付日</label>
                    <input type="date" form="supportForm" min="2000-01-01" max="2100-12-31" name="received_at" class="input-secondary" id="received_at" value="{{old('received_at',$support->received_at)}}" placeholder="">
                    @error('received_at')
                    <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="user_id" class="label-primary ">受付対応者</label>
                    <select form="supportForm" id="user_id" name="user_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id', $support->user_id) == $user->id)>
                                {{ $user->user_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="client_user_kana_name" class="label-primary">顧客 氏名</label>
                    <input form="supportForm" type="text" name="client_user_kana_name" class="input-secondary" id="client_user_kana_name" value="{{old('client_user_kana_name',$support->client_user_kana_name)}}" placeholder="">
                    @error('client_user_kana_name')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="client_user_department" class="label-primary">顧客 部署</label>
                    <input form="supportForm" type="text" name="client_user_department" class="input-secondary" id="client_user_department" value="{{old('client_user_department',$support->client_user_department)}}" placeholder="">
                    @error('client_user_department')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="title" class="label-primary">タイトル</label>
                <input form="supportForm" type="text" name="title" class="input-secondary" id="title" value="{{ old('title', $support->title) }}" placeholder="">
                @error('title')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="request_content" class="label-primary">内容</label>
                <textarea form="supportForm" name="request_content" class="input-secondary" data-auto-resize="true" id="request_content" data-min-height="210" cols="30" rows="8">{{ old('request_content', $support->request_content) }}</textarea>
                @error('request_content')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="response_content" class="label-primary">回答</label>
                <textarea form="supportForm" name="response_content" class="input-secondary" data-auto-resize="true" id="response_content" data-min-height="210" cols="30" rows="8">{{ old('response_content', $support->response_content) }}</textarea>
                @error('response_content')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>


            <div class="grid gap-2 mb-4 mt-4 sm:grid-cols-5">
                <div class="">
                    <label for="support_type_id" class="label-primary">サポート種別</label>
                    <select form="supportForm" id="support_type_id" name="support_type_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($supportTypes as $supportType)
                            <option value="{{ $supportType->id }}" @selected(old('support_type_id', $support->support_type_id) == $supportType->id)>
                                {{ $supportType->type_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('support_type_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="support_time_id" class="label-primary">所要時間</label>
                    <select form="supportForm" id="support_time_id" name="support_time_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($supportTimes as $supportTime)
                            <option value="{{ $supportTime->id }}" @selected(old('support_time_id', $support->support_time_id) == $supportTime->id)>
                                {{ $supportTime->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('support_time_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="product_series_id" class="label-primary">シリーズ</label>
                    <select form="supportForm" id="product_series_id" name="product_series_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($productSeriess as $productSeries)
                            <option value="{{ $productSeries->id }}" @selected(old('product_series_id', $support->product_series_id) == $productSeries->id)>
                                {{ $productSeries->series_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_series_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="product_version_id" class="label-primary">バージョン</label>
                    <select form="supportForm" id="product_version_id" name="product_version_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($productVersions as $productVersion)
                            <option value="{{ $productVersion->id }}" @selected(old('product_version_id', $support->product_version_id) == $productVersion->id)>
                                {{ $productVersion->version_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_version_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="product_category_id" class="label-primary">系統</label>
                    <select form="supportForm" id="product_category_id" name="product_category_id" class="input-secondary">
                        <option value="">---</option>
                        @foreach($productCategories as $productCategory)
                            <option value="{{ $productCategory->id }}" @selected(old('product_category_id', $support->product_category_id) == $productCategory->id)>
                                {{ $productCategory->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-2 mb-4 sm:grid-cols-2">
                <div class="w-full flex flex-col">
                    <label for="internal_message" class="label-primary">社内連絡欄</label>
                    <textarea form="supportForm" name="internal_message" class="input-secondary" data-auto-resize="true" id="internal_message" data-min-height="150" cols="30">{{ old('internal_message', $support->internal_message) }}</textarea>
                    @error('internal_message')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="internal_memo1" class="label-primary">社内メモ欄</label>
                    <textarea form="supportForm" name="internal_memo1" class="input-secondary" data-auto-resize="true" id="internal_memo1" data-min-height="150" cols="30">{{ old('internal_memo1', $support->internal_memo1) }}</textarea>
                    @error('internal_memo1')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input type="hidden" form="supportForm" name="is_finished" value="0">
                        <input type="checkbox" form="supportForm" id="is_finished" name="is_finished" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            @checked(old('is_finished', $support->is_finished))>
                        <label for="is_finished" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                    </div>
                    @error('is_finished')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>

                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input type="hidden" form="supportForm" name="is_faq_target" value="0">
                        <input type="checkbox" form="supportForm" id="is_faq_target" name="is_faq_target" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            @checked(old('is_faq_target', $support->is_faq_target))>
                        <label for="is_faq_target" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                    </div>
                    @error('is_faq_target')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
            
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input type="hidden" form="supportForm" name="is_disclosured" value="0">
                        <input type="checkbox" form="supportForm" id="is_disclosured" name="is_disclosured" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            @checked(old('is_disclosured', $support->is_disclosured))>
                        <label for="is_disclosured" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                    </div>
                    @error('is_disclosured')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
            
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input type="hidden" form="supportForm" name="is_troubled" value="0">
                        <input type="checkbox" form="supportForm" id="is_troubled" name="is_troubled" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            @checked(old('is_troubled', $support->is_troubled))>
                        <label for="is_troubled" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                    </div>
                    @error('is_troubled')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
            
                <li class="w-full dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input type="hidden" form="supportForm" name="is_confirmed" value="0">
                        <input type="checkbox" form="supportForm" id="is_confirmed" name="is_confirmed" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            @checked(old('is_confirmed', $support->is_confirmed))>
                        <label for="is_confirmed" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">上長確認済</label>
                    </div>
                    @error('is_confirmed')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
            </ul>
        </div>
        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 mb-4" id="base" role="tabpanel" aria-labelledby="base-tab">
            <!-- メインコンテンツ -->
            <div class="flex flex-col gap-6 mt-6">
                <!-- 法人情報 -->
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">法人情報</h3>
                    <div class="grid gap-4">
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">法人No.</span>
                            <span class="corporation-num text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">法人名</span>
                            <span class="corporation-name text-gray-600 dark:text-gray-200">-</span>
                        </div>
                    </div>
                </div>

                <!-- 顧客情報 -->
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">顧客情報</h3>
                    <div class="grid gap-4">
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">顧客No.</span>
                            <span class="client-num text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">顧客名</span>
                            <span class="client-name text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">設置種別</span>
                            <span class="installation-type text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">顧客種別</span>
                            <span class="client-type text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">管轄事業部</span>
                            <span class="affiliation text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">営業担当</span>
                            <span class="sales-user text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">取引状態</span>
                            <span class="trade-status text-gray-600 dark:text-gray-200">-</span>
                        </div>
                    </div>
                </div>

                <!-- 連絡先 -->
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">代表連絡先</h3>
                    <div class="grid gap-4">
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">電話番号</span>
                            <span class="tel text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">FAX番号</span>
                            <span class="fax text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">Email</span>
                            <span class="email text-gray-600 dark:text-gray-200">-</span>
                        </div>
                    </div>
                </div>

                <!-- 所在地情報 -->
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">所在地</h3>
                    <div class="grid gap-4">
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">郵便番号</span>
                            <span class="postal-code text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">都道府県</span>
                            <span class="prefecture text-gray-600 dark:text-gray-200">-</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-600 dark:text-gray-300">住所</span>
                            <span class="address text-gray-600 dark:text-gray-200">-</span>
                        </div>
                    </div>
                </div>

                <!-- 契約情報 -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">契約情報</h3>
                    <div class="bg-gray-100 dark:bg-gray-700 p-0.5 rounded-lg overflow-x-auto">
                        <table class="w-full mt-2 border-collapse border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-600">
                                    <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">契約区分</th>
                                    <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">契約金額</th>
                                    <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">契約開始日</th>
                                    <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">解約日</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">サポート契約</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">30,000,000</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">2025年4月1日</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">-</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">バックアップ契約</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">200,000</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">2025年4月1日</td>
                                    <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
    </div>

    <!-- 不要？ -->
    <div id="clientSearchModal" tabindex="-1" class="fixed inset-0 items-center justify-center z-50 hidden">
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
                            <select form="supportForm" id="affiliation2Code" name="affiliation2Code" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">---</option>
                                @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->affiliation2_prefix }}">{{ $affiliation2->affiliation2_name }}</option>
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
        const modal = document.getElementById('clientSearchModal');
        const overlay = document.getElementById('overlay');
        
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            //背後の操作不可を有効
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('clientSearchModal');
            //背後の操作不可を解除
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
            modal.classList.remove('flex');
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
<script src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
<script src="{{ asset('/assets/js/client-info-manager.js') }}"></script>

</x-app-layout>