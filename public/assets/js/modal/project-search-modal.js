/**
 * プロジェクト検索モーダルを制御するオブジェクト
 * 検索、フォーカス管理、結果表示などの機能を提供します
 */
const ProjectSearchModal = {
    // モーダルの状態を管理するオブジェクト
    state: {
        activeModalId: null,
        keydownHandler: null,
        lastSearchParams: null
    },

    // スタイル定義を集約し、再利用性を向上
    CLASSES: {
        ROW: [
            'dark:border-gray-600',
            'hover:bg-blue-400',
            'focus:bg-blue-400',
            'focus:outline-none',
            'focus:ring-blue-500',
            'dark:text-white',
            'text-gray-900',
            'border-b-white',
            'cursor-pointer',
            'border',
            'whitespace-nowrap',
        ].join(' '),
        CELL: 'py-2 px-5',
        CELL_WIDE: 'w-96',
        CELL_NOWRAP: 'whitespace-nowrap',
        HEADER: 'py-3 px-5 whitespace-nowrap',
        DROPDOWN_ITEM: [
            'px-4',
            'py-2',
            'hover:bg-blue-400',
            'cursor-pointer',
            'focus:bg-blue-500',
            'focus:text-white',
            'focus:outline-none',
            'transition-colors',
            'duration-150',
            'ease-in-out'
        ].join(' ')
    },

    // プロジェクトのステータス定義
    // STATUS_LIST: [
    //     { id: 'planning', name: '計画中' },
    //     { id: 'in_progress', name: '進行中' },
    //     { id: 'completed', name: '完了' },
    //     { id: 'on_hold', name: '保留中' }
    // ],

    /**
     * モーダルを表示し、初期化処理を行います
     * @param {string} modalId - モーダルのID
     */
    show: function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('overlay');

        if (!modal || !overlay) {
            console.error('Modal or overlay elements not found');
            return;
        }

        this.state.activeModalId = modalId;
        
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // キーボードイベントハンドラーの設定
        this.setupKeyboardHandler(modal);

        // 最初の入力要素にフォーカスを設定
        const firstInput = modal.querySelector('input, select, button');
        if (firstInput) firstInput.focus();

        // 各種ドロップダウンの初期化
        this.initializeDropdowns(modalId);

        // 前回の検索パラメータがあれば、検索を実行
        if (this.state.lastSearchParams) {
            this.search(modalId, this.state.lastSearchParams.screenId);
        }
    },

    /**
     * キーボードイベントハンドラーを設定します
     * @param {HTMLElement} modal - モーダル要素
     */
    setupKeyboardHandler: function(modal) {
        const handleKeydown = (e) => {
            if (e.key === 'Escape') {
                this.hide(this.state.activeModalId);
            }
            if (e.key === 'Tab') {
                e.preventDefault();
                this.handleTabNavigation(e, modal);
            }
        };

        modal.addEventListener('keydown', handleKeydown);
        this.state.keydownHandler = handleKeydown;
    },

    /**
     * Tabキーによるナビゲーションを処理します
     * @param {Event} e - キーボードイベント
     * @param {HTMLElement} modal - モーダル要素
     */
    handleTabNavigation: function(e, modal) {
        const focusableElements = this.getFocusableElements(modal);
        const focused = document.activeElement;
        const index = focusableElements.indexOf(focused);
        let nextIndex = e.shiftKey ? index - 1 : index + 1;

        if (nextIndex < 0) nextIndex = focusableElements.length - 1;
        if (nextIndex >= focusableElements.length) nextIndex = 0;

        focusableElements[nextIndex].focus();
    },

    /**
     * モーダルを非表示にします
     * @param {string} modalId - モーダルのID
     */
    hide: function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('overlay');

        if (!modal || !overlay) return;

        // イベントリスナーのクリーンアップ
        if (this.state.keydownHandler) {
            modal.removeEventListener('keydown', this.state.keydownHandler);
            this.state.keydownHandler = null;
        }
        
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // ドロップダウンメニューを閉じる
        this.closeAllDropdowns(modalId);
    },

    /**
     * フォーカス可能な要素を取得します
     * @param {HTMLElement} modal - モーダル要素
     * @returns {Array<HTMLElement>} フォーカス可能な要素の配列
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
                return style.display !== 'none' && 
                       style.visibility !== 'hidden' && 
                       style.opacity !== '0' &&
                       !element.closest('.hidden');
            });
    },

    /**
     * ドロップダウンの初期化処理を行います
     * @param {string} modalId - モーダルのID
     */
    initializeDropdowns: function(modalId) {
        this.initializeStatusDropdown(modalId);
        this.initializeUserDropdown(modalId);
    },

    /**
     * ステータスドロップダウンを初期化します
     * @param {string} modalId - モーダルのID
     */
    initializeStatusDropdown: function(modalId) {
        const dropdownToggle = document.getElementById(`${modalId}_status_dropdown_toggle`);
        const dropdownMenu = document.getElementById(`${modalId}_status_dropdown_menu`);
        const statusList = document.getElementById(`${modalId}_status_list`);

        if (!dropdownToggle || !dropdownMenu || !statusList) return;

        // トグルボタンのクリックイベント
        dropdownToggle.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
            dropdownToggle.setAttribute('aria-expanded', 
                dropdownMenu.classList.contains('hidden') ? 'false' : 'true'
            );
        });

        // ステータスリストの生成
        // statusList.innerHTML = this.STATUS_LIST.map(status => `
        //     <li class="${this.CLASSES.DROPDOWN_ITEM}"
        //         role="option"
        //         tabindex="0"
        //         data-value="${status.id}">
        //         ${status.name}
        //     </li>
        // `).join('');

        // 各ステータス項目のイベント設定
        statusList.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', () => {
                this.selectStatus(modalId, {
                    id: li.dataset.value,
                    name: li.textContent.trim()
                });
            });

            li.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    li.click();
                }
            });
        });

        // 外部クリックでの閉じる処理
        document.addEventListener('click', (e) => {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownToggle.setAttribute('aria-expanded', 'false');
            }
        });
    },

    /**
     * ユーザードロップダウンを初期化します
     * @param {string} modalId - モーダルのID
     */
    initializeUserDropdown: function(modalId) {
        const dropdownToggle = document.getElementById(`${modalId}_dropdown_toggle`);
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);

        if (!dropdownToggle || !dropdownMenu || !userSearch) return;

        let debounceTimer = null;

        // トグルボタンのクリックイベント
        dropdownToggle.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
            dropdownToggle.setAttribute('aria-expanded', 
                dropdownMenu.classList.contains('hidden') ? 'false' : 'true'
            );
            if (!dropdownMenu.classList.contains('hidden')) {
                userSearch.focus();
                this.fetchUsers(modalId);
            }
        });

        // ユーザー検索の入力処理
        userSearch.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                this.fetchUsers(modalId, e.target.value);
            }, 300);
        });

        // フォーカス時のスタイル
        userSearch.addEventListener('focus', () => {
            userSearch.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
        });

        userSearch.addEventListener('blur', () => {
            userSearch.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
        });

        // 外部クリックでの閉じる処理
        document.addEventListener('click', (e) => {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownToggle.setAttribute('aria-expanded', 'false');
            }
        });
    },

    /**
     * ユーザー検索を実行します
     * @param {string} modalId - モーダルのID
     * @param {string} searchTerm - 検索キーワード
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
            
            if (users.length === 0 && !searchTerm) {
                const initialUsers = await this.fetchInitialUsers();
                this.displayUsers(modalId, initialUsers);
            } else {
                this.displayUsers(modalId, users);
            }
        } catch (error) {
            console.error('Error fetching users:', error);
            userList.innerHTML = `
                <li class="px-4 py-2 text-red-500">
                    エラーが発生しました
                </li>
            `;
        }
    },

    /**
     * 初期ユーザー一覧を取得します
     * @returns {Promise<Array>} ユーザー一覧
     */
    fetchInitialUsers: async function() {
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
     * プロジェクト検索を実行します
     * @param {string} modalId - モーダルのID
     * @param {string} screenId - 画面ID
     */
    search: async function(modalId, screenId) {
        const modal = document.getElementById(modalId);
        const searchData = {
            project_name: modal.querySelector(`#${modalId}_project_name`).value,
            project_num: modal.querySelector(`#${modalId}_project_num`).value,
            client_name: modal.querySelector(`#${modalId}_client_name`).value,
            user_id: modal.querySelector(`#${modalId}_user_id`).value,
            screen_id: screenId
        };

        // 検索パラメータを保存
        this.state.lastSearchParams = { ...searchData };

        this.setLoadingState(modalId, true);

        try {
            const response = await fetch('/projects/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(searchData)
            });

            if (!response.ok) throw new Error('Network response was not ok');

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
     * @param {string} modalId - モーダルのID
     * @param {boolean} isLoading - ローディング状態
     */
    setLoadingState: function(modalId, isLoading) {
        const searchButton = document.querySelector(`#${modalId} button[onclick*="ProjectSearchModal.search"]`);
        
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
     * @param {string} modalId - モーダルのID
     */
    clearSearch: function(modalId) {
        const modal = document.getElementById(modalId);
        const inputs = modal.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.value = '';
        });

        // ステータスと担当者の表示をリセット
        // document.getElementById(`${modalId}_selected_status_display`).textContent = 'ステータスを選択';
        document.getElementById(`${modalId}_selected_user_display`).textContent = '営業担当を選択';
        
        // 結果表示もクリア
        const resultsContainer = document.getElementById(`${modalId}_results`);
        resultsContainer.innerHTML = '';
        document.getElementById(`${modalId}_count`).textContent = '0';
        
        // 最初の入力フィールドにフォーカス
        const firstInput = modal.querySelector('input, select');
        if (firstInput) firstInput.focus();

        // 保存された検索パラメータをクリア
        this.state.lastSearchParams = null;
    },

    /**
     * 検索結果を更新します
     * @param {string} modalId - モーダルのID
     * @param {Array} results - 検索結果
     * @param {Array} displayItems - 表示項目定義
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
            row.setAttribute('aria-label', `${result.project_name} を選択`);

            row.innerHTML = displayItems.map(item => {
                const cellClasses = [
                    this.CLASSES.CELL,
                    item.column_key === 'project_name' ? this.CLASSES.CELL_WIDE : '',
                    item.column_key !== 'project_name' ? this.CLASSES.CELL_NOWRAP : ''
                ].filter(Boolean).join(' ');

                const value = this.getNestedValue(result, item.column_key);
                // ステータスの場合は表示名に変換
                const displayValue = item.column_key === 'status' ? 
                    this.getStatusDisplayName(value) : value;

                return `<td class="${cellClasses}">${displayValue}</td>`;
            }).join('');

            this.setupRowEventListeners(row, result, modalId);
            fragment.appendChild(row);
        });

        resultsContainer.innerHTML = '';
        resultsContainer.appendChild(fragment);

        // 最初の結果行にフォーカスを設定
        requestAnimationFrame(() => {
            const firstRow = resultsContainer.querySelector('tr[role="button"]');
            if (firstRow) firstRow.focus();
        });
    },

    /**
     * ステータスのIDから表示名を取得します
     * @param {string} statusId - ステータスID
     * @returns {string} ステータスの表示名
     */
    // getStatusDisplayName: function(statusId) {
    //     const status = this.STATUS_LIST.find(s => s.id === statusId);
    //     return status ? status.name : statusId;
    // },

    /**
     * ネストされたオブジェクトから値を取得します
     * @param {Object} obj - 対象オブジェクト
     * @param {string} path - プロパティパス（例: 'user.name'）
     * @returns {*} 取得した値
     */
    getNestedValue: function(obj, path) {
        return path.split('.').reduce((current, key) => 
            current ? current[key] : '', obj);
    },

    /**
     * 行のイベントリスナーを設定します
     * @param {HTMLElement} row - 行要素
     * @param {Object} result - 行のデータ
     * @param {string} modalId - モーダルのID
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
     * @param {Event} e - キーボードイベント
     * @param {HTMLElement} currentRow - 現在の行要素
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
     * ユーザー一覧を表示します
     * @param {string} modalId - モーダルのID
     * @param {Array} users - ユーザー一覧
     */
    displayUsers: function(modalId, users) {
        const userList = document.getElementById(`${modalId}_user_list`);
        userList.innerHTML = '';

        users.forEach(user => {
            const li = document.createElement('li');
            li.className = this.CLASSES.DROPDOWN_ITEM;
            li.tabIndex = 0;
            li.setAttribute('role', 'option');

            li.innerHTML = `
                <div class="font-semibold">${user.user_name}</div>
                <div class="text-sm text-gray-600">${user.email}</div>
            `;

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
     * ユーザーを選択します
     * @param {string} modalId - モーダルのID
     * @param {Object} user - 選択されたユーザー
     */
    selectUser: function(modalId, user) {
        const selectedUserDisplay = document.getElementById(`${modalId}_selected_user_display`);
        const selectedUserId = document.getElementById(`${modalId}_user_id`);
        const dropdownMenu = document.getElementById(`${modalId}_user_dropdown_menu`);
        const userSearch = document.getElementById(`${modalId}_user_search`);

        selectedUserDisplay.textContent = user.user_name;
        selectedUserId.value = user.id;
        dropdownMenu.classList.add('hidden');
        userSearch.value = '';
    },

    /**
     * ステータスを選択します
     * @param {string} modalId - モーダルのID
     * @param {Object} status - 選択されたステータス
     */
    selectStatus: function(modalId, status) {
        const selectedStatusDisplay = document.getElementById(`${modalId}_selected_status_display`);
        const selectedStatus = document.getElementById(`${modalId}_status`);
        const dropdownMenu = document.getElementById(`${modalId}_status_dropdown_menu`);
        
        selectedStatusDisplay.textContent = status.name;
        selectedStatus.value = status.id;
        dropdownMenu.classList.add('hidden');
    },

    /**
     * すべてのドロップダウンを閉じます
     * @param {string} modalId - モーダルのID
     */
    closeAllDropdowns: function(modalId) {
        const dropdowns = document.querySelectorAll(`#${modalId} [id$="_dropdown_menu"]`);
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
};

// グローバルスコープで利用可能にする
window.ProjectSearchModal = ProjectSearchModal;