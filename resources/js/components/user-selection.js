// resources/js/components/user-selection.js
/**
 * ユーザー選択管理モジュール
 */
export const UserSelector = {
    storageManager: {
        selectedUserIds: JSON.parse(localStorage.getItem('selectedUserIds')) || [],

        updateStorage() {
            localStorage.setItem('selectedUserIds', JSON.stringify(this.selectedUserIds));
            console.log('ストレージ更新後のselectedUserIds:', this.selectedUserIds);
        },

        addUser(userId, userName) {
            userId = String(userId); // 文字列に統一
            if (!this.selectedUserIds.includes(userId)) {
                this.selectedUserIds.push(userId);
                localStorage.setItem('userName_' + userId, userName);
                this.updateStorage();
            }
        },

        removeUser(userId) {
            userId = String(userId);
            const index = this.selectedUserIds.indexOf(userId);
            if (index !== -1) {
                this.selectedUserIds.splice(index, 1);
                localStorage.removeItem('userName_' + userId);
                this.updateStorage();
            }
        },

        getUserName(userId) {
            return localStorage.getItem('userName_' + userId);
        }
    },

    elements: {
        selectedUsers: document.getElementById('selectedUsers'),
        selectedRecipients: document.getElementById('selectedRecipients'),
        searchResults: document.getElementById('searchResults'),
        searchButton: document.getElementById('searchUsersButton'),
        userName: document.getElementById('user_name'),
        userAffiliation1: document.getElementById('user_affiliation1_id'),
        userAffiliation2: document.getElementById('user_affiliation2_id'),
    },

    initialize() {
        const { selectedRecipients, selectedUsers } = this.elements;
        const { selectedUserIds, getUserName } = this.storageManager;

        selectedUsers.value = selectedUserIds.join(',');

        // 初期表示
        selectedUserIds.forEach(userId => {
            const userName = getUserName(userId);
            if (userName) {
                selectedRecipients.insertAdjacentHTML(
                    'afterbegin',
                    `<div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}">${userName}</div>`
                );
            }
        });

        this.setupEventListeners();
    },

    setupEventListeners() {
        const { searchButton, searchResults, selectedRecipients, selectedUsers, userName, userAffiliation1, userAffiliation2 } = this.elements;

        // ユーザー検索
        searchButton.addEventListener('click', async () => {
            const params = new URLSearchParams({
                user_name: userName.value,
                affiliation1_id: userAffiliation1.value,
                affiliation2_id: userAffiliation2.value,
            });

            try {
                const response = await fetch('/search-users?' + params);
                const data = await response.json();

                const filteredUsers = data.filter(user =>
                    !this.storageManager.selectedUserIds.includes(String(user.id))
                );

                const sortedUsers = filteredUsers.sort((a, b) =>
                    a.user_kana_name.toUpperCase().localeCompare(b.user_kana_name.toUpperCase())
                );

                searchResults.innerHTML = sortedUsers.map(user =>
                    `<div class="selectUser cursor-pointer hover:dark:text-blue-400" data-user-id="${user.id}" data-user-name="${user.user_name}">${user.user_name}</div>`
                ).join('');
            } catch (error) {
                console.error('検索エラー:', error);
            }
        });

        // 選択・解除
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

    selectUser(element) {
        const userId = String(element.dataset.userId);
        const userName = element.dataset.userName;

        // 重複チェック
        if (this.storageManager.selectedUserIds.includes(userId)) {
            element.remove();
            return;
        }

        const selectedUsers = Array.from(this.elements.selectedRecipients.querySelectorAll('.selectedUser'));
        let inserted = false;

        for (const selected of selectedUsers) {
            if (userName.localeCompare(selected.textContent, 'ja', { sensitivity: 'base' }) < 0) {
                selected.insertAdjacentHTML('beforebegin', `<div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}">${userName}</div>`);
                inserted = true;
                break;
            }
        }

        if (!inserted) {
            this.elements.selectedRecipients.insertAdjacentHTML('beforeend', `<div class="selectedUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}">${userName}</div>`);
        }

        this.storageManager.addUser(userId, userName);
        element.remove();
        this.elements.selectedUsers.value = this.storageManager.selectedUserIds.join(',');
    },

    deselectUser(element) {
        const userId = String(element.dataset.userId);
        const userName = element.textContent;

        this.elements.searchResults.insertAdjacentHTML('beforeend', `<div class="selectUser cursor-pointer hover:dark:text-blue-400" data-user-id="${userId}" data-user-name="${userName}">${userName}</div>`);

        this.storageManager.removeUser(userId);
        element.remove();
        this.elements.selectedUsers.value = this.storageManager.selectedUserIds.join(',');
    }
};
