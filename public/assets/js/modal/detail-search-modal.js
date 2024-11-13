    // モーダル管理クラス
    class ModalController {
        constructor(modalId, overlayId) {
            this.modal = document.getElementById(modalId);
            this.overlay = document.getElementById(overlayId);
            
            if (!this.modal || !this.overlay) {
                throw new Error('Modal or overlay element not found');
            }
    
            this.bindEvents();
        }
    
        bindEvents() {
            // ESCキーでモーダルを閉じる
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                    this.hide();
                }
            });
    
            // オーバーレイクリックでモーダルを閉じる
            this.overlay.addEventListener('click', () => this.hide());
    
            // モーダル内のクローズボタンの処理
            const closeButtons = this.modal.querySelectorAll('[data-modal-close]');
            closeButtons.forEach(button => {
                button.addEventListener('click', () => this.hide());
            });
        }
    
        show() {
            document.body.classList.add('overflow-hidden');
            this.overlay.classList.remove('hidden');
            this.modal.classList.remove('hidden');
            
            // カスタムイベントの発火
            this.modal.dispatchEvent(new CustomEvent('modal:shown'));
        }
    
        hide() {
            document.body.classList.remove('overflow-hidden');
            this.overlay.classList.add('hidden');
            this.modal.classList.add('hidden');
    
            // カスタムイベントの発火
            this.modal.dispatchEvent(new CustomEvent('modal:hidden'));
        }
    
        // モーダルの表示状態を切り替える
        toggle() {
            if (this.modal.classList.contains('hidden')) {
                this.show();
            } else {
                this.hide();
            }
        }
    
        // モーダルの表示状態を取得
        isVisible() {
            return !this.modal.classList.contains('hidden');
        }
    }