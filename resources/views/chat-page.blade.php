<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.ably.io/lib/ably.min-1.js"></script> 
    {{-- the second link is for ably SDK so use it for javascript that i am using --}}
</head>
<body>
    {{-- this is a litle style for a message but consider to style the way you like --}}
    <style>
         #chat {
            display: flex;
            flex-direction: column;
            /* max-width: 400px; */
            margin: auto;
        }

        .message {
            margin: 5px;
            padding: 10px;
            border-radius: 5px;
            /* max-width: 70%; */
            word-wrap: break-word;
        }
       
        #messageInput {
            margin-top: 10px;
        }
    </style>

<div class="container">
    <center>
        <h2>Realtime Chat App in Laravel</h2>
        <div class="col-6 my-3">
            <div id="chat">
                <div id="messages"></div>
                <input type="text" id="senderName" name="senderName" class="form-control" placeholder="Type your name">
                <input type="text" id="messageInput" name="message_body" class="form-control my-2" placeholder="Type your message...">
                <button onclick="sendMessage()" type="submit" class="btn btn-primary btn-sm">Send</button>
            </div>
    </div>
    </div>
    </center>

    {{-- now add ably and javascript messaging functionality as below --}}
    

<script>
    var ably = new Ably.Realtime('28DzIw.xdCtoA:J9vNpIBu3MixoR218By72WEFjXqn9ut7qgVERZEi6OM'); //remember to pass your ably API key
    var channel = ably.channels.get('chatting'); // here i create a channel or initialize the existing channel
    var messagesDiv = document.getElementById('messages');
    var senderName = document.getElementById('senderName'); //get a sender name
    var messageInput = document.getElementById('messageInput'); //get the message body
    // then subscribe to an event from the channel(here my channel is called "chat")
    // by subscribing to channel event means you listen to any event and receive any message from that channel
    channel.subscribe('messageEvent', function(message) { // message this is message from channel
        // Handle incoming messages (create a message body div tag)
        var messageElement = document.createElement('div');
        messageElement.textContent = message.data.name + ': ' + message.data.text;
        // here i add the message content to my created div tag
        messagesDiv.appendChild(messageElement);
    });
    // for sending message to chat channel we publish the new event with the intended message
    function sendMessage() {
        var message = messageInput.value.trim(); //get the message from input
        var name = senderName.value; //get the sender name from input
        if (message !== '') { //if input message is not empty publish a message
            // Publish the message to the chat channel
            channel.publish('messageEvent', { name: name, text: message, sender: 'local' });
            
            // Clear the input field
            messageInput.value = '';
            
        }
    }
</script>
</body>
</html>