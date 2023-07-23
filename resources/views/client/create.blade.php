<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                顧客登録
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
        <form id="basic" method="post" action="{{route('client.store')}}" enctype="multipart/form-data" autocomplete="new-password">
            @csrf

            <!-- 法人検索ボタン -->
            <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 mb-2 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                法人検索
            </button>


            {{-- <div class="md:flex flex-wrap md:justify-between">
                <div class="md:w-2/5 flex flex-col">
                    <label for="clientcorporation_num" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人番号</label>
                    <input type="text" name="clientcorporation_num" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_num" value="{{old('clientcorporation_num')}}" placeholder="法人検索してください" readonly>
                </div>
                
                <div class="md:w-2/5 flex flex-col">
                    <label for="clientcorporation_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人名称</label>
                    <input type="text" name="clientcorporation_name" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="法人検索してください" readonly>
                </div>
            </div>

            <div class="md:flex flex-wrap md:justify-between md:mt-2">
                <div class="md:w-2/5 flex flex-col">
                    <label for="client_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客名称</label>
                    <input type="text" name="client_name" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name')}}" placeholder="例）烏丸大学">
                </div>

                <div class="md:w-2/5 flex flex-col">
                    <label for="client_kana_name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">顧客カナ名称</label>
                    <input type="text" name="client_kana_name" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_kana_name" value="{{old('client_kana_name')}}" placeholder="例）カラスマダイガク">
                </div>
            </div> --}}

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="">
                    <label for="clientcorporation_num" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人番号</label>
                    <input type="text" name="clientcorporation_num" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_num" value="{{old('clientcorporation_num')}}" placeholder="法人検索してください" readonly>
                </div>
                
                <div class="">
                    <label for="clientcorporation_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                    <input type="text" name="clientcorporation_name" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="法人検索してください" readonly>
                </div>
            
                <div class="">
                    <label for="client_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客名称</label>
                    <input type="text" name="client_name" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_name" value="{{old('client_name')}}" placeholder="例）烏丸大学">
                </div>

                <div class="">
                    <label for="client_kana_name" class="block  font-semibold dark:text-gray-100 text-gray-900 leading-none md:mt-2">顧客カナ名称</label>
                    <input type="text" name="client_kana_name" class="w-full py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="client_kana_name" value="{{old('client_kana_name')}}" placeholder="例）カラスマダイガク">
                </div>
            </div>


            <div class="grid gap-4 mb-4 md:grid-cols-5 grid-cols-2">

                <div>
                    <label for="installation_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                    <select id="installation_type_id" name="installation_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType->id }}">{{ $installationType->name }}</option>
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
                        <option value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                        @endforeach
                    </select>
                    @error('client_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="department" class="font-semibold  text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->prefix_code }}">{{ $department->department_name }}</option>
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
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="trade_status_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">取引状態</label>
                    <select id="trade_status_id" name="trade_status_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($tradeStatuses as $tradeStatus)
                        <option value="{{ $tradeStatus->id }}">{{ $tradeStatus->name }}</option>
                        @endforeach
                    </select>
                    @error('trade_status_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">基本情報</button>
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

                    





                    <div class="h-adr">
                        <span class="p-country-name" style="display:none;">Japan</span>
                        <div class="w-full flex flex-col">
                            <label for="head_post_code" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password p-postal-code">郵便番号</label>
                            <input type="text" name="head_post_code" class="w-32 py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="input-yubinbango-head_post_code" value="{{old('head_post_code')}}" placeholder="">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="head_prefecture" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4 ">都道府県</label>
                            <select id="head_prefecture" name="head_prefecture" class="block w-32 p-1.5 text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">未選択</option>
                                @foreach($prefectures as $prefecture)
                                    <option value="{{ $prefecture->id }}">{{ $prefecture->code }}:{{ $prefecture->name }}</option>
                                @endforeach
                        </select>
                            {{-- <input type="text" name="head_prefecture" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 p-region" id="head_prefecture" value="{{old('head_prefecture')}}" placeholder=""> --}}
                        </div>

                        
                        <div class="w-full flex flex-col">
                            <label for="head_addre1" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">本部所在地</label>
                            <input type="text" name="head_addre1" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1 p-locality p-street-address p-extended-address" id="head_addre1" value="{{old('head_addre1')}}" placeholder="">
                        </div>
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="head_addre2" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4"></label>
                        <input type="text" name="head_addre2" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_addre2" value="{{old('head_addre2')}}" placeholder="">
                    </div> --}}
                    {{-- <div class="w-full flex flex-col">
                        <label for="head_addre3" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4"></label>
                        <input type="text" name="head_addre3" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_addre3" value="{{old('head_addre3')}}" placeholder="">
                    </div> --}}
                    <div class="w-full flex flex-col">
                        <label for="head_tel" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-8">代表TEL</label>
                        <input type="tel" name="head_tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" maxlength="11" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="head_tel" value="{{old('head_tel')}}" placeholder="">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="students" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">学生数</label>
                        <input type="number" name="students" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="students" value="{{old('students')}}">
                    </div>

                    <div class="w-full flex flex-col">
                        <label for="distribution" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">商流</label>
                        <input type="text" name="distribution" class="w-auto py-1.5 placeholder-gray-400 border border-gray-300 rounded-md mt-1" id="distribution" value="{{old('distribution')}}" placeholder="">
                    </div>

                    {{-- <label for="department" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">管轄事業部</label>
                    <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->prefix_code }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
        
                    <label for="user_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">営業担当</label>
                    <select id="user_id" name="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <label for="trade_status_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">取引状態</label>
                    <select id="trade_status_id" name="trade_status_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($tradeStatuses as $tradeStatus)
                        <option value="{{ $tradeStatus->id }}">{{ $tradeStatus->name }}</option>
                        @endforeach
                    </select>
                    @error('trade_status_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <label for="installation_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">設置種別</label>
                    <select id="installation_type_id" name="installation_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType->id }}">{{ $installationType->name }}</option>
                        @endforeach
                    </select>
                    @error('installation_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <label for="client_type_id" class="font-semibold text-gray-900 dark:text-white leading-none mt-4">顧客種別</label>
                    <select id="client_type_id" name="client_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">未選択</option>
                        @foreach($clientTypes as $clientType)
                        <option value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                        @endforeach
                    </select>
                    @error('client_type_id')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror --}}

                    <div class="w-full flex flex-col">
                        <label for="memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">備考</label>
                        <textarea name="memo" class="w-auto py-1.5 border border-gray-300 rounded-md mt-1 placeholder-gray-400" id="memo" value="{{old('memo')}}" cols="30" rows="5"></textarea>
                    </div>
                    <x-primary-button form-id="basic" class="mt-4">
                        新規登録する
                    </x-primary-button>
                </form>

                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">請求区分、契約日、解約日、契約金額、サポートページID、PW、暗号、契約備考、契約書添付、契約履歴</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">バージョン、リビジョン、初期導入日、前回VUP日、クライアントライセンス、カスタマイズ区分、備考、システムはテーブル表示か？</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">インフラ区分（オンプレ、クラウド、クラウドサービス）</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Windows Server</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SQL Server</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SQL インスタンス名：SQLSERVER2019</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SQL ユーザ名：sa</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SQL パスワード：※※※※</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">セキュリティソフト</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">リモート種別：（RDP直、RDP（VPN）、NTR）</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">VPN方法：FortiClient</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">フォルダ構成</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">バックアップ情報</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">備考</p>
                </div>
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
                            <input type="text" name="corporationName" id="corporationName" class="w-auto mt-1 mr-2 py-1.5 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                        <div class="w-full flex flex-col">
                            <label for="corporationNumber" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">法人番号</label>
                            <input type="text" name="corporationNumber" id="corporationNumber" class="w-auto mt-1 mr-2 py-1.5 placeholder-gray-400 border border-gray-300 rounded-md">
                        </div>
                    </div>
                </form>
                <div class=" max-h-80 overflow-y-auto overflow-x-hidden">
                    <table class="w-full mt-4 text-white mb-5 text-left text-sm">
                        <thead>
                        <tr>
                            {{-- <th class="py-1.5"></th> --}}
                            <th class="py-1.5 pl-5">法人名称</th>
                            <th class="py-1.5 whitespace-nowrap">法人番号</th>
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
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setCorporation('${result.clientcorporation_name}', '${result.clientcorporation_num}')">${result.clientcorporation_abbreviation_name}</td>
                    <td class="py-2 ml-2">${result.clientcorporation_num}</td>
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
    </script>
 
</x-app-layout>


{{-- <td class="py-2 ml-1">
    <button type="button" onclick="setCorporation('${result.clientcorporation_name}', '${result.clientcorporation_num}')" class="font-bold text-blue-500 hover:underline whitespace-nowrap" tabindex="-1">選択</button>
</td>
<td class="py-2 ml-2">${result.clientcorporation_name}</td>
<td class="py-2 ml-2">${result.clientcorporation_num}</td> --}}