// ダークモードの状態をローカルストレージから取得
const storedTheme = localStorage.getItem('color-theme');
const isDarkMode = storedTheme === 'dark';

let myChart = null;

// チャートの初期化関数
function initChart() {
    const chartDom = document.getElementById('main');
    
    // 既存のチャートがある場合は破棄
    if (myChart) {
        myChart.dispose();
    }
    
    myChart = echarts.init(chartDom);
    
    // 現在のビューポートサイズに基づいてバー幅を計算
    const viewportWidth = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
    const barWidth = calculateBarWidth(viewportWidth);

    const option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            textStyle: {
                color: isDarkMode ? '#ffffff' : '#000000',
            },
        },
        grid: {
            left: '3%',  // グリッドの余白を調整
            right: '3%',
            bottom: '3%',
            containLabel: true,
        },
        xAxis: [{
            type: 'category',
            data: ['11月', '12月', '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月'],
            axisLabel: {
                color: isDarkMode ? '#ffffff' : '#000000',
                interval: 0,
                rotate: viewportWidth < 768 ? 45 : 0  // スマホサイズの場合はラベルを回転
            }
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                color: isDarkMode ? '#ffffff' : '#000000'
            }
        }],
        series: [
            {
                name: '学務',
                type: 'bar',
                stack: 'Ad',
                barWidth: barWidth,
                emphasis: { focus: 'series' },
                data: [120, 132, 101, 134, 90, 230, 210, 60, 89, 123, 56, 325],
                label: {
                    show: true,
                    position: 'inside',
                    color: isDarkMode ? '#ffffff' : '#000000',
                }
            },
            {
                name: '財務',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                data: [220, 182, 191, 234, 290, 330, 310, 134, 90, 230, 210, 60]
            },
            {
                name: '総務',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                data: [150, 232, 201, 154, 190, 330, 410, 220, 182, 191, 234, 290]
            },
            {
                name: '高校',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                data: [150, 232, 201, 154, 190, 330, 410, 232, 201, 154, 56, 87]
            },
            {
                name: 'その他',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                data: [150, 232, 201, 154, 190, 330, 410, 154, 190, 330, 410, 874]
            }
        ]
    };

    myChart.setOption(option);
}

// バー幅を計算する関数
function calculateBarWidth(width) {
    // PWAかどうかの判定
    const isPWA = window.matchMedia('(display-mode: standalone)').matches || 
                 window.navigator.standalone === true;
    
    // PWAの場合は異なる計算を適用
    if (isPWA) {
        if (width < 768) return 10;
        if (width < 1024) return 20;
        return 30;
    } else {
        // 通常のブラウザの場合
        if (width < 768) return '10%';
        if (width < 1024) return '20%';
        return '30%';
    }
}

// リサイズハンドラー
function handleResize() {
    if (!myChart) return;

    const width = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
    const barWidth = calculateBarWidth(width);

    // チャートのサイズを更新
    myChart.resize();

    // バー幅とラベルの回転を更新
    myChart.setOption({
        xAxis: [{
            axisLabel: {
                rotate: width < 768 ? 45 : 0
            }
        }],
        series: [{
            barWidth: barWidth
        }]
    });
}

// 初期化時の実行
initChart();

// イベントリスナーの設定
window.addEventListener('resize', _.debounce(handleResize, 250));

// ダークモード変更検知
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    initChart();
});

// PWAの表示モード変更検知
window.matchMedia('(display-mode: standalone)').addEventListener('change', () => {
    initChart();
});