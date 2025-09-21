<li x-data="{ open: true }"
    @expand-all.window="open = $event.detail"
    class="ml-4"
>
    <div class="flex items-center space-x-2">
        @if($department->children->isNotEmpty())
            <button @click="open = !open" class="text-sm text-blue-600 dark:text-blue-400">
                <span x-show="open">▼</span>
                <span x-show="!open">▶</span>
            </button>
        @endif
        <span class="text-gray-900 dark:text-gray-100">
            {{ $department->name }}
            <span class="text-xs text-gray-500">
                {{-- (Lv:{{ $department->level }}) --}}
            </span>
        </span>
    </div>

    @if($department->children->isNotEmpty())
        <ul x-show="open" class="ml-6 mt-1 space-y-1">
            @foreach($department->children as $child)
                @include('masters.departments.partials.department-tree', ['department' => $child])
            @endforeach
        </ul>
    @endif
</li>
