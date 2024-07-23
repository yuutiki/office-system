<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">
                見積書登録
            </h2>
            <div class="flex justify-end">
                <x-general-button onclick="location.href='{{route('clients.index')}}'">
                    戻る
                </x-general-button>
                <x-primary-button class="ml-2" form="form1">
                    新規登録する
                </x-primary-button>
                <x-message :message="session('message')"/>
            </div>
        </div>
    </x-slot>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>

    <div class="mx-auto sm:pl-16 pr-3 pl-3 pb-4">
        {{-- <div class="mx-4 sm:p-8"> --}}
            <form id="form1" method="post" action="{{route('projects.store')}}" enctype="multipart/form-data" autocomplete="new-password">
                @csrf
                {{-- <div class="grid gap-4 mb-4 sm:grid-cols-3">
                    <div class="">
                        <label for="clientcorporation_name" class="block  dark:text-gray-100 text-gray-900 leading-none md:mt-4">法人名称</label>
                        <input type="text" name="clientcorporation_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="clientcorporation_name" value="{{old('clientcorporation_name')}}" placeholder="顧客検索してください" readonly>
                        @error('clientcorporation_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hidden">
                        <label for="client_num" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客番号</label>
                        <input type="text" name="client_num" id="client_num" value="{{old('client_num')}}" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed">
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">顧客名称</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="client_name" value="{{old('client_name')}}" placeholder="顧客検索してください" readonly>
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="department_id" class="block  text-gray-900 dark:text-white leading-none md:mt-4">管轄事業部</label>
                        <select id="department_id" name="department_id" class="dark:bg-gray-400 mt-1 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 pointer-events-none" readonly>
                            <option value="">未選択</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected($department->id == old('department_id'))>{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="">
                        <label for="project_num" class="block  dark:text-gray-100 text-gray-900 leading-none md:mt-4">見積番号</label>
                        <input type="text" name="project_num" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1 cursor-not-allowed" id="project_num" value="{{old('project_num')}}" placeholder="登録時に自動採番されます" readonly>
                        @error('project_num')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="project_name" class="block  dark:text-gray-100 text-gray-900 leading-none md:mt-4">宛名</label>
                        <input type="text" name="project_name" class="w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="project_name" value="白梅学園大学" placeholder="">
                        @error('project_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">見積書表題</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="御　見　積　書" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">注文書表題</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="注　文　書" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">件名</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="grid gap-4 mb-4 sm:grid-cols-5">

                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">受渡期日</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="御相談" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">受渡場所</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="御指定場所" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">取引方法</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="月末締翌月末迄現金" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">有効期限</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="3ヶ月" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">見積作成日</label>
                        <input type="date" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="2024-01-04" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">住所</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="3ヶ月" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">担当者</label>
                        <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="3ヶ月" placeholder="">
                        @error('client_name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">見積書明細</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">注文書設定</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">見積書別紙</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">添付ファイル</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="order-tab" data-tabs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">決裁情報</button>
                        </li>
                    </ul>
                </div>


                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <div id="mytable"></div>

                        {{-- <label>{{ __('材料') }}
                            <a onclick = add() class="btn btn-sm btn-light">明細追加</a>
                            <div id="input_plural">
                                <div class="flex">
                                    <input type="text" class="input-primary text-sm" name="ing-name-1">
                                    <input type="text" class="input-primary ml-2 text-sm" name="ing-size-1">
                                    <input type="text" class="input-primary ml-2 text-sm" name="ing-maker-1">
                                    <input type="text" class="input-primary ml-2 text-sm" name="ing-kataban-1">
                                    <input type="text" class="input-primary ml-2 text-sm" name="ing-tanka-1">
                                    <input type="button" class="button-delete ml-2" value="削除" onclick="del(this)">
                                </div>
                            </div>
                      </label> --}}

                      <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

                      <label>
                          <a onclick="add()" class="rounded bg-blue-500 py-2 px-1 cursor-pointer text-white">明細追加</a>
                      </label>
                      <div class="relative overflow-x-auto mt-4">
                          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                              <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 mt-8">
                                  <tr>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">複製</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600"></th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">No.</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600 hidden">並び順</th>
                                      <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">商品CD</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">品名</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">メーカ</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">標準単価</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">原価/個</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">数量</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">標準価格</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">値引額</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">提供価格</th>
                                      <th scope="col" class="px-2 py-0.5 whitespace-nowrap border-x border-gray-600 text-xs">粗利額<br>粗利率</th>
                                      <th scope="col" class="px-2 py-2 whitespace-nowrap border-x border-gray-600">操作</th>
                                  </tr>
                              </thead>
                              <tbody id="input_plural">
                                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                                      <td class="px-1 border border-gray-600 text-center">
                                          <button type="button" class="copy-row p-1 text-sm font-medium text-white bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" onclick="copyRow(this)">
                                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                              </svg>
                                          </button>
                                      </td>
                                      <td class="px-1 border border-gray-600 text-center drag-handle">
                                          <svg class="w-6 h-6 text-gray-800 dark:text-white cursor-move" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3"/>
                                          </svg>
                                      </td>
                                      <td class="px-1 border border-gray-600 text-center">1</td>
                                      <td class="px-1 border border-gray-600 hidden"><input type="hidden" name="sort-order-1" value="1"></td>
                                      <td class="px-1 border border-gray-600">
                                          <div class="flex">
                                              <input type="text" class="input-estimate w-[130px] text-sm" name="ing-cd-1">
                                              <button type="button" id="invoiceApi" class="p-2.5 text-sm font-medium h-[34px] items-center text-white ml-1 mt-1 bg-blue-700 rounded border border-blue-700 hover:bg-blue-800 focus:outline-none  dark:bg-blue-600 dark:hover:bg-blue-700  dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                  </svg>
                                              </button>
                                          </div>
                                      </td>
                                      <td class="px-1 border border-gray-600"><div class="flex"><input type="text" class="input-estimate min-w-[400px] text-sm" name="ing-name-1"></div></td>
                                      <td class="px-1 border border-gray-600"><input type="text" class="input-estimate text-sm" name="ing-maker-1"></td>
                                      <td class="px-1 border border-gray-600"><input type="text" class="input-estimate w-[110px] text-sm text-right" name="ing-tanka-1" onchange="formatNumber(this); calculateAll(this)"></td>
                                      <td class="px-1 border border-gray-600"><input type="text" class="input-estimate w-[110px] text-sm text-right" name="ing-genka-1" onchange="formatNumber(this); calculateAll(this)"></td>
                                      <td class="px-1 border border-gray-600"><input type="number" class="input-estimate w-12 text-sm text-right" name="ing-suryo-1" onchange="calculateAll(this)"></td>
                                      <td class="px-1 border border-gray-600 readonly-cell"><input type="text" class="input-estimate w-[110px] text-sm readonly-cell pointer-events-none text-right" name="ing-hyojun-1" readonly tabindex="-1"></td>
                                      <td class="px-1 border border-gray-600 readonly-cell hidden"><input type="text" class="input-estimate  w-[110px] text-sm readonly-cell pointer-events-none text-right" name="ing-hyojungenka-1" readonly tabindex="-1"></td>
                                      <td class="px-1 border border-gray-600"><input type="text" class="input-estimate w-[110px] text-sm dark:text-red-500 text-right" name="ing-nebiki-1" onchange="formatNebiki(this); calculateAll(this)"></td>
                                      <td class="px-1 border border-gray-600 readonly-cell"><input type="text" class="input-estimate w-[110px] text-sm readonly-cell pointer-events-none text-right" name="ing-teikyo-1" readonly tabindex="-1"></td>
                                      <td class="px-1 border border-gray-600 readonly-cell">
                                          <input type="text" class="input-estimate-arari w-[110px] text-xs py-0 readonly-cell pointer-events-none text-right block" name="ing-arari-1" readonly tabindex="-1">
                                          <input type="text" class="input-estimate-arari w-[110px] text-xs py-0 readonly-cell pointer-events-none text-right mt-0" name="ing-arariritu-1" readonly tabindex="-1">
                                      </td>
                                      <td class="px-1 border border-gray-600"><input type="button" class="button-delete" value="削除" onclick="del(this)" tabindex="-1"></td>
                                  </tr>
                              </tbody>
                          </table>
                          <div class="mt-4">
                              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200 border border-gray-600">
                                  <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                      <tr>
                                          <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">項目</th>
                                          <th scope="col" class="px-6 py-2 whitespace-nowrap border-x border-gray-600">金額</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                          <td class="px-6 py-2 border-x border-gray-600">原価合計</td>
                                          <td class="px-6 py-2 border-x border-gray-600"><span id="total-cost">0</span></td>
                                      </tr>
                                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                          <td class="px-6 py-2 border-x border-gray-600">粗利合計</td>
                                          <td class="px-6 py-2 border-x border-gray-600"><span id="total-profit">0</span></td>
                                      </tr>
                                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                          <td class="px-6 py-2 border-x border-gray-600">税抜合計</td>
                                          <td class="px-6 py-2 border-x border-gray-600"><span id="total-without-tax">0</span></td>
                                      </tr>
                                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                          <td class="px-6 py-2 border-x border-gray-600">消費税額</td>
                                          <td class="px-6 py-2 border-x border-gray-600"><span id="total-tax">0</span></td>
                                      </tr>
                                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                          <td class="px-6 py-2 border-x border-gray-600">税込合計</td>
                                          <td class="px-6 py-2 border-x border-gray-600"><span id="total-with-tax">0</span></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                    
                      <script>
                        let rowCount = 1;
                        
                        function add() {
                            rowCount++;
                            const newRow = document.querySelector('#input_plural tr').cloneNode(true);
                            newRow.querySelectorAll('input').forEach(input => {
                                input.value = '';
                                const nameParts = input.name.split('-');
                                input.name = `${nameParts[0]}-${nameParts[1]}-${rowCount}`;
                            });
                            newRow.querySelector('td:nth-child(3)').textContent = rowCount;
                            newRow.querySelector('input[type="hidden"]').name = `sort-order-${rowCount}`;
                            newRow.querySelector('input[type="hidden"]').value = rowCount;
                            
                            // 削除ボタンのテキストを設定
                            const deleteButton = newRow.querySelector('.button-delete');
                            if (deleteButton) {
                                deleteButton.value = '削除';
                            }
                            
                            document.querySelector('#input_plural').appendChild(newRow);
                            updateSortable();
                            setupInputListeners(); // 追加
                        }
                        
                        function del(button) {
                            if (document.querySelectorAll('#input_plural tr').length > 1) {
                                button.closest('tr').remove();
                                renumberRows();
                                calculateTotals();
                            }
                        }
                        
                        function renumberRows() {
                            document.querySelectorAll('#input_plural tr').forEach((row, index) => {
                                const rowNumber = index + 1;
                                row.querySelector('td:nth-child(3)').textContent = rowNumber;
                                row.querySelector('input[type="hidden"]').name = `sort-order-${rowNumber}`;
                                row.querySelector('input[type="hidden"]').value = rowNumber;
                                row.querySelectorAll('input:not([type="hidden"])').forEach(input => {
                                    const nameParts = input.name.split('-');
                                    input.name = `${nameParts[0]}-${nameParts[1]}-${rowNumber}`;
                                });
                            });
                            rowCount = document.querySelectorAll('#input_plural tr').length;
                        }
                        
                        function copyRow(button) {
                            const originalRow = button.closest('tr');
                            const newRow = originalRow.cloneNode(true);
                            rowCount++;

                            // No.列の数字を更新
                            newRow.querySelector('td:nth-child(3)').textContent = rowCount;

                            newRow.querySelector('input[type="hidden"]').name = `sort-order-${rowCount}`;
                            newRow.querySelector('input[type="hidden"]').value = rowCount;
                            newRow.querySelectorAll('input:not([type="hidden"])').forEach(input => {
                                const nameParts = input.name.split('-');
                                input.name = `${nameParts[0]}-${nameParts[1]}-${rowCount}`;
                            });

                            // 削除ボタンのテキストを設定
                            const deleteButton = newRow.querySelector('.button-delete');
                            if (deleteButton) {
                                deleteButton.value = '削除';
                            }

                            originalRow.parentNode.insertBefore(newRow, originalRow.nextSibling);
                            updateSortable();
                            renumberRows(); // 全ての行の番号を振り直す
                            calculateAll(newRow.querySelector('input[name^="ing-suryo-"]'));
                            setupInputListeners(); // 追加
                        }
                        
                        function formatNumber(input) {
                            let value = input.value.replace(/[^\d.-]/g, '');
                            if (value !== '' && !isNaN(value)) {
                                input.value = Number(value).toLocaleString();
                            }
                        }
                        
                        function formatNebiki(input) {
                            let value = input.value.replace(/[^\d.-]/g, '');
                            if (value !== '' && !isNaN(value)) {
                                if (value.startsWith('-')) {
                                    input.value = '-' + Number(value.slice(1)).toLocaleString();
                                } else {
                                    input.value = '-' + Number(value).toLocaleString();
                                }
                            }
                        }
                        
                        function calculateAll(changedInput) {
                            const row = changedInput.closest('tr');
                            const tanka = parseFloat(row.querySelector('input[name^="ing-tanka-"]').value.replace(/,/g, '')) || 0;
                            const genka = parseFloat(row.querySelector('input[name^="ing-genka-"]').value.replace(/,/g, '')) || 0;
                            const suryo = parseFloat(row.querySelector('input[name^="ing-suryo-"]').value) || 0;
                            const nebiki = parseFloat(row.querySelector('input[name^="ing-nebiki-"]').value.replace(/,/g, '')) || 0;
                        
                            const hyojun = tanka * suryo;
                            const hyojungenka = genka * suryo;
                            const teikyo = hyojun + nebiki;
                            const arari = teikyo - hyojungenka;
                            const arariritu = teikyo !== 0 ? (arari / teikyo) * 100 : 0;
                        
                            row.querySelector('input[name^="ing-hyojun-"]').value = Math.round(hyojun).toLocaleString();
                            row.querySelector('input[name^="ing-hyojungenka-"]').value = Math.round(hyojungenka).toLocaleString();
                            row.querySelector('input[name^="ing-teikyo-"]').value = Math.round(teikyo).toLocaleString();
                            row.querySelector('input[name^="ing-arari-"]').value = Math.round(arari).toLocaleString();
                            row.querySelector('input[name^="ing-arariritu-"]').value = arariritu.toFixed(2) + '%';
                        
                            calculateTotals();
                        }
                        
                        function calculateTotals() {
                            let totalCost = 0;
                            let totalProfit = 0;
                            let totalWithoutTax = 0;
                        
                            document.querySelectorAll('#input_plural tr').forEach(row => {
                                const genka = parseFloat(row.querySelector('input[name^="ing-genka-"]').value.replace(/,/g, '')) || 0;
                                const suryo = parseFloat(row.querySelector('input[name^="ing-suryo-"]').value) || 0;
                                const teikyo = parseFloat(row.querySelector('input[name^="ing-teikyo-"]').value.replace(/,/g, '')) || 0;
                        
                                totalCost += genka * suryo;
                                totalProfit += teikyo - (genka * suryo);
                                totalWithoutTax += teikyo;
                            });
                        
                            const taxRate = 0.1; // 10%
                            const totalTax = totalWithoutTax * taxRate;
                            const totalWithTax = totalWithoutTax + totalTax;
                        
                            document.getElementById('total-cost').textContent = Math.round(totalCost).toLocaleString();
                            document.getElementById('total-profit').textContent = Math.round(totalProfit).toLocaleString();
                            document.getElementById('total-without-tax').textContent = Math.round(totalWithoutTax).toLocaleString();
                            document.getElementById('total-tax').textContent = Math.round(totalTax).toLocaleString();
                            document.getElementById('total-with-tax').textContent = Math.round(totalWithTax).toLocaleString();
                        }
                        
                        function updateSortable() {
                            const tbody = document.querySelector('#input_plural');
                            new Sortable(tbody, {
                                handle: '.drag-handle',
                                animation: 150,
                                onEnd: function() {
                                    renumberRows();
                                }
                            });
                        }
                        
                        document.addEventListener('DOMContentLoaded', function() {
                            updateSortable();
                            calculateTotals();
                        });
                        
                        // イベントリスナーを追加
                        document.querySelector('#input_plural').addEventListener('change', function(e) {
                            if (e.target.matches('input[name^="ing-tanka-"], input[name^="ing-genka-"], input[name^="ing-suryo-"], input[name^="ing-nebiki-"]')) {
                                calculateAll(e.target);
                            }
                        });

                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                // e.preventDefault(); // デフォルトの Enter キーの動作を防ぐ
                                moveCell(e.shiftKey ? 'up' : 'down');
                            }
                        });

                        function handleKeyDown(e) {
                            // input要素（textまたはnumber）にフォーカスがあり、かつテーブル内の要素である場合のみ処理を行う
                            if (e.target.matches('#input_plural input[type="text"], #input_plural input[type="number"]') && e.key === 'Enter') {
                                e.preventDefault();
                                moveCell(e.shiftKey ? 'up' : 'down', e.target);
                            }
                        }

                        function moveCell(direction, element) {
                            const currentCell = element.closest('td');
                            const currentRow = currentCell.parentElement;
                            const cellIndex = Array.from(currentRow.cells).indexOf(currentCell);
                            
                            let targetRow;
                            if (direction === 'down') {
                                targetRow = currentRow.nextElementSibling;
                                if (!targetRow) {
                                    targetRow = currentRow.parentElement.firstElementChild;
                                }
                            } else { // up
                                targetRow = currentRow.previousElementSibling;
                                if (!targetRow) {
                                    targetRow = currentRow.parentElement.lastElementChild;
                                }
                            }

                            if (targetRow) {
                                const targetCell = targetRow.cells[cellIndex];
                                const targetInput = targetCell.querySelector('input[type="text"], input[type="number"]');
                                if (targetInput) {
                                    targetInput.focus();
                                    targetInput.setSelectionRange(targetInput.value.length, targetInput.value.length);
                                }
                            }
                        }

                        function setupInputListeners() {
                            const inputs = document.querySelectorAll('#input_plural input[type="text"], #input_plural input[type="number"]');
                            inputs.forEach(input => {
                                input.addEventListener('keydown', handleKeyDown);
                            });
                        }
                        </script>

                    <style>
                        .readonly-cell {
                            background-color: #f3f4f6;
                            color: #6b7280;
                        }
                        .dark .readonly-cell {
                            background-color: #374151;
                            color: #9ca3af;
                        }
                        .input-estimate.text-right {
                            text-align: right;
                        }
                        .input-estimate.text-xs {
                            font-size: 0.75rem; /* テキストサイズを小さくする */
                        }
                    </style>

                        {{-- <div class="grid gap-4 sm:grid-cols-5">
                            <div class="">
                                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">税抜合計</label>
                                <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="totalPrice" value="3,000,000" placeholder="">
                            </div>
                            <div class="">
                                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-4">消費税額</label>
                                <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="300,000" placeholder="">
                            </div>
                        </div>
                        <div class="grid gap-4 mb-4 sm:grid-cols-5">
                            <div class="col-span-2">
                                <label for="client_name" class="block dark:text-gray-100 text-gray-900 leading-none md:mt-1">税込合計</label>
                                <input type="text" name="client_name" class="dark:bg-gray-400 w-full py-1 placeholder-gray-400 border border-gray-300 rounded mt-1" id="client_name" value="3,300,000" placeholder="">
                            </div>
                        </div> --}}

                        <div class="w-full flex flex-col">
                            <label for="memo" class="dark:text-gray-100 text-gray-900 leading-none mt-4">見積備考</label>
                            <textarea name="memo" class="w-auto py-1 border border-gray-300 rounded mt-1 placeholder-gray-400" id="auto-resize-textarea-client_memo" value="{{old('memo')}}" cols="30" rows="5">■内容等変更が生じた場合は再度御見積りが必要となります。
■消費税率が改定される際は別途御見積り致します。</textarea>
                        </div>

{{-- 添付ファイル　決裁シート　別紙　レイアウト　見積備考と注文書備考　採用フラグ　印刷用明細 --}}

                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="order" role="tabpanel" aria-labelledby="order-tab">
                        <button>generatePdf</button>
                        <iframe src="{{ route('estimate.pdf.generate') }}" style="width:600px; height:500px;"></iframe>
                    </div>
                </div>
            </form>
        {{-- </div> --}}
    </div>

    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css">
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css">
    <script src="https://bossanova.uk/jsuites/v4/jsuites.lang.ja.js"></script>
    <script>
//     const myTable = jspreadsheet(document.getElementById('mytable'), {
//       data: [
//         // ['PKN1000100', '学籍教務情報システム', 4700000, 200000, 1, "=C1*E1", 100000, "=F1-G1", "=H1-D1", "=(I1/H1)*100"],
//         // ['PKN1000101', '入試情報システム', 2400000, 100000, 1, "=C2*E2"]
//         ['PKN1000100', '学籍教務情報システム', 4700000, 200000, 1, null, 100000, null, null, null],
//         ['PKN1000101', '入試情報システム', 2400000, 100000, 1, null, null, null, null, null]
//       ],
//       columns: [
//         { type: 'text', title: '商品コード', width: 100 },
//         { type: 'text', title: '商品名称', width: 200, align:'left' },
//         { type: 'numeric', title: '標準単価', width: 100, mask:'#,##', align:'right' },
//         { type: 'numeric', title: '原価', width: 100, mask:'#,##', align:'right' },
//         { type: 'numeric', title: '数量', width: 80 },
//         { type: 'numeric', title: '標準価格', width: 80, mask:'#,##', align:'right',},
//         // { type: 'numeric', title: '標準価格', width: 80, mask:'#,##', align:'right',readOnly:true, editor: false,},
//         { type: 'numeric', title: '値引額', width: 80, mask:'#,##', align:'right' },
//         { type: 'numeric', title: '提供価格', width: 80, mask:'#,##', align:'right', },
//         // { type: 'numeric', title: '提供価格', width: 80, mask:'#,##', align:'right',readOnly:true, editor: false, },
//         { type: 'numeric', title: '粗利額', width: 80, mask:'#,##', align:'right', },
//         // { type: 'numeric', title: '粗利額', width: 80, mask:'#,##', align:'right',readOnly:true, editor: false, },
//         { type: 'numeric', title: '粗利率(％)', width: 80, mask: '#,##0.00', align:'right', },
//         // { type: 'numeric', title: '粗利率(％)', width: 80, mask: '#,##0.00', align:'right',readOnly:true, editor: false, },
//       ],
//       // メーカー　型番　製品種別　
//       language: 'ja', // 日本語を指定
//       tableWidth:'98vw',
//       allowInsertColumn:false, // 列追加を許可するか (デフォルト：true)。
//       allowDeleteColumn:false, // 列削除を許可するか (デフォルト：true)。
//       allowRenameColumn:false,
//       tableOverflow:false, // テーブルの高さや横幅を超えた場合にスクロールバーを表示するか (デフォルト：false)
//       rowDrag:false,
//       selectionCopy:false,
//     //   onload: function (el, instance) {
//     //     // 数式を計算してセルに表示する
//     //     calculateFormulas(instance);

//     });
//     // 数式を計算してセルに表示する関数
//     window.addEventListener("load", function(){
// function calculateFormulas(instance) {
//     const data = instance.getData();

//     // 各行に対して数式を計算してセルに表示
//     data.forEach((row, rowIndex) => {
//         const D = row[3]; // 原価
//         // const F = row[6]; // 値引額
//         const G = row[6]; // 値引額
//         const H = row[7]; // 提供価格
//         const J = row[9]; // 粗利率(％)

//         // 数式の計算
//         if (H !== null && D !== null) {
//             row[8] = H - D; // 粗利額 = 提供価格 - 原価
//         }

//         // if (H !== null && D !== null) {
//         //     row[9] = (H / D) * 100; // 粗利率(％) = (粗利額 / 原価) * 100
//         // }
//     });

//     // 変更を反映
//     instance.setData(data);
// }})






        // jExcelオブジェクト変数
        var jExcelsheetObj = null;

        // 商品データ
        var productList=[
            {"id": "00000001", "name": "学籍教務情報システム"},
            {"id": "00000002", "name": "入試情報システム"},
            {"id": "00000003", "name": "学生募集情報システム"},
            {"id": "00000004", "name": "大学入学共通テストサブシステム"},
            {"id": "00000005", "name": "出欠情報サブシステム"},
            {"id": "00000006", "name": "Web学生出席登録オプション"}
        ];

        // 表示データ
        var sheetData = [
          { 
            "productCode": "SDCOO19000001"
            , "maker": "システムディ"
            , "product": "00000001"
            , "amount": "4"
            , "salesUnitPrice": "2000"
            , "salesSumPrice": "0"
            , "discount": "0"
            , "Price": "0"
            , "purchaseUnitPrice": "1600"
            , "purchaseSumPrice": "0"
            , "profit":"0"
            , "profitRate":"0"
          } //１行目
          ,{ 
            "productCode": "SDCOO19000002"
            , "maker": "システムディ"
            , "product": "00000003"
            , "amount": "1"
            , "salesUnitPrice": "3000"
            , "salesSumPrice": "0"
            , "discount": "0"
            , "Price": "0"
            , "purchaseUnitPrice": "2000"
            , "purchaseSumPrice": "0"
            , "profit":"0"
            , "profitRate":"0"
          } //２行目
        ];


        // 合計計算関数
        const calculateTotalPrice = function () {
            let totalPrice = 0;

            // データ(行)数ループ
            for (let idx = 0; idx < jExcelsheetObj.rows.length; idx++) {
                // 行のデータを取得
                const rowData = jExcelsheetObj.getRowData(idx);
                
                // 提供価格の列番号（0ベース）を確認し、値を加算
                const priceColumnIdx = 7; // 例として7列目（0ベース）が提供価格の列
                totalPrice += rowData[priceColumnIdx];
            }

            return totalPrice;
        };

        // 画面に合計額を表示する関数
        const displayTotalPrice = function (totalPrice) {
            // 例: 合計額を表示する要素があると仮定しています
            const totalElement = document.getElementById('totalPrice');
            
            // 合計額を要素にセット
            totalElement.textContent = `合計提供価格: ${totalPrice} 円`;
        };

        // ページ読み込み時
        window.addEventListener("load", function(){

            // シートの領域取得
            var spArea = document.getElementById('mytable');



            /** 
            * セルの値が変更された場合
            * @param instance:編集されたタグのインスタンス(使用していない)
            * @param cell:編集されたタグの情報(使用していない)
            * @param x:列のインデックス
            * @param y:行のインデックス 
            * @param value:編集されたタグの内容(使用していない)
            */

            const cellChanged = function(instance, cell, x, y, value) {

                // 合計計算関数呼び出し
                const totalPrice = calculateTotalPrice();

                // 画面に合計額を表示
                displayTotalPrice(totalPrice);

                // 合計処理を実行するカラムインデックス
                const executeCalcSumDataColomIdx = ["3","4","6","8"];

                beforeChangeExcute();
                // 合計処理を実行するカラム番号の場合
                if(executeCalcSumDataColomIdx.indexOf(x) >= 0){

                    // 計算データ取得
                    let calcData = calcSumData(y, x);

                    if(calcData){
                        // 計算データ設定
                        jExcelsheetObj.setRowData(y, calcData);
                    }
                }
                afterChangeExcute();
            }

            /** 
            * 合計計算ロジック(指定行の合計した数値を計算する)
            * @param rowIdx:行のインデックス 
            * @param colomIdx:列のインデックス(デフォルト-1のときは、処理実行)
            */
            const calcSumData = function(rowIdx){

                // 余りの行は、処理しない
                if(rowIdx >= jExcelsheetObj.rows.length - jExcelsheetObj.options.minSpareRows) return null;

                // 行のデータを取得
                rowData = jExcelsheetObj.getRowData(rowIdx);

                try{

                    /** 設定している値で計算(インデックスはリテラルじゃなくて、ちゃんと定義したほうが良い) */
                    // 売上金額 = 数量 × 売上単価
                    rowData[5] = chgStrToInt(rowData[3]) * chgStrToInt(rowData[4]);
                    // 消費税 = 売上金額 × 税率（定義してね）
                    rowData[7] = rowData[5] + chgStrToInt(rowData[6]);
                    // 仕入価格 = 数量 × 仕入単価
                    rowData[9] = chgStrToInt(rowData[3]) * chgStrToInt(rowData[8]);
                    // 利益 = 売上金額 - 仕入金額
                    rowData[10] = rowData[7] - rowData[9];
                    // 利益率 = 利益 ÷ 売上金額
                    // rowData[10] = Math.round(rowData[9] / rowData[5] * 100) + "%";
                    if (rowData[5] !== 0) {
                        rowData[11] = (rowData[10] / rowData[5] * 100).toFixed(2) + "%";
                    } else {
                        rowData[11] = "-";
                    }



                    console.log(rowData[4]);
                }catch(e){
                    console.log(e);
                    // エラーが出る前のものまで返す
                    return rowData;
                }
                return rowData;
            }

            /** 
            * セル変更処理実行処理前ロジック
            */
            const beforeChangeExcute = function(){

                // 変更ロジック無効
                jExcelsheetObj.options.onchange = null;
                // 読み込み専用無効(無効にしないと、プログラムでも編集できない)
                jExcelsheetObj.options.columns[5].readOnly = false;
                // jExcelsheetObj.options.columns[6].readOnly = false;
                jExcelsheetObj.options.columns[7].readOnly = false;
                jExcelsheetObj.options.columns[9].readOnly = false;
                jExcelsheetObj.options.columns[10].readOnly = false;
                jExcelsheetObj.options.columns[11].readOnly = false;
                // 読み込み専用の反映
                jExcelsheetObj.refresh();
            }
            /** 
            * 処理変更処理実行処理後ロジック
            */
            const afterChangeExcute = function(){
                // 変更ロジック有効
                jExcelsheetObj.options.onchange = cellChanged;
                // 読み込み専用有効
                jExcelsheetObj.options.columns[5].readOnly = true;
                // jExcelsheetObj.options.columns[6].readOnly = true;
                jExcelsheetObj.options.columns[7].readOnly = true;
                jExcelsheetObj.options.columns[9].readOnly = true;
                jExcelsheetObj.options.columns[10].readOnly = true;
                jExcelsheetObj.options.columns[11].readOnly = true;
                // 読み込み専用の反映
                jExcelsheetObj.refresh();
            }

            const chgStrToInt = function(strNum){
            // カンマを除去してから数値に変換
            return parseInt(strNum.replace(/,/g, ''));
            }

            /** 初期処理開始 */
            // シートの領域取得
            var spArea = document.getElementById('mytable');

            };            


            // jExcelオブジェクト生成
            jExcelsheetObj = jexcel(spArea, {
                data: sheetData, //設定データ
                columns: [
                    { type: "text", title:"商品コード", width:105, },
                    { type: "text", title:"メーカー", width:90, align: "left", },
                    { type: "autocomplete", title:"商品名", width:220 , align: "left", source: productList, multiple:false },
                    { type: "numeric", title:"数量", width:40, align: "right" ,mask:"#,##" },
                    { type: "numeric", title:"標準単価", width:70, align: "right" ,mask:"#,##" },
                    { type: "numeric", title:"標準価格", width:70, align: "right" ,mask:"#,##", readOnly:true},
                    { type: "numeric", title:"値引額", width:70, align: "right" ,mask:"#,##",},
                    { type: "numeric", title:"提供価格", width:70, align: "right" ,mask:"#,##", readOnly:true},
                    { type: "numeric", title:"仕入単価", width:70, align: "right" ,mask:"#,##", value: 0 },
                    { type: "numeric", title:"仕入価格", width:70, align: "right" ,mask:"#,##", readOnly:true},
                    { type: "numeric", title:"粗利", width:70 , align: "right" ,mask:"#,##", readOnly:true},
                    { type: "numeric", title:"利益率", width:60, align: "right" ,mask:'#,##%' ,readOnly:true},
                ], 
                minSpareRows: 1, //余り行
                tableOverflow:true,    // trueの場合は、領域以上になるとスクロールを表示
                tableHeight:'200px',   // 高さ
                tableWidth:'100%',     // 幅
                onchange: cellChanged, // 変更時のロジック
                allowDeleteColumn: false,       // 列削除ＮＧ
                allowInsertColumn: false,       // 列追加ＮＧ
                allowManualInsertColumn: false, // 列追加ＮＧ
                allowRenameColumn: false,       // 列名変更
                selectionCopy:false, // フィルコピーNG
            });

            /** 初回データの計算ロジック */
            // 変更前メソッドを実行
            beforeChangeExcute();
            // データ(行)数取得
            let allDataRows = jExcelsheetObj.rows.length;
            // データ(行)数ループ
            for(let idx=0; idx<allDataRows;idx++){
                // 計算データ取得
                let calcData = calcSumData(idx);

                if(calcData){
                    // 計算データ設定
                    jExcelsheetObj.setRowData(idx, calcData);
                }

            }
            // 変更後メソッドを有効にする
            afterChangeExcute();

            // 初回の合計計算関数呼び出し
            const initialTotalPrice = calculateTotalPrice();
            // 初回の画面に合計額を表示
            displayTotalPrice(initialTotalPrice);

            // ヘッダーの中央寄せ
            var spHeaders = document.querySelectorAll("#mytable thead.resizable td");
            for(let idx = 0; idx<spHeaders.length;idx++){
                spHeaders[idx].style.textAlign="center";
            }



            // 登録ボタン
            document.getElementById("regist").addEventListener("click", function(){
                // 全データ取得
                var allData = jExcelsheetObj.getData();

                // 取得したデータでajaxで指定URLにpostとかする
                // commonAjax(url, allData);
            });

        });
    </script>












    <style>
        /* .jexcel > tbody > tr > td.readonly 
        {
            color:rgba(0,0,0,0.5)
        } */

        #mytable{
            font-size:13px;
        }

        #mytable tbody tr td[data-X="6"] {
            color:red
        }


        #mytable tbody tr td[data-X="5"],
        #mytable tbody tr td[data-X="7"],
        /* #mytable tbody tr td[data-X="8"], */
        #mytable tbody tr td[data-X="9"],
        #mytable tbody tr td[data-X="10"],
        #mytable tbody tr td[data-X="11"]  {
            color:#000;
            background-color: #ff9;
        }

        /* #mytable thead.resizable td[data-X="3"]  {
            style.text-Align:"center";
        } */

    </style>
    
</x-app-layout>