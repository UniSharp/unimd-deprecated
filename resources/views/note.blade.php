@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="editor">
                <textarea id="editor"></textarea>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.0.0/codemirror.min.js"></script>>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.0.0/mode/markdown/markdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.5.0/lodash.min.js"></script>

<script type="text/javascript">
    var wsUri = "ws://{{config('swoole.websocket.server')}}:{{config('swoole.websocket.port')}}";
    var socket = new WebSocket(wsUri);

    var editor = CodeMirror.fromTextArea(document.querySelector('#editor'), {
      lineNumbers: true,
      mode: 'markdown'
    })
    var replaceRange = diff => editor.replaceRange(diff.text, diff.from, diff.to)
    editor.on('change', (editor, diff) => diff.origin && (diff.origin !== 'setValue') && changeSend(diff))

    socket.onopen = function(ev) {
        console.log('connected');
        getNote("{{$note->id}}");
    }

    socket.onclose = function(ev) {
        console.log('closed');
    }

    socket.onerror = function(ev) {
        console.log('error :' + ev.data);
    }

    socket.onmessage = function(ev) {
        var data = JSON.parse(ev.data);
        if (data.action === 'changeNote') {
            replaceRange(data.message);
        } else if (data.action === 'getNote') {
            editor.getDoc().setValue(data.message);
        }
        console.log('message: ' + ev.data);
    }

    function getNote($note_id) {
        var msg = {
            action: 'getNote',
            note_id : $note_id
        };
        socket.send(JSON.stringify(msg));
    }

    function changeSend(diff) {
        var msg = {
            action: 'changeNote',
            message: diff
        };
        socket.send(JSON.stringify(msg));
    }
</script>
@endsection