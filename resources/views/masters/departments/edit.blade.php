<!-- resources/views/departments/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center w-full">
            <h2 class="text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('editDepartment', $department) }}
            </h2>
            <div class="ml-auto flex justify-end space-x-2">
                <a href="{{ route('departments.index') }}" 
                   class="px-4 py-2 bg-gray-600 dark:bg-gray-500 text-white rounded hover:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                    キャンセル
                </a>
            </div>
        </div>
    </x-slot>

    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md mt-4">
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700 dark:text-red-300">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('departments.update', $department->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 部門コード -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            部門コード <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="code" 
                               name="code" 
                               value="{{ old('code', $department->code) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      @error('code') border-red-500 dark:border-red-400 @enderror"
                               required>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 部門名 -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            部門名 <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $department->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      @error('name') border-red-500 dark:border-red-400 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 親部門 -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        親部門
                    </label>
                    <select id="parent_id" 
                            name="parent_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   @error('parent_id') border-red-500 dark:border-red-400 @enderror">
                        <option value="">-- 親部門を選択 --</option>
                        @foreach($parentDepartments as $parent)
                            <option value="{{ $parent->id }}" 
                                    {{ old('parent_id', $department->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ str_repeat('　', $parent->level - 1) }}{{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 説明 -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        説明
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                     bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                     @error('description') border-red-500 dark:border-red-400 @enderror"
                              placeholder="部門の説明を入力してください">{{ old('description', $department->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 現在の階層情報（読み取り専用） -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">現在の部門情報</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">現在の階層:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $department->level }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">現在のパス:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $department->path }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">作成日:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $department->created_at->format('Y/m/d') }}</span>
                        </div>
                    </div>
                </div>

                <!-- ボタン -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <a href="{{ route('departments.index') }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 
                              rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        キャンセル
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-md 
                                   hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>