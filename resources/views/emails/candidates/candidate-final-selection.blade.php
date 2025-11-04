<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Congratulations!</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333;">
    <h2>🎉 Congratulations {{ $name }}!</h2>

    <p>We are pleased to inform you that you have been <strong>finally selected</strong> for the position of <strong>{{ $position }}</strong>.</p>

    <p>Please visit our HR Department to collect your appointment letter within the next few working days.</p>

    <p>We are excited to welcome you to our team!</p>

    <br>
    <p>Best Regards,<br>
    <strong>HR Department</strong><br>
    {{ config('app.name') }}</p>
</body>
</html>
