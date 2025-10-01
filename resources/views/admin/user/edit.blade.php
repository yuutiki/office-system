<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('editUser', $user) }}
            </h2>
            <div class="ml-auto flex justify-end items-center space-x-2">
                <form method="post" action="{{route('users.update', $user)}}" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')
                    <x-button-save form-id="updateForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __('save') }}
                    </x-button-save>
                </form>

                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                        <li>
                            <button type="button" data-modal-target="deleteModal-{{$user->id}}" data-modal-show="deleteModal-{{$user->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                                <div class="flex">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="font-semibold">削除</span>
                                </div>
                            </button>
                        </li>
                        <li>
                            <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新日：{{ $user->updated_at }}</span>
                        </li>
                        <li>
                            <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">更新者：{{ optional($user->updatedBy)->user_name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base" aria-selected="false">基本情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-md" id="group-tab" data-tabs-target="#group" type="button" role="tab" aria-controls="group" aria-selected="false">グループ情報</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">

            <!-- 画像選択用のフォーム -->
            <div class="mb-8 w-20 h-20">
                <img id="image_preview" src="{{ asset('storage/'. $user->profile_image) }}?{{ time() }}" alt="プロフ画像" class="cursor-pointer w-full h-full object-cover rounded" onclick="document.getElementById('profile_image').click()">
                <input type="file" id="profile_image" accept="image/*" class="hidden" form="updateForm" name="profile_image">
            </div>

            <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
            <input type="hidden" id="cropped_profile_image" name="cropped_profile_image" form="updateForm">

            <label class="relative inline-flex items-center cursor-pointer mb-9">
                <input type="hidden" form="updateForm" name="is_enabled" value="0">
                <input type="checkbox" form="updateForm" name="is_enabled" value="1" @checked(old('is_enabled', $user->is_enabled)) class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">有効</span>
            </label>

            <div class="grid gap-4 md:grid-cols-4 mb-4">
                <div class="w-full flex flex-col">
                    <label for="user_num" class="text-sm dark:text-gray-100 leading-none">社員番号<span class="text-red-500"> *</span></label>
                    <input type="text" form="updateForm" name="user_num" class="input-primary" id="user_num" value="{{old('user_num', $user->user_num)}}" placeholder="999999" maxlength="6">
                    @error('user_num')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="employee_status_id" class="text-sm dark:text-gray-100 leading-none">雇用状態<span class="text-red-500"> *</span></label>
                    <select form="updateForm" name="employee_status_id" class=" input-primary" id="employee_status_id" value="{{old('employee_status_id', $user->employee_status_id)}}">
                        @foreach($e_statuses as $employee_status)
                        <option value="{{ $employee_status->id }}" @selected($employee_status->id == $user->employee_status_id)>{{ $employee_status->employee_status_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_status_id')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="employment_at" class="text-sm dark:text-gray-100 leading-none">入職年月日</label>
                    <input type="date" min="1900-01-01" max="2200-12-31" form="updateForm" name="employment_at" class="input-primary" id="employment_at" value="{{old('employment_at', $user->employment_at)}}" placeholder="">
                    @error('employment_at')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="birth" class="text-sm dark:text-gray-100 leading-none">生年月日<span class="text-red-500"> *</span></label>
                    <input type="date" min="1900-01-01" max="2200-12-31" form="updateForm" name="birth" class="input-primary" id="birth" value="{{old('birth', $user->birth)}}" placeholder="">
                    @error('birth')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-3 md:grid-cols-2">
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                        <label for="user_name" class="text-sm dark:text-gray-100 leading-none">氏名<span class="text-red-500"> *</span></label>
                        <input type="text" form="updateForm" name="user_name" class="input-secondary" id="user_name" value="{{old('user_name', $user->user_name)}}" placeholder="">
                        @error('user_name')
                            <div class="text-red-500">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="md:flex items-center">
                    <div class="w-full flex flex-col">
                    <label for="user_kana_name" class="text-sm dark:text-gray-100 leading-none">カナ氏名<span class="text-red-500"> *</span></label>
                    <input type="text" form="updateForm" name="user_kana_name" class="input-secondary" id="user_kana_name" value="{{old('user_kana_name', $user->user_kana_name)}}" placeholder="">
                    @error('user_kana_name')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <span class="dark:text-white">連絡先</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3">
                <div class="w-full flex flex-col">
                    <label for="ext_phone" class="text-sm dark:text-gray-100 leading-none mt-2">外線番号<span class="text-red-500"> *</span></label>
                    <input type="text" form="updateForm" name="ext_phone" onchange="validateAndFormat('ext_phone')" class="input-secondary" id="ext_phone" value="{{old('ext_phone', $user->ext_phone)}}" placeholder="999-9999-9999">
                    @error('ext_phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="int_phone" class="text-sm dark:text-gray-100 leading-none mt-2">内線番号</label>
                    <input type="text" form="updateForm" name="int_phone" class="input-secondary" id="int_phone" value="{{old('int_phone', $user->int_phone)}}" placeholder="999" maxlength="{{ $maxlength }}">
                    @error('int_phone')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
                <div class="w-full flex flex-col">
                    <label for="email" class="text-sm dark:text-gray-100 leading-none mt-2">E-MAIL<span class="text-red-500"> *</span></label>
                    <input type="text" form="updateForm" name="email" class="input-secondary" id="email" value="{{old('email', $user->email)}}" placeholder="test＠gmail.com">
                    @error('email')
                        <div class="text-red-500">{{$message}}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8">
                <span class="dark:text-white">所属情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            <div class="grid gap-4 mb-4 md:grid-cols-3 ">
                <div class="w-full flex flex-col">
                    <label for="affiliation1_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属1</label>
                    <select form="updateForm" name="affiliation1_id" class="input-secondary" id="affiliation1_id" value="{{old('affiliation1_id', $user->affiliation1_id)}}">
                        @foreach($affiliation1s as $affiliation1)
                        <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == $user->affiliation1_id)>{{ $affiliation1->affiliation1_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation1_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="affiliation2_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属2</label>
                    <select form="updateForm" name="affiliation2_id" class="input-secondary" id="affiliation2_id" value="{{old('affiliation2_id', $user->affiliation2_id)}}">
                        @foreach($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == $user->affiliation2_id)>{{ $affiliation2->affiliation2_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation2_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror

                <div class="w-full flex flex-col">
                    <label for="affiliation3_id" class="text-sm dark:text-gray-100 leading-none mt-2">所属3</label>
                    <select form="updateForm" name="affiliation3_id" class="input-secondary" id="affiliation3_id" value="{{old('affiliation3_id', $user->affiliation3_id)}}">
                        @foreach($affiliation3s as $affiliation3)
                        <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == $user->affiliation3_id)>{{ $affiliation3->affiliation3_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('affiliation3_id')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

    <div class="mb-4">
        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
            所属部門
        </label>
        <select id="department_id" form="updateForm" name="department_id" class="input-primary w-full">
            <option value="">未選択</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $user->department_id) == $department->id)>
                    {{ $department->path }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

            <div class="mt-8">
                <span class="dark:text-white">印鑑情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>
            <!-- 画像選択用のフォーム -->
            <div class="mb-8 w-20 h-20">
                <img id="stamp_image_preview" src="{{ asset('storage/'. $user->user_stamp_image) }}?{{ time() }}" alt="印鑑画像" class="cursor-pointer w-full h-full object-cover rounded" onclick="document.getElementById('user_stamp_image').click()">
                <input type="file" id="user_stamp_image" accept="image/*" class="hidden" form="updateForm" name="user_stamp_image">
            </div>

            <!-- フォームにトリミング後の画像をセットするための非表示のinput要素 -->
            <input type="hidden" id="cropped_user_stamp_image" name="cropped_user_stamp_image" form="updateForm">

            <div class="mt-8">
                <span class="dark:text-white">ログイン情報</span>
                <ul class="pt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            </div>

            {{-- <div class="w-full flex flex-col">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード</label>
                <input type="password" form="updateForm" name="password" autocomplete="new-password" class="input-primary" id="password" value="{{old('password', $user->password)}}">
            </div>
            @error('password')
                <div class="text-red-500">{{$message}}</div>
            @enderror

            <div class="w-full flex flex-col mt-4">
                <label class="text-sm dark:text-gray-100 leading-none mt-2">パスワード（確認）</label>
                <input type="password" form="updateForm" name="password_confirmation" autocomplete="new-password" class="input-primary" id="password_confirmation" value="{{old('password_confirmation', $user->password_confirmation)}}">
            </div>
            @error('password_confirmation')
                <div class="text-red-500">{{$message}}</div>
            @enderror --}}

            <div class="text-white">
                ※初期パスワードは自動で設定されメール送信されます。
                <br>
                「生年月日8桁＋A%＋外線番号下4桁」
            </div>

            <label class="relative inline-flex items-center cursor-pointer my-9">
                <input type="hidden" form="updateForm" name="password_change_required" value="0">
                @if($user->password_change_required == 1)
                    <input type="checkbox" form="updateForm" name="password_change_required" id="password_change_required" value="1" class="sr-only peer" checked>
                @else
                    <input type="checkbox" form="updateForm" name="password_change_required" id="password_change_required" value="1" class="sr-only peer">
                @endif
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">次回ログイン時パスワード変更</span>
            </label>
        </div>
        
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="group" role="tabpanel" aria-labelledby="group-tab">
            <div>
                <div class="relative bg-white dark:bg-gray-700 rounded-t md:w-auto shadow-md  dark:text-gray-900 mt-4 border border-gray-600">
                    <div class="flex flex-col justify-end p-2 space-y-1 md:flex-row md:space-y-0 md:space-x-4">

                        <!-- ユーザ検索モーダルを表示するボタン -->
                        <div class="flex flex-col items-stretch flex-shrink-0 w-full md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button type="button"  onclick="showRoleGroupsSearchModal()" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                {{ __('一括登録') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                            <tr>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">
                                    権限グループコード
                                </th>
                                <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    権限グループ名称
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    権限グループ英名称
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    備考
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roleGroups as $roleGroup)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                                <td class="px-6 py-2 font-medium whitespace-nowrap border border-gray-600">{{ $roleGroup->role_group_code }}</td>
                                <td class="px-2 py-2 text-center border border-gray-600">{{ $roleGroup->role_group_name }}</td>
                                <td class="px-2 py-2 text-center border border-gray-600">{{ $roleGroup->role_group_eng_name }}</td>
                                <td class="px-2 py-2 text-center border border-gray-600">{{ $roleGroup->role_group_memo }}</td>
                                <td class="text-center border border-gray-600">
                                    {{-- <form method="post" action="{{ route('group.delete_user') }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="user_id" value="{{ $roleGroup->id }}">
                                        <input type="hidden" name="role_group_id" value="{{ $roleGroup->id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm1-7a1 1 0 01-2 0V7a1 1 0 012 0v2z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- プロフ画像トリミング Modal -->
    <div id="imageModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        アイコン編集
                    </h3>
                    <button type="button" onclick="hideModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body（トリミング用のコンテナ） -->
                <div id="cropper_container"></div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="setProfileImage()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        完了
                    </button>
                    <button type="button" onclick="hideImageModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        キャンセル
                    </button> 
                </div>
            </div>
        </div>
    </div>

    <!-- 印鑑画像トリミング Modal -->
    <div id="stampModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-2xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        アイコン編集
                    </h3>
                    <button type="button" onclick="hideStampImageModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body（トリミング用のコンテナ） -->
                <div id="cropper_stamp_container"></div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="setStampImage()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        完了
                    </button>
                    <button type="button" onclick="hideStampImageModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        キャンセル
                    </button> 
                </div>
            </div>
        </div>
    </div>




      
    <!-- 権限グループ検索モーダル -->
    <div id="roleGroupSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-7xl">
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- モーダル header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        権限グループ検索画面
                    </h3>
                    {{-- 検索結果件数をJSで取得し表示 --}}
                    <div class="text-white font-medium ml-4 flex">
                        <div id="searchResultCount"></div>
                        <span>件</span>
                    </div>
                    <button type="button" onclick="hideRoleGroupsSearchModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- モーダル body（検索条件入力） -->
                <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-2">
                    <div class="">
                        <label for="role_group_code" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-1">権限グループコード</label>
                        <input type="text" name="role_group_code" id="role_group_code" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                    </div>

                    <div class="">
                        <label for="role_group_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-1">権限グループ名称</label>
                        <input type="text" name="role_group_name" id="role_group_name" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                    </div>
                    <div class="">
                        <label for="role_group_eng_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none md:mt-1">権限グループ英名称</label>
                        <input type="text" name="role_group_eng_name" id="role_group_eng_name" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                    </div>
                </div>
                <button type="button" onclick="searchRoleGroups()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    検索
                </button>
                <!-- モーダル body（検索結果出力） -->
                <form method="post" action="{{route('users.add-role-groups')}}" enctype="multipart/form-data" id="addUsersForm">
                    @csrf
                    <input type="hidden" name="user_id" form="addUsersForm" value="{{ $user->id }}">
                    <div class="max-h-80 overflow-x-auto mt-4 rounded border dark:border-gray-600">
                        <table class="w-full text-white text-left text-sm">
                            <thead class="sticky top-0 bg-white dark:bg-gray-600 border-l dark:border-gray-600">
                                <tr class="whitespace-nowrap">
                                    <th class="py-3 pl-5">
                                        <label class="flex items-center cursor-pointer text-gray-900 dark:text-white">
                                            <input type="checkbox" onclick="checkAllCheckboxes(this)" class="header-checkbox h-5 w-5 text-blue-600 mr-2 ml-3.5 rounded cursor-pointer">
                                            <span>全て選択</span>
                                        </label>
                                    </th>
                                    <th class="py-3 whitespace-nowrap">権限グループコード</th>
                                    <th class="py-3 whitespace-nowrap">権限グループ名称</th>
                                    <th class="py-3 whitespace-nowrap">権限グループ英名称</th>
                                    {{-- <th class="py-3 whitespace-nowrap">所属2</th>
                                    <th class="py-3 whitespace-nowrap">所属3</th> --}}
                                </tr>
                            </thead>
                            <tbody id="searchResultsContainer" class="overflow-y-auto whitespace-nowrap">
                                <!-- 検索結果がここに追加されます -->
                            </tbody>
                        </table>
                    </div>
                    <!-- モーダル footer -->
                    <div class="flex items-center p-6 space-x-2 border-t mt-4 border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" id="saveButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            一括登録
                        </button>
                        <button type="button" onclick="hideRoleGroupsSearchModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            閉じる
                        </button> 
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 共通変数・定数
        const overlay = document.getElementById('overlay');
        const body = document.body;
    </script>

    {{-- プロフィール用 --}}
    <script>
        // Imageモーダルの要素を取得
        const modal = document.getElementById('imageModal');

        // Imageモーダルを表示するための関数
        function showImageModal() {
            //背後の操作不可を有効
            overlay.classList.remove('hidden');
            body.classList.add('overflow-hidden');

            // Imageモーダルを表示するためにhiddenを取り除く
            modal.classList.remove('hidden');
        }

        // Imageモーダルを非表示にするための関数
        function hideImageModal() {
            //背後の操作不可を解除
            overlay.classList.add('hidden');
            body.classList.remove('overflow-hidden');

            // Imageモーダルを非表示にするためにhiddenを追加
            modal.classList.add('hidden');
        }

        // ファイル選択用のinput要素をクリックした時に発火
        document.getElementById('profile_image').addEventListener('click', function(event) {
            // ファイルの選択をリセットする（onchangeなので同じファイルを選択した場合もイベントが発火するようにするため）
            this.value = null;
        });

        // ファイル選択用のinput要素が変更されたときに発火
        document.getElementById('profile_image').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.createElement('img');
                img.src = reader.result;
                img.id = 'cropper_target';
                document.getElementById('cropper_container').innerHTML = '';
                document.getElementById('cropper_container').appendChild(img);

                showImageModal();

                // Cropper.jsの初期化（第一引数にimgファイルを渡す、第二引数にオプション）
                var cropper = new Cropper(img, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    dragMode: 'move',
                    cropBoxResizable: false,
                    autoCropArea: 0.8,
                    movable: false,
                    crop: function(event) {
                        // トリミングされた画像の情報を取得
                        var canvas = cropper.getCroppedCanvas();
                        // 画像トリミング後にフォームに画像をセットする処理を有効化する
                        document.getElementById('cropped_profile_image').value = canvas.toDataURL();
                    }
                });
            };
            reader.readAsDataURL(input.files[0]);
        });
    
        // トリミング後の画像をフォームにセットする処理（Modal上の完了ボタン押下時に発火）
        function setStampImage() {
            // トリミング対象の画像要素が存在するか確認
            if (document.getElementById('cropper_target')) {
                var canvas = document.getElementById('cropper_target').cropper.getCroppedCanvas();
                var dataURL = canvas.toDataURL();
                document.getElementById('image_preview').src = dataURL;
                // トリミング後の画像をフォームにセット
                document.getElementById('cropped_profile_image').value = dataURL;
                
                // モーダルを非表示にする処理を追加する
                hideImageModal();
            } else {
                console.error('トリミング対象の画像要素が見つかりません。');
            }
        }
    </script>


    <script>
        // Imageモーダルの要素を取得
        const stampImageModal = document.getElementById('stampModal');

        // Imageモーダルを表示するための関数
        function showStampImageModal() {
            //背後の操作不可を有効
            overlay.classList.remove('hidden');
            body.classList.add('overflow-hidden');

            // StampImageモーダルを表示するためにhiddenを取り除く
            stampImageModal.classList.remove('hidden');
        }

        // StampImageモーダルを非表示にするための関数
        function hideStampImageModal() {
            //背後の操作不可を解除
            overlay.classList.add('hidden');
            body.classList.remove('overflow-hidden');

            // StampImageモーダルを非表示にするためにhiddenを追加
            stampImageModal.classList.add('hidden');
        }

        // ファイル選択用のinput要素をクリックした時に発火
        document.getElementById('user_stamp_image').addEventListener('click', function(event) {
            // ファイルの選択をリセットする（onchangeなので同じファイルを選択した場合もイベントが発火するようにするため）
            this.value = null;
        });

        // ファイル選択用のinput要素が変更されたときに発火
        document.getElementById('user_stamp_image').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.createElement('img');
                img.src = reader.result;
                img.id = 'cropper_target';
                document.getElementById('cropper_stamp_container').innerHTML = '';
                document.getElementById('cropper_stamp_container').appendChild(img);

                showStampImageModal();

                // Cropper.jsの初期化（第一引数にimgファイルを渡す、第二引数にオプション）
                var cropper = new Cropper(img, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    dragMode: 'move',
                    cropBoxResizable: false,
                    autoCropArea: 0.8,
                    movable: false,
                    crop: function(event) {
                        // トリミングされた画像の情報を取得
                        var canvas = cropper.getCroppedCanvas();
                        // 画像トリミング後にフォームに画像をセットする処理を有効化する
                        document.getElementById('cropped_user_stamp_image').value = canvas.toDataURL();
                    }
                });
            };
            reader.readAsDataURL(input.files[0]);
        });
    
        // トリミング後の画像をフォームにセットする処理（Modal上の完了ボタン押下時に発火）
        function setStampImage() {
            // トリミング対象の画像要素が存在するか確認
            if (document.getElementById('cropper_target')) {
                var canvas = document.getElementById('cropper_target').cropper.getCroppedCanvas();
                var dataURL = canvas.toDataURL();
                document.getElementById('stamp_image_preview').src = dataURL;
                // トリミング後の画像をフォームにセット
                document.getElementById('cropped_user_stamp_image').value = dataURL;
                
                // モーダルを非表示にする処理を追加する
                hideStampImageModal();
            } else {
                console.error('トリミング対象の画像要素が見つかりません。');
            }
        }
    </script>



    <script>
        const overlay2 = document.getElementById('overlay');
        const modal2 = document.getElementById('roleGroupSearchModal');

        // 権限グループ検索モーダルを開く関数
        function showRoleGroupsSearchModal() {
            overlay2.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            modal2.classList.remove('hidden');
        }

        // 権限グループ検索モーダルを開く関数
        function hideRoleGroupsSearchModal() {
            //背後の操作不可を解除
            overlay2.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            modal2.classList.add('hidden');
        }

        // ユーザーを検索する関数
        function searchRoleGroups() {
            var roleGroupCode = document.getElementById('role_group_code').value; // 必要なクエリを設定する
            var roleGroupName = document.getElementById('role_group_name').value; // 必要に応じて追加
            var roleGroupEngName = document.getElementById('role_group_eng_name').value; // 必要に応じて追加
            
            $.ajax({
                url: '/search-role-groups', // ユーザを検索するエンドポイント
                method: 'GET',
                data: {
                    role_group_code: roleGroupCode,
                    role_group_name: roleGroupName,
                    role_group_eng_name: roleGroupEngName,
                },
                success: function (data) {
                    var tbody = $('#roleGroupSearchModal tbody');
                    var resultCount = data.length; // 検索結果の件数を取得
                    $('#searchResultCount').text(resultCount); // 検索結果の件数を表示する要素にセット
                    
                    tbody.empty(); // テーブルの内容をクリア
                    var headerCheckbox = $('.header-checkbox'); // ヘッダーチェックボックスを取得
                    
                    // ユーザ検索ボタンが押されたときにヘッダーチェックボックスがチェックされている場合、外す
                    if (headerCheckbox.prop('checked')) {
                        headerCheckbox.prop('checked', false);
                    }

                    data.forEach(function (roleGroup) {
                        var row = $('<tr>').addClass('dark:border-gray-600 hover:bg-gray-600 dark:text-white border');
                            row.append(
                            $('<td>').append(
                                $('<input>').attr('type', 'checkbox').attr('name', 'role_group_ids[]').val(roleGroup.id).addClass('form-checkbox h-5 w-5 text-blue-600 ml-8 rounded cursor-pointer')
                            )
                        );
                        row.append($('<td>').text(roleGroup.role_group_code).addClass('py-2 ml-2'));
                        row.append($('<td>').text(roleGroup.role_group_name).addClass('py-2 ml-2'));
                        row.append($('<td>').text(roleGroup.role_group_eng_name).addClass('py-2 ml-2'));
                        tbody.append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Failed to fetch users:', error);
                }
            });
        }
    </script>

    <script>
        function checkAllCheckboxes(checkbox) {
            var checkboxes = document.querySelectorAll('#roleGroupSearchModal input[type="checkbox"]');
            checkboxes.forEach(function(item) {
                item.checked = checkbox.checked;
            });
        }
    </script>

    <script src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>