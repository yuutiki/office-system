<div x-data="refinedDatetime()" x-init="init()" 
     class="w-full h-full rounded-lg shadow-lg transition-colors duration-300 dark:bg-gray-800 bg-white border border-gray-100 dark:border-gray-700 overflow-hidden">
    
    <div class="p-6">
        <!-- 日付・曜日表示 - 洗練された配置 -->
        <div class="flex justify-center items-center space-x-1 mb-4">
            <span x-text="year" class="text-lg font-medium text-gray-600 dark:text-gray-300"></span>
            <span x-text="month" class="text-lg font-medium text-gray-600 dark:text-gray-300"></span>
            <span x-text="day" class="text-lg font-medium text-gray-600 dark:text-gray-300"></span>
            <span class="text-lg font-medium text-gray-400 dark:text-gray-500 mx-1">|</span>
            <span x-text="weekday" class="text-base font-medium text-gray-600 dark:text-gray-300"></span>
        </div>

        <!-- 時刻表示 - Tailwindの等幅数字クラスを使用 -->
        <div class="flex justify-center items-baseline">
            <span x-text="hours" class="text-5xl font-bold text-gray-800 dark:text-white tracking-tight font-mono tabular-nums"></span>
            <span class="mx-2 text-4xl font-light text-gray-400 dark:text-gray-500">:</span>
            <span x-text="minutes" class="text-5xl font-bold text-gray-800 dark:text-white tracking-tight font-mono tabular-nums"></span>
            <span class="mx-2 text-4xl font-light text-gray-400 dark:text-gray-500">:</span>
            <span x-text="seconds" class="text-3xl font-medium text-gray-500 dark:text-gray-400 tracking-tight font-mono tabular-nums"></span>
        </div>
    </div>
</div>

<script>
function refinedDatetime() {
    return {
        hours: '00',
        minutes: '00',
        seconds: '00',
        year: '',
        month: '',
        day: '',
        weekday: '',
        
        init() {
            this.updateClock();
            setInterval(() => {
                this.updateClock();
            }, 1000);
        },
        
        updateClock() {
            const now = new Date();
            
            // 時刻
            this.hours = String(now.getHours()).padStart(2, '0');
            this.minutes = String(now.getMinutes()).padStart(2, '0');
            this.seconds = String(now.getSeconds()).padStart(2, '0');
            
            // 年
            this.year = now.getFullYear() + '年';
            
            // 月と日
            this.month = (now.getMonth() + 1) + '月';
            this.day = now.getDate() + '日';
            
            // 曜日
            const weekdayNames = ['日', '月', '火', '水', '木', '金', '土'];
            this.weekday = weekdayNames[now.getDay()] + '曜日';
        }
    }
}
</script>