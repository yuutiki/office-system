/**
 * 顧客検索モーダルを制御するオブジェクト
 * フォーカス管理、検索機能、結果表示の制御を行います
 */
const ClientSearchModal = {
    // モーダルの状態管理
    state: {
        activeModalId: null,
        keydownHandler: null,
        initializedModals: new Set(), // 初期化済みモーダルを追跡
        dropdownHandlers: new Map()   // ドロップダウンハンドラーを管理
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

        // ユーザードロップダウンの初期化（重複を防ぐ）
        if (!this.state.initializedModals.has(modalId)) {
            this.initializeUserDropdown(modalId);
            this.state.initializedModals.add(modalId);
        } else {
            // 既に初期化済みの場合は状態をリセット
            this.resetDropdownState(modalId);
        }
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

        // ドロップダウン状態をリセット
        this.resetDropdownState(modalId);
        this.state.activeModalId = null;
    },

    /**
     * ドロップダウンの状態をリセット
     */
    resetDropdownState: function(modalId) {
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);
        
        if (dropdownMenu) {
            dropdownMenu.classList.add('hidden');
        }
        if (userSearch) {
            userSearch.value = '';
        }
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
            client_name: modal.querySelector(`#${modalId}_client_name`).value,
            client_number: modal.querySelector(`#${modalId}_client_number`).value,
            user_id: modal.querySelector(`#${modalId}_user_id`).value,
            screen_id: screenId
        };

        this.setLoadingState(modalId, true);

        try {
            const response = await fetch('/client/search', {
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
        const searchButton = document.querySelector(`#${modalId} button[onclick*="ClientSearchModal.search"]`);
        
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

        document.getElementById(`${modalId}_selected_user_display`).textContent = '営業担当を選択';

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
            row.setAttribute('aria-label', `${result.client_name} を選択`);

            row.innerHTML = displayItems.map(item => {
                const cellClasses = [
                    this.CLASSES.CELL,
                    item.column_key === 'client_name' ? this.CLASSES.CELL_WIDE : '',
                    item.column_key !== 'client_name' ? this.CLASSES.CELL_NOWRAP : ''
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

    /**
     * ユーザードロップダウンの初期化
     */
    initializeUserDropdown: function(modalId) {
        const dropdownToggle = document.getElementById(`${modalId}_dropdown_toggle`);
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);
        const userList = document.getElementById(`${modalId}_user_list`);
        const selectedUserDisplay = document.getElementById(`${modalId}_selected_user_display`);
        const selectedUserId = document.getElementById(`${modalId}_user_id`);

        if (!dropdownToggle || !dropdownMenu || !userSearch) {
            console.error('Required elements not found for modal:', modalId);
            return;
        }

        let debounceTimer = null;

        // 既存のハンドラーを削除（重複防止）
        this.removeDropdownHandlers(modalId);

        // ドロップダウンの表示/非表示
        const toggleHandler = () => {
            dropdownMenu.classList.toggle('hidden');
            if (!dropdownMenu.classList.contains('hidden')) {
                userSearch.focus();
                // ドロップダウンを開いたときに初期ユーザー一覧を取得
                this.fetchUsers(modalId);
            }
        };

        // ユーザー検索の入力処理
        const inputHandler = (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                this.fetchUsers(modalId, e.target.value);
            }, 300);
        };

        // フォーカス時のスタイル追加
        const focusHandler = () => {
            userSearch.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
        };

        const blurHandler = () => {
            userSearch.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
        };

        // 外部クリックでの閉じる処理
        const documentClickHandler = (e) => {
            if (this.state.activeModalId === modalId && 
                !dropdownToggle.contains(e.target) && 
                !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        };

        // イベントリスナーを追加
        dropdownToggle.addEventListener('click', toggleHandler);
        userSearch.addEventListener('input', inputHandler);
        userSearch.addEventListener('focus', focusHandler);
        userSearch.addEventListener('blur', blurHandler);
        document.addEventListener('click', documentClickHandler);

        // ハンドラーを保存（後で削除するため）
        this.state.dropdownHandlers.set(modalId, {
            dropdownToggle,
            userSearch,
            toggleHandler,
            inputHandler,
            focusHandler,
            blurHandler,
            documentClickHandler
        });
    },

    /**
     * ドロップダウンのイベントハンドラーを削除
     */
    removeDropdownHandlers: function(modalId) {
        const handlers = this.state.dropdownHandlers.get(modalId);
        if (handlers) {
            handlers.dropdownToggle.removeEventListener('click', handlers.toggleHandler);
            handlers.userSearch.removeEventListener('input', handlers.inputHandler);
            handlers.userSearch.removeEventListener('focus', handlers.focusHandler);
            handlers.userSearch.removeEventListener('blur', handlers.blurHandler);
            document.removeEventListener('click', handlers.documentClickHandler);
            this.state.dropdownHandlers.delete(modalId);
        }
    },

    /**
     * ユーザー検索を実行
     */
    fetchUsers: async function(modalId, searchTerm = '') {
        const userList = document.getElementById(`${modalId}_user_list`);
        
        try {
            const response = await fetch(`/search-users?user_name=${encodeURIComponent(searchTerm)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
    
            if (!response.ok) throw new Error('Network response was not ok');
            
            const users = await response.json();
            
            // ユーザーリストが空の場合、初期ユーザーを表示
            if (users.length === 0 && !searchTerm) {
                const initialUsers = await this.fetchInitialUsers(modalId);
                this.displayUsers(modalId, initialUsers);
            } else {
                this.displayUsers(modalId, users);
            }
        } catch (error) {
            console.error('Error fetching users:', error);
            if (userList) {
                userList.innerHTML = '<li class="px-4 py-2 text-red-500">エラーが発生しました</li>';
            }
        }
    },
    
    // 初期ユーザーを取得するための新しいメソッド
    fetchInitialUsers: async function(modalId) {
        try {
            const response = await fetch('/initial-users', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
    
            if (!response.ok) throw new Error('Network response was not ok');
            
            return await response.json();
        } catch (error) {
            console.error('Error fetching initial users:', error);
            return [];
        }
    },

    /**
     * ユーザー一覧を表示
     */
    displayUsers: function(modalId, users) {
        const userList = document.getElementById(`${modalId}_user_list`);
        if (!userList) return;
        
        userList.innerHTML = '';

        // 「選択を解除」オプションを最初に追加
        const clearOption = document.createElement('li');
        clearOption.tabIndex = 0;
        clearOption.className = 'px-4 py-2 hover:bg-red-50 cursor-pointer focus:bg-red-100 focus:text-red-600 focus:outline-none transition-colors duration-150 ease-in-out border-b border-gray-200 dark:border-gray-600';
        clearOption.setAttribute('role', 'option');
        clearOption.innerHTML = `
            <div class="flex items-center text-red-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="font-semibold">選択を解除</span>
            </div>
        `;

        clearOption.addEventListener('click', () => this.clearUserSelection(modalId));
        clearOption.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.clearUserSelection(modalId);
            }
        });


        userList.appendChild(clearOption);

        // 通常のユーザー一覧を追加
        users.forEach((user, index) => {
            const li = document.createElement('li');
            li.tabIndex = 0;
            li.className = 'px-4 py-2 hover:bg-blue-400 cursor-pointer focus:bg-blue-500 focus:text-white focus:outline-none transition-colors duration-150 ease-in-out';
            li.setAttribute('role', 'option');

            li.innerHTML = `
                <div class="font-semibold">${user.user_name}</div>
                <div class="text-sm">${user.email}</div>
            `;

            li.addEventListener('focus', () => {
                console.log('Focus received', user.user_name);
                // 強制的にスタイルを適用（デバッグ用）
                li.style.backgroundColor = '#3b82f6';
                li.style.color = 'white';
            });
        
            li.addEventListener('blur', () => {
                console.log('Focus lost', user.user_name);
                // スタイルを戻す
                li.style.backgroundColor = '';
                li.style.color = '';
            });

            li.addEventListener('click', () => this.selectUser(modalId, user));
            li.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.selectUser(modalId, user);
                }
            });

            userList.appendChild(li);
        });
    },

    /**
     * ユーザーを選択
     */
    selectUser: function(modalId, user) {
        const selectedUserDisplay = document.getElementById(`${modalId}_selected_user_display`);
        const selectedUserId = document.getElementById(`${modalId}_user_id`);
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);

        if (selectedUserDisplay) selectedUserDisplay.textContent = user.user_name;
        if (selectedUserId) selectedUserId.value = user.id;
        if (dropdownMenu) dropdownMenu.classList.add('hidden');
        if (userSearch) userSearch.value = '';
    },

    /**
     * 営業担当の選択を解除
     */
    clearUserSelection: function(modalId) {
        const selectedUserDisplay = document.getElementById(`${modalId}_selected_user_display`);
        const selectedUserId = document.getElementById(`${modalId}_user_id`);
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);

        if (selectedUserDisplay) {
            selectedUserDisplay.textContent = '営業担当を選択';
        }
        if (selectedUserId) {
            selectedUserId.value = '';
        }
        if (dropdownMenu) {
            dropdownMenu.classList.add('hidden');
        }
        if (userSearch) {
            userSearch.value = '';
        }
    },


    /**
     * 全てのモーダルを破棄（必要に応じて使用）
     */
    destroy: function() {
        // 全てのハンドラーを削除
        for (const modalId of this.state.dropdownHandlers.keys()) {
            this.removeDropdownHandlers(modalId);
        }
        this.state.initializedModals.clear();
        this.state.dropdownHandlers.clear();
    }
};