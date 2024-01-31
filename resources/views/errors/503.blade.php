<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Maintenance</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
        <style>
            /* カスタムのスタイルを追加 */
            body {
                background: url('maintenance-bg.jpg') center center fixed;
                background-size: cover;
            }
        </style>
    </head>
    <body class="flex items-center justify-center h-screen bg-gray-700">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">定期メンテナンス中</h1>
            <p class="text-lg text-white">申し訳ありませんが、サイトは現在メンテナンス中です。<br>ご迷惑をおかけいたしますが、しばらくお待ちください。</p>
            <!-- メンテナンス情報の追加 -->
            <div class="mt-8 text-white">
                <p class="text-sm">予定終了時刻: 2024-01-27 12:00 JST</p>
                {{-- <p class="text-sm">詳細情報: support@example.com</p> --}}
            </div>
        </div>
    </body>
</html>