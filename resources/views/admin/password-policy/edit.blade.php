<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('password-policy-setting') }}
            </h2>
            <div class="flex justify-end items-center space-x-2">
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('password-policy.update', $passwordPolicy) }}" enctype="multipart/form-data" id="editForm" class="flex items-center">
                    @csrf
                    @method('patch')
                    @can('storeUpdate_corporations')
                        <x-button-save form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                            {{ __("update") }}
                        </x-button-save>
                    @endcan
                </form>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>



    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">ポリシー情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">


                {{-- <div class="w-full flex">
                    <label for="employee_status_id" class="text-sm dark:text-gray-100 leading-none mt-2">雇用状態</label>
                    <select form="editForm" name="employee_status_id" class=" input-secondary" id="employee_status_id" value="{{old('employee_status_id')}}">
                        @foreach($e_statuses as $e_status)
                        <option value="{{ $e_status->id }}">{{ $e_status->employee_status_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('employee_status_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror --}}





            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr class="">
                            <th scope="col" class="px-3 py-2 whitespace-nowrap border-x border-gray-600">
                                ポリシー項目
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">
                                設定値
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                パスワードの最小桁数（8~30）
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="editForm" name="min_length" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="min_length" value="{{old('min_length', $passwordPolicy->min_length)}}" placeholder=""  min="8" max="30">
                                    <div class="font-semibold text-base my-auto ml-4">桁</div>
                                </div>
                                @error('min_length')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                1文字以上の英大文字を必須
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="require_uppercase" value="0">
                                    @if($passwordPolicy->require_uppercase == 1)
                                        <input type="checkbox" form="editForm" name="require_uppercase" id="require_uppercase" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="require_uppercase" id="require_uppercase" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('require_uppercase')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                1文字以上の英小文字を必須
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="require_lowercase" value="0">
                                    @if($passwordPolicy->require_lowercase == 1)
                                        <input type="checkbox" form="editForm" name="require_lowercase" id="require_lowercase" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="require_lowercase" id="require_lowercase" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('require_lowercase')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                1文字以上の数字を必須
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="require_numeric" value="0">
                                    @if($passwordPolicy->require_numeric == 1)
                                        <input type="checkbox" form="editForm" name="require_numeric" id="require_numeric" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="require_numeric" id="require_numeric" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('require_numeric')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                記号文字の使用を必須
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="require_symbol" value="0">
                                    @if($passwordPolicy->require_symbol == 1)
                                        <input type="checkbox" form="editForm" name="require_symbol" id="require_symbol" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="require_symbol" id="require_symbol" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('require_symbol')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>

                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                パスワードにログインIDを含めることを禁止
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="banned_email_use" value="0">
                                    @if($passwordPolicy->banned_email_use == 1)
                                        <input type="checkbox" form="editForm" name="banned_email_use" id="banned_email_use" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="banned_email_use" id="banned_email_use" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('banned_email_use')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                前回スワードの再利用を禁止（）
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" form="editForm" name="banned_password_reuse" value="0">
                                    @if($passwordPolicy->banned_password_reuse == 1)
                                        <input type="checkbox" form="editForm" name="banned_password_reuse" id="banned_password_reuse" value="1" class="sr-only peer" checked>
                                    @else
                                        <input type="checkbox" form="editForm" name="banned_password_reuse" id="banned_password_reuse" value="1" class="sr-only peer">
                                    @endif
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
                                </label>
                                @error('banned_password_reuse')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                アカウントロックまでの回数
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="editForm" name="max_login_attempt" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="max_login_attempt" value="{{old('max_login_attempt', $passwordPolicy->max_login_attempt)}}" min="0">
                                    <div class="font-semibold text-base my-auto ml-4">回</div>
                                </div>
                                @error('max_login_attempt')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                アカウントロック解除までの時間（秒）（）
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="editForm" name="lockout_time" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="lockout_time" value="{{old('lockout_time', $passwordPolicy->lockout_time)}}" min="0">
                                    <div class="font-semibold text-base my-auto ml-4">秒</div>
                                </div>
                                @error('lockout_time')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror

                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                アカウントを無効化する未ログイン期間
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="editForm" name="date_inactive" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="date_inactive" value="{{old('date_inactive', $passwordPolicy->date_inactive)}}" min="0">
                                    <div class="font-semibold text-base my-auto ml-4">日</div>
                                </div>
                                @error('date_inactive')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                            <td class="px-3 py-1 border text-sm md:text-base border-gray-600">
                                パスワード有効期限（日）※0で無期限
                            </td>
                            <td class="px-2 py-2 border border-gray-600">
                                <div class="w-full flex">
                                    <input type="number" form="editForm" name="date_password_expiration" class="w-20 py-0.5 rounded dark:bg-gray-100 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="date_password_expiration" value="{{old('date_password_expiration', $passwordPolicy->date_password_expiration)}}" min="0">
                                    <div class="font-semibold text-base my-auto ml-4">日</div>
                                </div>
                                @error('date_password_expiration')
                                    <div class="text-red-500">{{$message}}</div>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            
            {{-- <form method="post" action="{{route('password-policy.update', $passwordPolicy)}}" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                <x-primary-button class="mt-4" form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                    ポリシー適用(S)
                </x-primary-button>
            </form> --}}
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>