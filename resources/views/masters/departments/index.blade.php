<!-- resources/views/client/checkbox-options/index.blade.php -->
<x-app-layout>
    <div x-data="{ openHierarchyModal: false }" x-cloak>
        <x-slot name="header">
            <div class="flex items-center w-full">
                <h2 class="text-gray-900 dark:text-white">
                    {{ Breadcrumbs::render('departments') }}
                </h2>
                <div class="flex space-x-2 ml-auto">
                    <x-buttons.add-button :route="route('departments.create')" gate="storeUpdate_corporations" :text="__('Add')" />
                    <x-buttons.hierarchy-button onclick="openHierarchyModal()" :text="__('階層確認')" />
                </div>
            </div>
        </x-slot>
        
        <div class="relative bg-white dark:bg-gray-800 rounded md:w-auto md:ml-14 md:mr-2 m-auto shadow-md mt-4 mb-4">
            <div class="p-6">

                <div class="mb-4 flex items-center space-x-2">
                    <form method="GET" action="{{ route('departments.index') }}" class="flex items-center space-x-2">
                        <label for="level" class="text-gray-700 dark:text-gray-300">階層レベル:</label>
                        <select name="level" id="level" onchange="this.form.submit()"
                            class="border rounded p-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">すべて</option>
                            @foreach($levels as $l)
                                <option value="{{ $l }}" @selected((string)$l === (string)$level)>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-600 whitespace-nowrap">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">部門コード</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">部門名</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">階層</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">パス</th>
                                {{-- <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">親部門</th> --}}
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-gray-900 dark:text-gray-100">操作</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach($departments as $department)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="border border-gray-300 text-sm dark:border-gray-600 px-4 py-1.5 text-gray-900 dark:text-gray-100">{{ $department->code }}</td>
                                <td class="border border-gray-300 text-sm dark:border-gray-600 px-4 py-1.5 text-gray-900 dark:text-gray-100">{{ $department->name }}</td>
                                <td class="border border-gray-300 text-sm dark:border-gray-600 px-4 py-1.5 text-gray-900 dark:text-gray-100">{{ $department->level }}</td>
                                <td class="border border-gray-300 text-sm dark:border-gray-600 px-4 py-1.5 text-gray-900 dark:text-gray-100">{{ $department->path }}</td>
                                {{-- <td class="border border-gray-300 dark:border-gray-600 px-4 py-1.5 text-gray-900 dark:text-gray-100">{{ optional($department->parent)->name ?? '—' }}</td> --}}
                                <td class="border border-gray-300 dark:border-gray-600 px-4 py-1.5">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('departments.edit', $department->id) }}" 
                                        class="px-3 py-1 bg-green-600 dark:bg-green-500 text-white text-sm rounded hover:bg-green-700 dark:hover:bg-green-600 transition-colors">
                                            編集
                                        </a>
                                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-600 dark:bg-red-500 text-white text-sm rounded hover:bg-red-700 dark:hover:bg-red-600 transition-colors"
                                                    onclick="return confirm('この部門を削除してもよろしいですか？')">
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($departments->isEmpty())
                            <tr>
                                <td colspan="6" class="border border-gray-300 dark:border-gray-600 px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    部門が登録されていません
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 階層確認モーダル -->
        <div id="hierarchyModal"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
            style="display: none;"
            x-data
        >
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-3/4 h-[80vh] flex flex-col"
                onclick="event.stopPropagation()">

                <!-- ヘッダー -->
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">部門階層</h3>
                    <div class="flex space-x-2">
                        <button @click="$dispatch('expand-all', true)"
                                class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                            すべて展開
                        </button>
                        <button @click="$dispatch('expand-all', false)"
                                class="px-3 py-1 text-sm bg-gray-500 text-white rounded hover:bg-gray-600">
                            すべて閉じる
                        </button>
                        <button onclick="closeHierarchyModal()"
                                class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">✕</button>
                    </div>
                </div>

                <!-- 本体 -->
                <div class="flex-1 overflow-y-auto p-6">
                    <ul class="space-y-2">
                        @foreach($departmentTree->where('parent_id', null) as $root)
                            @include('masters.departments.partials.department-tree', ['department' => $root])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>




    <script>
        function openHierarchyModal() {
            document.getElementById('hierarchyModal').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // スクロール防止
        }

        function closeHierarchyModal() {
            document.getElementById('hierarchyModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // スクロール復元
        }

        // モーダル外クリックで閉じる
        document.getElementById('hierarchyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeHierarchyModal();
            }
        });

        // ESCキーで閉じる
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeHierarchyModal();
            }
        });

        // 部門ツリーの展開/収縮
        function toggleDepartment(button) {
            const ul = button.parentElement.nextElementSibling;
            const isOpen = ul.style.display !== 'none';
            
            ul.style.display = isOpen ? 'none' : 'block';
            button.innerHTML = isOpen ? '▶' : '▼';
        }
    </script>
</x-app-layout>