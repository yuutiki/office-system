<div class="bg-white dark:bg-gray-800 text-black dark:text-white shadow-lg rounded-lg p-6 w-full">
    <div class="flex justify-between items-center mb-4 ">
        <h2 class="text-lg font-semibold flex items-center text-gray-600 dark:text-gray-300">
            直近案件リスト
            <svg data-popover-target="clicks-info2" data-popover-placement="right" class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div data-popover id="clicks-info2" role="tooltip" class="absolute z-10 invisible text-sm text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-36 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 p-3 mt-2">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">表示範囲</h3>
                <p>当月及び次月</p>
                <div data-popper-arrow></div>
            </div>
        </h2>
        <button class="text-xs bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded transition-all">
            See all
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left border-t border-gray-200 dark:border-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-2 font-semibold">顧客名称</th>
                    <th class="px-4 py-2 font-semibold">プロジェクト№</th>
                    <th class="px-4 py-2 font-semibold">プロジェクト名称</th>
                    <th class="px-4 py-2 font-semibold">金額</th>
                    <th class="px-4 py-2 font-semibold">営業段階</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-4 py-2">白梅学園大学</td>
                    <td class="px-4 py-2">№100026-01-0021</td>
                    <td class="px-4 py-2">シラバス追加導入</td>
                    <td class="px-4 py-2">2,000,000-</td>
                    <td class="px-4 py-2">見込有</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">東京薬科大学</td>
                    <td class="px-4 py-2">№100026-01-0321</td>
                    <td class="px-4 py-2">Smart学務提案</td>
                    <td class="px-4 py-2">80,000,000-</td>
                    <td class="px-4 py-2">重点営業</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>