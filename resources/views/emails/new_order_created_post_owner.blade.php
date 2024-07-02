<!DOCTYPE html>
<html>

<head>
    <title>Почта о новом заказе</title>
</head>

<body>
    <h1>Почта о новом заказе</h1>
    <p>Привет {{ $order->post->user->name }},</p>
    <p>Пожалуйста, нажмите на эту ссылку, чтобы открыть адрес заказа CHIK:</p>
    <a href="{{ url('inquiry/' . $order->id) }}">ссылка для заказа CHIK</a>
    <br>
    <hr>
    <a href="https://chik.uz">
        <p style="text-align: center">Chik.uz</p>
    </a>
</body>

</html>
