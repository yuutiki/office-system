<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-sm text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editClient', $client) }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('clients.update', $client) }}" enctype="multipart/form-data" id="clientForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_clients')
                        <x-button-save form-id="clientForm" id="saveButton" onkeydown="stopTab(event)">
                            <span class="ml-1 hidden md:inline text-sm">更新</span>
                        </x-button-save>
                    @endcan
                </form>

                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-56 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$client->id}}" data-modal-show="deleteModal-{{$client->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500" onclick="focusCancel()">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="font-semibold">削除</span>
                            </div>
                        </button>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $client->updated_at }}</span>
                    </li>
                    <li>
                        <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ $client->updatedBy->user_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-2 pb-4 sm:pl-16 py-4">

        <div class="">
            <div class="relative z-0 hidden">
                <input type="text" id="client_num" name="client_num" form="clientForm" value="{{old('client_num',$client->client_num)}}" class="block py-2.5 px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                <label for="client_num" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">顧客No.</label>
            </div>

            <div class="ml-2">
                <div class="flex items-center">
                    <div class="text-white text-sm">{{ $client->corporation->corporation_name }}</div>
                    <span class="ml-6 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                        {{ $client->tradeStatus->trade_status_name }}
                    </span>
                </div>
                <div class="md:flex mt-1">
                    <div class="text-white text-lg">{{ $client->client_num }}</div>
                    <div class="text-white text-lg md:ml-6">{{ $client->client_name }}</div>
                </div>
            </div>

            <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700"></ul>


            {{-- <div class="grid gap-3 mb-2 sm:grid-cols-2">
                <div class="">
                    <label for="corporation_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2 mt-2">法人名称</label>
                    <input type="text" name="corporation_name" class="w-full py-1 mt-1 bg-gray-400 border border-gray-300 rounded" id="corporation_name" value="{{ $client->corporation->corporation_name }}" readonly>           
                </div>
                <div class="hidden md:inline-block">
                    <label for="corporation_kana_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">法人カナ名称</label>
                    <input type="text" name="corporation_kana_name" class="w-full py-1 mt-1 bg-gray-400 border border-gray-300 rounded" id="corporation_kana_name" value="{{ $client->corporation->corporation_kana_name }}" readonly>           
                </div>
                <div class="">
                    <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2 mt-2">顧客名称</label>
                    <input type="text" name="client_name" form="clientForm" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="client_name" value="{{old('client_name',$client->client_name)}}" placeholder="例）烏丸大学">
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
                <div class="hidden md:inline-block">
                    <label for="client_kana_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客カナ名称</label>
                    <input type="text" name="client_kana_name" form="clientForm" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="client_kana_name" value="{{old('client_kana_name',$client->client_kana_name)}}" placeholder="例）カラスマダイガク">
                    @error('client_kana_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
            </div> --}}







            {{-- タブヘッダStart --}}
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('base')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="{{ $activeTab === 'base' ? 'true' : 'false' }}">
                            基本情報
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('contracts')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contracts-tab" data-tabs-target="#contracts" type="button" role="tab" aria-controls="contracts" aria-selected="{{ $activeTab === 'contracts' ? 'true' : 'false' }}">
                            契約情報
                        </button>
                    </li>

                @if ($client->is_enduser)
                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('environments')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="environments-tab" data-tabs-target="#environments" type="button" role="tab" aria-controls="environments" aria-selected="{{ $activeTab === 'environments' ? 'true' : 'false' }}">
                            環境情報
                        </button>
                    </li>
                @endif
                @if ($client->is_enduser)
                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('systems')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="systems-tab" data-tabs-target="#systems" type="button" role="tab" aria-controls="systems" aria-selected="{{ $activeTab === 'systems' ? 'true' : 'false' }}">
                            導入システム
                        </button>
                    </li>
                @endif

                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('reports')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="reports-tab" data-tabs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="{{ $activeTab === 'reports' ? 'true' : 'false' }}">
                            営業報告
                        </button>
                    </li>
                
                    @if ($client->is_enduser)
                    <li class="mr-2" role="presentation">
                        <button onclick="changeTab('supports')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="supports-tab" data-tabs-target="#supports" type="button" role="tab" aria-controls="supports" aria-selected="{{ $activeTab === 'supports' ? 'true' : 'false' }}">
                            サポート履歴
                        </button>
                    </li>
                @endif

                </ul>
            </div>
            {{-- タブコンテンツStart --}}
            <div id="myTabContent">

                {{-- 1つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="profile-tab">

                <div class="grid gap-3 mb-2 sm:grid-cols-2">
                    <div class="">
                        <label for="client_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2 mt-2">顧客名称</label>
                        <input type="text" name="client_name" form="clientForm" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="client_name" value="{{old('client_name',$client->client_name)}}" placeholder="例）烏丸大学">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror                
                    </div>
                    <div class="hidden md:inline-block">
                        <label for="client_kana_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客カナ名称</label>
                        <input type="text" name="client_kana_name" form="clientForm" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" id="client_kana_name" value="{{old('client_kana_name',$client->client_kana_name)}}" placeholder="例）カラスマダイガク">
                        @error('client_kana_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror                
                    </div>
                </div>

                    <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-1">
                        <div>
                            <label for="installation_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">顧客カテゴリ</label>
                            <select id="installation_type_id" name="installation_type_id" form="clientForm" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($installationTypes as $installationType)
                                <option value="{{ $installationType->id }}" @selected( $installationType->id == $client->installation_type_id)>{{ $installationType->type_name }}</option>
                                @endforeach
                            </select>
                            @error('installation_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="client_type_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">顧客種別</label>
                            <select id="client_type_id" name="client_type_id" form="clientForm" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($clientTypes as $clientType)
                                <option value="{{ $clientType->id }}" @selected( $clientType->id == $client->client_type_id)>{{ $clientType->client_type_name }}</option>
                                @endforeach
                            </select>
                            @error('client_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="trade_status_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">取引状態</label>
                            <select id="trade_status_id" name="trade_status_id" form="clientForm" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($tradeStatuses as $tradeStatus)
                                <option value="{{ $tradeStatus->id }}" @selected( $tradeStatus->id == $client->trade_status_id )>{{ $tradeStatus->trade_status_name }}</option>
                                @endforeach
                            </select>
                            @error('trade_status_id')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="affiliation2" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                            <select id="affiliation2" name="affiliation2" form="clientForm" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($affiliation2s as $affiliation2)
                                    <option value="{{ $affiliation2->id }}" @selected( $affiliation2->id == $client->affiliation2_id )>{{ $affiliation2->affiliation2_name }}</option>
                                @endforeach
                            </select>
                            @error('affiliation2')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="user_id" class="text-sm text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                            <select id="user_id" name="user_id" form="clientForm" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected( $user->id == $client->user_id)>{{ $user->user_name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700"></ul>

                    <div class="grid gap-4 mb-4 sm:grid-cols-5 mt-2">

                        <div class="">
                            <label for="head_post_code" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">郵便番号</label>
                            {{-- <input type="text" name="head_post_code" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="head_post_code" value="{{old('head_post_code')}}" placeholder="" onKeyUp="AjaxZip3.zip2addr(this,'','head_prefecture','head_addre1','','',false);"> --}}
                            <div class="relative w-full">
                                <input type="text" name="head_post_code" form="clientForm" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="head_post_code" value="{{old('head_post_code', $client->head_post_code)}}" placeholder="">
                                <button type="button" id="client_ajaxzip3" class="absolute top-0 end-0 p-2.5 text-sm h-[34px] text-white mt-1 bg-blue-700 rounded-e border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- <x-general-button type="button" class="ajaxzip3">
                            郵便番号から住所を取得
                        </x-general-button> --}}
                        <div class="">
                            <label for="head_prefecture_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                            <select id="head_prefecture_id" name="head_prefecture_id" form="clientForm" class="w-full py-1.5  text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($prefectures as $prefecture)
                                    <option value="{{ $prefecture->id }}" @if( $prefecture->id == $client->head_prefecture ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label for="head_addre1" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表所在地</label>
                            <input type="text" name="head_addre1" form="clientForm" id="head_addre1" value="{{old('head_addre1', $client->head_address1)}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" placeholder="">
                        </div>




                        <div class="">
                            <label for="head_tel" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表TEL</label>
                            <input type="text" name="head_tel" form="clientForm" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_tel" value="{{old('head_tel',$client->head_tel)}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" placeholder="">
                        </div>
    
                        <div class="">
                            <label for="head_fax" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">代表FAX</label>
                            <input type="tel" name="head_fax" form="clientForm" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="13" id="head_fax" value="{{old('head_fax',$client->head_fax)}}" class="w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded"  placeholder="">
                        </div>
                    </div>

                    <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700"></ul>

                    <div class="grid gap-4 mb-1 sm:grid-cols-5 mt-1">
                        <div class="w-full flex flex-col">
                            <label for="students" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">規模（学生数/従業員数）</label>
                            <input type="number" min="0" name="students" form="clientForm" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="students" value="{{old('students',$client->students)}}">
                        </div>
                    </div>
                    <div class="grid gap-4 mb-1 sm:grid-cols-5 mt-1">
                        <div class="w-full flex flex-col">
                            <label for="distribution" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">商流</label>
                            <select id="distribution_type_id" name="distribution_type_id" form="clientForm" class="w-full mt-1 block py-1.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($distributionTypes as $distributionType)
                                <option value="{{ $distributionType->id }}" @selected( $distributionType->id == old('distribution_type_id',$client->distribution))>{{ $distributionType->distribution_type_name }}</option>
                                @endforeach
                            </select>
                            @error('distribution_type_id')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- <button type="button"  onclick="showCorporationModal()" class="md:mt-10 mt-6 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ディーラ検索
                    </button>
                    <div class="grid gap-4 mt-1 mb-4 sm:grid-cols-5">

                        <div class="w-full flex flex-col hidden">
                            <label for="billing_corporation_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">ディーラ（顧客）ID</label>
                            <input form="updateForm" type="text" name="billing_corporation_id" class="w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_id" value="{{old('billing_corporation_id',$client->billing_corporation_id)}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="billing_corporation_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（顧客）№</label>
                            <input type="text" name="billing_corporation_num" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded mt-1" id="billing_corporation_num" value="{{old('billing_corporation_num',optional($client->dealer)->vendor_num)}}" disabled>
                        </div>
                        <div class="w-full flex flex-col col-span-3">
                            <label for="billing_corporation_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（顧客）名称</label>
                            <input type="text" name="billing_corporation_name" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="billing_corporation_name" value="{{old('billing_corporation_name',optional($client->dealer)->vendor_name)}}" disabled>
                        </div>
                    </div> --}}

                    {{-- <div class="grid gap-4 mt-1 mb-4 sm:grid-cols-5">
                        <div class="w-full flex flex-col hidden">
                            <label for="dealer_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">ディーラID（hidden要素）</label>
                            <input type="text" name="dealer_id" class="w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="dealer_id" value="{{old('dealer_id')}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="vendor_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（業者）№</label>
                            <div class="relative w-full">
                                <input type="text" name="vendor_num" class="dark:bg-gray-400 w-full py-1 border border-gray-300 rounded mt-1" id="vendor_num" value="{{old('vendor_num',optional($client->dealer)->vendor_num)}}" disabled>
                                <button type="button" onclick="showdealerModal()" class="absolute top-0 end-0 p-2.5 text-sm h-[34px] text-white mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="w-full flex flex-col md:col-span-3">
                            <label for="vendor_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（業者）名称</label>
                            <input type="text" name="vendor_name" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="vendor_name" value="{{old('vendor_name',optional($client->dealer)->vendor_name)}}" disabled>
                        </div>
                    </div> --}}

                    <div class="grid gap-4 mt-1 mb-4 sm:grid-cols-5">
                        <div class="w-full flex flex-col hidden">
                            <label for="dealer_id" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">ディーラID（hidden要素）</label>
                            <input type="text" name="dealer_id" form="clientForm" class="w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="dealer_id" value="{{old('dealer_id')}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="vendor_num" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（業者）№</label>
                            <div class="relative w-full">
                                <input type="text" name="vendor_num" form="clientForm" class="dark:bg-gray-400 w-full py-1 border border-gray-300 rounded mt-1" id="vendor_num" value="{{old('vendor_num',optional($client->dealer)->vendor_num)}}" disabled>
                                <button type="button" onclick="showdealerModal()" class="absolute top-0 end-0 p-2.5 text-sm h-[34px] text-white mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    
                        <div class="w-full flex flex-col md:col-span-3">
                            <label for="vendor_name" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1">ディーラ（業者）名称</label>
                            <input type="text" name="vendor_name" form="clientForm" class="dark:bg-gray-400 w-auto py-1 border border-gray-300 rounded mt-1 mb-2" id="vendor_name" value="{{old('vendor_name',optional($client->dealer)->vendor_name)}}" disabled>
                        </div>
                    </div>
                    

                    <div class="w-full flex flex-col">
                        <label for="memo" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                        <textarea name="memo" form="clientForm" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea" data-auto-resize="true" value="{{old('memo')}}" cols="30" rows="5">{{old('memo', $client->memo)}}</textarea>
                    </div>
                    {{-- <ul class=" mt-4 items-center w-full text-sm text-gray-900 bg-white border border-gray-200 rounded sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_enduser === 1)
                                    <input id="is_enduser" name="is_enduser" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_enduser" name="is_enduser" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                                <label for="is_enduser" class="w-full py-3 ml-2 text-sm text-gray-900 dark:text-gray-300">エンドユーザ</label>
                            </div>
                            @error('is_enduser')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_dealer)
                                    <input id="is_dealer" name="is_dealer" type="checkbox" value="1" checked="checked"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_dealer" name="is_dealer" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                                <label for="is_dealer" class="w-full py-3 ml-2 text-sm text-gray-900 dark:text-gray-300">ディーラ</label>
                            </div>
                            @error('is_dealer')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_supplier)
                                    <input id="is_supplier" name="is_supplier" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_supplier" name="is_supplier" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                                <label for="is_supplier" class="w-full py-3 ml-2 text-sm text-gray-900 dark:text-gray-300">仕入外注先</label>
                            </div>
                            @error('is_supplier')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_lease)
                                    <input id="is_lease" name="is_lease" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_lease" name="is_lease" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                            <label for="is_supplier" class="w-full py-3 ml-2 text-sm text-gray-900 dark:text-gray-300">リース</label>

                            </div>

                            @error('is_lease')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                        <li class="w-full dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_other_partner)
                                    <input id="is_other_partner" name="is_other_partner" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_other_partner" name="is_other_partner" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                                <label for="is_other_partner" class="w-full py-3 ml-2 text-sm text-gray-900 dark:text-gray-300">その他協業</label>
                            </div>
                            @error('is_other_partner')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                    </ul> --}}
                    {{-- <x-primary-button class="mt-4" id="saveButton">
                        編集を確定する(s)
                    </x-primary-button>
                </form> --}}
                </div>
                {{-- 1つ目のタブコンテンツEnd --}}

                {{-- 2つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="contracts" role="tabpanel" aria-labelledby="contracts-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">請求区分、契約日、解約日、契約金額、サポートページID、PW、暗号、契約備考、契約書添付、契約履歴</p>
                </div>
                {{-- 2つ目のタブコンテンツEnd --}}


                {{-- 3つ目のタブコンテンツ(導入システム)Start --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="systems" role="tabpanel" aria-labelledby="systems-tab">
                    <span class="text-white">この顧客のサポート問い合わせ情報の内容が表示されます。ここからサポート情報を登録することもできます。</span>

                    {{-- <div class="w-full flex flex-col">
                        <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">主バージョン</label>
                        <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"V10.1")}}" placeholder="">
                    </div> --}}

                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">
                
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-2 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-4 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            シリーズ
                                        </div>
                                    </th>
                                    <th scope="col" class="px-1 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            バージョン
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            内訳種別
                                        </div>
                                    </th>
                                    <th scope="col" class="px-1 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            導入システム名称
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            数量
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            CUS
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            契約区分
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            導入備考
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-2 whitespace-nowrap">
                                        <button onclick="location.href='{{route('client-product.create')}}'" class="bg-blue-400 flex items-center justify-center px-2 py-1 text-sm text-white rounded bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800" type="button">
                                            <svg class="h-3.5 w-3.5 mr-0.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                            </svg>
                                            <span class="text-sm">追加</span>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($clientProducts as $clientProduct)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-2 py-2 text-center">
                                            <button onclick="location.href='{{route('clients.edit',$client)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">編集</span>
                                                </div>
                                            </button>
                                        </td>
                                        <th scope="row" class="pl-4 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $clientProduct->product->productSeries->series_name }}
                                        </th>
                                        <td class="px-1 py-2 whitespace-nowrap">
                                            {{ $clientProduct->productVersion->version_name }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{ $clientProduct->product->productSplitType->split_type_name }}
                                        </td>
                                        <td class="px-1 py-2 whitespace-nowrap">
                                            {{ $clientProduct->product->product_short_name }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $clientProduct->quantity }}
                                        </td>
                                        @if($clientProduct->is_customized == "1")
                                            <td class="px-2 py-2 whitespace-nowrap text-red-400">
                                                有り
                                            </td>
                                        @else
                                            <td class="px-2 py-2 whitespace-nowrap">
                                                -
                                            </td>
                                        @endif

                                        @if ($clientProduct->is_contracted == "1")
                                            <td class="px-2 py-2 whitespace-nowrap">
                                                契約済
                                            </td>
                                        @else
                                            <td class="px-2 py-2 whitespace-nowrap text-red-400">
                                                未契約
                                            </td>
                                        @endif
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="whitespace-nowrap overflow-ellipsis w-6/12 overflow-hidden">
                                            {{ $clientProduct->install_memo }}
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            {{-- <button>削除</button> --}}
                                            {{-- <button data-modal-target="deleteModal-{{$client->id}}" data-modal-toggle="deleteModal-{{$client->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded text-sm px-3 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                                削除
                                            </button> --}}
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                {{-- 削除確認モーダル画面 Start --}}
                                {{-- 削除確認モーダル画面 End --}}
                            {{-- @endforeach --}}
                        </table>
                        <div class="mt-2 mb-2 px-4">
                            {{-- {{ $clients->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
                        </div> 
                    </div> 
                </div>
                {{-- 3つ目のタブコンテンツEnd --}}

                {{-- 4つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="environments" role="tabpanel" aria-labelledby="environments-tab">
                    {{-- <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                        <div>
                            <label for="test1" class="text-sm text-gray-900 dark:text-white leading-none mt-4">インフラ区分</label>
                            <select id="test1" name="test1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                <option selected value="">物理</option>
                                <option selected value="">物理（仮想）</option>
                                <option selected value="">クラウド（AWS）</option>
                                <option selected value="">クラウド（Azure）</option>
                                <option selected value="">クラウド（GCP）</option>
                                <option selected value="">クラウド（SDPF）</option>
                                <option selected value="">クラウド（さくら）</option>
                                <option selected value="">クラウド（その他）</option>
                                <option selected value="">クラウドサービス</option>
                            </select>
                            @error('test1')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="test2" class="text-sm  text-gray-900 dark:text-white leading-none mt-4">Windows Server</label>
                            <select id="test2" name="test2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                <option selected value="">2008R2</option>
                                <option selected value="">2012</option>
                                <option selected value="">2019</option>
                                <option selected value="">2022</option>
                            </select>
                            @error('test2')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div>
                            <label for="test3" class="text-sm text-gray-900 dark:text-white leading-none mt-4">SQL Server</label>
                            <select id="test3" name="test3" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                <option selected value="">2008R2</option>
                                <option selected value="">2012</option>
                                <option selected value="">2019</option>
                                <option selected value="">2022</option>
                            </select>
                            @error('test3')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div>
                            <label for="test4" class="text-sm text-gray-900 dark:text-white leading-none mt-4">セキュリティソフト</label>
                            <select id="test4" name="test4" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">WindowsDifenser</option>
                                <option selected value="">Norton</option>
                                <option selected value="">ウィルスバスター</option>
                                <option selected value="">カスペルスキー</option>
                            </select>
                            @error('test4')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div>
                            <label for="test5" class="text-sm text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                            <select id="test5" name="test5" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                <option selected value="">未選択</option>
                                <option selected value="">未選択</option>
                                <option selected value="">未選択</option>
                            </select>
                            @error('test5')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL サーバ名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"DBサーバ名")}}" placeholder="">
                        </div>       

                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL インスタンス名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"SQLSERVER2019")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL ユーザ名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"sa")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL パスワード</label>
                            <input type="password" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"V10.1")}}" placeholder="">
                        </div>
                        <div>
                            <label for="test6" class="text-sm text-gray-900 dark:text-white leading-none mt-4">IIS Ver</label>
                            <select id="test6" name="test6" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">なし</option>
                                <option selected value="">5.0</option>
                                <option selected value="">6.0</option>
                                <option selected value="">7.0</option>
                                <option selected value="">7.5</option>
                                <option selected value="">8.0</option>
                                <option selected value="">8.5</option>
                                <option selected value="">10</option>
                            </select>
                            @error('test6')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test7" class="text-sm text-gray-900 dark:text-white leading-none mt-4">IIS TCPポート</label>
                            <select id="test7" name="test7" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未使用</option>
                                <option selected value="">80使用</option>
                            </select>
                            @error('test7')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test8" class="text-sm text-gray-900 dark:text-white leading-none mt-4">IIS SSLポート</label>
                            <select id="test8" name="test8" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未使用</option>
                                <option selected value="">443使用</option>
                            </select>
                            @error('test8')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test9" class="text-sm text-gray-900 dark:text-white leading-none mt-4">IIS 共有サービス</label>
                            <select id="test9" name="test9" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">なし</option>
                                <option selected value="">.campus</option>
                            </select>
                            @error('test9')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">接続タイムアウト値</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"120秒")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">プロセスリサイクル値</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="" value="{{old('',"1740分")}}" placeholder="">
                        </div>

                        <div>
                            <label for="test10" class="text-sm text-gray-900 dark:text-white leading-none mt-4">リモート種別</label>
                            <select id="test10" name="test10" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">禁止</option>
                                <option selected value="">RDP直</option>
                                <option selected value="">RDP（VPN）</option>
                                <option selected value="">NTR</option>
                            </select>
                            @error('test10')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test11" class="text-sm text-gray-900 dark:text-white leading-none mt-4">VPN方法</label>
                            <select id="test11" name="test11" class="bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">なし</option>
                                <option selected value="">FortiClient</option>
                                <option selected value="">GlobalProtect</option>
                                <option selected value="">F5VPN</option>
                                <option selected value="">OpenVPN</option>
                            </select>
                            @error('test11')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">サーバ構成</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">フォルダ構成</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">バックアップ情報</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">環境備考</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div> --}}

                </div>
                {{-- 4つ目のタブコンテンツEnd --}}

                {{-- 5つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                    <span class="text-white">この顧客の営業報告の内容が表示されます。ここから営業報告を登録することもできます。</span>
                    {{-- テーブル表示 --}}
                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">

                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <span class="sr-only">参照</span>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            対応日付
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            報告区分
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            タイトル
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            報告者
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <button type="button" onclick="location.href='{{route('reports.create')}}'" class=" bg-blue-400 flex items-center justify-center px-2 py-1 text-sm text-white rounded bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none m-auto">
                                                <svg class="h-3.5 w-3.5 mr-0.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                </svg>
                                                追加
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            @foreach ($reports as $report)
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-2 py-2 text-center">
                                     {{-- reports.showを作成して変更 --}}
                                            <button onclick="location.href='{{route('report.showFromClient',$report)}}'"  class="block whitespace-nowrap text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded text-sm px-2 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">参照</span>
                                                </div>
                                            </button>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$report->contact_at}}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$report->reporttype->report_type_name}}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$report->report_title}}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            {{$report->reporter->name}}
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            <button onclick="location.href='{{route('reports.edit',$report)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">編集</span>
                                                </div>
                                            </button>
                                        </td>
                                        <td class="px-2 py-2">
                                            <button data-modal-target="deleteModal-{{$report->id}}" data-modal-toggle="deleteModal-{{$report->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded text-sm px-2 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                                    </svg>
                                                    <span class="text-ms ">削除</span>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                {{-- 削除確認モーダル画面 Start --}}
                                <div id="deleteModal-{{$report->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full animate-slide-in-top">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                            <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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

                                                <form action="{{route('reports.destroy',$report->id)}}" method="POST" class="text-center m-auto">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-modal-hide="deleteModal-{{$report->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        削除
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    やっぱやめます
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- 削除確認モーダル画面 End --}}
                            @endforeach
                        </table>
                        <div class="mt-2 mb-2 px-4">
                        </div> 
                    </div>
                </div>
                {{-- 5つ目のタブコンテンツEnd --}}

                {{-- 6つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded bg-gray-50 dark:bg-gray-800" id="supports" role="tabpanel" aria-labelledby="supports-tab">
                    <span class="text-white">この顧客のサポート問い合わせ情報の内容が表示されます。ここからサポート情報を登録することもできます。</span>
                    <div class="w-full relative overflow-x-auto shadow-md rounded mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm text-left text-gray-800 dark:text-gray-400">
                
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('received_at','受付日')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('support_type_id','種別')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            表題
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_series_id','シリーズ')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_version_id','Ver')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_category_id','系統')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('user_id','対応者')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <button type="button" onclick="location.href='{{route('support.create')}}'" class=" bg-blue-400 flex items-center justify-center px-2 py-1 text-sm text-white rounded bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none m-auto">
                                                <svg class="h-3.5 w-3.5 mr-0.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                </svg>
                                                追加
                                            </button>

                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            @foreach ($supports as $support)
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            <button onclick="location.href='{{route('support.edit',$support)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded  text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-auto" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                                                    </svg>
                                                    <span class="text-ms">編集</span>
                                                </div>
                                            </button>
                                        </td >
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->received_at}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->supportType->type_name}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->title}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productSeries->series_name}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productVersion->version_name}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productCategory->category_name}}
                                        </th>
                                        <th scope="row" class="px-2 py-1 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->user->name}}
                                        </th>
                                        <td class="px-2 py-1">
                                            <button data-modal-target="deleteModal-{{$support->id}}" data-modal-toggle="deleteModal-{{$support->id}}"  class="button-delete-primary" type="button">
                                                <div class="flex">
                                                    <svg class="mr-1 w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                                    </svg>
                                                    <span class="text-ms ">削除</span>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                {{-- 削除確認モーダル画面 Start --}}
                                <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                            <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                
                                                <form action="{{route('support.destroy',$support->id)}}" method="POST" class="text-center m-auto">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        削除
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    やっぱやめます
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- 削除確認モーダル画面 End --}}
                            @endforeach
                        </table>
                        <div class="mt-1 mb-1 px-4">
                            {{ $supports->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
                        </div> 
                    </div>
                </div>
                {{-- 6つ目のタブコンテンツEnd --}}
        </div>
    </div>
</div>


    <!-- 法人検索 Modal -->
    <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    {{-- <div id="corporationSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class=" w-4/5  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl text-gray-900 dark:text-white">
                        法人検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"  onclick="hideModal()"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('corporations.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="flex flex-wrap justify-start mx-5">
                        <div class="w-full flex flex-col">
                            <label for="corporationName" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="w-auto mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="corporationNumber" class="text-sm dark:text-gray-100 text-gray-900 leading-none mt-4">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="w-auto mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left ml-3 mr-5 text-sm">
                        <thead>
                        <tr>
                            <th class="py-1">法人名称</th>
                            <th class="py-1">法人番号</th>
                            <th class="py-1"></th>
                        </tr>
                        </thead>
                        <tbody id="searchResultsContainer" class="">
                        <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="searchCorporation()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        検索
                    </button>
                    <button type="button" onclick="hideModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </div>
        </div>
    </div>

    <!-- ディーラ検索 Modal -->
    <div id="dealerSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl text-gray-900 dark:text-white">
                        ディーラ検索画面
                    </h3>
                    <button type="button" onclick="hideDealerModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="#" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="grid gap-4 mb-4 sm:grid-cols-2 mt-2">
                    {{-- <div class="flex flex-wrap justify-start mx-5"> --}}
                        <div class="">
                            <label for="vendorName" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人名称</label>
                            <input type="text" name="vendorName" id="vendorName" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                        </div>
                        <div class="">
                            <label for="vendorNumber" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">法人番号</label>
                            <input type="text" name="vendorNumber" id="vendorNumber" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
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
                        <tbody class="" id="searchResultsDealerContainer">                          
                                <!-- 検索結果がここに追加されます -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Modal footer -->
                <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <div>
                        <button type="button" onclick="searchDealer()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            検索
                        </button>
                        <button type="button" onclick="hideDealerModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            閉じる
                        </button>
                    </div>
                    <!-- 一括クリアボタン -->
                    <div class="flex items-center">
                        <button type="button" onclick="clearAllFields()" class="px-4 py-2 text-sm text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:bg-red-600">
                            一括クリア
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 削除モーダル -->
    <div id="deleteModal-{{$client->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal-{{$client->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                        <form action="{{route('clients.destroy',$client->id)}}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{$client->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 dark:focus:ring-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                削除
                            </button>
                        </form>
                        <button id="cancelButton-{{$client->id}}" data-modal-hide="deleteModal-{{$client->id}}" type="button" onkeydown="stopTab(event)" class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function clearAllFields() {
            // フィールドの値をクリアする
            document.getElementById('dealer_id').value = '';
            document.getElementById('vendor_num').value = '';
            document.getElementById('vendor_name').value = '';
            hideDealerModal();
        }
    </script>
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
            // document.getElementById('corporation_name').textContent = name;
            // document.getElementById('corporation_num').textContent = number;

            hideModal();
            }



    //ディーラ（業者）検索モーダル関連
        // モーダルを表示するための関数
        function showdealerModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('dealerSearchModal');
        //背後の操作不可を有効
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');
    }

    // モーダルを非表示にするための関数
    function hideDealerModal() {
        // モーダルの要素を取得
        const modal = document.getElementById('dealerSearchModal');
        //背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // モーダルを非表示にするためのクラスを削除
        modal.classList.add('hidden');
    }

    // 検索ボタンを押した時の処理
    function searchDealer() {
        const vendorName = document.getElementById('vendorName').value;
        const vendorNumber = document.getElementById('vendorNumber').value;
        const isDealer = 1;

        fetch('/vendors/search', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ vendorName, vendorNumber, isDealer })
        })
        .then(response => response.json())
        .then(data => {
            const searchResultsDealerContainer = document.getElementById('searchResultsDealerContainer');
            searchResultsDealerContainer.innerHTML = '';

            data.forEach(result => {
            const resultElement = document.createElement('tr');
            resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
            resultElement.innerHTML = `
                <td tabindex="1" class="py-2 pl-5 cursor-pointer" onclick="setDistribution('${result.id}', '${result.vendor_num}', '${result.vendor_name}')">${result.vendor_name}</td>
                <td class="py-2 ml-2">${result.vendor_num}</td>
            `;
            searchResultsDealerContainer.appendChild(resultElement);
            });
        });
        }

    function setDistribution(id, number, name) {
        document.getElementById('dealer_id').value = id;
        document.getElementById('vendor_num').value = number;
        document.getElementById('vendor_name').value = name;
        hideDealerModal();
    }

    </script>




