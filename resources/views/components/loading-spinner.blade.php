<div id="my-spinner" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-800 text-white opacity-100 transition-opacity duration-700">
    <!-- スピナー全体 -->
    <div class="relative w-[120px] h-[120px]">

        <!-- 回転する円 -->
        <div class="absolute inset-0 border-[8px] border-solid border-white border-t-white/10 border-b-white/10 rounded-full animate-spinner">
        </div>

        <!-- 円の中央のテキスト -->
        <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xs animate-spinner-text">
            Loading...
        </span>

    </div>
</div>