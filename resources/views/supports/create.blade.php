<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('createSupport') }}
            </h2>
            <div class="ml-auto flex space-x-2">
                <form method="post" action="{{ route('supports.store') }}" enctype="multipart/form-data" id="supportForm" class="flex">
                    @csrf
                    <x-buttons.save-button form-id="supportForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __('登録') }}
                    </x-buttons.save-button>

                    <x-buttons.draft-button form-id="supportForm" id="saveButton" class="ml-2" onclick="document.getElementById('isDraft').value = '1'; document.getElementById('supportForm').submit();">
                        {{ __('下書き') }}
                    </x-buttons.draft-button>
                </form>
            </div>
        </div>
    </x-slot>

    {{-- 下書きフラグ用の隠しフィールド --}}
    <input type="hidden" form="supportForm" name="is_draft" id="isDraft" value="0">

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <!-- 顧客検索ボタン(画面小) -->
        <button type="button" onclick="ClientSearchModal.show('clientSearchModal')" class="md:ml-1 md:mt-1 mt-1 mb-4 w-full md:w-auto whitespace-nowrap md:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            顧客検索
        </button>


        <div class="mx-auto my-4 rounded shadow-md overflow-hidden border border-gray-200 dark:border-gray-600">
            <table class="w-full text-sm text-left divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <tbody>
                    
                    <div class="hidden">
                        <label for="client_id">顧客ID（非表示）</label>
                        <input type="hidden" form="supportForm" name="client_id" id="client_id" value="{{ old('client_id', optional($client)->id) }}">
                    </div>
                    <!-- 顧客No. -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-0.5 md:border-r dark:border-gray-600 whitespace-nowrap block bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            <div class="flex items-center justify-between">
                                <span>顧客No.</span>
                                <button type="button" 
                                    onclick="ClientSearchModal.show('clientSearchModal')" 
                                    data-form="supportForm"
                                    class="ml-2 p-1.5 text-sm font-medium h-[30px] text-white bg-blue-700 rounded border border-blue-700 
                                        hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 
                                        dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 
                                        focus:ring-offset-2 dark:focus:ring-offset-gray-800 zip2addr-trigger hidden md:block">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </th>

                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1.5 md:px-2 md:py-1">
                            {{-- <div class="text-sm font-medium md:dark:text-gray-300">{{ optional($report->reportType)->report_type_name }}</div> --}}
                            <input type="text" form="supportForm" name="client_num" id="client_num" value="{{ old('client_num', optional($client)->client_num) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-400 text-sm dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                    
                    <!-- 顧客名称 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            顧客名称
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1">
                            <input type="text" form="supportForm" name="client_name" id="client_name" value="{{ old('client_name', optional($client)->client_name) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-400 text-sm dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">

                        </td>
                    </tr>
                    
                    <!-- 管轄部門 -->
                    <tr class="md:border-b dark:border-gray-600 block md:table-row">
                        <th class="pl-4 pr-2 py-2 md:border-r dark:border-gray-600 whitespace-nowrap block md:table-cell bg-gray-100 dark:bg-gray-800 md:w-36 lg:w-48">
                            管轄部門
                        </th>
                        <td class="md:dark:bg-gray-700 block md:table-cell bg-gray-600 md:bg-white text-white md:text-gray-900 px-4 py-1 md:px-2 md:py-1.5">
                            <input type="text" form="supportForm" name="affiliation2" id="affiliation2" value="{{ old('affiliation2', optional(optional($client)->department)->path) }}" class="w-full py-1 rounded bg-gray-300 dark:bg-gray-400 text-sm dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150 @error('client_id') input-error @enderror" placeholder="" readonly tabindex="-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @error('client_id')
            <div class="validate-message">{{ $message }}</div>
        @enderror







        <!-- タブボタン -->
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="support-request-tab" data-tabs-target="#support-request" type="button" role="tab" aria-controls="support-request" aria-selected="false">サポート内容</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="system-tab" data-tabs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">システム情報</button>
                </li>
                {{-- <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="support-history-tab" data-tabs-target="#support-history" type="button" role="tab" aria-controls="support-history" aria-selected="false">サポート履歴</button>
                </li> --}}
            </ul>
        </div>

        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 mb-4" id="support-request" role="tabpanel" aria-labelledby="support-request-tab">
            <div class="grid gap-2 mb-4 sm:grid-cols-4">
                <div class="">
                    <label for="received_at" class="label-primary">受付日<span class="text-red-500 ml-2">*</span></label>
                    <input type="date" form="supportForm" min="2000-01-01" max="2100-12-31" name="received_at" class="input-primary" id="received_at" value="{{ old('received_at', now()->format('Y-m-d')) }}" placeholder="">
                    @error('received_at') <div class="validate-message">{{ $message }}</div> @enderror
                </div>
                <div class="">
                    <label for="user_id" class="label-primary">受付対応者<span class="text-red-500 ml-2">*</span></label>
                    <select form="supportForm" id="user_id" name="user_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($user->id == Auth::user()->id) selected @endif>{{ $user->user_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex">
                    <div class="relative w-full">
                        <label for="client_user_kana_name" class="label-primary" autocomplete="new-password">顧客 氏名</label>
                        <input type="text" form="supportForm" name="client_user_kana_name" class="input-secondary" id="client_user_kana_name" value="{{old('client_user_kana_name')}}" placeholder="">
                        @error('client_user_kana_name')
                            <div class="validate-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" onclick="showClientPersonModal()" class="p-2.5 text-sm font-medium h-[35px] text-white mt-[27px] ml-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
                <div class="">
                    <label for="client_user_department" class="label-primary">顧客 部署</label>
                    <input type="text" form="supportForm" name="client_user_department" class="input-secondary" id="client_user_department" value="{{old('client_user_department')}}" placeholder="">
                    @error('client_user_department')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="w-full flex flex-col">
                <label for="title" class="label-primary">タイトル</label>
                <input type="text" form="supportForm" name="title" class="input-secondary" id="title" value="{{old('title')}}" placeholder="">
                @error('title')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="request_content" class="label-primary">内容</label>
                <textarea form="supportForm" name="request_content" class="input-secondary" data-auto-resize="true" data-min-height="210" id="request_content" value="{{old('request_content')}}" cols="30" rows="8">{{ old('request_content') }}</textarea>
                @error('request_content')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full flex flex-col">
                <label for="response_content" class="label-primary">回答</label>
                <textarea form="supportForm" name="response_content" class="input-secondary" data-auto-resize="true" data-min-height="210" id="response_content" value="{{old('response_content')}}" cols="30" rows="8">{{ old('response_content') }}</textarea>
                @error('response_content')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid gap-2 mb-4 mt-4 sm:grid-cols-5">
                <div class="">
                    <label for="support_type_id" class="label-primary ">サポート種別</label>
                    <select form="supportForm" id="support_type_id" name="support_type_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($supportTypes as $supportType)
                            <option value="{{ $supportType->id }}" @selected($supportType->id == old('support_type_id'))>{{ $supportType->type_name }}</option>
                        @endforeach
                    </select>
                    @error('support_type_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="support_time_id" class="label-primary ">所要時間</label>
                    <select form="supportForm" id="support_time_id" name="support_time_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($supportTimes as $supportTime)
                            <option value="{{ $supportTime->id }}" @selected($supportTime->id == old('support_time_id'))>{{ $supportTime->name }}</option>
                        @endforeach
                    </select>
                    @error('support_time_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="">
                    <label for="product_series_id" class="label-primary ">シリーズ</label>
                    <select form="supportForm" id="product_series_id" name="product_series_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($productSeriess as $productSeries)
                            <option value="{{ $productSeries->id }}" @selected($productSeries->id == old('product_series_id'))>{{ $productSeries->series_name }}</option>
                        @endforeach
                    </select>
                    @error('product_series_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="product_version_id" class="label-primary ">バージョン</label>
                    <select form="supportForm" id="product_version_id" name="product_version_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($productVersions as $productVersion)
                            <option value="{{ $productVersion->id }}" @selected($productVersion->id == old('product_version_id'))>{{ $productVersion->version_name }}</option>
                        @endforeach
                    </select>
                    @error('product_version_id')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label for="product_category_id" class="label-primary ">系統</label>
                    <select form="supportForm" id="product_category_id" name="product_category_id" class="input-secondary">
                        <option selected value="">---</option>
                        @foreach($productCategories as $productCategory)
                            <option value="{{ $productCategory->id }}" @selected($productCategory->id == old('product_category_id'))>{{ $productCategory->category_name }}</option>
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
                    <textarea form="supportForm" name="internal_message" class="input-secondary" id="internal_message" data-auto-resize="true" data-min-height="150" value="{{old('internal_message')}}" cols="30" rows="5">{{ old('internal_message') }}</textarea>
                </div>
                @error('internal_message')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
                <div class="w-full flex flex-col">
                    <label for="internal_memo1" class="label-primary">社内メモ欄</label>
                    <textarea form="supportForm" name="internal_memo1" class="input-secondary" id="internal_memo1" data-auto-resize="true" data-min-height="150" value="{{old('internal_memo1')}}" cols="30" rows="5">{{ old('internal_memo1') }}</textarea>
                </div>
                @error('internal_memo1')
                    <div class="validate-message">{{ $message }}</div>
                @enderror
            </div>
            <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="supportForm" id="is_finished" name="is_finished" type="checkbox" value="1" {{ old('is_finished') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_finished" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">対応完了済</label>
                    </div>
                    @error('is_finished')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="supportForm" id="is_faq_target" name="is_faq_target" type="checkbox" value="1" {{ old('is_faq_target') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_faq_target" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">FAQ対象</label>
                    </div>
                    @error('is_faq_target')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="supportForm" id="is_disclosured" name="is_disclosured" type="checkbox" value="1" {{ old('is_disclosured') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_disclosured" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">顧客開示</label>
                    </div>
                    @error('is_disclosured')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="supportForm" id="is_troubled" name="is_troubled" type="checkbox" value="1" {{ old('is_troubled') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="is_troubled" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">トラブル</label>
                    </div>
                    @error('is_troubled')
                        <div class="validate-message">{{ $message }}</div>
                    @enderror
                </li>
                <li class="w-full dark:border-gray-600">
                    <div class="flex items-center pl-3">
                        <input form="supportForm" id="is_confirmed" name="is_confirmed" type="checkbox" value="1" {{ old('is_confirmed') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
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
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
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


        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 mb-4" id="system" role="tabpanel" aria-labelledby="system-tab">
            <!-- 導入システム -->
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg overflow-x-auto">
                <table class="w-full mt-2 border-collapse border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-600">
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">シリーズ</th>
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">バージョン</th>
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">システム名称</th>
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">カスタマイズ</th>
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">契約済</th>
                            <th class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">数量</th>
                        </tr>
                    </thead>
                    <tbody class="system-table-body">
                        <tr>
                            <td colspan="6" class="text-center py-4">導入システムはありません</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800 mb-4" id="support-history" role="tabpanel" aria-labelledby="support-history-tab">
            {{-- サポート履歴の一覧をJSONで取得するか。 --}}
        </div>
    </div>




















        <!-- 顧客担当者検索 Modal -->
        <div id="clientPersonSearchModal" tabindex="-1" class="fixed inset-0 items-center justify-center z-50 hidden animate-slide-in-top">
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
                            <label for="clientName" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                            <input type="text" name="clientName" id="clientName" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="clientNumber" class="dark:text-gray-100 text-gray-900 leading-none mt-4">顧客番号</label>
                            <input type="text" name="clientNumber" id="clientNumber" class="w-auto mt-1 mr-3 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col mx-2">
                            <label for="affiliation2Id" class=" dark:text-gray-100 text-gray-900 leading-none mt-4">管轄事業部</label>
                            <select id="affiliation2Id" name="affiliation2Id" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500  text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">---</option>
                                {{-- @foreach($affiliation2s as $affiliation2)
                                <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == Auth::user()->affiliation2->id)>
                                    {{ $affiliation2->affiliation2_name }}
                                </option>
                                @endforeach --}}
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
        const modalPerson = document.getElementById('clientPersonSearchModal');
        const overlay = document.getElementById('overlay');


        function showClientPersonModal() {
            //背後の操作不可を有効
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // モーダルを表示するためのクラスを追加
            modalPerson.classList.remove('hidden');
            modalPerson.classList.add('flex');
        }

        // モーダルを非表示にするための関数
        function hideClientPersonModal() {
            //背後の操作不可を解除
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // モーダルを非表示にするためのクラスを削除
            modalPerson.classList.add('hidden');
            modalPerson.classList.remove('flex');
        }

        // 検索ボタンを押した時の処理
        function searchClientPerson() {
            const clientName = document.getElementById('clientName').value;
            const clientNumber = document.getElementById('clientNumber').value;
            const affiliation2Id = document.getElementById('affiliation2Id').value;

            fetch('/client/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ clientName, clientNumber, affiliation2Id })
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
                    <td class="py-2 ml-2">${result.affiliation2.affiliation2_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClientPerson(name) {
                document.getElementById('client_person_name').value = name;
                hideClientPersonModal();
            }
    </script> 


    <x-modals.client-search-modal
        modalId="clientSearchModal"
        screenId="order_entry"
        :users="$users"
        onSelectCallback="handleClientSelect"
    />

    <script>
        // コールバック関数の定義
        function handleClientSelect(client) {
            document.getElementById('client_id').value = client.id;
            document.getElementById('client_num').value = client.client_num;
            document.getElementById('client_name').value = client.client_name;
            // document.getElementById('sales_user').value = client.user.user_name;
            document.getElementById('affiliation2').value = client.department.path;
        }

        // モーダルのコールバック関数を設定
        window.clientSearchModal_onSelect = handleClientSelect;

        // 顧客情報の更新を明示的に呼び出し
        if (window.clientInfoManager) {
            console.log('Calling handleClientIdChange with:', client.id); // 追加
            window.clientInfoManager.handleClientIdChange(client.id);
        } else {
            console.warn('clientInfoManager not initialized'); // 追加
        }
    </script>
    <script src="{{ asset('/assets/js/modal/client-search-modal.js') }}"></script>
    <script src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>
    <script src="{{ asset('/assets/js/client-info-manager.js') }}"></script>
</x-app-layout>