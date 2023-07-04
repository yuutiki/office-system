<!-- clientcorporation/search.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <!-- ページヘッダーのコード -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- 検索結果表示 -->
                <div class="p-6 bg-white">
                    <h2 class="text-lg font-semibold mb-4">検索結果</h2>
                    @if (count($corporations) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <!-- 検索結果テーブルのヘッダー -->
                            <thead class="bg-gray-50">
                                <!-- ヘッダーのコード -->
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($corporations as $corporation)
                                    <!-- 検索結果の行データ -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- 法人名称の表示 -->
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- 法人番号の表示 -->
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <!-- 選択ボタンのコード -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>検索結果がありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
