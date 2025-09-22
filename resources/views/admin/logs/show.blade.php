<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('showLog', $modelHistory) }}
            </h2>
        </div>
    </x-slot>
    
    <div class="max-w-7xl mx-auto px-2 md:pl-14">
        <div class="bg-gray-100 dark:bg-gray-700 shadow-md rounded-lg overflow-hidden p-4 md:px-8">

            <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-200 mb-2">{{ class_basename($modelHistory->model) }} - {{ $modelHistory->operation_type }}</h2>

            <div class="flex mb-6">
                <span class="w-28 text-gray-600 dark:text-gray-300">記録日時</span>
                <span class="client-num text-gray-600 dark:text-gray-200">{{ $modelHistory->created_at }}</span>
            </div>

            <div class="grid gap-4">
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">モデル</span>
                    <span class="client-num text-gray-600 dark:text-gray-200">{{ class_basename($modelHistory->model) }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">データID</span>
                    <span class="client-name text-gray-600 dark:text-gray-200">{{ $modelHistory->model_id }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">ユーザー</span>
                    <span class="installation-type text-gray-600 dark:text-gray-200">{{ $modelHistory->user->user_name ?? 'N/A' }}</span>
                </div>
                <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300">接続元IP</span>
                    <span class="client-type text-gray-600 dark:text-gray-200">{{ $modelHistory->ip_address }}</span>
                </div>
                {{-- <div class="flex">
                    <span class="w-28 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">User Agent</span>
                    <span class="affiliation text-gray-600 dark:text-gray-200 ">{{ $modelHistory->user_agent }}</span>
                </div> --}}

                <div x-data="userAgentInfo()">
                    <div class="flex flex-col text-gray-600 dark:text-gray-200">
                        <div class="grid gap-4">
                            <div class="flex">
                                <span class="w-28 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">UA:デバイス</span>
                                <span class="affiliation text-gray-600 dark:text-gray-200" x-text="device">
                            </div>
                            <div class="flex">
                                <span class="w-28 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">UA:OS</span>
                                <span class="affiliation text-gray-600 dark:text-gray-200" x-text="os"></span><span x-text="osVersion"></span>
                            </div>
                            <div class="flex">
                                <span class="w-28 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">UA:ブラウザ</span>
                                <span class="affiliation text-gray-600 dark:text-gray-200" x-text="browser"></span><span x-text="browserVersion"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($modelHistory->changes)
                <dt class="font-medium text-gray-600 dark:text-gray-300  mt-4">変更内容</dt>
                <table class="min-w-full divide-y divide-gray-200 border-gray-400 border-spacing-1 rounded-md border-2">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-300">
                                フィールド
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-300">
                                変更前
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-300">
                                変更後
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($modelHistory->changes as $field => $change)
                            <tr>
                                <td class="px-6 py-2 whitespace-nowrap text-sm font-medium border-x border-gray-300 text-gray-900">{{ $field }}</td>
                                <td class="px-6 py-2 text-sm text-gray-500 border-x border-gray-300 whitespace-nowrap">
                                    <div class="mb-2">
                                        {{-- <span class="font-semibold">変更前：</span> --}}
                                        {{ $change['before'] ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-2 text-sm text-gray-500 border-x border-gray-300 whitespace-nowrap">
                                    <div>
                                        {{-- <span class="font-semibold">変更後：</span> --}}
                                        {{ $change['after'] ?? 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if($modelHistory->meta)
                <dt class="font-medium text-gray-600 dark:text-gray-300 mt-6">メタデータ</dt>
                <dd class="text-gray-900">
                    <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto">{{ json_encode($modelHistory->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </dd>
            @endif
            @if($modelHistory->user_agent_client_hint)
                <dt class="font-medium text-gray-600 dark:text-gray-300 mt-6">UACH</dt>
                <dd class="text-gray-900">
                    <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto">{{ $modelHistory->user_agent_client_hint }}</pre>
                </dd>
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/platform/1.3.6/platform.min.js"></script>
    <!-- LaravelのUser AgentをJavaScriptに渡す -->
    <script>
        function userAgentInfo() {
            return {
                os: platform.os.family || "不明",
                osVersion: platform.os.version || "",
                browser: platform.name || "不明",
                browserVersion: platform.version || "不明",
                device: (() => {
                    const os = platform.os.family || "";
                    if (os.includes("Windows") || os.includes("Mac OS") || os.includes("Linux")) {
                        return "PC";
                    } else if (os.includes("Android") || os.includes("iOS")) {
                        return "スマホ / タブレット";
                    }
                    return "不明";
                })()
            };
        }
    </script>
</x-app-layout>