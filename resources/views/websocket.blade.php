<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div>
                    <input type="text" id='text'></div>
                    <button id='sendBtn'>Send</button>
                    <ul id='message'>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script>
    var wsUri = "ws://{{config('swoole.websocket.server')}}:{{config('swoole.websocket.port')}}";
    websocket = new WebSocket(wsUri);

    websocket.onopen = function(ev) {
        $('#message').append('<li>connected</li>');
        console.log('connected');
    }

    websocket.onclose = function(ev) {
        $('#message').append('<li>closed</li>');
        console.log('closed');
    }

    websocket.onerror = function(ev) {
        $('#message').append('<li>error:' + ev.data + '</li>');
        console.log('error :' + ev.data);
    }

    websocket.onmessage = function(ev) {
        $('#message').append('<li>' + ev.data + '</li>');
        console.log('message: ' + ev.data);
    }

    $('#sendBtn').click(function(e){
        var msg = {
            action: 'chat',
            message: $('#text').val()
        };
        websocket.send(JSON.stringify(msg));
        $('#text').val('');
    });
</script>