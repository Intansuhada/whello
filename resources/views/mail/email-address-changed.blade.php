<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Your email address has been changed</h1>
    <p>
        Hello<br>

        You recently asked to change your email address associated with your account.
        Please verify this change by clicking the link below within the next 15 minutes:
        <a href="{{ $url }}">Verify Email Address</a><br>
        <br>

        Thanks,<br>
        {{ config('app.name') }}
    </p>
</body>
</html>