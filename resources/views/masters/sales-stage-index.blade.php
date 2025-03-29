<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('salesStageMaster') }}
                <div class="ml-4" id="record-count">
                    {{ $count }}件
                </div>
            </h2>
            <div class="flex justify-end">
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <!-- 検索・フィルタリング部分 -->
    <div class="relative bg-white dark:bg-gray-800 rounded-t-md md:w-auto md:ml-14 md:mr-2 m-auto shadow-md dark:text-gray-900 mt-4">
        <div class="w-full">
            <div class="relative bg-white dark:bg-gray-800">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                    <div class="w-full">
                        <div class="flex flex-col md:flex-row w-full" id="search-form">
                            <div class="relative w-full">
                                <div class="absolute inset-y-5 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" id="code-search" name="code" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="コード" >
                            </div>

                            <div class="relative w-full mt-2 md:ml-2 md:mt-0">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="search" id="name-search" name="name" class="block w-full p-2 pl-10 text-sm text-gray-900 dark:text-white rounded bg-gray-100 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 border-gray-400 border focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 placeholder:text-gray-400" placeholder="名称" >
                            </div>

                            <div class="flex mt-2 md:mt-0">
                                <div class="flex flex-col justify-end w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                                    <div class="flex mt-4 md:mt-0">
                                        <button type="button" id="search-button" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <div class="whitespace-nowrap">検索</div>
                                        </button>
                                        <button type="button" id="reset-button" class="ml-2 px-4 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                            <div class="whitespace-nowrap">リセット</div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- テーブルのローディングインジケーター -->
        <div id="loading-indicator" class="hidden flex justify-center items-center p-6">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
        </div>

        <!-- データテーブル部分 -->
        <div class="md:w-auto md:mr-2 mb-4 relative overflow-x-auto rounded-b shadow-md dark:bg-gray-700 dark:text-gray-900 bg-gray-300">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="pl-4 py-3 whitespace-nowrap cursor-pointer" data-sort="sales_stage_code">
                            <div class="flex items-center">
                                コード
                                <span class="sort-icon ml-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap cursor-pointer" data-sort="sales_stage_name">
                            <div class="flex items-center">
                                名称
                                <span class="sort-icon ml-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap cursor-pointer" data-sort="updated_by">
                            <div class="flex items-center">
                                更新者
                                <span class="sort-icon ml-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap cursor-pointer" data-sort="updated_at">
                            <div class="flex items-center">
                                更新日時
                                <span class="sort-icon ml-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody id="sales-stages-table-body">
                    <!-- テーブル本体はJavaScriptで動的に生成されます -->
                </tbody>
            </table>
        </div>
        
        <!-- ページネーション部分 -->
        <div class="mt-2 mb-2 px-4" id="pagination-container">
            <!-- ページネーションはJavaScriptで動的に生成されます -->
        </div> 
    </div>

    <!-- 編集モーダル -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        営業段階マスタ編集
                    </h3>
                    <button type="button" id="close-modal-button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-md text-sm w-8 h-8 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                
                <form id="edit-form" class="mt-4">
                    <input type="hidden" id="edit-id">
                    
                    <div class="w-full flex flex-col mb-4">
                        <label for="edit-sales-stage-code" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mb-2">コード</label>
                        <input type="text" maxlength="3" id="edit-sales-stage-code" name="sales_stage_code" class="dark:bg-white w-full py-2 border border-gray-300 rounded-md" required>
                    </div>
                    
                    <div class="w-full flex flex-col mb-4">
                        <label for="edit-sales-stage-name" class="font-semibold dark:text-gray-100 text-gray-900 leading-none mb-2">名称</label>
                        <input type="text" maxlength="20" id="edit-sales-stage-name" name="sales_stage_name" class="dark:bg-white w-full py-2 border border-gray-300 rounded-md" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <button type="submit" id="update-button" class="w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            更新
                        </button>
                        <button type="button" id="delete-button" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                            <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            削除
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 現在のページと並び替えの状態を保持
            let currentPage = 1;
            let sortColumn = 'sales_stage_code';
            let sortDirection = 'asc';
            let searchParams = {};
            
            // CSRFトークン設定
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // 初期データ読み込み
            fetchSalesStages();
            
            // 検索ボタンのイベントリスナー
            document.getElementById('search-button').addEventListener('click', function() {
                searchParams = {
                    code: document.getElementById('code-search').value,
                    name: document.getElementById('name-search').value
                };
                currentPage = 1; // 検索時は最初のページに戻る
                fetchSalesStages();
            });
            
            // リセットボタンのイベントリスナー
            document.getElementById('reset-button').addEventListener('click', function() {
                document.getElementById('code-search').value = '';
                document.getElementById('name-search').value = '';
                searchParams = {};
                currentPage = 1;
                fetchSalesStages();
            });
            
            // ソートヘッダーのイベントリスナー
            document.querySelectorAll('th[data-sort]').forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.getAttribute('data-sort');
                    
                    // 同じカラムをクリックした場合は並び順を反転
                    if (sortColumn === column) {
                        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortColumn = column;
                        sortDirection = 'asc';
                    }
                    
                    // ソートアイコンを更新
                    updateSortIcons();
                    
                    // データを再取得
                    fetchSalesStages();
                });
            });
            
            // ソートアイコンを更新する関数
            function updateSortIcons() {
                // すべてのソートアイコンをリセット
                document.querySelectorAll('.sort-icon').forEach(icon => {
                    icon.innerHTML = `
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    `;
                });
                
                // アクティブなソートカラムのアイコンを更新
                const activeIcon = document.querySelector(`th[data-sort="${sortColumn}"] .sort-icon`);
                if (activeIcon) {
                    if (sortDirection === 'asc') {
                        activeIcon.innerHTML = `
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        `;
                    } else {
                        activeIcon.innerHTML = `
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        `;
                    }
                }
            }
            
            // データを取得する関数
            function fetchSalesStages() {
                // ローディングインジケーターを表示
                document.getElementById('loading-indicator').classList.remove('hidden');
                document.getElementById('sales-stages-table-body').innerHTML = '';
                
                // リクエストパラメータを構築
                const params = new URLSearchParams({
                    page: currentPage,
                    sort_column: sortColumn,
                    sort_direction: sortDirection,
                    ...searchParams
                });
                
                // Fetch APIを使ってデータを取得
                fetch(`/api/sales-stages?${params.toString()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // ローディングインジケーターを非表示
                        document.getElementById('loading-indicator').classList.add('hidden');
                        
                        // レコード件数を更新
                        document.getElementById('record-count').textContent = `${data.total}件`;
                        
                        // テーブル本体を更新
                        renderTableBody(data.data);
                        
                        // ページネーションを更新
                        renderPagination(data);
                    })
                    .catch(error => {
                        console.error('Error fetching sales stages:', error);
                        document.getElementById('loading-indicator').classList.add('hidden');
                        // エラーメッセージを表示
                        document.getElementById('sales-stages-table-body').innerHTML = `
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-red-500">
                                    データの取得中にエラーが発生しました。再読み込みしてください。
                                </td>
                            </tr>
                        `;
                    });
            }
            
            // テーブル本体を描画する関数
            function renderTableBody(salesStages) {
                const tableBody = document.getElementById('sales-stages-table-body');
                tableBody.innerHTML = '';
                
                if (salesStages.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center">
                                データが見つかりませんでした。
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                salesStages.forEach(stage => {
                    const tr = document.createElement('tr');
                    tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white dark:hover:bg-gray-600';
                    
                    tr.innerHTML = `
                        <td class="pl-4 py-2 whitespace-nowrap">
                            ${stage.sales_stage_code}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${stage.sales_stage_name}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            ${stage.updated_by ? stage.updated_by.user_name : ''}
                        </td>
                        <td class="px-1 py-2 whitespace-nowrap">
                            ${stage.updated_at}
                        </td>
                        <td class="px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-center">
                                <button class="button-edit edit-button" type="button" data-id="${stage.id}">
                                    編集
                                </button>
                            </div>
                        </td>
                    `;
                    
                    tableBody.appendChild(tr);
                });
                
                // 編集ボタンのイベントリスナーを追加
                document.querySelectorAll('.edit-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        openEditModal(id);
                    });
                });
            }
            
            // ページネーションを描画する関数
            function renderPagination(data) {
                const paginationContainer = document.getElementById('pagination-container');
                paginationContainer.innerHTML = '';
                
                if (data.last_page <= 1) {
                    return;
                }
                
                const pagination = document.createElement('div');
                pagination.className = 'flex justify-center mt-4';
                
                // 前のページボタン
                const prevButton = document.createElement('button');
                prevButton.className = `px-3 py-1 rounded-md ${data.current_page === 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                prevButton.innerHTML = '前へ';
                prevButton.disabled = data.current_page === 1;
                
                if (data.current_page !== 1) {
                    prevButton.addEventListener('click', function() {
                        currentPage--;
                        fetchSalesStages();
                    });
                }
                
                pagination.appendChild(prevButton);
                
                // ページ番号ボタン
                let startPage = Math.max(1, data.current_page - 2);
                let endPage = Math.min(data.last_page, startPage + 4);
                
                if (endPage - startPage < 4 && startPage > 1) {
                    startPage = Math.max(1, endPage - 4);
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.className = `mx-1 px-3 py-1 rounded-md ${i === data.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                    pageButton.innerHTML = i;
                    
                    if (i !== data.current_page) {
                        pageButton.addEventListener('click', function() {
                            currentPage = i;
                            fetchSalesStages();
                        });
                    }
                    
                    pagination.appendChild(pageButton);
                }
                
                // 次のページボタン
                const nextButton = document.createElement('button');
                nextButton.className = `ml-1 px-3 py-1 rounded-md ${data.current_page === data.last_page ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                nextButton.innerHTML = '次へ';
                nextButton.disabled = data.current_page === data.last_page;
                
                if (data.current_page !== data.last_page) {
                    nextButton.addEventListener('click', function() {
                        currentPage++;
                        fetchSalesStages();
                    });
                }
                
                pagination.appendChild(nextButton);
                paginationContainer.appendChild(pagination);
            }
            
            // 編集モーダルを開く関数
            function openEditModal(id) {
                // モーダルを表示
                document.getElementById('edit-modal').classList.remove('hidden');
                
                // ロギングを追加してデバッグ
                console.log('Fetching data for ID:', id);
                
                // Fetch APIでレコード詳細を取得
                fetch(`/api/sales-stages/${id}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // レスポンスデータの中身を確認
                    console.log('Received data:', data);
                    
                    // APIからのレスポンス構造を考慮した修正
                    // 実際のAPIレスポンスは { data: { ... } } の形式になっていることを確認
                    const salesStage = data.data || data;
                    
                    // フォームに値をセット
                    document.getElementById('edit-id').value = salesStage.id;
                    document.getElementById('edit-sales-stage-code').value = salesStage.sales_stage_code;
                    document.getElementById('edit-sales-stage-name').value = salesStage.sales_stage_name;
                    
                    // セット後の値を確認
                    console.log('Set form values:', {
                        id: document.getElementById('edit-id').value,
                        code: document.getElementById('edit-sales-stage-code').value,
                        name: document.getElementById('edit-sales-stage-name').value
                    });
                })
                .catch(error => {
                    console.error('Error fetching sales stage details:', error);
                    alert('データの取得中にエラーが発生しました。再試行してください。');
                    closeEditModal();
                });
            }
            
            // 編集モーダルを閉じる関数
            function closeEditModal() {
                document.getElementById('edit-modal').classList.add('hidden');
                document.getElementById('edit-form').reset();
            }
            
            // モーダルの閉じるボタンのイベントリスナー
            document.getElementById('close-modal-button').addEventListener('click', closeEditModal);
            
            // モーダル外クリックで閉じる
            document.getElementById('edit-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeEditModal();
                }
            });
            
            // 更新ボタンのイベントリスナー
            document.getElementById('edit-form').addEventListener('submit', function(event) {
                event.preventDefault();
                
                const id = document.getElementById('edit-id').value;
                const formData = {
                    sales_stage_code: document.getElementById('edit-sales-stage-code').value,
                    sales_stage_name: document.getElementById('edit-sales-stage-name').value
                };
                
                // Fetch APIでデータを更新
                fetch(`/api/sales-stages/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 更新成功時の処理
                        closeEditModal();
                        // 成功メッセージを表示（フラッシュメッセージなど）
                        showToast('更新が完了しました', 'success');
                        // テーブルデータを再取得
                        fetchSalesStages();
                    })
                    .catch(error => {
                        console.error('Error updating sales stage:', error);
                        try {
                            const errorData = JSON.parse(error.message);
                            // バリデーションエラーなどの処理
                            if (errorData.errors) {
                                Object.keys(errorData.errors).forEach(key => {
                                    // 該当フィールドにエラーメッセージを表示
                                    const inputField = document.getElementById(`edit-${key.replace('_', '-')}`);
                                    if (inputField) {
                                        inputField.classList.add('border-red-500');
                                        const errorElement = document.createElement('p');
                                        errorElement.className = 'text-red-500 text-xs mt-1';
                                        errorElement.textContent = errorData.errors[key][0];
                                        inputField.parentNode.appendChild(errorElement);
                                    }
                                });
                            } else {
                                showToast(errorData.message || '更新中にエラーが発生しました', 'error');
                            }
                        } catch (e) {
                            showToast('更新中にエラーが発生しました', 'error');
                        }
                    });
            });
            
            // 削除ボタンのイベントリスナー
            document.getElementById('delete-button').addEventListener('click', function() {
                const id = document.getElementById('edit-id').value;
                
                if (confirm('本当に削除しますか？この操作は取り消せません。')) {
                    // Fetch APIでデータを削除
                    fetch(`/api/sales-stages/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // 削除成功時の処理
                            closeEditModal();
                            // 成功メッセージを表示
                            showToast('削除が完了しました', 'success');
                            // テーブルデータを再取得
                            fetchSalesStages();
                        })
                        .catch(error => {
                            console.error('Error deleting sales stage:', error);
                            showToast('削除中にエラーが発生しました', 'error');
                        });
                }
            });
            
            // トーストメッセージを表示する関数
            function showToast(message, type = 'info') {
                // 既存のトーストを削除
                const existingToast = document.getElementById('toast-message');
                if (existingToast) {
                    existingToast.remove();
                }
                
                // 新しいトーストを作成
                const toast = document.createElement('div');
                toast.id = 'toast-message';
                toast.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-md transition-opacity duration-500 ${
                    type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
                } text-white`;
                toast.innerHTML = `
                    <div class="flex items-center">
                        <span class="mr-2">
                            ${type === 'success' 
                                ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
                                : type === 'error'
                                    ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
                                    : '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
                            }
                        </span>
                        <span>${message}</span>
                    </div>
                `;
                
                // ドキュメントに追加
                document.body.appendChild(toast);
                
                // 数秒後に消える
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 3000);
            }
            
            // Enter キーでのフォーム送信時に検索を実行
            document.getElementById('code-search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('search-button').click();
                }
            });
            
            document.getElementById('name-search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('search-button').click();
                }
            });
        });
    </script>
</x-app-layout>