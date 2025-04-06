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
     * ユーザーリストアイテムを作成する
     * @param {Object} user - ユーザー情報オブジェクト
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