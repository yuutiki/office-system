<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                顧客編集
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('client.index')}}'">
                    戻る
                </x-general-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-4 sm:p-8">
        <form method="post" action="{{route('client.update',$client)}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf
            @method('patch')
            
            <div class="">
                <label for="client_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4 mt-2">顧客番号</label>
                <input type="text" name="client_num" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="client_num" value="{{old('client_num',$client->client_num)}}" readonly>
                    @error('client_num')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror            
            </div>

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="">
                    <label for="clientcorporation_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4 mt-2">法人名称</label>
                    <input type="text" name="clientcorporation_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name',$client->clientcorporation->clientcorporation_name)}}" readonly>
                    @error('clientcorporation_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
                <div class="">
                    <label for="clientcorporation_kana_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人カナ名称</label>
                    <input type="text" name="clientcorporation_kana_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_kana_name" value="{{old('clientcorporation_kana_name',$client->clientcorporation->clientcorporation_kana_name)}}" readonly>
                    @error('clientcorporation_kana_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
                <div class="">
                    <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name',$client->client_name)}}" placeholder="例）烏丸大学">
                    @error('client_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
                <div class="">
                    <label for="client_kana_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客カナ名称</label>
                    <input type="text" name="client_kana_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_kana_name" value="{{old('client_kana_name',$client->client_kana_name)}}" placeholder="例）カラスマダイガク">
                    @error('client_kana_name')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror                
                </div>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                <div>
                    <label for="department" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected( $department->id == $client->department_id )>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                    <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected( $user->id == $client->user_id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="trade_status_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">取引状態</label>
                    <select id="trade_status_id" name="trade_status_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($tradeStatuses as $tradeStatus)
                        <option value="{{ $tradeStatus->id }}" @selected( $tradeStatus->id == $client->trade_status_id )>{{ $tradeStatus->name }}</option>
                        @endforeach
                    </select>
                    @error('trade_status_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="installation_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                    <select id="installation_type_id" name="installation_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType->id }}" @selected( $installationType->id == $client->installation_type_id)>{{ $installationType->name }}</option>
                        @endforeach
                    </select>
                    @error('installation_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="client_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">顧客種別</label>
                    <select id="client_type_id" name="client_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($clientTypes as $clientType)
                        <option value="{{ $clientType->id }}" @selected( $clientType->id == $client->client_type_id)>{{ $clientType->name }}</option>
                        @endforeach
                    </select>
                    @error('client_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- タブヘッダStart --}}
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="basic-tab" data-tabs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="false">基本情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">契約関連</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">導入システム</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">環境情報</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="reports-tab" data-tabs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">営業報告</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="support-tab" data-tabs-target="#support" type="button" role="tab" aria-controls="support" aria-selected="false">サポート履歴</button>
                    </li>
                </ul>
            </div>
            {{-- タブコンテンツStart --}}
            <div id="myTabContent">

                {{-- 1つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="basic" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="w-full flex flex-col">
                        <label for="head_post_code" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">郵便番号</label>
                        <input type="text" name="head_post_code" class="w-32 py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_post_code" value="{{old('head_post_code',$client->head_post_code)}}" placeholder="" onKeyUp="AjaxZip3.zip2addr(this,'','head_prefecture','head_addre1');">
                    </div>

                    <div class="md:flex">
                        <div class="w-auto flex flex-col">
                            <label for="head_prefecture" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                            <select id="head_prefecture" name="head_prefecture" class="block w-32 py-1.5  text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($prefectures as $prefecture)
                                    <option value="{{ $prefecture->id }}" @if( $prefecture->id == $client->head_prefecture ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full flex flex-col ml-4">
                            <label for="head_addre1" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">本部所在地</label>
                            <input type="text" name="head_addre1" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_addre1" value="{{old('head_addre1',$client->head_address1)}}" placeholder="">
                        </div>
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="head_addre2" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">住所2</label>
                        <input type="text" name="head_addre2" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_addre2" value="{{old('head_addre2',$client->head_addre2)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="head_addre3" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">住所3</label>
                        <input type="text" name="head_addre3" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_addre3" value="{{old('head_addre3',$client->head_addre3)}}" placeholder="">
                    </div> --}}
                    <div class="w-full flex flex-col">
                        <label for="head_tel" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">代表TEL(ハイフン有)</label>
                        <input type="text" name="head_tel" class="w-32 py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_tel" value="{{old('head_tel',$client->head_tel)}}" placeholder="">
                    </div>

                    <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>

                    <div class="w-full flex flex-col">
                        <label for="students" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">学生数</label>
                        <input type="number" min="0" name="students" class="w-1/2 py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="students" value="{{old('students',$client->students)}}">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="distribution" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">商流</label>
                        <input type="text" name="distribution" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="distribution" value="{{old('distribution',$client->distribution)}}" placeholder="">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                        <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="memo" value="{{old('memo')}}" cols="30" rows="5"></textarea>
                    </div>
                    <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                @if ($client->is_enduser === 1)
                                    <input id="is_enduser" name="is_enduser" type="checkbox" value="1" checked="checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @else
                                    <input id="is_enduser" name="is_enduser" type="checkbox" value="1"  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                @endif
                                <label for="is_enduser" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">エンドユーザ</label>
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
                                <label for="is_dealer" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">ディーラ</label>
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
                                <label for="is_supplier" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">仕入外注先</label>
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
                                <label for="is_lease" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">リース会社</label>
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
                                <label for="is_other_partner" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">その他協業</label>
                            </div>
                            @error('is_other_partner')
                             <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </li>
                    </ul>
                    <x-primary-button class="mt-4">
                        編集を確定する
                    </x-primary-button>
                </form>
                </div>
                {{-- 1つ目のタブコンテンツEnd --}}

                {{-- 2つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">請求区分、契約日、解約日、契約金額、サポートページID、PW、暗号、契約備考、契約書添付、契約履歴</p>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">契約番号</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">契約先区分</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">更新月</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">契約種別</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">契約日</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">解約日</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">契約金額</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">SPログイン名</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">SPパスワード</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">SPパスワード（読み方）</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">契約備考</label>
                        <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="memo" value="{{old('memo')}}" cols="30" rows="5"></textarea>
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-8" autocomplete="new-password">請求区分</label>
                        <input type="text" name="memo" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="memo" value="{{old('memo',$client->memo)}}" placeholder="">
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">請求備考</label>
                        <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="memo" value="{{old('memo')}}" cols="30" rows="5"></textarea>
                    </div>
                </div>
                {{-- 2つ目のタブコンテンツEnd --}}

                {{-- 3つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">バージョン,初期導入日、前回VUP日</p>

                    <div class="w-full flex flex-col">
                        <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">主バージョン</label>
                        <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"V10.1")}}" placeholder="">
                    </div>

                    <div class="w-full relative overflow-x-auto shadow-md rounded-lg mx-auto mt-4 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">
                
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
                                        {{-- <button class="rounded-md bg-blue-400 px-3 py-1">追加</button> --}}
                                        <button type="button" class=" bg-blue-400 flex items-center justify-center px-3 py-1 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                            <svg class="h-3.5 w-3.5 mr-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                              <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                            </svg>
                                            製品追加
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($clientProducts as $clientProduct)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-4 py-1 text-center">
                                            <a href="{{route('client.edit',$client)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">編集</a>
                                        </td>
                                        <th scope="row" class="pl-4 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $clientProduct->product->productSeries->series_name }}
                                        </th>
                                        <td class="px-1 py-1 whitespace-nowrap">
                                            {{ $clientProduct->productVersion->version_name }}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            {{ $clientProduct->product->productSplitType->split_type_name }}
                                        </td>
                                        <td class="px-1 py-1 whitespace-nowrap">
                                            {{ $clientProduct->product->product_short_name }}
                                        </td>
                                        <td class="px-4 py-1 whitespace-nowrap">
                                            {{ $clientProduct->quantity }}個
                                        </td>
                                        @if($clientProduct->is_customized == "1")
                                            <td class="px-2 py-1 whitespace-nowrap text-red-400">
                                                有り
                                            </td>
                                        @else
                                            <td class="px-2 py-1 whitespace-nowrap">
                                                -
                                            </td>
                                        @endif

                                        @if ($clientProduct->is_contracted == "1")
                                            <td class="px-2 py-1 whitespace-nowrap">
                                                契約済
                                            </td>
                                        @else
                                            <td class="px-2 py-1 whitespace-nowrap text-red-400">
                                                未契約
                                            </td>
                                        @endif
                                        <td class="px-2 py-1 whitespace-nowrap">
                                            <div class="whitespace-nowrap overflow-ellipsis w-6/12 overflow-hidden">
                                            {{ $clientProduct->install_memo }}
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            {{-- <button>削除</button> --}}
                                            {{-- <button data-modal-target="deleteModal-{{$client->id}}" data-modal-toggle="deleteModal-{{$client->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
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
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                    <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">
                        <div>
                            <label for="test1" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">インフラ区分</label>
                            <select id="test1" name="test1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test2" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">Windows Server</label>
                            <select id="test2" name="test2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test3" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">SQL Server</label>
                            <select id="test3" name="test3" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test4" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">セキュリティソフト</label>
                            <select id="test4" name="test4" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test5" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                            <select id="test5" name="test5" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL サーバ名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"DBサーバ名")}}" placeholder="">
                        </div>       

                        <div class="w-full flex flex-col">
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL インスタンス名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"SQLSERVER2019")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL ユーザ名</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"sa")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">SQL パスワード</label>
                            <input type="password" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"V10.1")}}" placeholder="">
                        </div>
                        <div>
                            <label for="test6" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">IIS Ver</label>
                            <select id="test6" name="test6" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test7" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">IIS TCPポート</label>
                            <select id="test7" name="test7" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未使用</option>
                                <option selected value="">80使用</option>
                            </select>
                            @error('test7')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test8" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">IIS SSLポート</label>
                            <select id="test8" name="test8" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未使用</option>
                                <option selected value="">443使用</option>
                            </select>
                            @error('test8')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="test9" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">IIS 共有サービス</label>
                            <select id="test9" name="test9" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">なし</option>
                                <option selected value="">.campus</option>
                            </select>
                            @error('test9')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">接続タイムアウト値</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"120秒")}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-1" autocomplete="new-password">プロセスリサイクル値</label>
                            <input type="text" name="" class="w-auto py-1 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="" value="{{old('',"1740分")}}" placeholder="">
                        </div>

                        <div>
                            <label for="test10" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">リモート種別</label>
                            <select id="test10" name="test10" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <label for="test11" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">VPN方法</label>
                            <select id="test11" name="test11" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <label for="test14" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">サーバ構成</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">フォルダ構成</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">バックアップ情報</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="test14" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">環境備考</label>
                        <textarea name="test14" class="w-auto py-1 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="test14" value="{{old('test14')}}" cols="30" rows="5"></textarea>
                    </div>

                </div>
                {{-- 4つ目のタブコンテンツEnd --}}

                {{-- 5つ目のタブコンテンツStart --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                    <span class="text-white">この顧客の営業報告の内容が表示されます。ここから営業報告を登録することもできます。</span>
                    {{-- テーブル表示 --}}
                    <div class="w-full relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">

                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        <span class="sr-only">参照</span>
                                    </th>
                                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            対応日付
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            報告区分
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            タイトル
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                                        </div>
                                    </th>
                                    <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            報告者
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg> --}}
                                        </div>
                                    </th>
                                    {{-- <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            更新日付
                                        </div>
                                    </th> --}}
                                    <th scope="col" class="px-2 py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <button type="button" onclick="location.href='{{route('report.create')}}'" class=" bg-blue-400 flex items-center justify-center px-3 py-1 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                                </svg>
                                                追加
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                </tr>
                            </thead>
                            @foreach ($reports as $report)
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-4 py-4 text-center">
                                     {{-- report.showを作成して変更 --}}
                                            <a href="{{route('report.showFromClient',$report)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">参照</a>
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap">
                                            {{$report->contact_at}}
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap">
                                            {{$report->type}}
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap">
                                            {{$report->title}}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            {{$report->reporter->name}}
                                        </td>
                                        {{-- <td class="px-2 py-4 whitespace-nowrap">
                                            {{$report->updated_at->format('y-m-d')}}
                                        </td> --}}
                                        <td class="px-4 py-4 text-center">
                                            <a href="{{route('report.create',$report)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline whitespace-nowrap">
                                                編集
                                            </a>
                                        </td>
                                        <td class="py-3">
                                            <button data-modal-target="deleteModal-{{$report->id}}" data-modal-toggle="deleteModal-{{$report->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                                削除
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                {{-- 削除確認モーダル画面 Start --}}
                                <div id="deleteModal-{{$report->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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

                                                <form action="{{route('report.destroy',$report->id)}}" method="POST" class="text-center m-auto">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" data-modal-hide="deleteModal-{{$report->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        削除
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{$report->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="support" role="tabpanel" aria-labelledby="support-tab">
                    <span class="text-white">この顧客のサポート問い合わせ情報の内容が表示されます。ここからサポート情報  を登録することもできます。</span>
                    <div class="w-full relative overflow-x-auto shadow-md rounded-lg mx-auto mt-1 boeder-2 bg-gray-300 dark:bg-gray-700">
                        <table class="w-full text-sm font-medium text-left text-gray-800 dark:text-gray-400">
                
                            {{-- テーブルヘッダ start --}}
                            <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        <span class="sr-only">編集</span>
                                    </th>
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('received_at','受付日')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('support_type_id','種別')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            表題
                                        </div>
                                    </th>
            
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('user_id','受付対応者')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_series_id','シリーズ')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_version_id','バージョン')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('product_category_id','系統')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th>
                                    {{-- <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @sortablelink('status_flag','ステータス')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                        </div>
                                    </th> --}}
                                    {{-- <th scope="col" class="px-2 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            更新日
                                        </div>
                                    </th> --}}
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        <span class="sr-only">削除</span>
                                    </th>
                                </tr>
                            </thead>
                            @foreach ($supports as $support)
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <button onclick="location.href='{{route('support.edit',$support)}}'"  class="block whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                編集
                                            </button>
                                        </td>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->received_at}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->supportType->type_name}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->title}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->user->name}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productSeries->series_name}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productVersion->version_name}}
                                        </th>
                                        <th scope="row" class="pl-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$support->productCategory->category_name}}
                                        </th>
                                        
                                        {{-- @if($keepdata->status_flag == "0")
                                            <td class="px-2 py-4 whitespace-nowrap text-fuchsia-300">
                                                未返却
                                            </td>
                                        @else
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                返却済
                                            </td>
                                        @endif --}}
                                        {{-- <td class="px-2 py-4 whitespace-nowrap">
                                            {{$support->updated_at->format('y-m-d')}}
                                        </td> --}}
                                        <td class="py-3">
                                            <button data-modal-target="deleteModal-{{$support->id}}" data-modal-toggle="deleteModal-{{$support->id}}"  class="block whitespace-nowrap text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                                削除
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                {{-- 削除確認モーダル画面 Start --}}
                                <div id="deleteModal-{{$support->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                                    <button type="submit" data-modal-hide="deleteModal-{{$support->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        削除
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{$support->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
                        {{-- {{ $keepdatas->appends(request()->query())->links() }}   --}}
                        {{-- {{ $supports->withQueryString()->links('vendor.pagination.custum-tailwind') }}   --}}
                        </div> 
                    </div>
                </div>
                {{-- 6つ目のタブコンテンツEnd --}}
        </div>
    </div>
</div>


    <!-- Extra Large Modal -->
    <div id="corporationSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    {{-- <div id="corporationSearchModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center"> --}}
        <div class=" w-4/5  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        法人検索画面
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3"  onclick="hideModal()"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('clientcorporation.search') }}" method="GET">
                    <!-- 検索条件入力フォーム -->
                    <div class="flex flex-wrap justify-start mx-5">
                        <div class="w-full flex flex-col">
                            <label for="corporationName" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人名称</label>
                            <input type="text" name="corporationName" id="corporationName" class="w-auto mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="corporationNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="w-auto mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded-md">
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

            fetch('/clientcorporation/search', {
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
                    <td class="py-2">${result.clientcorporation_name}</td>
                    <td class="py-2">${result.clientcorporation_num}</td>
                    <td class="py-2">
                    <button type="button" onclick="setCorporation('${result.clientcorporation_name}', '${result.clientcorporation_num}')" class="font-bold text-blue-500 hover:underline"  tabindex="-1">選択</button>
                    </td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setCorporation(name, number) {
            document.getElementById('clientcorporation_num').value = number;
            document.getElementById('clientcorporation_name').value = name;
            // document.getElementById('clientcorporation_name').textContent = name;
            // document.getElementById('clientcorporation_num').textContent = number;

            hideModal();
            }

// タブがクリックされたときにアクティブなタブ情報をローカルストレージに保存
document.addEventListener('click', function(event) {
    if (event.target.matches('[role="tabpanel"]')) {
        const tabId = event.target.getAttribute('aria-controls');
        localStorage.setItem('activeTab', tabId);
    }
});

// ページが読み込まれたときにローカルストレージからアクティブなタブ情報を取得
document.addEventListener('DOMContentLoaded', function() {
    const activeTabId = localStorage.getItem('activeTab');
    if (activeTabId) {
        // アクティブなタブ情報がローカルストレージにある場合、それを使用してアクティブなタブを設定
        tabs.show(activeTabId); // "tabs" は前のコードで作成した Tabs オブジェクト
    }
});

        // カナ補完
        $(function() {
            $.fn.autoKana('input[name="client_name"]', 'input[name="client_kana_name"]', {katakana: true});
        });
    </script> 
</x-app-layout>