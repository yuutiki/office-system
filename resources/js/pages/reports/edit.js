// resources/js/pages/reports/edit.js

import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';
import ProjectSearchModal from '../../components/modals/project-search-modal';
import { UserSelectorEdit } from '../../components/user-selection-edit';


document.addEventListener('DOMContentLoaded', () => {
    // リサイズテキストエリア
    setupAutoResizeTextareas();

    // Blade で hidden に入れた初期IDを取得
    const initialIds = Array.from(document.querySelectorAll('#selectedRecipients .selectedUser'))
        .map(el => el.dataset.userId);

    UserSelectorEdit.initialize(initialIds);


    // アコーディオン開閉
    document.querySelectorAll('.accordion-btn').forEach(btn => {
        const panel = document.getElementById(btn.getAttribute('aria-controls'));
        const icon = btn.querySelector('.arrow');
        btn.addEventListener('click', () => {
            const isOpen = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', !isOpen);
            icon.classList.toggle('rotate-180', !isOpen);
            panel.classList.toggle('hidden', isOpen);
        });
    });

    // グローバルスコープで使えるようにする
    window.ProjectSearchModal = ProjectSearchModal;

    // プロジェクト選択時のコールバック
    function handleProjectSelect(project) {
        document.getElementById('project_id').value = project.id;
        document.getElementById('project_num').value = project.project_num;
        document.getElementById('project_name').value = project.project_name;
        document.getElementById('project_client_name').value = project.client.client_name;
        // document.getElementById('project_manager').value = project.user.user_name;
    }
    // モーダルごとのコールバックをグローバルに設定
    window.projectSearchModal1_onSelect = handleProjectSelect;



//     // 顧客担当者選択機能
//     const selectedContactsInput = document.getElementById('selectedClientContacts');
    
//     // hidden inputに既に値があれば（編集時）、配列に変換
//     let preSelectedIds = [];
//     if (selectedContactsInput && selectedContactsInput.value) {
//         preSelectedIds = selectedContactsInput.value.split(',').filter(id => id.trim());
//     }

//     // 顧客担当者をロードする関数
// function loadClientContacts(clientId) {
//     if (!clientId) return;
    
//     // ルートに合わせてURLを修正
//     fetch(`/client-contacts/ajax/${clientId}`)
//         .then(res => {
//             if (!res.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return res.json();
//         })
//         .then(response => {
//             // ResourceCollectionの場合、dataプロパティにデータが入っている
//             const contacts = response.data || response;
            
//             const listContainer = document.getElementById('clientContactsList');
//             if (!listContainer) return;
            
//             listContainer.innerHTML = '';

//             if (!contacts || contacts.length === 0) {
//                 listContainer.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm">担当者が登録されていません</p>';
//                 return;
//             }

//             contacts.forEach(contact => {
//                 const checkbox = document.createElement('input');
//                 checkbox.type = 'checkbox';
//                 checkbox.value = contact.id;
//                 checkbox.id = `contact-${contact.id}`;
//                 checkbox.classList.add('mr-2', 'rounded', 'border-gray-300', 'dark:border-gray-600');

//                 // 編集画面では既存担当者にチェック
//                 if (preSelectedIds.includes(contact.id.toString())) {
//                     checkbox.checked = true;
//                 }

//                 checkbox.addEventListener('change', updateSelectedContacts);

//                 const label = document.createElement('label');
//                 label.htmlFor = checkbox.id;
//                 label.textContent = `${contact.last_name ?? ''} ${contact.first_name ?? ''}${contact.division_name ? `（${contact.division_name}）` : ''}`;
//                 label.classList.add('cursor-pointer', 'select-none');

//                 const wrapper = document.createElement('div');
//                 wrapper.classList.add('flex', 'items-center', 'hover:bg-gray-100', 'dark:hover:bg-gray-700', 'p-1', 'rounded');
//                 wrapper.appendChild(checkbox);
//                 wrapper.appendChild(label);

//                 listContainer.appendChild(wrapper);
//             });

//             // 初回ロード後に hidden を更新
//             updateSelectedContacts();
//         })
//         .catch(err => {
//             console.error('担当者リストの取得に失敗しました:', err);
//             const listContainer = document.getElementById('clientContactsList');
//             if (listContainer) {
//                 listContainer.innerHTML = '<p class="text-red-500 text-sm">担当者の取得に失敗しました</p>';
//             }
//         });
// }

//     // hidden input更新関数
//     function updateSelectedContacts() {
//         const checkedIds = Array.from(
//             document.querySelectorAll('#clientContactsList input[type="checkbox"]:checked')
//         ).map(el => el.value);
        
//         if (selectedContactsInput) {
//             selectedContactsInput.value = checkedIds.join(',');
//         }
//     }

//     // 初回ロード（編集画面）
//     const clientIdInput = document.querySelector('[name="client_id"]');
//     if (clientIdInput && clientIdInput.value) {
//         loadClientContacts(clientIdInput.value);
//     }
    
//     // 顧客選択時の担当者リスト更新（モーダルから選択した場合）
//     window.addEventListener('clientSelected', (event) => {
//         const clientId = event.detail.clientId;
//         if (clientId) {
//             // 新しい顧客を選択した場合は、選択された担当者をクリア
//             preSelectedIds = [];
//             if (selectedContactsInput) {
//                 selectedContactsInput.value = '';
//             }
//             loadClientContacts(clientId);
//         }
//     });

});