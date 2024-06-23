// ダークモードの状態をローカルストレージから取得
const storedTheme = localStorage.getItem('color-theme');
const isDarkMode = storedTheme === 'dark';

var chartDom = document.getElementById('main');
var myChart = echarts.init(chartDom);
var option;

option = {
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  legend: {
    textStyle:{
      color: isDarkMode ? '#ffffff' : '#000000',
    },
  },
  grid: {
    left: '1%',
    right: '1%',
    bottom: '1%',
    containLabel: true,
  },
  xAxis: [
    {
      type: 'category',
      data: ['11月', '12月', '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月']
    }
  ],
  yAxis: [
    {
      type: 'value'
    }
  ],
  series: [
    {
      name: '学務',
      type: 'bar',
      stack: 'Ad',
      barWidth: 30,
      emphasis: {
        focus: 'series'
      },
      data: [120, 132, 101, 134, 90, 230, 210, 60, 89, 123, 56, 325],
        // ラベルを追加
        label: {
            show: true, // ラベルを表示する
            position: 'middle', // ラベルの位置をバーの上に設定
            formatter: function(params) { // ラベルのフォーマット関数
                return params.value; // バーの値を表示
            },
            color: isDarkMode ? '#ffffff' : '#000000', // テキストの色
            }
    },
    {
      name: '財務',
      type: 'bar',
      stack: 'Ad',
      emphasis: {
        focus: 'series'
      },
      data: [220, 182, 191, 234, 290, 330, 310, 134, 90, 230, 210, 60]
    },
    {
      name: '総務',
      type: 'bar',
      stack: 'Ad',
      emphasis: {
        focus: 'series'
      },
      data: [150, 232, 201, 154, 190, 330, 410, 220, 182, 191, 234, 290]
    },
    {
      name: '高校',
      type: 'bar',
      stack: 'Ad',
      emphasis: {
        focus: 'series'
      },
      data: [150, 232, 201, 154, 190, 330, 410, 232, 201, 154, 56, 87]
    },
    {
      name: 'その他',
      type: 'bar',
      stack: 'Ad',
      emphasis: {
        focus: 'series'
      },
      data: [150, 232, 201, 154, 190, 330, 410, 154, 190, 330, 410, 874]
    },
  ]
};

option && myChart.setOption(option);

// ウィンドウのリサイズイベントを監視
window.addEventListener('resize', function() {
  // ウィンドウがリサイズされたときに実行されるコード
  myChart.resize(); // グラフのサイズを更新

  // ウィンドウの幅に応じてバーの幅を計算し、設定
  var width = window.innerWidth;
  var barWidth;
  if (width < 768) {
      // スマートフォンサイズの場合
      barWidth = '20%';
  } else {
      // それ以外の場合
      barWidth = '30%';
  }

  // 各シリーズのバー幅を更新
  myChart.setOption({
      series: [
          {
              barWidth: barWidth,
              label: {
                  color: isDarkMode ? '#ffffff' : '#000000',
              }
          }
          // 他の series も同様に更新する必要がある場合は、ここに追加する
      ]
  });
});