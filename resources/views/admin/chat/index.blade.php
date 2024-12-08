{{-- <!DOCTYPE html>
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

</html> --}}



<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>



    <script>
        var room_id = 'j5pseF8YBvW6bY';

        function streamData(e) {
            console.log(e);

        }
    </script>


    <script src="http://127.0.0.1:8000/build/assets/app-7c68810e.js"></script>

    {{-- <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('80ee95e3f2e5e8050987', {
            cluster: 'mt1'
        });



        var room_id = 'j5pseF8YBvW6bY';
        var channel = pusher.subscribe(`rooms.${room_id}`);
        channel.bind('ChatEvent', function(data) {
            alert(JSON.stringify(data));
        });

        channel.bind(`rooms.${room_id}`)
            .listen('ChatEvent', (event) => {
                console.log(event);
            });
    </script> --}}
</head>

<body>
    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
</body>
