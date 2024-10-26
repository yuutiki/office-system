// File: public/js/user-dropdown.js

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
        listItem: 'px-4 py-2 hover:bg-gray-600 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-400 focus:dark:text-blue-400',
        userName: 'font-semibold transition-colors duration-150 ease-in-out',
        focusedUserName: 'text-blue-500 dark:text-blue-400'
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
     * ユーザーリストアイテムを作成する
     * @param {Object} user - ユーザー情報オブジェクト
     * @returns {HTMLElement} 作成されたリストアイテム要素
     */
    function createUserListItem(user) {
        const li = document.createElement('li');
        li.className = CLASSES.listItem;
        li.setAttribute('tabindex', '0');
        li.setAttribute('role', 'option');
        li.innerHTML = `
            <div class="flex items-center dark:text-white">
                <div>
                    <div class="${CLASSES.userName}">${user.user_name}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-300">${user.email}</div>
                </div>
            </div>
        `;
        li.addEventListener('click', () => selectUser(user));
        li.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                selectUser(user);
            }
        });

        const userNameElement = li.querySelector(`.${CLASSES.userName}`);
        
        // フォーカスイベントリスナーを追加
        li.addEventListener('focus', () => {
            userNameElement.classList.add(...CLASSES.focusedUserName.split(' '));
        });
        
        // ブラーイベントリスナーを追加
        li.addEventListener('blur', () => {
            userNameElement.classList.remove(...CLASSES.focusedUserName.split(' '));
        });
        return li;
    }

    /**
     * ユーザーリストを表示する
     * @param {Array} users - 表示するユーザーの配列
     */
    function displayUsers(users) {
        DOM.userList.innerHTML = '';
        users.forEach((user) => {
            DOM.userList.appendChild(createUserListItem(user));
        });
        makeListItemsTabbable();
    }

    /**
     * リストアイテムをタブで選択可能にする
     */
    function makeListItemsTabbable() {
        DOM.userList.querySelectorAll('li').forEach((item) => {
            item.setAttribute('tabindex', '0');
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

    /**
     * アプリケーションの初期化
     */
    function init() {
        initEventListeners();
        fetchUsers(); // 初期化時にユーザーデータを取得
    }

    // アプリケーションを初期化
    init();
});