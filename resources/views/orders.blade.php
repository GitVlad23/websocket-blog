<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <h1>Заказы</h1>

    <div id="orders">
        
    </div>

    <script>
        let socket = new WebSocket("ws://192.168.3.5:8080");

        socket.onopen = function(e) {
          console.log("[open] Соединение установлено");
          console.log("Отправляем данные на сервер");
          socket.send("Меня зовут Джон");
        };

        socket.onmessage = function(event) {

            var json = JSON.parse(event.data);

            var orders = document.getElementById('orders');

            var order = '' + 
                '<div class="order">' +
                '<p>'+json.name+'</p>' +
                '<p>'+json.product+'</p>' +
                '</div>' +
                '';

            orders.insertAdjacentHTML('beforeend', order);
        };

        socket.onclose = function(event) {
          if (event.wasClean) {
            console.log(`[close] Соединение закрыто чисто, код=${event.code} причина=${event.reason}`);
          } else {
            // например, сервер убил процесс или сеть недоступна
            // обычно в этом случае event.code 1006
            console.log('[close] Соединение прервано');
          }
        };

        socket.onerror = function(error) {
          console.log(`[error] ${error.message}`);
        };
    </script>

</body>
</html>