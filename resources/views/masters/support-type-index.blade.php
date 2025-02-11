<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('supportTypeMaster') }}
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md  dark:text-gray-900 mt-4">

        <div class="w-full">
            <!-- Start coding here -->
            <div class="relative bg-white dark:bg-gray-800">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="名称" required="">
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                        <button type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="pl-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            コード
                        </div>
                    </th>
                    <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            名称
                        </div>
                    </th>
                    {{-- <th scope="col" class="px-1 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            英名称
                        </div>
                    </th> --}}
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
                @foreach ($supportTypes as $supportType)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <td class="pl-4 py-2 whitespace-nowrap">
                            {{ $supportType->type_code }}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$supportType->type_name}}
                        </td>
                        {{-- <td class="px-1 py-2 whitespace-nowrap">
                            {{$supportType->projectType_eng_name}}
                        </td> --}}
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{ optional($supportType->updatedBy)->user_name }}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            {{$supportType->updated_at}}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                    </tr>
                        <!-- drawer component -->
                        <div id="drawer-{{$supportType->id}}" 
                            class="drawer-component fixed top-0 right-0 z-50 h-screen overflow-y-auto bg-white dark:bg-gray-600 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out"
                            style="min-width: 300px; width: min(30rem, 100vw); max-width: 100vw;">

                           
                           {{-- リサイズハンドル --}}
                           <div class="resize-handle absolute left-0 top-0 w-2 h-full cursor-col-resize bg-gray-200 hover:bg-blue-500 opacity-0 hover:opacity-100 transition-opacity"></div>
                       
                                                               {{-- ヘッダー部分 --}}

                       
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
                                            <button type="submit" class="justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded px-4 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">
                                                {{ __('update') }}
                                            </button>
                                            <button type="button" class="justify-center text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded px-4 py-1.5 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 inline-flex items-center">
                                                <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ __('delete') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-y-4 p-4">
                                        <div class="w-full">
                                            <label for="type_code-{{$supportType->id}}" class="block font-semibold dark:text-gray-100 text-gray-900 mb-1">
                                                コード
                                            </label>
                                            <input type="text" 
                                                    maxlength="2" 
                                                    name="type_code" 
                                                    id="type_code-{{$supportType->id}}" 
                                                    value="{{old('type_code',$supportType->type_code)}}" 
                                                    class="input-secondary" 
                                                    >
                                            @error('type_code')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="w-full">
                                            <label for="type_name-{{$supportType->id}}" class="block font-semibold dark:text-gray-100 text-gray-900 mb-1">
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
                                    </div>
                                </form>
                            </div>
                        </div>
                @endforeach
            </tbody>
        </table>
        <div class="mt-1 mb-1 px-4">
        {{ $supportTypes->withQueryString()->links('vendor.pagination.custum-tailwind') }}  
        </div> 
    </div>



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
    // フォームの初期化
    initialize(form) {
        this.setupFormChangeDetection(form);
        this.setupSubmitHandler(form);
        this.setupCloseButton(form);
    },

    // 入力変更の検知を設定
    setupFormChangeDetection(form) {
        const inputs = Array.from(form.elements).filter(element => 
            element.tagName.toLowerCase() === 'input' &&
            !['hidden', 'submit'].includes(element.type)
        );

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                form.dataset.isChanged = 'true';
            });
        });
    },

    // フォーム送信時の処理
    setupSubmitHandler(form) {
        form.addEventListener('submit', () => {
            form.dataset.isChanged = 'false';
            form.dataset.submitting = 'true';
        });
    },

    // クローズボタンの設定
    setupCloseButton(form) {
        const closeButton = form.querySelector('button[data-drawer-id]');
        if (closeButton) {
            closeButton.addEventListener('click', (e) => {
                e.preventDefault();
                const drawerId = closeButton.dataset.drawerId;
                
                if (this.shouldConfirmClose(form)) {
                    if (confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
                        form.reset();
                        closeDrawer(drawerId);
                    }
                } else {
                    closeDrawer(drawerId);
                }
            });
        }
    },

    // 閉じる前の確認が必要かどうかを判定
    shouldConfirmClose(form) {
        return form.dataset.isChanged === 'true' && !form.dataset.submitting;
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

    // 変更があれば確認
    if (form && FormManager.shouldConfirmClose(form)) {
        if (!confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
            return;
        }
        form.reset();
    }

    if (drawer) {
        drawer.classList.add('translate-x-full');
        overlay.classList.add('opacity-0');
        overlay.classList.remove('opacity-100');
        
        setTimeout(() => {
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);

        if (form) {
            form.dataset.isChanged = 'false';
            form.dataset.submitting = 'false';
        }

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

    // 各フォームの初期化
    document.querySelectorAll('form[id^="support-type-form-"]').forEach(form => {
        FormManager.initialize(form);
    });

    // ESCキーでドロワーを閉じる
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openDrawer = document.querySelector('.drawer-component:not(.translate-x-full)');
            if (openDrawer) {
                const id = openDrawer.id.replace('drawer-', '');
                closeDrawer(id);
            }
        }
    });
});
        </script>
        
</x-app-layout>