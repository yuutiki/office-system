/**
 * 再利用可能なドロワー管理用スクリプト
 * @param {string} formPrefix フォームIDのプレフィックス（例: 'support-type-form', 'project-type-form'）
 */
function initializeDrawerManager(formPrefix) {
    // ドロワーの設定を管理するオブジェクト
    const DrawerManager = {
        currentWidth: 480,
        minWidth: 300,
        maxWidth: Math.min(1200, window.innerWidth),
        activeDrawerId: null,
        
        updateAllDrawersWidth: function(width) {
            this.currentWidth = Math.min(parseInt(width), window.innerWidth);
            document.querySelectorAll('.drawer-component').forEach(drawer => {
                drawer.style.width = `${this.currentWidth}px`;
            });
            localStorage.setItem('drawerWidth', this.currentWidth);
        },

        loadSavedWidth: function() {
            const savedWidth = localStorage.getItem('drawerWidth');
            if (savedWidth) {
                this.currentWidth = Math.min(parseInt(savedWidth), window.innerWidth);
                this.updateAllDrawersWidth(this.currentWidth);
            }
        },
        
        setupInitialState: function() {
            document.querySelectorAll('.drawer-component').forEach(drawer => {
                drawer.setAttribute('aria-hidden', 'true');
                
                FocusTrap.getFocusableElements(drawer).forEach(element => {
                    if (element.hasAttribute('tabindex')) {
                        element.dataset.originalTabindex = element.getAttribute('tabindex');
                    }
                    element.setAttribute('tabindex', '-1');
                });
            });
        }
    };

    // フォーカストラップを管理するオブジェクト
    const FocusTrap = {
        lastFocusedElement: null,
        keyboardListener: null,
        
        // ラジオボタングループを含むフォーカス可能な要素を取得
        getFocusableElements: function(drawerElement) {
            const focusableSelectors = 'button:not([disabled]), [href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
            const elements = Array.from(drawerElement.querySelectorAll(focusableSelectors));
            
            // ラジオボタンの特殊処理
            const radioGroups = new Map();
            const filteredElements = [];
            
            elements.forEach(el => {
                if (el.type === 'radio') {
                    // ラジオボタングループごとに1つだけ含める
                    if (!radioGroups.has(el.name)) {
                        // チェックされているものか、最初のものを代表として選択
                        const checkedRadio = drawerElement.querySelector(`input[type="radio"][name="${el.name}"]:checked`);
                        const firstRadio = drawerElement.querySelector(`input[type="radio"][name="${el.name}"]`);
                        radioGroups.set(el.name, checkedRadio || firstRadio);
                    }
                } else if (el.offsetParent !== null) {
                    // 通常の要素（表示されているもののみ）
                    filteredElements.push(el);
                }
            });
            
            // ラジオボタングループの代表要素を追加
            radioGroups.forEach(radio => {
                if (radio && radio.offsetParent !== null) {
                    filteredElements.push(radio);
                }
            });
            
            // DOM順にソート
            return filteredElements.sort((a, b) => {
                const position = a.compareDocumentPosition(b);
                if (position & Node.DOCUMENT_POSITION_FOLLOWING) return -1;
                if (position & Node.DOCUMENT_POSITION_PRECEDING) return 1;
                return 0;
            });
        },
        
        trapFocus: function(drawerElement) {
            this.lastFocusedElement = document.activeElement;
            this.enableFocusableElements(drawerElement);
            
            // ラジオボタングループのキーボード操作を設定
            this.setupRadioGroupNavigation(drawerElement);
            
            this.keyboardListener = (e) => {
                if (e.key !== 'Tab') return;
                
                const focusableElements = this.getFocusableElements(drawerElement);
                if (focusableElements.length === 0) return;
                
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            };
            
            document.addEventListener('keydown', this.keyboardListener);
            
            // 最初のフォーカス可能な要素にフォーカス（input/textareaを優先）
            const focusableElements = this.getFocusableElements(drawerElement);
            if (focusableElements.length > 0) {
                const firstInput = focusableElements.find(el => 
                    (el.tagName === 'INPUT' && el.type !== 'radio' && el.type !== 'checkbox' && !el.readOnly) ||
                    el.tagName === 'TEXTAREA'
                );
                
                setTimeout(() => {
                    (firstInput || focusableElements[0]).focus();
                }, 50);
            }
        },
        
        // ラジオボタングループのキーボードナビゲーション設定
        setupRadioGroupNavigation: function(drawerElement) {
            const radioGroups = new Map();
            
            // すべてのラジオボタンをグループごとに整理
            drawerElement.querySelectorAll('input[type="radio"]').forEach(radio => {
                if (!radioGroups.has(radio.name)) {
                    radioGroups.set(radio.name, []);
                }
                radioGroups.get(radio.name).push(radio);
            });
            
            // 各グループにキーボードナビゲーションを設定
            radioGroups.forEach((radios, groupName) => {
                radios.forEach((radio, index) => {
                    radio.addEventListener('keydown', (e) => {
                        let nextIndex = -1;
                        
                        switch(e.key) {
                            case 'ArrowDown':
                            case 'ArrowRight':
                                e.preventDefault();
                                nextIndex = (index + 1) % radios.length;
                                break;
                            case 'ArrowUp':
                            case 'ArrowLeft':
                                e.preventDefault();
                                nextIndex = (index - 1 + radios.length) % radios.length;
                                break;
                            case ' ':
                            case 'Enter':
                                e.preventDefault();
                                radio.checked = true;
                                radio.dispatchEvent(new Event('change', { bubbles: true }));
                                return;
                        }
                        
                        if (nextIndex !== -1) {
                            radios[nextIndex].focus();
                            radios[nextIndex].checked = true;
                            radios[nextIndex].dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    });
                });
            });
        },
        
        enableFocusableElements: function(drawerElement) {
            drawerElement.setAttribute('aria-hidden', 'false');
            
            const elements = this.getFocusableElements(drawerElement);
            elements.forEach(element => {
                if (element.dataset.originalTabindex) {
                    element.setAttribute('tabindex', element.dataset.originalTabindex);
                } else {
                    element.removeAttribute('tabindex');
                }
            });
        },
        
        disableFocusableElements: function(drawerElement) {
            drawerElement.setAttribute('aria-hidden', 'true');
            
            const elements = Array.from(drawerElement.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]'
            )).filter(el => !el.hasAttribute('disabled'));
            
            elements.forEach(element => {
                if (element.hasAttribute('tabindex') && element.getAttribute('tabindex') !== '-1') {
                    element.dataset.originalTabindex = element.getAttribute('tabindex');
                }
                element.setAttribute('tabindex', '-1');
            });
        },
        
        releaseFocus: function(drawerElement) {
            if (this.keyboardListener) {
                document.removeEventListener('keydown', this.keyboardListener);
                this.keyboardListener = null;
            }
            
            if (drawerElement) {
                this.disableFocusableElements(drawerElement);
            }
            
            if (this.lastFocusedElement) {
                setTimeout(() => {
                    this.lastFocusedElement.focus();
                    this.lastFocusedElement = null;
                }, 50);
            }
        }
    };

    // フォームの変更検知と警告を管理するオブジェクト（ラジオボタン対応版）
    const FormManager = {
        formStates: new Map(),

        initialize(form) {
            const initialValues = this.getInitialValues(form);
            
            this.formStates.set(form.id, {
                initialValues: initialValues,
                isChanged: false
            });

            this.setupChangeDetection(form);
            this.setupCloseButton(form);
            this.setupSubmitHandler(form);

            // console.log('Form initialized:', {
            //     formId: form.id,
            //     initialValues: Object.fromEntries(initialValues)
            // });
        },

        // 初期値を取得（ラジオボタン対応）
        getInitialValues(form) {
            const values = new Map();
            const inputs = this.getFormInputs(form);
            
            // ラジオボタングループを管理
            const radioGroups = new Set();
            
            inputs.forEach(input => {
                if (input.type === 'radio') {
                    // ラジオボタングループはグループ名で管理
                    if (!radioGroups.has(input.name)) {
                        radioGroups.add(input.name);
                        const checkedRadio = form.querySelector(`input[type="radio"][name="${input.name}"]:checked`);
                        values.set(input.name, checkedRadio ? checkedRadio.value : '');
                    }
                } else if (input.type === 'checkbox') {
                    values.set(input.name, input.checked ? input.value : '');
                } else {
                    values.set(input.name, input.value);
                }
            });
            
            return values;
        },

        // 現在の値を取得（ラジオボタン対応）
        getCurrentValues(form) {
            const values = new Map();
            const inputs = this.getFormInputs(form);
            
            const radioGroups = new Set();
            
            inputs.forEach(input => {
                if (input.type === 'radio') {
                    if (!radioGroups.has(input.name)) {
                        radioGroups.add(input.name);
                        const checkedRadio = form.querySelector(`input[type="radio"][name="${input.name}"]:checked`);
                        values.set(input.name, checkedRadio ? checkedRadio.value : '');
                    }
                } else if (input.type === 'checkbox') {
                    values.set(input.name, input.checked ? input.value : '');
                } else {
                    values.set(input.name, input.value);
                }
            });
            
            return values;
        },

        setupChangeDetection(form) {
            const inputs = this.getFormInputs(form);

            const checkChanges = () => {
                const formState = this.formStates.get(form.id);
                if (!formState) return;

                const currentValues = this.getCurrentValues(form);
                const hasChanges = Array.from(currentValues.entries()).some(
                    ([name, value]) => value !== formState.initialValues.get(name)
                );

                formState.isChanged = hasChanges;
                form.dataset.isChanged = hasChanges.toString();

                // console.log('Change detected:', {
                //     formId: form.id,
                //     currentValues: Object.fromEntries(currentValues),
                //     initialValues: Object.fromEntries(formState.initialValues),
                //     hasChanges: hasChanges
                // });
            };

            inputs.forEach(input => {
                // ラジオボタンとチェックボックスはchangeイベントのみ
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.addEventListener('change', checkChanges);
                } else {
                    input.addEventListener('input', checkChanges);
                    input.addEventListener('change', checkChanges);
                }
            });
        },

        resetForm(form) {
            // console.log('Starting form reset for:', form.id);
            
            form.reset();
            
            // 既存の初期値を保持（新しく取得しない）
            const formState = this.formStates.get(form.id);
            if (formState) {
                formState.isChanged = false;
                form.dataset.isChanged = 'false';
            }

            // console.log('Form reset completed:', {
            //     formId: form.id,
            //     initialValues: formState ? Object.fromEntries(formState.initialValues) : 'not found',
            //     isChanged: false
            // });
        },

        getFormInputs(form) {
            return Array.from(form.elements).filter(element => 
                (element.tagName.toLowerCase() === 'input' || 
                 element.tagName.toLowerCase() === 'select' || 
                 element.tagName.toLowerCase() === 'textarea') &&
                !['hidden', 'submit', 'button'].includes(element.type)
            );
        },

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

        setupSubmitHandler(form) {
            form.addEventListener('submit', () => {
                const formState = this.formStates.get(form.id);
                if (formState) {
                    formState.isChanged = false;
                    form.dataset.isChanged = 'false';
                }
            });
        },

        initializeCreateForm() {
            const form = document.getElementById(`${formPrefix}-create`);
            if (!form) return;

            const initialValues = this.getInitialValues(form);

            this.formStates.set(form.id, {
                initialValues: initialValues,
                isChanged: false
            });

            this.setupChangeDetection(form);
            this.setupCloseButton(form);
            this.setupSubmitHandler(form);
        },

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
                const newWidth = Math.min(initialWidth - diffX, window.innerWidth);

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
        
        DrawerManager.setupInitialState();
    }

    // ドロワーを開く
    function openDrawer(id) {
        const drawer = document.getElementById(`drawer-${id}`);
        const overlay = document.getElementById('overlay');
        
        if (drawer && overlay) {
            const maxWidth = Math.min(DrawerManager.currentWidth, window.innerWidth);
            drawer.style.width = `${maxWidth}px`;

            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            drawer.classList.remove('translate-x-full');
            updateUrl(id);
            
            DrawerManager.activeDrawerId = id;
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
            
            DrawerManager.activeDrawerId = null;
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
                    form.querySelectorAll('input:not([type="hidden"]), select').forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    });
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
    FormManager.handleValidationError();
    setupSearchFormReset();

    // グローバル関数として公開
    window.openDrawer = openDrawer;
    window.closeDrawer = closeDrawer;
}

// DOMContentLoaded時に実行される
document.addEventListener('DOMContentLoaded', function() {
    const defaultFormPrefix = 'support-type-form';
    const formPrefix = (typeof window.FORM_PREFIX !== 'undefined') ? window.FORM_PREFIX : defaultFormPrefix;
    
    initializeDrawerManager(formPrefix);
});