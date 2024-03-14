<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .hanko-container {
            width: 100%;
            margin-top: 20px;
            margin-left: 80px;
        }
        .hanko {
            float: left;
            width: 26%; /* 3つの印鑑欄を横並びにするために幅を調整 */
            height: 70px;
            border: 1px solid #000;
            /* margin-right: 10px; 印鑑欄の間隔を調整 */
        }
    </style>
    <title>御見積書</title>
</head>
<body>
    {{-- headder --}}
        <h1 class="" style="text-align: center; text-decoration: underline;">御  見  積  書</h1>
        <div class="header" style="font-size: 12px; text-decoration: underline; text-align: right;">見積作成日：2024年　4月　10日</div>
        <div class="header" style="font-size: 12px; text-decoration: underline; text-align: right;">見積番号：196128-C-C01-0001-001</div>

        <div class="" style="font-size: 20px; text-decoration: underline;">{{ $atesaki }} 御中</div>
        <div class="" style="margin-top: 10px; font-size: 10px;">下記の通り御見積申し上げます。</div>
        
        <div class="yoko" style="overflow: hidden;">
            <div class="box" style="float: left; width: 50%;">
                <div class="zyouken" style="margin-top: 16px; margin-right: 80px; padding-bottom: 4px; border-bottom: 0.5px solid #000; font-size: 12px;">受渡期日</div>
                <div class="zyouken" style="margin-top: 16px; margin-right: 80px; padding-bottom: 4px; border-bottom: 0.5px solid #000; font-size: 12px;">受渡場所</div>
                <div class="zyouken" style="margin-top: 16px; margin-right: 80px; padding-bottom: 4px; border-bottom: 0.5px solid #000; font-size: 12px;">取引方法</div>
                <div class="zyouken" style="margin-top: 16px; margin-right: 80px; padding-bottom: 4px; border-bottom: 0.5px solid #000; font-size: 12px;">有効期限</div>
                <div class="" style="font-size: 15px; border-bottom: 0.5px solid #000; margin-top: 16px; margin-right: 80px;">御見積金額計</div>
            </div>
            <div class="box" style="float: left; width: 50%;">
                <div class="kaisya" style="font-size: 12px; margin-left:70px;">株式会社システム ディ</div>
                <div class="kaisya" style="font-size: 12px; margin-left:70px;">東京支社</div>
                <div class="kaisya" style="font-size: 12px; margin-left:70px;">東京都港区芝大門2丁目 KDX芝大門ビル6階</div>
                <div class="kaisya" style="font-size: 12px; margin-left:70px;">TEL. (03)5777-5201 FAX. (03)5777-5205</div>
                <div class="kaisya" style="font-size: 12px; margin-left:80px;">担当部署：学園ソリューション事業部</div>
                <div class="kaisya" style="font-size: 12px; margin-left:80px;">担当氏名：末久 優</div>
                <!-- 印鑑欄 -->
                <div class="hanko-container">
                    <div class="hanko"></div>
                    <div class="hanko"></div>
                    <div class="hanko"></div>
                </div>
            </div>
        </div>

        <div class="" style="font-size: 12px; width: 100%; margin-top: 20px; border-bottom: 0.5px solid #000;">件  名</div>
    {{-- headder --}}
    {{-- body --}}
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; height: 100%;">
            <thead>
                <tr>
                    <th style="font-size: 12px; border: 1px solid #000000; width: 30px;">№</th>
                    <th style="font-size: 12px; border: 1px solid #000000; width: 350px;">品名</th>
                    <th style="font-size: 12px; border: 1px solid #000000;">標準単価</th>
                    <th style="font-size: 12px; border: 1px solid #000000;">数量</th>
                    <th style="font-size: 12px; border: 1px solid #000000;">標準価格</th>
                    <th style="font-size: 12px; border: 1px solid #000000; width: 80px;">御提供価格</th>
                </tr>
            </thead>
            <tbody style="border: 4px solid #000000; height: 100vh;">
                <tr>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: center;">1</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%;">大学入学共通テストサブシステム</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\1,000</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: center;">5</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\5,000</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\4,500</td>
                </tr>
                <tr>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: center;">2</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%;">商品B</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\800</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: center;">10</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\8,000</td>
                    <td style="font-size: 12px; border: 1px solid #000000; height: 100%; text-align: right; padding-right: 5px;">\7,000</td>
                </tr>
                <!-- 他の行も同様に追加 -->
            </tbody>
        </table>
    {{-- body --}}
    {{-- footer --}}
        <div style="margin-top: 20px; border-top: 1px solid #000000; padding-top: 10px;">
            <div style="border-bottom: 0.5px solid #000;">
                <span style="float: left;">合　　計:</span>
                <span style="float: right; width: 50%;">13000</span>
                <div style="clear: both;"></div>
            </div>
            <div style="border-bottom: 0.5px solid #000;">
                <span style="float: left;">消費税額:</span>
                <span style="float: right; width: 50%;">1500</span>
                <div style="clear: both;"></div>
            </div>
            <div style="border-bottom: 0.5px solid #000;">
                <span style="float: left;">税込合計:</span>
                <span style="float: right; width: 50%;">14500</span>
                <div style="clear: both;"></div>
            </div>
            <div>備考欄</div>
        </div>
    {{-- footer --}}
</body>
</html>
