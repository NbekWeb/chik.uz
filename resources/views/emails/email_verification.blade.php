<!DOCTYPE html>
<html>

<head>
    <title>Verify Email Address</title>
</head>

<body>
    <h1>Verify Email Address</h1>
    <p>Hello {{ $user->name }},</p>
    <p>Please click the following link to verify your email address:</p>
    <a href="{{ $verificationUrl }}">Verify Email Address</a>
    <p>{{ $additionalInfo }}</p>
</body>

</html>
