@props([
    'modalId' => 'deleteModal',
    'target' => 'default',  {{-- cancelButtonのsuffixに使う --}}
    'action',
    'countId' => 'modalSelectedCount',
    'confirmText' => '削除する',
    'cancelText' => 'キャンセル',
    'message' => '件を本当に削除しますか？',
])

<div id="{{ $modalId }}"
     tabindex="-1"
     aria-hidden="true"
     class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 overflow-y-auto">

    <div class="w-full max-w-md rounded shadow bg-white dark:bg-gray-700">
        <div class="p-6 text-center space-y-6">

            <!-- アイコン -->
            <x-icon name="ui/modal-alert"
                    class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" />

            <!-- メッセージ -->
            <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">
                <span id="{{ $countId }}">0</span> {{ $message }}
            </h3>

            <!-- ボタン群 -->
            <div class="flex justify-center gap-2">
                <form method="POST" action="{{ $action }}">
                    @csrf
                    <button type="submit"
                            data-modal-hide="{{ $modalId }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-red-700 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        {{ $confirmText }}
                    </button>
                </form>

                <button id="cancelButton-{{ $target }}"
                        data-modal-hide="{{ $modalId }}"
                        type="button"
                        class="px-5 py-2.5 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-offset-gray-800">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- モーダル初期化スクリプト --}}
@once
    <script type="module">
        import { setupDeleteModal } from "{{ Vite::asset('resources/js/components/modals/delete-modal.js') }}";
        document.addEventListener('DOMContentLoaded', () => {
            setupDeleteModal('{{ $modalId }}', '{{ $target }}');
        });
    </script>
@endonce
