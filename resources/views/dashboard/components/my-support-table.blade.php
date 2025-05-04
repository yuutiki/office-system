{{-- resources/views/components/support/my-support-table.blade.php --}}
<div class="w-full overflow-x-auto font-medium bg-white rounded-xl shadow-lg p-4">
    <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-4 p-4">担当顧客サポート状況</h2>
    <table class="min-w-full bg-white dark:bg-gray-800 text-sm text-left text-gray-700 dark:text-gray-200 border">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-6 py-3">顧客名称</th>
                <th class="px-6 py-3">タイトル</th>
                <th class="px-6 py-3">完了フラグ</th>
                <th class="px-6 py-3">種別</th>
                <th class="px-6 py-3">対応者</th>
                <th class="px-6 py-3">受付日時</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
            @foreach ($mySupports as $mySupport)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">{{ optional($mySupport->client)->client_name }}</td>
                    <td class="px-6 py-4">{{ $mySupport->title }}</td>
                    <td class="px-6 py-4">
                        @if ($mySupport->is_finished == "0")
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded dark:bg-red-900 dark:text-red-300">
                                対応中
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">
                                完了
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ optional($mySupport->supportType)->type_name }}</td>
                    <td class="px-6 py-4">{{ optional($mySupport->user)->name }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($mySupport->received_at)->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
