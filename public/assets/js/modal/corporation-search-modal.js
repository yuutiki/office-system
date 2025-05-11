/**
 * 顧客検索モーダルを制御するオブジェクト
 * フォーカス管理、検索機能、結果表示の制御を行います
 */
const CorporationSearchModal = {
    // モーダルの状態管理
    state: {
        activeModalId: null,
        keydownHandler: null
    },

    // スタイル定義を集約し、再利用性を向上
    CLASSES: {
        ROW: [
            'hover:bg-blue-400',
            'focus:bg-blue-400',
            'focus:outline-none',
            'focus:ring-blue-500',
            'dark:text-white',
            'text-gray-900',
            'border-b-white',
            'cursor-pointer',
            'outline-gray-900',
            'outline-4',
            'whitespace-nowrap',
        ].join(' '),
        CELL: 'py-2 px-5',
        CELL_WIDE: 'w-96',
        CELL_NOWRAP: 'whitespace-nowrap',
        HEADER: 'py-3 px-5 whitespace-nowrap'
    },

    /**
     * モーダルを表示し、フォーカス管理を開始します
     */
    show: function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('overlay');

        if (!modal || !overlay) return;

        this.state.activeModalId = modalId;
        
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // フォーカス管理のためのキーボードイベントハンドラーを設定
        const handleKeydown = (e) => {
            if (e.key === 'Escape') {
                this.hide(modalId);
            }
            if (e.key === 'Tab') {
                e.preventDefault();
                const focusableElements = this.getFocusableElements(modal);
                const focused = document.activeElement;
                const index = focusableElements.indexOf(focused);
                let nextIndex = e.shiftKey ? index - 1 : index + 1;

                if (nextIndex < 0) nextIndex = focusableElements.length - 1;
                if (nextIndex >= focusableElements.length) nextIndex = 0;

                focusableElements[nextIndex].focus();
            }
        };

        modal.addEventListener('keydown', handleKeydown);
        this.state.keydownHandler = handleKeydown;

        // 最初の入力要素にフォーカスを設定
        const firstInput = modal.querySelector('input, select, button');
        if (firstInput) firstInput.focus();

        // ユーザードロップダウンの初期化
        // this.initializeUserDropdown(modalId);
    },

    /**
     * モーダルを非表示にします
     */
    hide: function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('overlay');

        if (!modal || !overlay) return;

        if (this.state.keydownHandler) {
            modal.removeEventListener('keydown', this.state.keydownHandler);
            this.state.keydownHandler = null;
        }
        
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    },

    /**
     * フォーカス可能な要素を取得します
     */
    getFocusableElements: function(modal) {
        const focusableSelectors = [
            'button:not([disabled])',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            'a[href]',
            '[tabindex="0"]',
            'tr[role="button"]'
        ].join(',');

        return Array.from(modal.querySelectorAll(focusableSelectors))
            .filter(element => {
                const style = window.getComputedStyle(element);
                const isVisible = style.display !== 'none' && 
                                style.visibility !== 'hidden' && 
                                style.opacity !== '0';
                const isContainedInVisibleParent = !element.closest('.hidden');
                return isVisible && isContainedInVisibleParent;
            });
    },

    /**
     * 検索を実行します
     */
    search: async function(modalId, screenId) {
        const modal = document.getElementById(modalId);
        const searchData = {
            corporation_name: modal.querySelector(`#${modalId}_corporation_name`).value,
            corporation_number: modal.querySelector(`#${modalId}_corporation_number`).value,
            // user_id: modal.querySelector(`#${modalId}_user_id`).value,
            screen_id: screenId
        };

        this.setLoadingState(modalId, true);

        try {
            const response = await fetch('/corporations/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(searchData)
            });

            const data = await response.json();
            this.updateResults(modalId, data.results, data.displayItems);
            document.getElementById(`${modalId}_count`).textContent = 
                data.results ? data.results.length : 0;

        } catch (error) {
            console.error('Search error:', error);
            const resultsContainer = document.getElementById(`${modalId}_results`);
            resultsContainer.innerHTML = `
                <tr>
                    <td colspan="100%" class="p-4 text-center text-red-600 dark:text-red-400">
                        検索中にエラーが発生しました。
                    </td>
                </tr>
            `;
        } finally {
            this.setLoadingState(modalId, false);
        }
    },

    /**
     * 検索ボタンのローディング状態を制御します
     */
    setLoadingState: function(modalId, isLoading) {
        const searchButton = document.querySelector(`#${modalId} button[onclick*="CorporationSearchModal.search"]`);
        
        if (!searchButton) {
            console.error('Search button not found');
            return;
        }

        searchButton.disabled = isLoading;
        searchButton.innerHTML = isLoading ? `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            検索中...
        ` : '検索';
    },

    /**
     * 検索条件をクリアします
     */
    clearSearch: function(modalId) {
        const modal = document.getElementById(modalId);
        const inputs = modal.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.value = '';
        });

        // document.getElementById(`${modalId}_selected_user_display`).textContent = '営業担当を選択';

        
        const firstInput = modal.querySelector('input, select');
        if (firstInput) firstInput.focus();
    },

    /**
     * 検索結果を更新します
     */
    updateResults: function(modalId, results, displayItems) {
        const headerContainer = document.getElementById(`${modalId}_headers`);
        const resultsContainer = document.getElementById(`${modalId}_results`);

        // ヘッダーの更新
        headerContainer.innerHTML = displayItems.map(item => 
            `<th class="${this.CLASSES.HEADER}">${item.display_name}</th>`
        ).join('');

        if (!results || results.length === 0) {
            resultsContainer.innerHTML = `
                <tr>
                    <td colspan="${displayItems.length}" class="p-4 text-center dark:text-gray-300 text-gray-700 whitespace-nowrap text-sm">
                        検索条件に合致する結果がありません。
                    </td>
                </tr>
            `;
            return;
        }

        // DocumentFragmentを使用してDOM操作を最適化
        const fragment = document.createDocumentFragment();

        results.forEach(result => {
            const row = document.createElement('tr');
            row.className = this.CLASSES.ROW;
            row.setAttribute('tabindex', '0');
            row.setAttribute('role', 'button');
            row.setAttribute('aria-label', `${result.corporation_name} を選択`);

            row.innerHTML = displayItems.map(item => {
                const cellClasses = [
                    this.CLASSES.CELL,
                    item.column_key === 'corporation_name' ? this.CLASSES.CELL_WIDE : '',
                    item.column_key !== 'corporation_name' ? this.CLASSES.CELL_NOWRAP : ''
                ].filter(Boolean).join(' ');

                return `<td class="${cellClasses}">${this.getNestedValue(result, item.column_key)}</td>`;
            }).join('');

            this.setupRowEventListeners(row, result, modalId);
            fragment.appendChild(row);
        });

        resultsContainer.innerHTML = '';
        resultsContainer.appendChild(fragment);

        // 最初の結果にフォーカスを設定
        requestAnimationFrame(() => {
            const firstRow = resultsContainer.querySelector('tr[role="button"]');
            if (firstRow) firstRow.focus();
        });
    },

    /**
     * ネストされたオブジェクトから値を取得します
     */
    getNestedValue: function(obj, path) {
        return path.split('.').reduce((current, key) => 
            current ? current[key] : '', obj);
    },

    /**
     * 行のイベントリスナーを設定します
     */
    setupRowEventListeners: function(row, result, modalId) {
        const handleSelect = () => {
            const callback = window[`${modalId}_onSelect`];
            if (typeof callback === 'function') {
                callback(result);
                this.hide(modalId);
            }
        };

        row.addEventListener('click', handleSelect);

        row.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handleSelect();
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                this.handleRowNavigation(e, row);
            }
        });
    },

    /**
     * 行のキーボードナビゲーションを処理します
     */
    handleRowNavigation: function(e, currentRow) {
        e.preventDefault();
        const rows = Array.from(currentRow.parentElement.querySelectorAll('tr[role="button"]'));
        const currentIndex = rows.indexOf(currentRow);
        
        let nextIndex;
        if (e.key === 'ArrowUp') {
            nextIndex = currentIndex > 0 ? currentIndex - 1 : rows.length - 1;
        } else {
            nextIndex = currentIndex < rows.length - 1 ? currentIndex + 1 : 0;
        }

        rows[nextIndex].focus();
    },

};