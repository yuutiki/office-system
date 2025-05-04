<!-- resources/views/client/checkbox-options/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex">
                {{-- {{ Breadcrumbs::render('supportTimeMaster') }} --}}
                チェックボックスオプション管理
                <div class="ml-4">
                    {{-- {{ $count }}件 --}}
                </div>
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
                <x-buttons.save-button onclick="location.href='{{ route('client-contacts.checkbox-options.create') }}'">
                    {{ __('create') }}
                </x-buttons.save-button>
            </div>
        </div>
    </x-slot>

    <div class="md:w-auto md:ml-14 md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left uppercase whitespace-nowrap">
                        表示順
                    </th>
                    <th class="px-6 py-3 text-left uppercase whitespace-nowrap">
                        識別名
                    </th>
                    <th class="px-6 py-3 text-left uppercase whitespace-nowrap">
                        表示名
                    </th>
                    <th class="px-6 py-3 text-left uppercase whitespace-nowrap">
                        状態
                    </th>
                    <th class="px-6 py-3 text-left uppercase whitespace-nowrap">
                        操作
                    </th>
                </tr>
            </thead>
            <tbody id="sortable-list" class="bg-white divide-y divide-gray-200">
                @foreach ($checkboxOptions as $option)
                    <tr data-id="{{ $option->id }}" class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="handle px-2 py-1 bg-gray-200 dark:bg-gray-500 rounded cursor-grab">
                                <i class="fas fa-grip-lines"></i> {{ $option->display_order }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $option->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $option->label }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($option->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded">
                                    有効
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded">
                                    無効
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('client-contacts.checkbox-options.edit', $option) }}" class="text-indigo-600 hover:text-indigo-900">
                                    編集
                                </a>
                                <form action="{{ route('client-contacts.checkbox-options.toggle-active', $option) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $option->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                        {{ $option->is_active ? '無効化' : '有効化' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("#sortable-list").sortable({
                handle: ".handle",
                update: function(event, ui) {
                    const ids = $(this).sortable('toArray', { attribute: 'data-id' });
                    
                    $.ajax({
                        url: "{{ route('client-contacts.checkbox-options.update-order') }}",
                        method: "POST",
                        data: {
                            ids: ids,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>