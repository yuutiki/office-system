<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SMTP設定テストメール</title>
</head>
<body>
    <h1>SMTP設定テストメール</h1>
    
    <p>このメールは、SMTP設定のテストとして送信されました。</p>
    
    <hr>
    
    <h2>設定情報</h2>
    <ul>
        <li><strong>設定名:</strong> {{ $setting->name }}</li>
        <li><strong>ホスト:</strong> {{ $setting->host }}</li>
        <li><strong>ポート:</strong> {{ $setting->port }}</li>
        <li><strong>暗号化:</strong> {{ $setting->encryption ?? 'なし' }}</li>
        <li><strong>認証タイプ:</strong> {{ $setting->auth_type === 'oauth' ? 'OAuth認証' : 'パスワード認証' }}</li>
        <li><strong>送信元アドレス:</strong> {{ $setting->from_address }}</li>
        <li><strong>送信元名:</strong> {{ $setting->from_name }}</li>
        <li><strong>タイプ:</strong> {{ $setting->type === 'internal' ? '社内向け' : '社外向け' }}</li>
        <li><strong>送信日時:</strong> {{ now() }}</li>
    </ul>
    
    <p>このメールを受信できていれば、SMTP設定は正常に機能しています。</p>
</body>
</html>