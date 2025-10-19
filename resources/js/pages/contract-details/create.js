import { setupAutoResizeTextareas } from '../../components/auto-resize-textarea';
import ProjectSearchModal from '../../components/modals/project-search-modal';

document.addEventListener('DOMContentLoaded', () => {
    // リサイズテキストエリア
    setupAutoResizeTextareas();

    // グローバルスコープで使えるようにする
    window.ProjectSearchModal = ProjectSearchModal;

    // プロジェクト選択時のコールバック
    function handleProjectSelect(project) {
        document.getElementById('project_id').value = project.id;
        document.getElementById('project_num').value = project.project_num;
        document.getElementById('project_name').value = project.project_name;
        // document.getElementById('project_client_name').value = project.client.client_name;
        document.getElementById('account_user').value = project.account_user.user_name;
        document.getElementById('sales_stage_name').value = project.sales_stage.sales_stage_name;
    }

    // モーダルごとのコールバックをグローバルに設定
    window.projectSearchModal1_onSelect = handleProjectSelect;
});
