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
<script src="https://neil.fraser.name/software/diff_match_patch/svn/trunk/javascript/diff_match_patch.js"></script>
<script src="https://codemirror.net/addon/merge/merge.js"></script>

<script type="text/javascript">
    var wsUri = "{{env('WS_URI') ?: 'ws://'.config('swoole.websocket.server').':'.config('swoole.websocket.port')}}"
    var socket = new WebSocket(wsUri);
    var note_id = "{{$note->id}}";

    var editor = CodeMirror.fromTextArea(document.querySelector('#editor'), {
      lineNumbers: true,
      mode: 'markdown'
    })
    var dmp = new diff_match_patch();
    var content = '';
    var diff = '';
    var replaceRange = diff => editor.replaceRange(diff.text, diff.from, diff.to)
    editor.on('change', function(editor, diff) {
        if (diff.origin && (diff.origin !== 'setValue')) {
            changeSend(diff, note_id);
            newDiff = dmp.patch_toText(dmp.patch_make(content, editor.getDoc().getValue()));
            diffSend(newDiff, note_id);
        }
        // console.log(diff);
    })

    socket.onopen = function(ev) {
        console.log('connected');
        getNote(note_id);
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
        } else if (data.action === 'getNote' && data.message !== null) {
            editor.getDoc().setValue(data.message);
        } else if (data.action === 'getDiff') {
            var patch = dmp.patch_fromText(data.message);
            var apply = dmp.patch_apply(patch, editor.getDoc().getValue());
            editor.getDoc().setValue(apply[0])
        }
        console.log('message: ' + ev.data);
    }

    function getNote(note_id) {
        var msg = {
            action: 'getNote',
            note_id: note_id
        };
        socket.send(JSON.stringify(msg));
    }

    function changeSend(diff, note_id) {
        var msg = {
            action: 'changeNote',
            note_id: note_id,
            message: diff
        };
        socket.send(JSON.stringify(msg));
    }

    function diffSend(diff, note_id) {
        var msg = {
            action: 'diffNote',
            note_id: note_id,
            message: diff
        };
        socket.send(JSON.stringify(msg));
    }
</script>
@endsection