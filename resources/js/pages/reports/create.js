// resources/js/pages/reports/create.js
import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';
import ProjectSearchModal from '../../components/modals/project-search-modal';
import { UserSelector } from '../../components/user-selection';

document.addEventListener('DOMContentLoaded', () => {
    // リサイズテキストエリア
    setupAutoResizeTextareas();

    UserSelector.initialize();

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
});
