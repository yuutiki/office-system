<!DOCTYPE html>
<html lang="{{ $locale ?? 'ja' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login_info') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", "Hiragino Kaku Gothic ProN", "Hiragino Sans", "Yu Gothic", sans-serif;
        }
    </style>
</head>
<body>
    <p>{{ __('messages.dear_user') }}</p>
    <p>{{ __('messages.login_info_intro') }}</p>
    <ul>
        <li><strong>{{ __('messages.application_url') }}:</strong> {{ $url }}</li>
        <li><strong>{{ __('messages.login_id') }}:</strong> {{ $email }}</li>
        <li><strong>{{ __('messages.password') }}:</strong> 生年月日8桁＋A%＋外線番号下4桁</li>
    </ul>
    <p>{{ __('messages.security_notice') }}</p>
    <p>{{ __('messages.regards') }}</p>
    <p>{{ __('messages.team_name') }}</p>
</body>
</html>
