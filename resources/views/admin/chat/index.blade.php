<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>
    <div id="chat-app">
        <h1>Chat Room</h1>
        <div id="messages" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: scroll;">

            @forelse ($conversation->messages as $message)
                <div>{{ $message->user->name }} : {{ $message->content }}</div>
            @empty
                <p>هنوز پیغامی وجود ندارد!</p>
            @endforelse

        </div>
    </div>

    <script>
        var room_id = '{{ $conversationId}}';
        const messagesDiv = document.getElementById('messages');

        function streamData(e) {
            console.log(e);

            const messageElement = document.createElement('div');
            messageElement.innerText = `${e.user.name}: ${e.message.content}`;
            messagesDiv.appendChild(messageElement);
        }

    </script>
    <script src="http://192.168.10.137:8000/build/assets/app-fb08cf50.js"></script>

</body>

</html>
