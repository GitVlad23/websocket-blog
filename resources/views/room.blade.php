<div>
	@if($id == 1)
		<h1>Комната - 1</h1>
	@elseif($id == 2)
		<h1>Комната - 2</h1>
	@else
		<h1>Комната - 3</h1>
	@endif
</div>

<div class="row">
	<div>
		<h3>Пользователи онлайн</h3>
		<ul id="users">
			
		</ul>
	</div>

	<div>
		<h3>Сообщения</h3>
		<div id="messages">
			
		</div>
	</div>

	<div>
		<input type="text" id="text">
		<button type="submit" id="send" onclick="sendMessage()">Отправить!</button>
	</div>
</div>

<script>
	let socket = new WebSocket("ws://192.168.3.5:8080");

        socket.onopen = function(e) {
        	socket.send('{"message": "new room", "value": "{{ $room_name }}", "user": "{{ $name }}"}');
            console.log("[open] Соединение установлено");
        };

        socket.onmessage = function(event) {

            var json = JSON.parse(event.data);

            if(json.message == 'connection')
            {
            	const deleteElement = document.querySelector("#users");
            	deleteElement.innerHTML = '';

            	json.users.map(function(item)
            	{
            		var users = document.getElementById('users');
            		let liFirst = document.createElement('li');
            		liFirst.innerHTML = "<li><span>"+item+"</span></li>";

            		users.prepend(liFirst);
            	});
            } else if(json.message == 'new message')
            {
        		var messages = document.getElementById('messages');
        		let pFirst = document.createElement('p');
        		pFirst.innerHTML = "<b>"+json.user+"</b>: "+json.value;

        		messages.prepend(pFirst);
            }
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

        function sendMessage()
        {
        	var text = document.getElementById('text').value;

        	socket.send('{"message": "new message", "value": "'+text+'"}');
        }
</script>