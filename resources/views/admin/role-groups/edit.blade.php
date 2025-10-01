<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editRoleGroup', $roleGroup) }}
            </h2>
            <div class="flex ml-auto">
                <form method="post" action="{{route('role-groups.update',$roleGroup)}}" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('patch')
                    <x-buttons.save-button class="" form-id="editForm" id="saveButton" onkeydown="stopTab(event)">
                        {{ __("update") }}
                    </x-buttons.save-button>
                </form>
                <button id="dropdownActionButton" data-dropdown-toggle="dropdownActions" class="inline-flex items-center p-2 ml-4 text-sm font-medium text-center text-gray-900 bg-white rounded hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </button>
            </div>
            <!-- Dropdown menu -->
            <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                    <li>
                        <button type="button" data-modal-target="deleteModal-{{$roleGroup->id}}" data-modal-show="deleteModal-{{$roleGroup->id}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full dark:text-red-500">
                            <div class="flex">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span class="">グループを削除</span>
                            </div>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 md:pl-14">

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm text-center" id="myTabContent" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button onclick="changeTab('base')" class="inline-block p-4 border-b-2 rounded-t-md" id="base-tab" data-tabs-target="#base" type="button" role="tab" aria-controls="base"  aria-selected="{{ $activeTab === 'base' ? 'true' : 'false' }}">グループ情報</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button onclick="changeTab('user')" class="inline-block p-4 border-b-2 rounded-t-md" id="user-tab" data-tabs-target="#user" type="button" role="tab" aria-controls="user"  aria-selected="{{ $activeTab === 'user' ? 'true' : 'false' }}">所属ユーザ</button>
                </li>
            </ul>
        </div>
        
        {{-- 基本情報タブ --}}
        <div class="hidden md:p-4 p-2 mb-4 rounded bg-gray-50 dark:bg-gray-800" id="base" role="tabpanel" aria-labelledby="base-tab">
            <div class="hidden">
                <input type="text" id="role_group_id" value="{{old('role_group_id',$roleGroup->id)}}" class="block text-lg px-0 w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly />
                <label for="role_group_id" name="role_group_id" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">権限グループコード</label>
            </div>
            <div>
                <div  class="w-full flex flex-col">
                    <label for="role_group_code" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループコード</label>
                    <input type="text" form="editForm" name="role_group_code" class="w-full py-1 mt-1 rounded dark:bg-gray-400 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150" id="role_group_code" value="{{old('role_group_code',$roleGroup->role_group_code)}}" readonly tabindex="-1">
                </div>
            </div>
            <div class="w-full flex flex-col">
                <label for="role_group_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループ名称<span class="text-red-500"> *</span></label>
                <input type="text" form="editForm" name="role_group_name" class="input-secondary" id="role_group_name" value="{{old('role_group_name',$roleGroup->role_group_name)}}">
                @error('role_group_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div  class="w-full flex flex-col">
                    <label for="role_group_eng_name" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">権限グループ英名称<span class="text-red-500"> *</span></label>
                    <input type="text" form="editForm" name="role_group_eng_name" class="input-secondary" id="role_group_eng_name" value="{{old('role_group_eng_name',$roleGroup->role_group_eng_name)}}">
                </div>
                @error('role_group_eng_name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <div class="w-full flex flex-col">
                    <label for="role_group_memo" class="dark:text-gray-100 text-gray-900 leading-none text-sm mt-4">備考</label>
                    <input type="text" form="editForm" name="role_group_memo" class="input-secondary" id="role_group_memo" value="{{old('role_group_memo',$roleGroup->role_group_memo)}}">
                </div>
                @error('role_group_memo')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>

            <div class="relative bg-white dark:bg-gray-700 rounded-t md:w-auto shadow-md dark:text-gray-900 mt-16 border border-gray-600">
                <div class="flex justify-end p-2 space-y-1 flex-row md:space-y-0">
                    <div class="flex flex-shrink-0 w-auto md:space-y-0 items-center">
                        <div class="flex justify-end md:max-w-[calc(100%-3rem)]">
                            <select id="bulkPermissionSelect" class="py-[5px] rounded rounded-r-none text-sm md:text-base w-full md:w-auto">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->permission_code }}:{{ $permission->permission_name }}</option>
                                @endforeach
                            </select>
                            <button id="bulkSetPermissionsButton" class="bg-blue-500 whitespace-nowrap hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded rounded-l-none">一括設定</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-scroll w-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-600">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                        <tr class="">
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center w-2">
                                №
                            </th>
                            <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">
                                機能名称
                            </th>
                            <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">
                                権限
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($functionMenus as $functionMenu)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap ">
                                <td class="px-2 py-1 border border-gray-600 text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-1 border text-base border-gray-600">
                                    {{ $functionMenu->function_menu_name }}
                                </td>
                                <td class="px-2 py-2 border border-gray-600">
                                    <select name="permissions[{{ $functionMenu->id }}]" form="editForm" class="w-full min-w-max py-1 rounded dark:bg-gray-300 border-gray-700 border border-transparent dark:text-gray-900 tracking-widest hover:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150">
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}"  @selected($permission->id == $functionMenu->permission->id)>{{ $permission->permission_code }}:{{ $permission->permission_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 所属ユーザタブ --}}
        <div class="hidden md:p-4 p-2 rounded bg-gray-50 dark:bg-gray-800 mb-4" id="user" role="tabpanel" aria-labelledby="user-tab">
            <div>
                <div class="relative bg-white dark:bg-gray-700 rounded-t md:w-auto shadow-md  dark:text-gray-900 mt-4 border border-gray-600">
                    <div class="flex flex-col justify-between p-2 space-y-1 md:flex-row md:space-y-0 md:space-x-4">
                        <div class="mt-1 mb-1 px-4">
                            {{ $users->withQueryString()->links('vendor.pagination.secondary-pagination') }}  
                        </div> 
                        <!-- ユーザ検索モーダルを表示するボタン -->
                        <div class="flex flex-col items-stretch flex-shrink-0 w-full md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button type="button"  onclick="showUserSearchModal()" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
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
                                    社員番号
                                </th>
                                <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    ユーザ名
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    在職状態
                                </th>
                                {{-- <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    所属1
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    所属2
                                </th> --}}
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    所属部門
                                </th>
                                <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 text-center">
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                                <td class="px-6 py-2 font-medium whitespace-nowrap border border-gray-600">{{ $user->user_num }}</td>
                                <td class="px-2 py-2 text-center border border-gray-600">{{ $user->user_name }}</td>
                                <td class="px-2 py-2 text-center border border-gray-600">
                                    @if ($user->employee_status_id == 1)
                                        <span class="bg-green-100 text-green-800 text-xs whitespace-nowrap font-medium px-2.5 py-0.5 rounded dark:bg-green-700 dark:text-green-400 border border-green-400">
                                            在職中
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs whitespace-nowrap font-medium px-2.5 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">
                                            退職済み
                                        </span>
                                    @endif
                                </td>
                                {{-- <td class="px-2 py-2 text-center border border-gray-600">{{ $user->affiliation1->affiliation1_name }}</td> --}}
                                {{-- <td class="px-2 py-2 text-center border border-gray-600">{{ $user->affiliation2->affiliation2_name }}</td> --}}
                                {{-- <td class="px-2 py-2 text-center border border-gray-600">{{ $user->affiliation3->affiliation3_name }}</td> --}}
                                <td class="px-2 py-2 text-center border border-gray-600">{{ $user->department->path }}</td>
                                <td class="text-center border border-gray-600">
                                    <form method="post" action="{{ route('group.delete_user') }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="role_group_id" value="{{ $roleGroup->id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm1-7a1 1 0 01-2 0V7a1 1 0 012 0v2z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>










    <!-- グループ削除モーダル -->
    <div id="deleteModal-{{$roleGroup->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded shadow dark:bg-gray-700">
                <button data-modal-hide="deleteModal-{{$roleGroup->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                        <form action="{{route('corporations.destroy',$roleGroup->id)}}" method="POST" class="">
                            @csrf
                            @method('delete')
                            <button type="submit" data-modal-hide="deleteModal-{{$roleGroup->id}}" class="text-white  bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                グループを削除
                            </button>
                        </form>
                        <button data-modal-hide="deleteModal-{{$roleGroup->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            やっぱやめます
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <!-- ユーザ検索モーダル -->
    <div id="userSearchModal" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50 hidden animate-slide-in-top">
        <div class="max-h-full w-full max-w-7xl overflow-y-auto">
            <!-- モーダル content -->
            <div class="relative p-4 bg-white rounded shadow dark:bg-gray-700">
                <!-- モーダル header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        ユーザ検索画面
                    </h3>
                    {{-- 検索結果件数をJSで取得し表示 --}}
                    <div class="text-white font-medium ml-4 flex">
                        <div id="searchResultCount"></div>
                        <span>件</span>
                    </div>
                    <button type="button" onclick="hideUserSearchModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- モーダル body -->
                <!-- 検索条件入力フォーム -->

                <div class="grid gap-4 mb-4 sm:grid-cols-4 mt-2">
                    <div class="">
                        <label for="user_name" class="block text-sm dark:text-gray-100 text-gray-900 leading-none">ユーザ名</label>
                        <input type="text" name="user_name" id="user_name" class="block w-full mt-1 mr-2 py-1 placeholder-gray-400 border border-gray-300 rounded">
                    </div>

                    <div>
                        <label for="affiliation1_id" class="block font-semibold text-sm dark:text-white text-gray-900 leading-none md:mt-1">所属1</label>
                        <select id="affiliation1_id" name="affiliation1_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($affiliation1s as $affiliation1)
                            <option value="{{ $affiliation1->id }}" @selected($affiliation1->id == old('affiliation1_id'))>{{ $affiliation1->affiliation1_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="affiliation2_id" class="block font-semibold text-sm dark:text-white text-gray-900 leading-none md:mt-1">所属2</label>
                        <select id="affiliation2_id" name="affiliation2_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($affiliation2s as $affiliation2)
                            <option value="{{ $affiliation2->id }}" @selected($affiliation2->id == old('affiliation2_id'))>{{ $affiliation2->affiliation2_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="affiliation3_id" class="block font-semibold text-sm dark:text-white text-gray-900 leading-none md:mt-1">所属3</label>
                        <select id="affiliation3_id" name="affiliation3_id" class="input-primary">
                            <option value="">未選択</option>
                            @foreach($affiliation3s as $affiliation3)
                            <option value="{{ $affiliation3->id }}" @selected($affiliation3->id == old('affiliation3_id'))>{{ $affiliation3->affiliation3_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 他の検索条件を追加する場合はここに追加 -->
                </div>
                <button type="button" onclick="searchUsers()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    検索
                </button>

            <form method="post" action="{{route('role-groups.add-users')}}" enctype="multipart/form-data" id="addUsersForm">
                @csrf
                <input type="hidden" name="role_group_id" form="addUsersForm" value="{{ $roleGroup->id }}">

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
                                <th class="py-3 whitespace-nowrap">社員番号</th>
                                <th class="py-3 whitespace-nowrap">ユーザ名</th>
                                <th class="py-3 whitespace-nowrap">所属1</th>
                                <th class="py-3 whitespace-nowrap">所属2</th>
                                <th class="py-3 whitespace-nowrap">所属3</th>
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
                    <button type="button" onclick="hideUserSearchModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        閉じる
                    </button> 
                </div>
            </form>

            </div>
        </div>
    </div>





<script>

    // Permission一括設定用
    document.addEventListener('DOMContentLoaded', function () {
        const bulkPermissionSelect = document.getElementById('bulkPermissionSelect');
        const bulkSetPermissionsButton = document.getElementById('bulkSetPermissionsButton');

        bulkSetPermissionsButton.addEventListener('click', function () {
            const selectedPermissionId = bulkPermissionSelect.value;
            const permissionOptions = document.querySelectorAll('select[name^="permissions"] option');

            permissionOptions.forEach(option => {
                option.selected = (option.value === selectedPermissionId);
            });
        });
    });

    // モーダルを開く関数
    function showUserSearchModal() {
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        document.getElementById('userSearchModal').classList.remove('hidden');
    }

    // ユーザーを検索する関数
    function searchUsers() {
        var userName = document.getElementById('user_name').value; // 必要なクエリを設定する
        var affiliation1Id = document.getElementById('affiliation1_id').value; // 必要に応じて追加
        var affiliation2Id = document.getElementById('affiliation2_id').value; // 必要に応じて追加
        var affiliation3Id = document.getElementById('affiliation3_id').value; // 必要に応じて追加
        
        $.ajax({
            url: '/search-users', // ユーザを検索するエンドポイント
            method: 'GET',
            data: {
                user_name: userName,
                affiliation1_id: affiliation1Id,
                affiliation2_id: affiliation2Id,
                affiliation3_id: affiliation3Id
            },
            success: function (data) {
                var tbody = $('#userSearchModal tbody');
                var resultCount = data.length; // 検索結果の件数を取得
                $('#searchResultCount').text(resultCount); // 検索結果の件数を表示する要素にセット
                
                tbody.empty(); // テーブルの内容をクリア
                var headerCheckbox = $('.header-checkbox'); // ヘッダーチェックボックスを取得
                
                // ユーザ検索ボタンが押されたときにヘッダーチェックボックスがチェックされている場合、外す
                if (headerCheckbox.prop('checked')) {
                    headerCheckbox.prop('checked', false);
                }

                data.forEach(function (user) {
                    var row = $('<tr>').addClass('dark:border-gray-600 hover:bg-gray-600 dark:text-white border');
                        row.append(
                        $('<td>').append(
                            $('<input>').attr('type', 'checkbox').attr('name', 'user_ids[]').val(user.id).addClass('form-checkbox h-5 w-5 text-blue-600 ml-8 rounded cursor-pointer')
                        )
                    );
                    row.append($('<td>').text(user.user_num).addClass('py-2 ml-2'));
                    row.append($('<td>').text(user.user_name).addClass('py-2 ml-2'));
                    row.append($('<td>').text(user.affiliation1.affiliation1_name).addClass('py-2 ml-2'));
                    row.append($('<td>').text(user.affiliation2.affiliation2_name).addClass('py-2 ml-2'));
                    row.append($('<td>').text(user.affiliation3.affiliation3_name).addClass('py-2 ml-2'));
                    tbody.append(row);
                });
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch users:', error);
            }
        });
    }

    function hideUserSearchModal() {
        document.getElementById('userSearchModal').classList.add('hidden');
        //背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

        </script>

        <script>
            function checkAllCheckboxes(checkbox) {
        var checkboxes = document.querySelectorAll('#userSearchModal input[type="checkbox"]');
        checkboxes.forEach(function(item) {
            item.checked = checkbox.checked;
        });
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

<script type="text/javascript" src="{{ asset('assets/js/stopTab.js') }}"></script>
</x-app-layout>