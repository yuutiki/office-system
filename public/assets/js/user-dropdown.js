/**
 * ユーザードロップダウン検索機能
 * このスクリプトは、ユーザー検索ドロップダウンの機能を制御します。
 * ユーザーの検索、選択、表示を管理します。
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM要素の参照を保持
    const DOM = {
        dropdownToggle: document.getElementById('dropdown-toggle'),
        dropdownMenu: document.getElementById('dropdown-menu'),
        userSearch: document.getElementById('user-search'),
        userList: document.getElementById('user-list'),
        selectedUserDisplay: document.getElementById('selected-user-display'),
        selectedUserId: document.getElementById('selected-user-id')
    };

    // アプリケーションの状態を管理
    const STATE = {
        debounceTimer: null
    };

    // 使用するCSSクラス名を定義
    const CLASSES = {
        hidden: 'hidden',
        listItem: 'px-4 py-2 hover:bg-blue-400 cursor-pointer focus:bg-blue-500 focus:text-white transition-colors duration-150 ease-in-out',
        clearItem: 'px-4 py-2 hover:bg-red-400 cursor-pointer focus:bg-red-500 focus:text-white transition-colors duration-150 ease-in-out border-b border-gray-300 dark:border-gray-600',
        userName: 'font-semibold',
    };

    /**
     * ドロップダウンメニューの表示/非表示を切り替える
     */
    function toggleDropdown() {
        DOM.dropdownMenu.classList.toggle(CLASSES.hidden);
        if (!DOM.dropdownMenu.classList.contains(CLASSES.hidden)) {
            DOM.userSearch.focus();
        }
    }

    /**
     * ドロップダウンメニューを閉じる
     */
    function closeDropdown() {
        DOM.dropdownMenu.classList.add(CLASSES.hidden);
    }

    /**
     * 選択解除オプションを作成する
     * @returns {HTMLElement} 作成された選択解除アイテム要素
     */
    function createClearOption() {
        const li = document.createElement('li');
        li.tabIndex = 0;
        li.className = CLASSES.clearItem;
        li.setAttribute('role', 'option');
        li.setAttribute('data-clear', 'true');

        // デバッグ用：フォーカス時の状態を確認
        li.addEventListener('focus', () => {
            console.log('Focus received on clear option');
            li.style.backgroundColor = '#ef4444';
            li.style.color = 'white';
        });

        li.addEventListener('blur', () => {
            console.log('Focus lost on clear option');
            li.style.backgroundColor = '';
            li.style.color = '';
        });

        li.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                clearUserSelection();
            }
        });

        li.innerHTML = `
            <div class="flex items-center">
                <svg class="h-4 w-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="text-red-600 dark:text-red-400">選択を解除</span>
            </div>
        `;

        li.addEventListener('click', clearUserSelection);
        return li;
    }

    /**
     * ユーザーリストアイテムを作成する
     * @param {Object} user - ユーザー情報オブジェクト
     * @param {boolean} isLastItem - 最後のアイテムかどうか
     * @returns {HTMLElement} 作成されたリストアイテム要素
     */
    function createUserListItem(user, isLastItem) {
        const li = document.createElement('li');
        li.tabIndex = 0;
        li.className = CLASSES.listItem;
        li.setAttribute('role', 'option');

        // デバッグ用：フォーカス時の状態を確認
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

        // 最後の要素の場合、Tabキーをトラップする
        if (isLastItem) {
            li.addEventListener('keydown', (e) => {
                if (e.key === 'Tab' && !e.shiftKey) {
                    e.preventDefault();  // Tabキーのデフォルトの動作を防ぐ
                }
                if (e.key === 'Enter') {
                    selectUser(user);
                }
            });
        } else {
            li.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    selectUser(user);
                }
            });
        }

        li.innerHTML = `
            <div>
                <div class="${CLASSES.userName}">${user.user_name}</div>
                <div class="text-sm">${user.email}</div>
            </div>
        `;

        li.addEventListener('click', () => selectUser(user));
        return li;
    }

    /**
     * ユーザーリストを表示する
     * @param {Array} users - 表示するユーザーの配列
     */
    function displayUsers(users) {
        DOM.userList.innerHTML = '';
        
        // 常に選択解除オプションを最上部に追加
        const clearOption = createClearOption();
        DOM.userList.appendChild(clearOption);
        
        // 同期的に要素を追加
        users.forEach((user, index) => {
            // 最後の要素かどうかを判定してcreateUserListItemに渡す
            const isLastItem = index === users.length - 1;
            const li = createUserListItem(user, isLastItem);
            DOM.userList.appendChild(li);
        });

        // フォーカスの設定を確実にするため、次のフレームで実行
        requestAnimationFrame(() => {
            const items = DOM.userList.querySelectorAll('li');
            items.forEach(item => {
                item.tabIndex = 0;
                // フォーカス可能であることを明示的に示す
                item.style.outline = 'none';
            });
        });
    }

    /**
     * ユーザーを選択する
     * @param {Object} user - 選択されたユーザーオブジェクト
     */
    function selectUser(user) {
        DOM.selectedUserDisplay.textContent = user.user_name;
        DOM.selectedUserId.value = user.id;
        closeDropdown();
        DOM.userSearch.value = '';
    }

    /**
     * ユーザー選択を解除する
     */
    function clearUserSelection() {
        // データ属性から分割されたテキストを取得
        const defaultMain = DOM.selectedUserDisplay.getAttribute('data-default-main') || 'ユーザー';
        const defaultSub = DOM.selectedUserDisplay.getAttribute('data-default-sub') || 'を選択';
        
        // HTMLを組み立てて設定
        DOM.selectedUserDisplay.innerHTML = `
            <span>${defaultMain}</span>
            <span class="text-gray-400 ml-2">${defaultSub}</span>
        `;
        
        DOM.selectedUserId.value = '';
        closeDropdown();
        DOM.userSearch.value = '';
        console.log('User selection cleared');
    }

    /**
     * ユーザーデータをサーバーから取得する
     * @param {string} userName - 検索するユーザー名
     */
    async function fetchUsers(userName = '') {
        try {
            const response = await fetch(`/search-users?user_name=${encodeURIComponent(userName)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const users = await response.json();
            displayUsers(users);
        } catch (error) {
            console.error('Error fetching users:', error);
            // TODO: ユーザーにエラーを表示する処理を追加
        }
    }

    /**
     * イベントリスナーを初期化する
     */
    function initEventListeners() {
        // ドロップダウンの開閉
        DOM.dropdownToggle.addEventListener('click', toggleDropdown);

        // ユーザー検索の入力処理（デバウンス付き）
        DOM.userSearch.addEventListener('input', (e) => {
            clearTimeout(STATE.debounceTimer);
            STATE.debounceTimer = setTimeout(() => {
                fetchUsers(e.target.value);
            }, 300);
        });

        // Enterキーでの検索実行
        DOM.userSearch.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                fetchUsers(e.target.value);
            }
        });

        // ドロップダウン外クリックでの閉じる処理
        document.addEventListener('click', (e) => {
            if (!DOM.dropdownToggle.contains(e.target) && !DOM.dropdownMenu.contains(e.target)) {
                closeDropdown();
            }
        });
    }

    // フォーカス管理のための関数を追加
    function initFocusManagement() {
        // リストのキーボードナビゲーション
        DOM.userList.addEventListener('keydown', (e) => {
            const items = Array.from(DOM.userList.querySelectorAll('li'));
            const currentIndex = items.indexOf(document.activeElement);

            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (currentIndex < items.length - 1) {
                        items[currentIndex + 1].focus();
                    }
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    if (currentIndex > 0) {
                        items[currentIndex - 1].focus();
                    }
                    break;
            }
        });
    }

    /**
     * アプリケーションの初期化
     */
    function init() {
        initEventListeners();
        initFocusManagement(); // フォーカス管理を初期化
        fetchUsers(); // 初期化時にユーザーデータを取得
    }

    // アプリケーションを初期化
    init();
});