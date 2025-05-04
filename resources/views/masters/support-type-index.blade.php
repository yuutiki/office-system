<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex items-center">
                {{ Breadcrumbs::render('supportTypeMaster') }}
                <div class="ml-4">
                    {{ $count }}件
                </div>
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
                <x-buttons.save-button onclick="openDrawer('create')" class="mr-2">
                    {{ __('create') }}
                </x-buttons.save-button>

                <div class="flex items-center w-full space-x-3 hidden md:w-auto md:inline-block">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full p-2.5 text-sm font-medium hover:bg-[#313a48] bg-[#364050] text-gray-200 rounded md:w-auto focus:z-10 dark:bg-blue-600 dark:text-gray-100 dark:border-gray-600 dark:hover:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button">
                        <x-icon name="ui/dot-option" class="w-4 h-4"></x-icon>
                    </button>
                    <div id="actionsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                            <li>
                                <x-buttons.csv-upload-button :route="route('corporations.showUploadForm')" gate="admin_masters" />
                            </li>
                            <li>
                                <x-buttons.csv-download-button :route="route('support-types.export')" gate="download_masters" />
                            </li>
                            <hr class="border-gray-300 dark:border-gray-500 mx-2">

                            <li>
                                @can('admin_masters')
                                    <button type="button" data-modal-target="deleteModal-corporations" data-modal-show="deleteModal-corporations" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white">
                                        <div class="flex items-center min-w-6">
                                        <x-icon name="actions/delete"></x-icon>
                                        </div>
                                        <div class="ml-2">データ削除</div>
                                    </button>
                                @else
                                    <button type="button" class="relative w-full flex items-center py-2 px-3 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white cursor-not-allowed" disabled>
                                        <div class="flex items-center min-w-6">
                                            <x-icon name="actions/lock"></x-icon>
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

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">
        <div class="w-full dark:bg-gray-800 p-4">
            <form method="GET" action="{{ route('support-type.index') }}" id="search_form" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                @csrf

                {{-- コード検索 --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icon name="ui/search" class="w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                    </div>
                    <input type="search" name="code" value="{{ $typeCode ?? '' }}" class="input-search" placeholder="コード">
                </div>

                {{-- 名称検索 --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icon name="ui/search" class="w-5 h-5 text-gray-500 dark:text-gray-400 pointer-events-none" />
                    </div>
                    <input type="search" name="name" value="{{ request('name') ?? '' }}" class="input-search" placeholder="名称 / 英名称">
                </div>

                {{-- ボタン類 --}}
                <div class="flex space-x-2">
                    <x-buttons.search-button />
                    <x-buttons.reset-button />
                </div>
            </form>
        </div>


        <div class="md:w-auto  md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="pl-4 py-3 whitespace-nowrap">コード</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">編集</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">名称</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">英名称</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">更新者</th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supportTypes as $supportType)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-600">
                            <td class="pl-4 py-2 whitespace-nowrap">
                                {{ $supportType->type_code }}
                            </td>
                            <td class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="text-center">
                                    <button type="button" class="button-edit-primary" onclick="openDrawer('{{$supportType->id}}')">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                            </svg>
                                            <span class="md:block hidden">編集</span>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$supportType->type_name}}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                {{$supportType->type_name_en}}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap">
                                {{ optional($supportType->updatedBy)->user_name }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap hidden md:block">
                                {{$supportType->updated_at}}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap md:hidden">
                                {{$supportType->updated_at->format('Y-m-d')}}
                            </td>
                        </tr>
                        <!-- drawer component -->
                        <div id="drawer-{{$supportType->id}}" 
                            class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
                            style="min-width: 300px; width: min(30rem, 100vw); max-width: 100vw;">
                        
                            {{-- リサイズハンドル --}}
                            <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity">
                            </div>
                    
                            {{-- フォーム部分 --}}
                            <div class="">
                                <form method="POST" action="{{ route('support-type.update', $supportType->id) }}" id="support-type-form-{{$supportType->id}}" data-is-changed="false">
                                    @csrf
                                    @method('PUT')

                                    <div class="flex justify-between items-center p-4">
                                        <button type="button" 
                                            data-drawer-id="{{$supportType->id}}"
                                            class="p-0.5 rounded text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-500 dark:hover:text-white">
                                            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                                            </svg>
                                        </button>

                                        <div class="flex gap-4">
                                            <x-buttons.save-button form-id="corporationForm" id="saveButton" class="" data-drawer-id="{{$supportType->id}}">
                                                {{ __("update") }}
                                            </x-buttons.save-button>

                                            <button type="button" data-modal-target="deleteModal-{{$supportType->id}}" data-modal-show="deleteModal-{{$supportType->id}}" class="button-delete-primary">
                                                <x-icon name="actions/delete" class="w-5 h-5 mr-1 -ml-1"></x-icon>
                                                {{ __('delete') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-y-4 p-4">
                                        <div class="w-full">
                                            <label for="type_code-{{$supportType->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                コード
                                            </label>
                                            <input type="text" 
                                                    maxlength="2" 
                                                    name="type_code" 
                                                    id="type_code-{{$supportType->id}}" 
                                                    value="{{old('type_code',$supportType->type_code)}}" 
                                                    class="input-readonly" 
                                                    readonly>
                                            @error('type_code')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="w-full">
                                            <label for="type_name-{{$supportType->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                名称
                                            </label>
                                            <input type="text" 
                                                    maxlength="10" 
                                                    name="type_name" 
                                                    id="type_name-{{$supportType->id}}" 
                                                    value="{{old('type_name',$supportType->type_name)}}" 
                                                    class="input-secondary" 
                                                    required>
                                            @error('type_name')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="w-full">
                                            <label for="type_name-{{$supportType->id}}" class="block font-semibold dark:text-gray-100 text-gray-900">
                                                英名称
                                            </label>
                                            <input type="text" 
                                                    maxlength="10" 
                                                    name="type_name_en" 
                                                    id="type_name_en-{{$supportType->id}}" 
                                                    value="{{old('type_name_en',$supportType->type_name_en)}}" 
                                                    class="input-secondary" 
                                                    >
                                            @error('type_name_en')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- 削除確認モーダル画面 Start --}}
                        <div id="deleteModal-{{$supportType->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-s rounded-e shadow dark:bg-gray-700">
                                    <button data-modal-hide="deleteModal-{{$supportType->id}}" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-s rounded-e text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>

                                    <div class="p-6 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">本当に削除しますか？</h3>
                                        <form action="{{route('support-type.destroy',$supportType->id)}}" method="POST" class="text-center m-auto">
                                            @csrf
                                            @method('delete')
                                            @can('delete_masters')
                                                <button type="submit" data-modal-hide="deleteModal-{{$supportType->id}}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-s rounded-e text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    削除
                                                </button>
                                            @endcan
                                        </form>
                                        <button data-modal-hide="deleteModal-{{$supportType->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-s rounded-e border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            やっぱやめます
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- 削除確認モーダル画面 End --}}
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-1 mb-1 px-4">
            {{ $supportTypes->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>


    {{-- 新規登録用ドロワー --}}
    <div id="drawer-create" 
        class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
        style="min-width: 300px; width: 30rem; max-width: 1200px;">
        
        {{-- リサイズハンドル --}}
        <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity"></div>

        <div class="p-4">
            <form method="POST" 
                action="{{ route('support-type.store') }}" 
                id="support-type-form-create" 
                data-is-changed="false">
                @csrf

                <div class="flex justify-between items-center">
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
                        <label for="type_code" class="block font-semibold dark:text-gray-100 text-gray-900">
                            コード
                        </label>
                        <input type="text" 
                            maxlength="2" 
                            name="type_code" 
                            id="type_code"
                            value="{{ old('type_code') }}"
                            class="input-secondary" 
                            required>
                        @error('type_code')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="type_name" class="block font-semibold dark:text-gray-100 text-gray-900">
                            名称
                        </label>
                        <input type="text" 
                            maxlength="20" 
                            name="type_name" 
                            id="type_name"
                            value="{{ old('type_name') }}"
                            class="input-secondary" 
                            >
                        @error('type_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="type_name_en" class="block font-semibold dark:text-gray-100 text-gray-900">
                            英名称
                        </label>
                        <input type="text" 
                            maxlength="20" 
                            name="type_name_en" 
                            id="type_name_en"
                            value="{{ old('type_name_en') }}"
                            class="input-secondary" 
                            >
                        @error('type_name_en')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <x-buttons.save-button  class="mr-2">
                            {{ __('save') }}
                        </x-buttons.save-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- @push('scripts')
        <script src="{{ asset('assets/js/drawer-manager.js') }}"></script>
    @endpush --}}
    <script>
        // ドロワーの設定を管理するオブジェクト
        const DrawerManager = {
            currentWidth: 480,
            minWidth: 300,
            maxWidth: Math.min(1200, window.innerWidth), // 画面幅を超えないように調整
            
            // ドロワーの幅を更新
            updateAllDrawersWidth: function(width) {
                this.currentWidth = Math.min(parseInt(width), window.innerWidth);
                document.querySelectorAll('.drawer-component').forEach(drawer => {
                    drawer.style.width = `${this.currentWidth}px`;
                });
                localStorage.setItem('drawerWidth', this.currentWidth);
            },

            // 保存された幅を読み込む
            loadSavedWidth: function() {
                const savedWidth = localStorage.getItem('drawerWidth');
                if (savedWidth) {
                    this.currentWidth = Math.min(parseInt(savedWidth), window.innerWidth);
                    this.updateAllDrawersWidth(this.currentWidth);
                }
            }
        };

        // フォームの変更検知と警告を管理するオブジェクト
        const FormManager = {
            // フォームの初期値と変更状態を保持
            formStates: new Map(), // { formId: { initialValues: Map, isChanged: boolean } }

            // フォームの初期化
            initialize(form) {
                const initialValues = new Map();
                const inputs = this.getFormInputs(form);
                
                inputs.forEach(input => {
                    initialValues.set(input.name, input.value);
                });

                this.formStates.set(form.id, {
                    initialValues: initialValues,
                    isChanged: false
                });

                this.setupChangeDetection(form);
                this.setupCloseButton(form);
                this.setupSubmitHandler(form);

                console.log('Form initialized:', {
                    formId: form.id,
                    initialValues: Object.fromEntries(initialValues)
                });
            },

            // 変更検知の設定
            setupChangeDetection(form) {
                const inputs = this.getFormInputs(form);

                inputs.forEach(input => {
                    const checkChanges = () => {
                        const formState = this.formStates.get(form.id);
                        if (!formState) return;

                        const currentValues = new Map(inputs.map(field => [field.name, field.value]));
                        const hasChanges = Array.from(currentValues.entries()).some(
                            ([name, value]) => value !== formState.initialValues.get(name)
                        );

                        formState.isChanged = hasChanges;
                        form.dataset.isChanged = hasChanges.toString();

                        console.log('Change check:', {
                            formId: form.id,
                            field: input.name,
                            currentValue: input.value,
                            initialValue: formState.initialValues.get(input.name),
                            hasChanges: hasChanges
                        });
                    };

                    // input と change の両方のイベントを監視
                    input.addEventListener('input', checkChanges);
                    input.addEventListener('change', checkChanges);
                });
            },

            // フォームのリセット処理
            resetForm(form) {
                console.log('Starting form reset for:', form.id);
                
                // まずフォームをリセット
                form.reset();

                // 現在のフォーム値を取得し、新しい初期値として設定
                const inputs = this.getFormInputs(form);
                const newInitialValues = new Map();
                
                inputs.forEach(input => {
                    // リセット後の値を新しい初期値として保存
                    const resetValue = input.value;
                    newInitialValues.set(input.name, resetValue);
                    console.log(`Reset ${input.name} to:`, resetValue);
                });

                // フォームの状態を更新
                this.formStates.set(form.id, {
                    initialValues: newInitialValues,
                    isChanged: false
                });

                console.log('Form reset completed:', {
                    formId: form.id,
                    newState: {
                        initialValues: Object.fromEntries(newInitialValues),
                        isChanged: false
                    }
                });
            },

            // 入力要素を取得するユーティリティ
            getFormInputs(form) {
                return Array.from(form.elements).filter(element => 
                    element.tagName.toLowerCase() === 'input' &&
                    !['hidden', 'submit'].includes(element.type)
                );
            },

            // 閉じるボタンの設定
            setupCloseButton(form) {
                const drawerId = form.id.split('-').pop();
                const drawer = document.getElementById(`drawer-${drawerId}`);
                const closeButton = drawer.querySelector('button[data-drawer-id]');
                
                if (closeButton) {
                    closeButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.handleClose(form, drawerId);
                    });
                }
            },

            // 閉じる処理
            handleClose(form, drawerId) {
                const formState = this.formStates.get(form.id);
                
                if (formState.isChanged) {
                    if (confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
                        this.resetForm(form);
                        closeDrawer(drawerId);
                    }
                } else {
                    closeDrawer(drawerId);
                }
            },

            // 送信処理
            setupSubmitHandler(form) {
                form.addEventListener('submit', () => {
                    const formState = this.formStates.get(form.id);
                    formState.isChanged = false;
                    form.dataset.isChanged = 'false';
                });
            },

                // 新規作成フォームの初期化
                initializeCreateForm() {
                const form = document.getElementById('support-type-form-create');
                if (!form) return;

                const initialValues = new Map();
                const inputs = this.getFormInputs(form);
                
                inputs.forEach(input => {
                    initialValues.set(input.name, input.value || '');  // 空値の場合も考慮
                });

                this.formStates.set(form.id, {
                    initialValues: initialValues,
                    isChanged: false
                });

                this.setupChangeDetection(form);
                this.setupCloseButton(form);
                this.setupSubmitHandler(form);
            },

            // バリデーションエラー時のドロワー再表示
            handleValidationError() {
                const params = new URLSearchParams(window.location.search);
                const shouldOpenDrawer = sessionStorage.getItem('openDrawer');
                
                if (shouldOpenDrawer === 'create') {
                    openDrawer('create');
                    sessionStorage.removeItem('openDrawer');
                }
            }
        };

        // ドロワーの初期化
        function initializeDrawers() {
            // リサイズ機能の初期化
            document.querySelectorAll('.resize-handle').forEach(handle => {
                let isResizing = false;
                let drawer = handle.parentElement;
                let initialWidth, initialX;

                handle.addEventListener('mousedown', startResize);

                function startResize(e) {
                    isResizing = true;
                    initialX = e.clientX;
                    initialWidth = drawer.offsetWidth;

                    document.body.style.cursor = 'col-resize';
                    document.body.style.userSelect = 'none';

                    document.addEventListener('mousemove', handleResize);
                    document.addEventListener('mouseup', stopResize);
                    e.stopPropagation();
                }

                function handleResize(e) {
                    if (!isResizing) return;

                    const diffX = e.clientX - initialX;
                    const newWidth = Math.min(initialWidth - diffX, window.innerWidth); // 画面幅を超えない

                    if (newWidth >= DrawerManager.minWidth) {
                        drawer.style.width = `${newWidth}px`;
                        DrawerManager.updateAllDrawersWidth(newWidth);
                    }

                    e.preventDefault();
                }

                function stopResize() {
                    if (!isResizing) return;
                    
                    isResizing = false;
                    document.body.style.cursor = '';
                    document.body.style.userSelect = '';
                    document.removeEventListener('mousemove', handleResize);
                    document.removeEventListener('mouseup', stopResize);
                }
            });

            // オーバーレイのクリックイベントを設定
            const overlay = document.getElementById('overlay');
            overlay.addEventListener('click', function() {
                const openDrawer = document.querySelector('.drawer-component:not(.translate-x-full)');
                if (openDrawer) {
                    const id = openDrawer.id.replace('drawer-', '');
                    closeDrawer(id);
                }
            });
        }

        // ドロワーを開く
        function openDrawer(id) {
            const drawer = document.getElementById(`drawer-${id}`);
            const overlay = document.getElementById('overlay');
            
            if (drawer) {
                const maxWidth = Math.min(DrawerManager.currentWidth, window.innerWidth); // 画面幅以下にする
                drawer.style.width = `${maxWidth}px`;

                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                drawer.classList.remove('translate-x-full');
                updateUrl(id);

                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                    overlay.classList.remove('opacity-0');
                }, 0);
            }
        }

        // ドロワーを閉じる
        function closeDrawer(id) {
            const drawer = document.getElementById(`drawer-${id}`);
            const overlay = document.getElementById('overlay');
            const form = document.getElementById(`support-type-form-${id}`);

            // FormManager.shouldConfirmClose の代わりに formStates を使用
            if (form) {
                const formState = FormManager.formStates.get(form.id);
                if (formState && formState.isChanged) {
                    if (!confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
                        return;
                    }
                    FormManager.resetForm(form);
                }
            }

            if (drawer) {
                drawer.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }, 300);

                removeDrawerParam();
            }
        }


        // URLパラメータの更新
        function updateUrl(id) {
            const url = new URL(window.location);
            url.searchParams.set('drawer', id);
            window.history.pushState({}, '', url);
        }

        // URLパラメータの削除
        function removeDrawerParam() {
            const url = new URL(window.location);
            url.searchParams.delete('drawer');
            window.history.pushState({}, '', url);
        }

        // URLからドロワーIDを取得して開く
        function checkUrlAndOpenDrawer() {
            const urlParams = new URLSearchParams(window.location.search);
            const drawerId = urlParams.get('drawer');
            
            if (drawerId) {
                openDrawer(drawerId);
            }
        }

        // 初期化処理
        document.addEventListener('DOMContentLoaded', function() {
            initializeDrawers();
            checkUrlAndOpenDrawer();
            DrawerManager.loadSavedWidth();

            // フォームの初期化をシンプルに
            document.querySelectorAll('form[id^="support-type-form-"]').forEach(form => {
                FormManager.initialize(form);
            });
            

            // ESCキーでドロワーを閉じる処理はそのまま
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openDrawer = document.querySelector('.drawer-component:not(.translate-x-full)');
                    if (openDrawer) {
                        const id = openDrawer.id.replace('drawer-', '');
                        closeDrawer(id);
                    }
                }
            });

            // 新規作成フォームの初期化
            FormManager.initializeCreateForm();

            // バリデーションエラー時の処理
            FormManager.handleValidationError();
        });
    </script>
        
</x-app-layout>