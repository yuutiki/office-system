<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Information</title>
</head>
<body>
    <p>Dear User,</p>
    <p>Here is your login information:</p>
    <ul>
        <li><strong>Application URL:</strong> {{ $url }}</li>
        <li><strong>Login ID:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> 生年月日8桁＋A%＋外線番号下4桁</li>
    </ul>
    <p>Please keep this information secure.</p>
    <p>Best regards,</p>
    <p>Your Application Team</p>
</body>
</html>