<script>
    function changeTab(tabName) {
        // タブ切り替え時にクエリパラメータを更新してページ遷移を回避
        window.history.pushState({ tab: tabName }, '', `?tab=${tabName}`);

        // 全tab切り替えボタンをfalseにする
        document.querySelectorAll('[role="tab"]').forEach(tabButton => {
            tabButton.setAttribute('aria-selected', 'false');
        });
        // 押下されたtab切り替えボタンのみtrueにする
        document.getElementById(`${tabName}-tab`).setAttribute('aria-selected', 'true');
    }

    function changeTabReload(tabName) {
        // タブ切り替え時にクエリパラメータを更新してページ遷移を回避
        window.history.pushState({ tab: tabName }, '', `?tab=${tabName}`);
        // 画面をリロード
       window.location.reload();

        // ボタンの状態を更新
        document.querySelectorAll('[role="tab"]').forEach(tabButton => {
            tabButton.setAttribute('aria-selected', 'false');
        });
        document.getElementById(`${tabName}-tab`).setAttribute('aria-selected', 'true');
    }

    // ページ読み込み時と履歴操作時にタブの状態を復元する
    window.onload = function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const activeTab = urlParams.get('tab');
        const tabName = activeTab || 'base';
        changeTab(tabName);
    };

    // ブラウザの戻る・進む操作時にタブの状態を復元する
    window.onpopstate = function(event) {
        if (event.state && event.state.tab) {
            changeTabReload(event.state.tab);
        } else {
            // event.stateがnullまたはtabが存在しない場合はデフォルトのタブを選択する
            changeTabReload('base');
        }
    };
</script>

<script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

</x-app-layout>