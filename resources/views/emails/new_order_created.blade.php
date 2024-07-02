<!DOCTYPE html>
<html>

<head>
    <title>Почта о новом заказе</title>
</head>

<body>
    <h1>Почта о новом заказе</h1>
    <p>Привет {{ $order->user->name }},</p>
    <p>Пожалуйста, нажмите на следующую ссылку, чтобы открыть адрес вашего заказа:</p>
    <a href="{{ url('order/' . $order->id) }}">ссылка для заказа</a>
    <br>
    <hr>
    <a href="https://chik.uz">
        <p style="text-align: center">Chik.uz</p>
    </a>
</body>

</html>
