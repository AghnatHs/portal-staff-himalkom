<!DOCTYPE html>
<html>

<head>
    <title>Pemberitahuan Data Akun Himalkom</title>
</head>

<body>
    <h2>Halo, akun Himalkom Anda telah dibuat!</h2>
    <p>Silakan login dengan kredensial berikut:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Anda bisa login di <a href="{{ url('/login') }}">sini</a>.</p>
    <p><strong>Jangan lupa untuk mengganti password setelah login!.</strong></p>
</body>

</html>
