/**
 * edit専用ユーザー選択モジュール
 * createとは独立して動作
 */
export const UserSelectorEdit = {
    selectedUserIds: [],

    elements: {
        selectedUsers: document.getElementById('selectedUsers'),
        selectedRecipients: document.getElementById('selectedRecipients'),
        searchResults: document.getElementById('searchResults'),
        searchButton: document.getElementById('searchUsersButton'),
        userName: document.getElementById('user_name'),
        userAffiliation1: document.getElementById('user_affiliation1_id'),
        userAffiliation2: document.getElementById('user_affiliation2_id'),
    },

    /**
     * 初期化処理（初期登録済みユーザーIDをセット）
     */
    initialize(initialIds = []) {
        this.selectedUserIds = initialIds.map(String);

        const { selectedRecipients, selectedUsers } = this.elements;

        // DOM上に初期表示済みの報告先を確認し、selectedUserIdsに統一
        const domIds = Array.from(selectedRecipients.querySelectorAll('.selectedUser'))
            .map(div => String(div.dataset.userId));

        this.selectedUserIds = [...new Set([...this.selectedUserIds, ...domIds])];

        selectedUsers.value = this.selectedUserIds.join(',');

        this.setupEventListeners();
    },

    /**
     * イベントリスナー登録
     */
    setupEventListeners() {
        const { searchButton } = this.elements;

        // 🔍 ユーザー検索処理
        searchButton.addEventListener('click', async () => {
            const params = new URLSearchParams({
                user_name: this.elements.userName.value,
                affiliation1_id: this.elements.userAffiliation1.value,
                affiliation2_id: this.elements.userAffiliation2.value,
            });

            try {
                const response = await fetch('/search-users?' + params);
                const data = await response.json();

                // すでに選択済み（DOM上の .selectedUser）を除外
                const selectedIds = Array.from(this.elements.selectedRecipients.querySelectorAll('.selectedUser'))
                    .map(div => String(div.dataset.userId));

                const filtered = data.filter(u => !selectedIds.includes(String(u.id)));

                // 50音順ソート
                filtered.sort((a, b) =>
                    a.user_kana_name.toUpperCase().localeCompare(b.user_kana_name.toUpperCase())
                );

                // 結果表示
                this.elements.searchResults.innerHTML = filtered.map(user =>
                    `<div class="selectUser cursor-pointer hover:dark:text-blue-400" 
                        data-user-id="${user.id}" 
                        data-user-name="${user.user_name}">
                        ${user.user_name}
                    </div>`
                ).join('');
            } catch (err) {
                console.error('検索エラー', err);
            }
        });

        // 🔄 ユーザー選択・解除イベント
        document.addEventListener('click', e => {
            if (e.target.classList.contains('selectUser')) {
                this.selectUser(e.target);
            } else if (e.target.classList.contains('selectedUser')) {
                this.deselectUser(e.target);
            }
        });

        document.addEventListener('keydown', e => {
            if ((e.target.classList.contains('selectUser') || e.target.classList.contains('selectedUser')) && e.key === 'Enter') {
                e.preventDefault();
                if (e.target.classList.contains('selectUser')) {
                    this.selectUser(e.target);
                } else {
                    this.deselectUser(e.target);
                }
            }
        });
    },

    /**
     * 検索結果から報告先へ移動
     */
    selectUser(element) {
        const userId = String(element.dataset.userId);
        const userName = element.dataset.userName;

        // すでに選択済みならスキップ
        const alreadySelected = Array.from(this.elements.selectedRecipients.querySelectorAll('.selectedUser'))
            .some(div => String(div.dataset.userId) === userId);
        if (alreadySelected) {
            element.remove();
            return;
        }

        // 50音順で挿入
        const selectedDivs = Array.from(this.elements.selectedRecipients.querySelectorAll('.selectedUser'));
        let inserted = false;
        for (const div of selectedDivs) {
            if (userName.localeCompare(div.textContent, 'ja', { sensitivity: 'base' }) < 0) {
                div.insertAdjacentHTML(
                    'beforebegin',
                    `<div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}">${userName}</div>`
                );
                inserted = true;
                break;
            }
        }
        if (!inserted) {
            this.elements.selectedRecipients.insertAdjacentHTML(
                'beforeend',
                `<div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}">${userName}</div>`
            );
        }

        // 内部状態更新
        if (!this.selectedUserIds.includes(userId)) {
            this.selectedUserIds.push(userId);
        }
        this.updateHidden();

        // 検索結果側から削除
        element.remove();
    },

    /**
     * 報告先から削除し、検索結果に戻す
     */
    deselectUser(element) {
        const userId = String(element.dataset.userId);
        const userName = element.textContent;

        // 検索結果にすでに存在していない場合のみ追加
        const existsInSearch = Array.from(this.elements.searchResults.querySelectorAll('.selectUser'))
            .some(div => String(div.dataset.userId) === userId);
        if (!existsInSearch) {
            this.elements.searchResults.insertAdjacentHTML(
                'beforeend',
                `<div class="selectUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}" data-user-name="${userName}">${userName}</div>`
            );
        }

        // 配列から削除
        this.selectedUserIds = this.selectedUserIds.filter(id => id !== userId);
        this.updateHidden();

        // DOMから削除
        element.remove();
    },

    /**
     * hidden input 更新
     */
    updateHidden() {
        this.elements.selectedUsers.value = this.selectedUserIds.join(',');
    }
};
