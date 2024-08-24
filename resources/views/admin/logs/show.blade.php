<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-5/6">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('showLog', $modelHistory) }}
                <div class="ml-4">
                </div>
            </h2>
            <x-message :message="session('message')" />
        </div>
    </x-slot>
    
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">{{ class_basename($modelHistory->model) }} - {{ $modelHistory->operation_type }}</h2>
                <p class="text-gray-600 mb-4">{{ $modelHistory->created_at }}</p>
    
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">ID</dt>
                        <dd class="mt-1 text-gray-900">{{ $modelHistory->id }}</dd>
                    </div> --}}
    
                    <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">モデル</dt>
                        <dd class="mt-1 text-gray-900">{{ class_basename($modelHistory->model) }}</dd>
                    </div>
    
                    <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">モデルID</dt>
                        <dd class="mt-1 text-gray-900">{{ $modelHistory->model_id }}</dd>
                    </div>
    
                    <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">ユーザー</dt>
                        <dd class="mt-1 text-gray-900">{{ $modelHistory->user->user_name ?? 'N/A' }}</dd>
                    </div>
    
                    <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">接続元IPアドレス</dt>
                        <dd class="mt-1 text-gray-900">{{ $modelHistory->ip_address }}</dd>
                    </div>
    
                    <div class="col-span-1 md:col-span-3">
                        <dt class="font-medium text-gray-700">ユーザーエージェント</dt>
                        <dd class="mt-1 text-gray-900 break-words">{{ $modelHistory->user_agent }}</dd>
                    </div>
    

                    @if($modelHistory->changes)
                        <div>
                            <dt class="font-medium text-gray-700">変更内容</dt>
                            <dd class="mt-1 text-gray-900">
                                <table class="min-w-full divide-y divide-gray-200 border-gray-400 border-spacing-1 rounded-md border-2">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-300">フィールド</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-x border-gray-300">変更内容</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($modelHistory->changes as $field => $change)
                                            <tr>
                                                <td class="px-6 py-2 whitespace-nowrap text-sm font-medium border-x border-gray-300 text-gray-900">{{ $field }}</td>
                                                <td class="px-6 py-2 text-sm text-gray-500 border-x border-gray-300 whitespace-nowrap">
                                                    <div class="mb-2">
                                                        <span class="font-semibold">変更前：</span>
                                                        {{ $change['before'] ?? 'N/A' }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold">変更後：</span>
                                                        {{ $change['after'] ?? 'N/A' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </dd>
                        </div>
                    @endif
    
                    @if($modelHistory->meta)
                        <div class="col-span-1 md:col-span-3">
                            <dt class="font-medium text-gray-700">メタデータ</dt>
                            <dd class="mt-1 text-gray-900">
                                <pre class="bg-gray-100 p-4 rounded-md overflow-x-auto">{{ json_encode($modelHistory->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>