<!DOCTYPE html>
<html>

<head>
    <title>Статус заказа изменился</title>
</head>

<body>
    <h1>Статус заказа изменился</h1>
    <p>Привет {{ $order->user->name }},</p>
    <p>Статус вашего заказа изменился. Нажмите ниже, чтобы открыть свой CHIK</p>
    <a href="{{ url('order/' . $order->id) }}">ссылка для заказа CHIK</a>
    <br>
    <hr>
    <a href="https://chik.uz">
        <p style="text-align: center">Chik.uz</p>
    </a>
</body>

</html>
