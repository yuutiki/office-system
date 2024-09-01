<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full whitespace-nowrap items-center">
            <h2 class="font-semibold sm:text-lg text-gray-900 dark:text-white flex">
                {{ Breadcrumbs::render('projects') }} 通知一覧
                <div class="ml-4 text-sm sm:text-lg">
                    {{-- {{ $count }}件 --}}
                </div>
            </h2>
            <x-message :message="session('message')" />
            <div class="flex flex-col flex-shrink-0 space-y-1 w-auto md:flex-row md:space-y-0 md:space-x-3 items-center">
                <button type="button" onclick="location.href='{{ route('projects.create') }}'" class="flex items-center pl-2 sm:px-4 py-2 text-sm font-medium text-white rounded bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="h-5 w-5 sm:h-3.5 sm:w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    <div class="hidden sm:block">{{ __('Add') }}</div>
                </button>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            <div class="flex items-center space-x-4 p-4 {{ $notification->read_at ? 'bg-gray-700' : 'bg-gray-500' }} rounded-lg">
                                <div class="flex-shrink-0">
                                    @if ($notification->data['content_data']['reporter']['user_name'])
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $notification->data['content_data']['reporter']['profile_image']) }}?{{ time() }}" alt="">
                                        {{-- {{ asset('storage/' . Auth::user()->profile_image) }}?{{ time() }} --}}
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-500"></div>
                                    @endif
                                </div>
                                <div>
                                    {{ $notification->data['content_data']['reporter']['user_name'] }}
                                </div>
                                <div class="flex-grow">
                                    <p class="font-semibold">
                                        {{ Str::limit($notification->data['notification_data']['message'] ?? 'No Message', 100) }}
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        {{ $notification->data['notification_data']['content_title'] ?? 'No Title' }}
                                    </p>
                                    @if ($notification->source_model && $notification->source_id)
                                        <p class="text-xs text-gray-500">
                                            Source: {{ $notification->source_model }} #{{ $notification->source_id }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-400 flex flex-col items-end">
                                    <span>{{ $notification->created_at->format('n月j日 H:i') }}</span>
                                    {{-- @if (!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-400 hover:text-blue-300">既読にする</button>
                                        </form>
                                    @endif --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>