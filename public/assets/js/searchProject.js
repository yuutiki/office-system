    // 製品検索モーダルを表示するための関数
    function showProjectModal() {
        const modal = document.getElementById('projectSearchModal');
        // 背後の操作不可を有効
        const overlay = document.getElementById('overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // モーダルを表示するためのクラスを追加
        modal.classList.remove('hidden');

        // モーダル内のコンテンツ要素を取得
        const modalContent = modal.querySelector('.rounded');

        // Tabキーによるフォーカス移動をトラップする関数
        function trapTabKey(e) {
            if (e.key === 'Tab') {
                const focusableElements = modalContent.querySelectorAll(
                    'a[href], button:not([disabled]), textarea, input:not([disabled]), select:not([disabled])'
                );

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
            }
        }

        // Tabキーイベントをモーダル内で捕捉
        modalContent.addEventListener('keydown', trapTabKey);

        // モーダルが開かれたときに最初のフォーカス可能な要素にフォーカスを当てる
        const productNameInput = document.getElementById('projectNumber');
        productNameInput.focus();
    }


    // プロジェクト検索モーダルを非表示にするための関数
    function hideProjectModal() {
        const modal = document.getElementById('projectSearchModal');
        // 背後の操作不可を解除
        const overlay = document.getElementById('overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        // モーダルを非表示にするためのクラスを追加
        modal.classList.add('hidden');

        const ProjectButton = document.getElementById('searchProjectButton');
        ProjectButton.focus();

        // モーダル内のコンテンツ要素からTabキーイベントリスナーを削除
        const modalContent = modal.querySelector('.rounded');
        modalContent.removeEventListener('keydown', showProjectModal.trapTabKey);
    }


    //プロジェクト検索ボタンを押下した際の処理
        function searchProject() {
            const projectName = document.getElementById('projectName').value;
            const projectNumber = document.getElementById('projectNumber').value;
            // const productSplitTypeId = document.getElementById('productSplitTypeId').value;

            fetch('/projects/search', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ projectName, projectNumber, })
            })
            .then(response => response.json())
            .then(data => {
                const searchResultsProjectContainer = document.getElementById('searchResultsProjectContainer');
                searchResultsProjectContainer.innerHTML = '';

                data.forEach(result => {
                const resultElement = document.createElement('tr');
                resultElement.classList.add('dark:border-gray-700', 'hover:bg-gray-600', 'dark:text-white', 'border-b-white')
                resultElement.innerHTML = `
                    <td class="py-2 pl-5 cursor-pointer" onclick="setProject('${result.id}','${result.project_num}', '${result.project_name}', '${result.account_user.name}', '${result.sales_stage.sales_stage_name}','${result.client.client_name}')">${result.project_num}</td>
                    <td class="py-2 ml-2">${result.client.client_name}</td>
                    <td class="py-2 ml-2">${result.project_name}</td>
                `;
                searchResultsProjectContainer.appendChild(resultElement);
                });
            });
            }

            // function setProject(id, num, name, accountUserName, salesStageName) {
            // document.getElementById('project_id').value = id;
            // document.getElementById('project_num').value = num;
            // document.getElementById('project_name').value = name;
            // document.getElementById('account_user').value = accountUserName;
            // document.getElementById('sales_stage_name').value = salesStageName;
            // hideProjectModal();
            // }

            // プロジェクト情報をセットする関数
            function setProject(id, num, name, accountUserName, salesStageName, clientName) {
                // セットする値と対応する要素のマッピング
                var valueMap = {
                    'project_id': id,
                    'project_num': num,
                    'project_name': name,
                    'account_user': accountUserName,
                    'sales_stage_name': salesStageName,
                    'client_name':clientName,
                };
                
                // マッピングされた各要素について、存在すれば値をセットし、存在しなければスルーする
                Object.keys(valueMap).forEach(function(elementId) {
                    // 要素のIDから対応する値を取得
                    var value = valueMap[elementId];
                    // 値が存在する場合にのみ処理を行う
                    if (value !== null && value !== undefined) {
                        // 対応する要素を取得
                        var element = document.getElementById(elementId);
                        // 要素が存在する場合にのみ値をセットする
                        if (element) {
                            element.value = value;
                        }
                    }
                });
                
                // プロジェクトモーダルを非表示にする
                hideProjectModal();
            }
            


// 使用画面
// ・contract-details.create
// ・contract-details.edit
// ・keepfiles.create
// ・keepfiles.edit