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
    
    <h1 id="rabbit">Hello World!</h1>

    <div>
        <p id="message"></p>
    </div>

    <button type="submit" onclick="rabbit()">Rabbit</button>

    <script>
        let socket = new WebSocket("ws://192.168.3.5:8080");

        socket.onopen = function(e) {
          alert("[open] Соединение установлено");
          alert("Отправляем данные на сервер");
          socket.send("Меня зовут Джон");
        };

        socket.onmessage = function(event) {
            document.getElementById('message').append(event.data);
        };

        socket.onclose = function(event) {
          if (event.wasClean) {
            alert(`[close] Соединение закрыто чисто, код=${event.code} причина=${event.reason}`);
          } else {
            // например, сервер убил процесс или сеть недоступна
            // обычно в этом случае event.code 1006
            alert('[close] Соединение прервано');
          }
        };

        socket.onerror = function(error) {
          alert(`[error] ${error.message}`);
        };

        function rabbit()
        {
            getElementById('rabbit').append('Rabbits!');
        }
    </script>

</body>
</html>