{{-- @if ($paginator->hasPages()) --}}
    <div class="pagination-component flex items-center justify-between py-0.5 px-1 rounded shadow-sm relative overflow-visible">
        <div class="flex items-center space-x-2">
            <!-- 前のページボタン -->
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" 
                      class="relative inline-flex items-center px-1.5 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-300 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 cursor-not-allowed rounded transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    rel="prev" 
                    class="pagination-prev relative inline-flex items-center px-1.5 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 active:bg-gray-100 dark:active:bg-gray-600 transition-all duration-200 shadow-sm group" 
                    aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="absolute bottom-full left-3/4 transform -translate-x-1/2 ml-2 mb-2 px-3 py-3 text-xs font-medium text-white bg-gray-900 dark:bg-gray-600 rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                        Ctrl + ←
                    </span>
                </a>
            @endif
            
            <!-- ページ番号入力フィールド -->
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded h-[34px] px-2 shadow-sm">
                <input type="number" 
                       class="pagination-page-input w-10 text-center text-sm font-semibold h-[28px] text-gray-900 dark:text-gray-100 border-0 focus:outline-none focus:ring-0 bg-transparent" 
                       min="1" 
                       max="{{ $paginator->lastPage() }}" 
                       value="{{ $paginator->currentPage() }}" 
                       data-max-page="{{ $paginator->lastPage() }}"
                       data-current-page="{{ $paginator->currentPage() }}"
                       placeholder="{{ $paginator->currentPage() }}">
                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">/</span>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 min-w-0">{{ $paginator->lastPage() }}</span>
            </div>
            
            <!-- 次のページボタン -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="pagination-next relative inline-flex items-center px-1.5 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 active:bg-gray-100 dark:active:bg-gray-600 transition-all duration-200 shadow-sm group" 
                    aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="absolute bottom-full left-3/4 transform -translate-x-1/2 ml-1 mb-2 px-3 py-3 text-xs font-medium text-white bg-gray-900 dark:bg-gray-600 rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                        Ctrl + →
                    </span>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}"
                      class="relative inline-flex items-center px-1.5 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-300 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 cursor-not-allowed rounded transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
            
            <!-- 件数表示 -->
            <div class="flex items-center space-x-2 text-sm text-gray-800 dark:text-gray-200 rounded border border-gray-300 dark:border-gray-600 py-1.5 px-2 bg-white dark:bg-gray-800">
                <span class="font-medium">{{ number_format($paginator->total()) }}</span>
                <span>件</span>
            </div>
            
            <!-- 表示範囲 -->
            {{-- <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <span>{{ number_format($paginator->firstItem()) }}</span>
                <span>-</span>
                <span>{{ number_format($paginator->lastItem()) }}</span>
                <span>を表示</span>
            </div> --}}
            
            <!-- 表示件数選択 -->
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded shadow-sm">
                <div class="relative">
                    <select class="pagination-per-page appearance-none bg-transparent border-0 rounded-l px-3 py-1.5 pr-8 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 cursor-pointer transition-all duration-200">
                        @foreach(config('pagination.allowed_per_page', [20, 50, 100, 500]) as $option)
                            <option value="{{ $option }}" {{ request('per_page', config('pagination.default_per_page', 20)) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <span class="px-2 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 border-l border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">行</span>
            </div>
        </div>
    </div>
    
    <style>
    /* ツールチップのz-indexを確保 */
    .pagination-component {
        position: relative;
    }
    
    .pagination-component a.group {
        position: relative;
    }
    
    /* Chrome、Safari、Edge、Opera でスピンボタンを非表示 */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Firefox でスピンボタンを非表示 */
    input[type=number] {
        -moz-appearance: textfield;
    }
    
    /* ページ入力フィールドのフォーカススタイル */
    .pagination-page-input:focus {
        background-color: #eff6ff;
        box-shadow: 0 0 0 2px #3b82f6;
        border-radius: 4px;
    }
    
    /* ダークモード時のフォーカススタイル */
    @media (prefers-color-scheme: dark) {
        .pagination-page-input:focus {
            background-color: #1e3a8a;
            box-shadow: 0 0 0 2px #60a5fa;
        }
    }
    
    /* セレクトボックスのオプションスタイル（ダークモード対応） */
    @media (prefers-color-scheme: dark) {
        select option {
            background-color: #374151;
            color: #e5e7eb;
        }
        
        select option:hover,
        select option:focus {
            background-color: #4b5563;
        }
    }
    
    /* レスポンシブ対応 */
    @media (max-width: 640px) {
        .flex.items-center.space-x-6 {
            flex-wrap: wrap;
            gap: 0.75rem;
        }
    }
    </style>
    
    <script>
    // ページネーションの初期化を一度だけ実行
    if (!window.paginationInitialized) {
        window.paginationInitialized = true;
        
        // DOMが読み込まれてから実行
        document.addEventListener('DOMContentLoaded', function() {
            // すべてのページネーションコンポーネントを初期化
            initializePaginations();
        });
        
        function initializePaginations() {
            // すべてのページネーションコンポーネントを取得
            const paginationComponents = document.querySelectorAll('.pagination-component');
            
            paginationComponents.forEach(function(component, index) {
                // 各コンポーネントに固有のIDを設定
                const uniqueId = 'pagination_' + index;
                component.setAttribute('data-pagination-id', uniqueId);
                
                // ページ入力フィールドの初期化
                const pageInput = component.querySelector('.pagination-page-input');
                if (pageInput) {
                    // 入力イベント
                    pageInput.addEventListener('keypress', function(event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            handlePageChange(this);
                        }
                    });
                    
                    // フォーカス時に全選択
                    pageInput.addEventListener('focus', function() {
                        this.select();
                    });
                    
                    // 入力値のバリデーション
                    pageInput.addEventListener('input', function() {
                        validatePageInput(this);
                    });
                    
                    // フォーカスが外れた時
                    pageInput.addEventListener('blur', function() {
                        handlePageChange(this);
                    });
                }
                
                // 表示件数セレクトボックスの初期化
                const perPageSelect = component.querySelector('.pagination-per-page');
                if (perPageSelect) {
                    perPageSelect.addEventListener('change', function() {
                        handlePerPageChange(this);
                    });
                }
            });
        }
        
        // ページ番号の検証
        function validatePageInput(input) {
            const value = parseInt(input.value);
            const maxPage = parseInt(input.getAttribute('data-max-page'));
            
            if (value > maxPage) {
                input.value = maxPage;
            } else if (value < 1 && input.value !== '') {
                input.value = 1;
            }
        }
        
        // ページ変更処理
        function handlePageChange(input) {
            const pageNum = parseInt(input.value);
            const maxPage = parseInt(input.getAttribute('data-max-page'));
            const currentPage = parseInt(input.getAttribute('data-current-page'));
            
            // バリデーション
            if (isNaN(pageNum) || pageNum < 1 || pageNum > maxPage) {
                input.value = currentPage;
                return;
            }
            
            // 現在のページと同じ場合は何もしない
            if (pageNum === currentPage) {
                return;
            }
            
            // ページ移動
            const url = new URL(window.location);
            url.searchParams.set('page', pageNum);
            window.location.href = url.toString();
        }
        
        // 表示件数変更処理
        function handlePerPageChange(select) {
            // ローディング状態
            select.disabled = true;
            select.style.opacity = '0.6';
            
            const url = new URL(window.location);
            url.searchParams.set('per_page', select.value);
            url.searchParams.set('page', 1);
            
            window.location.href = url.toString();
        }
        
        // キーボードショートカット
        document.addEventListener('keydown', function(event) {
            // Ctrl + 左矢印で前のページ
            if (event.ctrlKey && event.key === 'ArrowLeft') {
                const prevLink = document.querySelector('.pagination-prev');
                if (prevLink && prevLink.tagName === 'A') {
                    event.preventDefault();
                    window.location.href = prevLink.href;
                }
            }
            
            // Ctrl + 右矢印で次のページ
            if (event.ctrlKey && event.key === 'ArrowRight') {
                const nextLink = document.querySelector('.pagination-next');
                if (nextLink && nextLink.tagName === 'A') {
                    event.preventDefault();
                    window.location.href = nextLink.href;
                }
            }
        });
    }
    </script>
{{-- @endif --}}