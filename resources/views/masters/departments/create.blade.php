<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center w-full">
            <h2 class="text-gray-900 dark:text-white">
                {{ Breadcrumbs::render('createDepartment') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full sm:w-3/4 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                {{-- エラーメッセージ --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-100 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('departments.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- 部門コード --}}
                    <div>
                        <label for="code" class="block mb-1 font-semibold dark:text-gray-100">部門コード</label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            value="{{ old('code') }}"
                            maxlength="{{ $settings->code_length }}"
                            class="w-full border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    {{-- 部門名 --}}
                    <div>
                        <label for="name" class="block mb-1 font-semibold dark:text-gray-100">部門名</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            maxlength="100"
                            class="w-full border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    {{-- 親部門 --}}
                    <div>
                        <label for="parent_id" class="block mb-1 font-semibold dark:text-gray-100">親部門</label>
                        <select
                            id="parent_id"
                            name="parent_id"
                            class="w-full border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">なし（トップレベル）</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('parent_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->path }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 有効フラグ --}}
                    <div class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', 1) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="is_active" class="dark:text-gray-100">有効</label>
                    </div>

                    {{-- ボタン --}}
                    <div class="mt-4 flex items-center space-x-4">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            登録
                        </button>
                        <a href="{{ route('departments.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline">
                            戻る
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
