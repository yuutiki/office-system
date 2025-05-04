/**
 * 再利用可能なドロワー管理用スクリプト
 * @param {string} formPrefix フォームIDのプレフィックス（例: 'support-type-form', 'project-type-form'）
 */
function initializeDrawerManager(formPrefix) {
    // ドロワーの設定を管理するオブジェクト
    const DrawerManager = {
        currentWidth: 480,
        minWidth: 300,
        maxWidth: Math.min(1200, window.innerWidth), // 画面幅を超えないように調整
        activeDrawerId: null, // 現在開いているドロワーのID
        
        // ドロワーの幅を更新
        updateAllDrawersWidth: function(width) {
            this.currentWidth = Math.min(parseInt(width), window.innerWidth);
            document.querySelectorAll('.drawer-component').forEach(drawer => {
                drawer.style.width = `${this.currentWidth}px`;
            });
            localStorage.setItem('drawerWidth', this.currentWidth);
        },

        // 保存された幅を読み込む
        loadSavedWidth: function() {
            const savedWidth = localStorage.getItem('drawerWidth');
            if (savedWidth) {
                this.currentWidth = Math.min(parseInt(savedWidth), window.innerWidth);
                this.updateAllDrawersWidth(this.currentWidth);
            }
        },
        
        // 初期化時にすべてのドロワーを非表示状態にする
        setupInitialState: function() {
            // すべてのドロワーのフォーカス可能要素を非フォーカス可能に設定
            document.querySelectorAll('.drawer-component').forEach(drawer => {
                // ARIA属性を設定
                drawer.setAttribute('aria-hidden', 'true');
                
                // フォーカス可能な要素全てにtabindex="-1"を設定
                FocusTrap.getFocusableElements(drawer).forEach(element => {
                    // 元のtabindexを保存（あれば）
                    if (element.hasAttribute('tabindex')) {
                        element.dataset.originalTabindex = element.getAttribute('tabindex');
                    }
                    // フォーカス不可に設定
                    element.setAttribute('tabindex', '-1');
                });
            });
        }
    };

    // フォーカストラップを管理するオブジェクト
    const FocusTrap = {
        // 前回フォーカスされていた要素（ドロワー開閉時に使用）
        lastFocusedElement: null,
        
        // キーボードイベントリスナー参照
        keyboardListener: null,
        
        // ドロワー内のフォーカス可能な要素を取得
        getFocusableElements: function(drawerElement) {
            return Array.from(drawerElement.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            )).filter(el => !el.hasAttribute('disabled') && el.offsetParent !== null);
        },
        
        // フォーカスをトラップする
        trapFocus: function(drawerElement) {
            // 現在フォーカスされている要素を保存
            this.lastFocusedElement = document.activeElement;
            
            // ドロワー内のすべての要素をフォーカス可能に設定
            this.enableFocusableElements(drawerElement);
            
            // キーボードイベントリスナーを設定
            this.keyboardListener = (e) => {
                if (e.key !== 'Tab') return;
                
                const focusableElements = this.getFocusableElements(drawerElement);
                
                if (focusableElements.length === 0) return;
                
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                // SHIFT + Tabで逆方向に循環
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } 
                // Tabで順方向に循環
                else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            };
            
            document.addEventListener('keydown', this.keyboardListener);
            
            // ドロワー内の最初のフォーカス可能な要素にフォーカス
            const focusableElements = this.getFocusableElements(drawerElement);
            if (focusableElements.length > 0) {
                setTimeout(() => {
                    focusableElements[0].focus();
                }, 50);
            }
        },
        
        // ドロワー内の要素をフォーカス可能にする
        enableFocusableElements: function(drawerElement) {
            // ドロワーをARIAで表示状態に設定
            drawerElement.setAttribute('aria-hidden', 'false');
            
            // すべてのフォーカス可能要素を有効化
            const elements = this.getFocusableElements(drawerElement);
            elements.forEach(element => {
                // 保存された元のtabindexがあれば復元、なければ属性を削除
                if (element.dataset.originalTabindex) {
                    element.setAttribute('tabindex', element.dataset.originalTabindex);
                } else {
                    element.removeAttribute('tabindex');
                }
            });
        },
        
        // ドロワー内の要素をフォーカス不可にする
        disableFocusableElements: function(drawerElement) {
            // ドロワーをARIAで非表示状態に設定
            drawerElement.setAttribute('aria-hidden', 'true');
            
            // すべてのフォーカス可能要素を無効化
            const elements = Array.from(drawerElement.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]'
            )).filter(el => !el.hasAttribute('disabled'));
            
            elements.forEach(element => {
                // 現在のtabindexを保存（あれば）
                if (element.hasAttribute('tabindex') && element.getAttribute('tabindex') !== '-1') {
                    element.dataset.originalTabindex = element.getAttribute('tabindex');
                }
                // フォーカス不可に設定
                element.setAttribute('tabindex', '-1');
            });
        },
        
        // フォーカストラップを解除
        releaseFocus: function(drawerElement) {
            if (this.keyboardListener) {
                document.removeEventListener('keydown', this.keyboardListener);
                this.keyboardListener = null;
            }
            
            // ドロワー内の要素をフォーカス不可に設定
            if (drawerElement) {
                this.disableFocusableElements(drawerElement);
            }
            
            // 保存しておいた要素にフォーカスを戻す
            if (this.lastFocusedElement) {
                setTimeout(() => {
                    this.lastFocusedElement.focus();
                    this.lastFocusedElement = null;
                }, 50);
            }
        }
    };

    // フォームの変更検知と警告を管理するオブジェクト
    const FormManager = {
        // フォームの初期値と変更状態を保持
        formStates: new Map(), // { formId: { initialValues: Map, isChanged: boolean } }

        // フォームの初期化
        initialize(form) {
            const initialValues = new Map();
            const inputs = this.getFormInputs(form);
            
            inputs.forEach(input => {
                initialValues.set(input.name, input.value);
            });

            this.formStates.set(form.id, {
                initialValues: initialValues,
                isChanged: false
            });

            this.setupChangeDetection(form);
            this.setupCloseButton(form);
            this.setupSubmitHandler(form);

            console.log('Form initialized:', {
                formId: form.id,
                initialValues: Object.fromEntries(initialValues)
            });
        },

        // 変更検知の設定
        setupChangeDetection(form) {
            const inputs = this.getFormInputs(form);

            inputs.forEach(input => {
                const checkChanges = () => {
                    const formState = this.formStates.get(form.id);
                    if (!formState) return;

                    const currentValues = new Map(inputs.map(field => [field.name, field.value]));
                    const hasChanges = Array.from(currentValues.entries()).some(
                        ([name, value]) => value !== formState.initialValues.get(name)
                    );

                    formState.isChanged = hasChanges;
                    form.dataset.isChanged = hasChanges.toString();

                    console.log('Change check:', {
                        formId: form.id,
                        field: input.name,
                        currentValue: input.value,
                        initialValue: formState.initialValues.get(input.name),
                        hasChanges: hasChanges
                    });
                };

                // input と change の両方のイベントを監視
                input.addEventListener('input', checkChanges);
                input.addEventListener('change', checkChanges);
            });
        },

        // フォームのリセット処理
        resetForm(form) {
            console.log('Starting form reset for:', form.id);
            
            // まずフォームをリセット
            form.reset();

            // 現在のフォーム値を取得し、新しい初期値として設定
            const inputs = this.getFormInputs(form);
            const newInitialValues = new Map();
            
            inputs.forEach(input => {
                // リセット後の値を新しい初期値として保存
                const resetValue = input.value;
                newInitialValues.set(input.name, resetValue);
                console.log(`Reset ${input.name} to:`, resetValue);
            });

            // フォームの状態を更新
            this.formStates.set(form.id, {
                initialValues: newInitialValues,
                isChanged: false
            });

            console.log('Form reset completed:', {
                formId: form.id,
                newState: {
                    initialValues: Object.fromEntries(newInitialValues),
                    isChanged: false
                }
            });
        },

        // 入力要素を取得するユーティリティ
        getFormInputs(form) {
            return Array.from(form.elements).filter(element => 
                element.tagName.toLowerCase() === 'input' &&
                !['hidden', 'submit'].includes(element.type)
            );
        },

        // 閉じるボタンの設定
        setupCloseButton(form) {
            const drawerId = form.id.split('-').pop();
            const drawer = document.getElementById(`drawer-${drawerId}`);
            const closeButton = drawer.querySelector('button[data-drawer-id]');
            
            if (closeButton) {
                closeButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.handleClose(form, drawerId);
                });
            }
        },

        // 閉じる処理
        handleClose(form, drawerId) {
            const formState = this.formStates.get(form.id);
            
            if (formState && formState.isChanged) {
                if (confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
                    this.resetForm(form);
                    closeDrawer(drawerId);
                }
            } else {
                closeDrawer(drawerId);
            }
        },

        // 送信処理
        setupSubmitHandler(form) {
            form.addEventListener('submit', () => {
                const formState = this.formStates.get(form.id);
                if (formState) {
                    formState.isChanged = false;
                    form.dataset.isChanged = 'false';
                }
            });
        },

        // 新規作成フォームの初期化
        initializeCreateForm() {
            const form = document.getElementById(`${formPrefix}-create`);
            if (!form) return;

            const initialValues = new Map();
            const inputs = this.getFormInputs(form);
            
            inputs.forEach(input => {
                initialValues.set(input.name, input.value || '');  // 空値の場合も考慮
            });

            this.formStates.set(form.id, {
                initialValues: initialValues,
                isChanged: false
            });

            this.setupChangeDetection(form);
            this.setupCloseButton(form);
            this.setupSubmitHandler(form);
        },

        // バリデーションエラー時のドロワー再表示
        handleValidationError() {
            const params = new URLSearchParams(window.location.search);
            const shouldOpenDrawer = sessionStorage.getItem('openDrawer');
            
            if (shouldOpenDrawer === 'create') {
                openDrawer('create');
                sessionStorage.removeItem('openDrawer');
            }
        }
    };

    // ドロワーの初期化
    function initializeDrawers() {
        // リサイズ機能の初期化
        document.querySelectorAll('.resize-handle').forEach(handle => {
            let isResizing = false;
            let drawer = handle.parentElement;
            let initialWidth, initialX;

            handle.addEventListener('mousedown', startResize);

            function startResize(e) {
                isResizing = true;
                initialX = e.clientX;
                initialWidth = drawer.offsetWidth;

                document.body.style.cursor = 'col-resize';
                document.body.style.userSelect = 'none';

                document.addEventListener('mousemove', handleResize);
                document.addEventListener('mouseup', stopResize);
                e.stopPropagation();
            }

            function handleResize(e) {
                if (!isResizing) return;

                const diffX = e.clientX - initialX;
                const newWidth = Math.min(initialWidth - diffX, window.innerWidth); // 画面幅を超えない

                if (newWidth >= DrawerManager.minWidth) {
                    drawer.style.width = `${newWidth}px`;
                    DrawerManager.updateAllDrawersWidth(newWidth);
                }

                e.preventDefault();
            }

            function stopResize() {
                if (!isResizing) return;
                
                isResizing = false;
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
                document.removeEventListener('mousemove', handleResize);
                document.removeEventListener('mouseup', stopResize);
            }
        });

        // オーバーレイのクリックイベントを設定
        const overlay = document.getElementById('overlay');
        if (overlay) {
            overlay.addEventListener('click', function() {
                const openDrawer = document.querySelector('.drawer-component:not(.translate-x-full)');
                if (openDrawer) {
                    const id = openDrawer.id.replace('drawer-', '');
                    closeDrawer(id);
                }
            });
        }
        
        // ドロワー内の要素を初期状態で非フォーカス可能に設定
        DrawerManager.setupInitialState();
    }

    // ドロワーを開く
    function openDrawer(id) {
        const drawer = document.getElementById(`drawer-${id}`);
        const overlay = document.getElementById('overlay');
        
        if (drawer && overlay) {
            const maxWidth = Math.min(DrawerManager.currentWidth, window.innerWidth); // 画面幅以下にする
            drawer.style.width = `${maxWidth}px`;

            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            drawer.classList.remove('translate-x-full');
            updateUrl(id);
            
            // 現在のドロワーIDを保存
            DrawerManager.activeDrawerId = id;

            // フォーカストラップを設定
            FocusTrap.trapFocus(drawer);

            setTimeout(() => {
                overlay.classList.add('opacity-100');
                overlay.classList.remove('opacity-0');
            }, 0);
        }
    }

    // ドロワーを閉じる
    function closeDrawer(id) {
        const drawer = document.getElementById(`drawer-${id}`);
        const overlay = document.getElementById('overlay');
        const form = document.getElementById(`${formPrefix}-${id}`);

        // フォーム変更チェック
        if (form) {
            const formState = FormManager.formStates.get(form.id);
            if (formState && formState.isChanged) {
                if (!confirm('変更内容が保存されていません。閉じてもよろしいですか？')) {
                    return;
                }
                FormManager.resetForm(form);
            }
        }

        if (drawer && overlay) {
            drawer.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            overlay.classList.remove('opacity-100');
            
            // アクティブなドロワーIDをクリア
            DrawerManager.activeDrawerId = null;
            
            // フォーカストラップを解除
            FocusTrap.releaseFocus(drawer);
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);

            removeDrawerParam();
        }
    }

    // URLパラメータの更新
    function updateUrl(id) {
        const url = new URL(window.location);
        url.searchParams.set('drawer', id);
        window.history.pushState({}, '', url);
    }

    // URLパラメータの削除
    function removeDrawerParam() {
        const url = new URL(window.location);
        url.searchParams.delete('drawer');
        window.history.pushState({}, '', url);
    }

    // URLからドロワーIDを取得して開く
    function checkUrlAndOpenDrawer() {
        const urlParams = new URLSearchParams(window.location.search);
        const drawerId = urlParams.get('drawer');
        
        if (drawerId) {
            openDrawer(drawerId);
        }
    }

    // リセットボタンのイベント設定
    function setupSearchFormReset() {
        const resetButton = document.getElementById('clear');
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                const form = document.getElementById('search_form');
                if (form) {
                    // 検索条件をクリア (hidden除く)
                    form.querySelectorAll('input:not([type="hidden"]), select').forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    });
                    // フォーム送信
                    form.submit();
                }
            });
        }
    }

    // 初期化処理
    initializeDrawers();
    checkUrlAndOpenDrawer();
    DrawerManager.loadSavedWidth();

    // フォームの初期化
    document.querySelectorAll(`form[id^="${formPrefix}-"]`).forEach(form => {
        FormManager.initialize(form);
    });
    
    // ESCキーでドロワーを閉じる処理
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openDrawer = document.querySelector('.drawer-component:not(.translate-x-full)');
            if (openDrawer) {
                const id = openDrawer.id.replace('drawer-', '');
                closeDrawer(id);
            }
        }
    });

    // 新規作成フォームの初期化
    FormManager.initializeCreateForm();

    // バリデーションエラー時の処理
    FormManager.handleValidationError();
    
    // 検索フォームのリセット処理
    setupSearchFormReset();

    // グローバル関数として公開
    window.openDrawer = openDrawer;
    window.closeDrawer = closeDrawer;
}

// DOMContentLoaded時に実行される
document.addEventListener('DOMContentLoaded', function() {
    // デフォルト値 (ブレード側で上書き可能)
    const defaultFormPrefix = 'support-type-form';
    
    // ページで定義されていればそれを使用、なければデフォルト値
    const formPrefix = (typeof window.FORM_PREFIX !== 'undefined') ? window.FORM_PREFIX : defaultFormPrefix;
    
    // 初期化
    initializeDrawerManager(formPrefix);
});