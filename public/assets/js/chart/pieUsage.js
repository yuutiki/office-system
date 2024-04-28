// ピーエーチャートの初期化とオプション設定
var chart = echarts.init(document.getElementById('pieChart'));
var option = {
    // title: {
    //     text: '利用形態',
    //     subtext: 'Fake Data',
    //     left: 'left',
    //     textStyle: {
    //       color: isDarkMode ? '#ffffff' : '#000000',
    //     }
    // },
    tooltip: {
        trigger: 'item'
    },
    legend: {
        orient: 'vertical',
        left: 'center',
        textStyle: {
            padding: [8, 12],
            color: isDarkMode ? '#ffffff' : '#000000',
            rich: {
                sales: {
                    borderRadius: 5,
                    borderColor: '#b63a37',
                    borderWidth: 2,
                }
            }
        },
    },
    series: [
        {
            name: '利用形態',
            type: 'pie',
            radius: '50%',
            data: [
                { value: 1048, name: 'オンプレミス' },
                { value: 735, name: 'プライベートクラウド' },
                { value: 580, name: 'パブリッククラウド' },
            ],
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)',
                }
            }
        }
    ]
};
chart.setOption(option);