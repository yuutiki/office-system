<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <h2 class="flex text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('clientTypeMaster') }}
            </h2>

            <div class="ml-auto flex space-x-2">
                <x-buttons.add-button-drawer onclick="openDrawer('create')">
                    {{ __('create') }}
                </x-buttons.add-button-drawer>

                <div class="flex items-center space-x-3 w-auto hidden md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    {{-- <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                @can('admin_client_types')
                                    <button type="button" onclick="location.href='{{ route('client-types.showUploadForm') }}'" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-4c0-.6-.4-1-1-1h-2M8 9l4-5 4 5m1 8h0"/>
                                            </svg>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @else
                                    <button type="button" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        CSVアップロード
                                    </button>
                                @endcan
                            </li>
                            <li>
                                @can('download_client_types')
                                    <button type="button" onclick="location.href='{{ route('client-types.downloadCsv', $filters ?? []) }}'" class="relative w-full items-center py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/download" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div class="">CSVダウンロード</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <x-icon name="actions/lock" class="w-6 h-6 text-gray-800 dark:text-white"></x-icon>
                                        </div>
                                        <div>CSVダウンロード</div>
                                    </button>
                                @endcan
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md dark:text-gray-900 mt-4">
        <div class="relative bg-white dark:bg-gray-800">
            <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                <div class="w-full">
                    <form method="GET" action="{{ route('client-type.index') }}" id="search_form" class="flex items-center">
                        @csrf
                        <div class="flex flex-col md:flex-row w-full">

                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" id="client-type-code-search" name="code" value="{{ request('code', '') }}" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="コード" >
                            </div>

                            <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" id="client-type-name-search" name="name" value="{{ request('name', '') }}" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="名称" >
                            </div>

                            <li class="flex md:w-60 mt-2 md:mx-2 md:mt-0">
                                <input type="checkbox" id="include_invail" {{ request('include_invail') ? 'checked' : '' }} value="1" name="include_invail" class="sr-only peer">
                                <label for="include_invail" class="checkbox-label rounded">
                                    <div class="w-full text-sm font-medium text-center pt-0.5">無効も含む</div>
                                </label>
                            </li>
                            <div class="flex mt-2 md:mt-0">
                                <div class="flex flex-col justify-end w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                    
                                    <div class="flex mt-4 md:mt-0">
                                        <!-- 検索ボタン -->
                                        <x-buttons.search-button />
                                        <!-- リセットボタン -->
                                        <x-buttons.reset-button />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-1 mb-1 px-4 md:ml-9">
        {{ $clientTypes->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
    </div> 

    <div class="md:w-auto md:mr-2 md:ml-14 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-8 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            コード
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            名称
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            有効/無効
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            更新者
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            更新日時
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientTypes as $clientType)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <td class="pl-8 py-2 whitespace-nowrap font-mono text-lg">
                            {{ $clientType->client_type_code }}
                        </td>
                        <td class="px-1 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $clientType->client_type_name }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            @if($clientType->is_active)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    有効
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    無効
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap text-gray-400">
                            {{ optional($clientType->updatedBy)->user_name }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap text-gray-400">
                            <div class="hidden md:block">{{ $clientType->updated_at }}</div>
                            <div class="md:hidden">{{ $clientType->updated_at->format('Y-m-d')  }}</div>
                        </td>
                        <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button type="button" class="button-edit-primary" onclick="openDrawer('{{ $clientType->id }}')">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                        <span class="md:block hidden">編集</span>
                                    </div>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- drawer component -->
                    <div id="drawer-{{ $clientType->id }}"
                        class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
                        style="min-width: 300px; width: min(30rem, 100vw); max-width: 100vw;">
                    
                        <!-- リサイズハンドル -->
                        <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity">
                        </div>
                
                        <!-- フォーム部分 -->
                        <div class="">
                            <form method="POST" action="{{ route('client-type.update', $clientType->id) }}" id="client-type-form-{{ $clientType->id }}" data-is-changed="false">
                                @csrf
                                @method('PUT')

                                <div class="flex justify-between items-center p-4">
                                    <button type="button" data-drawer-id="{{ $clientType->id }}"
                                        class="close-drawer-button p-0.5 rounded text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                                        </svg>
                                    </button>
                                
                                    <div class="flex gap-4">
                                        <button type="submit" class="button-edit-primary dark:bg-blue-500">
                                            <div class="flex items-center px-3.5 py-1.5">
                                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>
                                                <span class="md:block hidden">{{ __('update') }}</span>
                                            </div>
                                        </button>
                                    <!-- 削除ボタン（モーダル表示トリガー） -->
                                    <button type="button" data-modal-target="deleteModal-{{ $clientType->id }}" data-modal-toggle="deleteModal-{{ $clientType->id }}" class="button-delete-primary rounded ">
                                        <div class="flex items-center px-3.5 py-1.5">
                                            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="md:block hidden">{{ __('delete') }}</span>
                                        </div>
                                    </button>

                                    </div>
                                </div>
                                <div class="space-y-4 p-4">
                                    <!-- 隠しフィールドで current updated_at を送信 -->
                                    <input type="hidden" name="updated_at" value="{{ $clientType->updated_at->format('Y-m-d H:i:s') }}">
                                    
                                    <div class="w-full">
                                        <label for="client_type_code-{{ $clientType->id }}" class="block dark:text-gray-100 text-gray-900">
                                            コード
                                        </label>
                                        <input type="text" maxlength="2" name="client_type_code" id="client_type_code-{{ $clientType->id }}" 
                                                value="{{old('client_type_code',$clientType->client_type_code)}}" 
                                                class="input-readonly" 
                                                readonly>
                                        @error('client_type_code')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                    <div class="w-full">
                                        <label for="client_type_name-{{ $clientType->id }}" class="block dark:text-gray-100 text-gray-900">
                                            名称
                                        </label>
                                        <input type="text" maxlength="10" name="client_type_name" id="client_type_name-{{ $clientType->id }}" 
                                                value="{{ old('client_type_name',$clientType->client_type_name) }}" 
                                                class="input-secondary" 
                                                required>
                                        @error('client_type_name')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="w-full" x-data="{ isActive: {{ old('is_active', $clientType->is_active) == 1 ? 'true' : 'false' }} }">
                                        <label for="" class="block dark:text-gray-100 text-gray-900 mb-2">
                                            有効/無効
                                        </label>

                                        <!-- 送信されないと困るので hidden で 0 を送信 -->
                                        <input type="hidden" name="is_active" value="0">

                                        <div class="flex items-center space-x-3">
                                            <!-- 四角いトグルボタン -->
                                            <label for="is_active-{{ $clientType->id }}" class="relative cursor-pointer">
                                                <input type="checkbox"name="is_active"id="is_active-{{ $clientType->id }}"
                                                    value="1"
                                                    x-model="isActive"
                                                    :checked="isActive"
                                                    class="sr-only peer">

                                                <!-- ボタン本体 -->
                                                <div class="button-active">
                                                    <span x-text="isActive ? '有効' : '無効'"></span>
                                                </div>
                                            </label>
                                        </div>

                                        @error('is_active')
                                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>

                            <!-- 削除確認モーダル -->
                            <div id="deleteModal-{{ $clientType->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded shadow dark:bg-gray-700">
                                        <div class="p-6 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                本当にこのデータを削除しますか？
                                            </h3>
                                            <div class="flex justify-center">
                                                <!-- 削除フォーム -->
                                                <form id="delete-form-{{ $clientType->id }}" action="{{ route('client-type.destroy', $clientType->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-modal-hide="deleteModal-{{ $clientType->id }}" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                        {{ __('delete') }}
                                                    </button>
                                                </form>
                                                <!-- キャンセルボタン -->
                                                <button data-modal-hide="deleteModal-{{ $clientType->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:outline-none rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                    キャンセル
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($clientTypes && $clientTypes->hasPages())
        <div class="mt-1 mb-1 px-4 md:ml-9">
            {{ $clientTypes->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    @endif

    <!-- 新規登録用ドロワー -->
    <div id="drawer-create" class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
        style="min-width: 300px; width: 30rem; max-width: 1200px;">
        
        <!-- リサイズハンドル -->
        <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity"></div>

        <div class="p-4">
            <form method="POST" 
                action="{{ route('client-type.store') }}" 
                id="client-type-form-create" 
                data-is-changed="false">
                @csrf

                <div class="flex justify-between items-center">
                    <!-- data-drawer-close属性を追加 -->
                    <button type="button" 
                            data-drawer-id="create"
                            class="close-drawer-button p-0.5 rounded text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-500 dark:hover:text-white">
                            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                            </svg>
                    </button>
                </div>

                <div class="space-y-4 mt-4">
                    <div class="w-full">
                        <label for="client_type_code" class="block dark:text-gray-100 text-gray-900">
                            コード
                        </label>
                        <input type="text" maxlength="2" name="client_type_code" id="client_type_code"
                            value="{{ old('client_type_code') }}"
                            class="input-secondary" 
                            required>
                        @error('client_type_code')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="client_type_name" class="block dark:text-gray-100 text-gray-900">
                            名称
                        </label>
                        <input type="text" maxlength="10" name="client_type_name" id="client_type_name"
                            value="{{ old('client_type_name') }}"
                            class="input-secondary" 
                            required>
                        @error('client_type_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full" 
                        x-data="{ isActive: {{ old('is_active', 1) == 1 ? 'true' : 'false' }} }">
                        <label class="block dark:text-gray-100 text-gray-900 mb-2">
                            有効/無効
                        </label>

                        <!-- 送信されないと困るので hidden で 0 を送信 -->
                        <input type="hidden" name="is_active" value="0">

                        <div class="flex items-center space-x-3">
                            <!-- 四角いトグルボタン -->
                            <label for="is_active" class="relative cursor-pointer">
                                <input type="checkbox"name="is_active"id="is_active"
                                    value="1"
                                    x-model="isActive"
                                    :checked="isActive"
                                    class="sr-only peer">

                                <!-- ボタン本体 -->
                                <div class="button-active">
                                    <span x-text="isActive ? '有効' : '無効'"></span>
                                </div>
                            </label>
                        </div>

                        @error('is_active')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 登録ボタン -->
                    <div class="">
                        <button type="submit" 
                            class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 dark:bg-blue-700 dark:hover:bg-blue-800 focus:border-blue-500  
                                font-medium rounded mt-12 px-5 py-2.5 border border-gray-700 
                                focus:outline-none focus:ring-2 dark:focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 placeholder-gray-400 transition ease-in-out duration-150">
                            登録
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            window.FORM_PREFIX = 'client-type-form';
        </script>
        <script src="{{ asset('assets/js/drawer-manager.js') }}"></script>
    @endpush
</x-app-layout>