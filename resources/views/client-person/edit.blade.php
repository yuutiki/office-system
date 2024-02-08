<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editclientperson') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('client-person.update', $clientPerson)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- 顧客検索ボタン -->
                <button type="button"  onclick="showModal()" class="md:ml-1 md:mt-1 mt-1 w-full md:w-auto whitespace-nowrap text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    顧客検索
                </button>
                <div class="grid gap-4 my-4 md:grid-cols-3">
                    <div class="w-full flex flex-col">
                        <label for="client_num" class="font-semibold dark:text-red-300 text-red-700 leading-none md:mt-4">顧客№</label>
                        <input type="text" name="client_num" id="client_num" value="{{old('client_num',  $clientPerson->client->client_num)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1 pointer-events-none" placeholder="" readonly>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="client_name" class="font-semibold dark:text-red-300 text-red-700 leading-none md:mt-4">顧客名称</label>
                        <input type="text" name="client_name" id="client_name" value="{{old('client_name', $clientPerson->client->client_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1 pointer-events-none" placeholder="" readonly>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="department_id" class="font-semibold dark:text-red-300 text-red-700 leading-none md:mt-4">管轄事業部</label>
                        <input type="text" name="department_id" id="department_id" value="{{old('department_id', $clientPerson->client->department->department_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1 pointer-events-none" placeholder="" readonly>
                    </div>
                </div>

                <div class="mt-8">
                    <span class="dark:text-white">担当者情報</span>
                    <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                </div>

                <label class="relative inline-flex items-center cursor-pointer">
                    {{-- <input type="hidden" name="is_retired" id="is_retired" value="0"> --}}
                    <input type="checkbox" name="is_retired" id="is_retired" value="1" @checked(old('is_retired', $clientPerson->is_retired) == 1) class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">退職フラグ</span>
                </label>

                <div class="grid gap-4 sm:grid-cols-2 md:mx-4">
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="last_name" class="font-semibold dark:text-red-300 text-red-700 leading-none md:mt-4">姓</label>
                            <input type="text" name="last_name" id="last_name" value="{{old('last_name', $clientPerson->last_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="" required>
                        </div>
                        @error('last_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="first_name" class="font-semibold dark:text-red-300 text-red-700 leading-none md:mt-4">名</label>
                            <input type="text" name="first_name" id="first_name" value="{{old('first_name', $clientPerson->first_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="" required>
                        </div>
                        @error('first_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="last_name_kana" class="font-semibold dark:text-red-300 text-red-700 leading-none">カナ姓</label>
                            <input type="text" name="last_name_kana" id="last_name_kana" value="{{old('last_name_kana', $clientPerson->last_name_kana)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="" required>
                        </div>
                        @error('last_name_kana')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="first_name_kana" class="font-semibold dark:text-red-300 text-red-700 leading-none">カナ名</label>
                            <input type="text" name="first_name_kana" id="first_name_kana" value="{{old('first_name_kana', $clientPerson->first_name_kana)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="" required>
                        </div>
                        @error('first_name_kana')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="division_name" class="font-semibold dark:text-white text-gray-900 leading-none">所属部署名</label>
                            <input type="text" name="division_name" id="division_name" value="{{old('division_name', $clientPerson->division_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('division_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="position_name" class="font-semibold dark:text-white text-gray-900 leading-none">役職名</label>
                            <input type="text" name="position_name" id="position_name" value="{{old('position_name', $clientPerson->position_name)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('position_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <span class="dark:text-white">連絡先情報</span>
                    <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 md:mx-4">
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="tel1" class="font-semibold dark:text-white text-gray-900 leading-none">電話番号</label>
                            <input type="text" name="tel1" id="tel1" value="{{old('tel1', $clientPerson->tel1)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('tel1')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="tel2" class="font-semibold dark:text-white text-gray-900 leading-none md:mt-4">電話番号2</label>
                        <input type="text" name="tel2" id="tel2" value="{{old('tel2', $clientPerson->tel2)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                    </div>
                    @error('tel2')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror --}}
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="fax1" class="font-semibold dark:text-white text-gray-900 leading-none">FAX番号</label>
                            <input type="text" name="fax1" id="fax1" value="{{old('fax1', $clientPerson->fax1)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('fax1')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    {{-- <div class="w-full flex flex-col">
                        <label for="fax2" class="font-semibold dark:text-white text-gray-900 leading-none">FAX番号2</label>
                        <input type="text" name="fax2" id="fax2" value="{{old('fax2', $clientPerson->fax2)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                    </div>
                    @error('fax2')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror --}}
                    {{-- <div class="w-full flex flex-col">
                        <label for="int_tel" class="font-semibold dark:text-white text-gray-900 leading-none">内線番号</label>
                        <input type="text" name="int_tel" id="int_tel" value="{{old('int_tel', $clientPerson->int_tel)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                    </div>
                    @error('int_tel')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror --}}
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="phone" class="font-semibold dark:text-white text-gray-900 leading-none">携帯番号</label>
                            <input type="text" name="phone" id="phone" value="{{old('phone', $clientPerson->phone)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('phone')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <div class="w-full flex flex-col">
                            <label for="mail" class="font-semibold dark:text-white text-gray-900 leading-none">Mail</label>
                            <input type="text" name="mail" id="mail" value="{{old('mail', $clientPerson->mail)}}" class="w-auto py-1 focus:ring-2 placeholder-gray-500 border border-gray-300 rounded mt-1" placeholder="">
                        </div>
                        @error('mail')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <span class="dark:text-white">住所情報</span>
                    <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                </div>

                <div class="grid gap-4 sm:grid-cols-4 md:mx-4">
                    <div class="col-span-1">
                        <label for="head_post_code" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4" autocomplete="new-password">郵便番号</label>
                        <div class="relative w-full">
                            <input type="text" name="head_post_code" class="focus:ring-2 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="head_post_code" value="{{old('head_post_code', $clientPerson->head_post_code)}}" placeholder="">
                            <button type="button" id="ajaxzip3" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-[34px] text-white mt-1 bg-blue-700 rounded-e border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label for="head_prefecture" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-4">都道府県</label>
                        <select id="head_prefecture" name="head_prefecture" class="focus:ring-2 w-full py-1.5 text-sm mt-1 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">未選択</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" @if( $prefecture->id == old('head_prefecture', $clientPerson->prefecture_id) ) selected @endif>{{ $prefecture->prefecture_code }}:{{ $prefecture->prefecture_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <div class="mt-3 md:mx-4">
                        <label for="head_addre1" class="font-semibold dark:text-gray-100 text-gray-900 leading-none">代表所在地</label>
                        <input type="text" name="head_addre1" id="head_addre1" value="{{old('head_addre1', $clientPerson->head_address1)}}" class="focus:ring-2 w-full py-1 mt-1 placeholder-gray-400 border border-gray-300 rounded" placeholder="">
                    </div>
                    @error('head_addre1')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <div>
                    <div class=" flex flex-col md:mx-4">
                        <label for="person_memo" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mt-8">担当者備考</label>
                        <textarea name="person_memo" id="person_memo" value="" class="w-full py-1 border border-gray-300 rounded mt-1 focus:ring-2 placeholder-gray-500" cols="30" rows="5" data-auto-resize="true" placeholder="">{{old('person_memo', $clientPerson->person_memo)}}</textarea>
                    </div>           
                    @error('person_memo')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>

                <ul class=" mt-4 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_billing_receiver" name="is_billing_receiver" type="checkbox" value="1" {{ old('is_billing_receiver', $clientPerson->is_billing_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_billing_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">請求先</label>
                        </div>
                        @error('is_billing_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_payment_receiver" name="is_payment_receiver" type="checkbox" value="1" {{ old('is_payment_receiver', $clientPerson->is_payment_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_payment_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">支払先</label>
                        </div>
                        @error('is_payment_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_support_info_receiver" name="is_support_info_receiver" type="checkbox" value="1" {{ old('is_support_info_receiver', $clientPerson->is_support_info_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_support_info_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">サポート送付先</label>
                        </div>
                        @error('is_support_info_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_closing_info_receiver" name="is_closing_info_receiver" type="checkbox" value="1" {{ old('is_closing_info_receiver', $clientPerson->is_closing_info_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_closing_info_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">休業案内先</label>
                        </div>
                        @error('is_closing_info_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_exhibition_info_receiver" name="is_exhibition_info_receiver" type="checkbox" value="1" {{ old('is_exhibition_info_receiver', $clientPerson->is_exhibition_info_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_exhibition_info_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">展示会案内先</label>
                        </div>
                        @error('is_exhibition_info_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                    <li class="w-full dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="is_cloud_info_receiver" name="is_cloud_info_receiver" type="checkbox" value="1" {{ old('is_cloud_info_receiver', $clientPerson->is_cloud_info_receiver) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="is_cloud_info_receiver" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">クラウド案内先</label>
                        </div>
                        @error('is_cloud_info_receiver')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </li>
                </ul>
                <x-primary-button class="mt-4 mb-4">
                    変更を確定する
                </x-primary-button>
            </form>
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
                            <svg class="w-3 h-3"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    {{-- <form action="{{ route('clientcorporation.search') }}" method="GET"> --}}
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
                                <select id="departmentId" name="departmentId" class="w-auto mt-1 mr-3 p-1.5 bg-gray-50 border border-gray-300 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 text-sm dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-900 dark:text-gray-900 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                                <th class="py-1 pl-5">顧客名称</th>
                                <th class="py-1 whitespace-nowrap">顧客番号</th>
                                <th class="py-1 whitespace-nowrap">管轄事業部</th>
                            </tr>
                            </thead>
                            <tbody class="" id="searchResultsContainer">                          
                                   <!-- 検索結果がここに追加されます -->
                            </tbody>
                        </table>
                    </div>
                   
                    <!-- Modal footer -->
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

    <script type="text/javascript" src="{{ asset('/assets/js/addresssearchbutton.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/autoresizetextarea.js') }}"></script>

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
                    <td class="py-2 pl-5 cursor-pointer" onclick="setClient('${result.client_num}', '${result.client_name}', '${result.department.department_name}')">${result.client_name}</td>
                    <td class="py-2 ml-2">${result.client_num}</td>
                    <td class="py-2 ml-2">${result.department.department_name}</td>
                `;
                searchResultsContainer.appendChild(resultElement);
                });
            });
            }

            function setClient(clientnum, clientname, department) {
            document.getElementById('client_num').value = clientnum;
            document.getElementById('client_name').value = clientname;
            document.getElementById('department_id').value = department;
            hideModal();
            }
    </script>
</x-app-layout>