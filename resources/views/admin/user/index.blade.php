<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="text-gray-900 dark:text-white flex items-center py-1">
                {{ Breadcrumbs::render('users') }}
            </h2>
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-2 items-center">
                <!-- 新規登録ボタン -->
                <x-buttons.add-button :route="route('users.create')" gate="storeUpdate_users" :text="__('Add')" />

                <div class="items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <!-- アクションセレクトボタン -->
                    <x-buttons.dropdown-edit-button />
                    <div id="dropdownActions" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            @can('admin_users')
                                <li>
                                    <button type="button" onclick="location.href='{{ route('users.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            {{-- <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                            </svg> --}}
                                            <x-icon name="actions/upload" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        CSVアップロード
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        CSVアップロード
                                    </button>
                                </li>
                                <li>
                                    <button type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        CSVダウンロード
                                    </button>
                                </li>
                            @endcan

                            <hr class="border-gray-300 dark:border-gray-500 mx-2">
                            
                            <li>
                                @can('admin_users')
                                    <button type="button" data-modal-target="deleteModal-users" data-modal-show="deleteModal-users" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/delete" class="w-5.5 h-5.5"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

<div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md dark:text-gray-900 mt-4">
    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between md:space-x-4">
        <form method="GET" action="{{ route('users.index') }}" id="search_form" class="w-full">
            @csrf

            {{-- === 検索入力欄 === --}}
            <div class="flex flex-col md:flex-row w-full space-y-2 md:space-y-0 md:space-x-2">
                {{-- ユーザNo --}}
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <x-icon name="ui/search" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </span>
                    <input type="search" id="user_num" name="user_num" value="{{ $filters['user_num'] ?? '' }}" placeholder="ユーザNo." class="input-search">
                </div>

                {{-- 氏名 --}}
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <x-icon name="ui/search" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                    </span>
                    <input type="search" id="user_name" name="user_name" value="{{ $filters['user_name'] ?? '' }}" placeholder="氏名" class="input-search">
                </div>

                {{-- 所属 --}}
                {{-- <select name="affiliation2_id" id="affiliation2_id"
                    class="block w-full p-2 text-sm border border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">所属</option>
                    @foreach ($affiliation2s as $affiliation2)
                        <option value="{{ $affiliation2->id }}" @selected(($affiliation2Id ?? null) == $affiliation2->id)>
                            {{ $affiliation2->affiliation2_name }}
                        </option>
                    @endforeach
                </select> --}}

                <select id="department_id" name="department_id" class="block w-full p-2 text-sm border border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">所属部門</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id',) == $department->id)>
                            {{ $department->path }}
                        </option>
                    @endforeach
                </select>

                {{-- ボタン群 --}}
                <button type="button" onclick="showModal()"
                    class="px-4 py-2 text-sm font-medium whitespace-nowrap text-white rounded-sm bg-indigo-700 hover:bg-indigo-800 focus:ring-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none focus:ring-indigo-500">
                    詳細条件
                </button>
                <div class="flex space-x-2 mt-2 md:mt-0">
                    <x-buttons.search-button />
                    <x-buttons.reset-button />
                </div>
            </div>

            {{-- === 詳細検索モーダル === --}}
            <div id="detailSearchModal" tabindex="-1"
                class="fixed inset-0 flex items-center justify-center overflow-y-auto z-50 hidden animate-slide-in-top">
                <div class="max-h-full w-full max-w-5xl p-4 bg-white rounded shadow dark:bg-gray-700">
                    {{-- モーダルヘッダ --}}
                    <div class="flex items-center justify-between border-b pb-2">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">詳細検索</h3>
                        <button type="button" onclick="hideModal()" class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>

                    {{-- モーダル本文 --}}
                    <div class="mt-4 space-y-4">
                        {{-- 在職状態 --}}
                        <div>
                            <label class="dark:text-white text-sm mx-2">在職状態</label>
                            <div class="grid w-full gap-3 md:grid-cols-6 sm:grid-cols-2 md:ml-2 mb-4">
                                <label class="flex justify-center items-center">
                                    <input type="checkbox" id="employee_status-1"
                                        name="employee_status_ids[]" value="1"
                                        class="hidden peer" @checked(in_array(1, $filters['employee_status_ids'] ?? []))>
                                    <span class="checkbox-label w-full text-sm text-center">在職</span>
                                </label>
                                <label class="flex justify-center items-center">
                                    <input type="checkbox" id="employee_status-2"
                                        name="employee_status_ids[]" value="2"
                                        class="hidden peer" @checked(in_array(2, $filters['employee_status_ids'] ?? []))>
                                    <span class="checkbox-label w-full text-sm text-center">退職</span>
                                </label>
                            </div>
                        </div>

                        {{-- 電話番号 --}}
                        <div>
                            <label for="tel" class="dark:text-white text-sm mx-2">電話番号</label>
                            <input type="search" name="tel" value="{{ $request['tel'] ?? '' }}"
                                placeholder="090-1234-5678"
                                class="block w-full p-2 text-sm border border-gray-300 rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- 内線番号 --}}
                        <div>
                            <label for="extension" class="dark:text-white text-sm mx-2">内線番号</label>
                            <input type="search" name="extension" value="{{ $request['extension'] ?? '' }}"
                                placeholder="1234"
                                class="block w-full p-2 text-sm border border-gray-300 rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Eメール --}}
                        <div>
                            <label for="email" class="dark:text-white text-sm mx-2">Eメール</label>
                            <input type="search" name="email" value="{{ $request['email'] ?? '' }}"
                                placeholder="test@test.com"
                                class="block w-full p-2 text-sm border border-gray-300 rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- 今後追加予定項目 --}}
                        <div class="flex space-x-4">
                            <label class="dark:text-white text-sm mx-2">権限グループ</label>
                            <label class="dark:text-white text-sm mx-2">有効/無効</label>
                        </div>
                    </div>

                    {{-- モーダルフッタ --}}
                    <div class="flex justify-end mt-6 space-x-2 border-t pt-3">
                        <button type="button" onclick="hideModal()"
                            class="px-5 py-2.5 text-sm border rounded dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            閉じる
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700">
                            検索
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


    <div class="text-gray-950 md:ml-9 my-2 pl-4">
        {{ $users->withQueryString()->links('vendor.pagination.custom-tailwind') }} 
    </div>

    <div class="md:w-auto md:ml-14 md:mr-2 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                <tr class="whitespace-nowrap">
                    <th scope="col" class="pl-4 py-3 w-auto">
                        <div class="flex items-center">
                            №
                        </div>
                    </th>
                    <th scope="col" class="pl-4 w-auto">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </div>
                    </th>
                    <th scope="col" class="px-1 w-auto">
                        <div class="">
                            （選択 <span id="selectedCount">0</span> 件）
                        </div>
                    </th>
                    <th scope="col" class="pl-4">
                        <div class="flex items-center">
                            @sortablelink('user_num','ユーザ№')
                            <x-icon name="ui/sort-arrow-icon" class="w-3 h-3 ml-1" />
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            @sortablelink('user_kana_name','氏名')
                            <x-icon name="ui/sort-arrow-icon" class="w-3 h-3 ml-1" />
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            @sortablelink('email','E-MAIL')
                            <x-icon name="ui/sort-arrow-icon" class="w-3 h-3 ml-1" />
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            @sortablelink('last_login_at','最終ログイン日時')
                            <x-icon name="ui/sort-arrow-icon" class="w-3 h-3 ml-1" />
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            @sortablelink('employee_status_id','在職')
                            <x-icon name="ui/sort-arrow-icon" class="w-3 h-3 ml-1" />
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            有効フラグ
                        </div>
                    </th>
                    <th scope="col" class="px-1">
                        <div class="flex items-center">
                            
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600 whitespace-nowrap">
                        <td class="pl-4 py-1">
                            {{ $loop->iteration }}
                        </td>
                        <td class="pl-4 py-1">
                            <div class="flex items-center">
                                <input id="checkbox{{ $user->id }}" type="checkbox" name="selectedIds[]" value="{{ $user->id }}" form="bulkDeleteForm" class="checkbox-item  w-4 h-4 text-blue-600 bg-gray-100 border-gray-500 dark:border-white rounded border  focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700">
                            </div>
                        </td>
                        <td class="pl-4 py-1 w-20">
                            <x-buttons.edit-button :route="route('users.edit', $user)" />
                        </td>
                        <td class="pl-4 py-1">
                            {{ $user->user_num }}
                        </td>
                        <td class="px-1 py-1">
                            {{ $user->user_name }}
                        </td>
                        <td class="px-1 py-1">
                            {{ $user->email }}
                        </td>
                        <td class="px-1 py-1">
                            @if ($user->last_login_at)
                                {{ Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                            @else
                                未ログイン
                            @endif
                        </td>
                        <td class="px-1 py-1">
                            {{$user->employeeStatus->employee_status_num}}:
                            {{$user->employeeStatus->employee_status_name}}
                        </td>
                        <td class="px-1 py-1 mr-2">
                            @if($user->is_enabled == '1')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    有効
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    無効
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-1">
                            {{ optional($user->updatedBy)->name }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mb-1 px-4 md:ml-9">
            {{ $users->withQueryString()->links('vendor.pagination.custom-tailwind') }}  
        </div>
    @endif

    <!-- モーダル本体 -->
    <x-modals.delete-index-modal
        modalId="deleteModal-users"
        target="users"
        action="{{ route('users.bulkDelete') }}"
        confirmText="{{ __('deleted') }}"
        cancelText="やっぱやめます"
        countId="modalSelectedCount"
    />


    <script>
        // モーダルを表示するための関数
        function showModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('detailSearchModal');
            //背後の操作不可を有効
            const overlay = document.getElementById('overlay').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
    
            // モーダルを表示するためのクラスを追加
            modal.classList.remove('hidden');
        }
    
        // モーダルを非表示にするための関数
        function hideModal() {
            // モーダルの要素を取得
            const modal = document.getElementById('detailSearchModal');
            //背後の操作不可を解除
            const overlay = document.getElementById('overlay').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
    
            // モーダルを非表示にするためのクラスを削除
            modal.classList.add('hidden');
        }
    </script>


    @push('scripts')
        @vite('resources/js/pages/users/index.js')
    @endpush
</x-app-layout>