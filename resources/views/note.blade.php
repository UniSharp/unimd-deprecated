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
    var wsUri = "{{env('WS_URI') ?: 'ws://'.config('swoole.websocket.server').':'.config('swoole.websocket.port')}}";
    var note_id = "{{$note->id}}";
    var content = '';

    var editor = CodeMirror.fromTextArea(document.querySelector('#editor'), {
      lineNumbers: true,
      mode: 'markdown'
    })
    var dmp = new diff_match_patch();
    var diff = '';
    var replaceRange = diff => editor.replaceRange(diff.text, diff.from, diff.to);

    editor.on('change', function(editor, diff) {
        if (diff.origin && (diff.origin !== 'setValue')) {
            changeSend(diff);
            newDiff = dmp.patch_toText(dmp.patch_make(content, editor.getDoc().getValue()));
            diffSend(newDiff);
        }
        // console.log(diff);
    })

    class Timer {
        constructor (seconds) {
            this.seconds = seconds;
            this.countDownCallback = () => {};
            this.completeCallback = () => {};
        }

        countDown (callback) {
            this.countDownCallback = callback;
            return this;
        }

        complete (callback) {
            this.completeCallback = callback;
            return this;
        }

        start () {
            var seconds = this.seconds;
            var that = this;

            that.countDownCallback(seconds);
            seconds--;

            var counter = setInterval(function () {
                if (seconds > 0) {
                    that.countDownCallback(seconds);
                    seconds--;
                }
            }, 1000);

            setTimeout(function () {
                clearInterval(counter);
                that.completeCallback();
            }, 1000 * (seconds + 1));
        }
    }

    class UniSocket {
        constructor (wsUri) {
            this.events = {};

            this.wsUri = wsUri;

            this.connect();
        }

        connect () {
            this.socket = new WebSocket(this.wsUri);
            this.socket.onopen = function(ev) {
                console.log('connected');
                getNote(note_id);
            }

            var that = this;

            this.socket.onclose = function(ev) {
                console.log('Connection lost.');

                (new Timer(5))
                    .countDown((seconds) => console.log('Retry connection in : ' + seconds + ' seconds'))
                    .complete(() => {
                        that.connect();
                        console.log('restarting');
                    })
                    .start()
            }

            this.socket.onerror = function(ev) {
                console.log(ev);
            }
        }

        emit (event_name, data) {
            data['action'] = event_name;
            this.socket.send(JSON.stringify(data));
            console.log('Event emited : ' + event_name);
        }

        on (event_name, callback) {
            this.events[event_name] = callback;

            var events = this.events;

            this.socket.onmessage = function(ev) {
                var data = JSON.parse(ev.data);
                if (events[data.action] != undefined) {
                    events[data.action](data);
                }
                console.log('message: ' + ev.data);
            }
            console.log('Event received : ' + event_name);
        }
    }

    let io = new UniSocket(wsUri);

    io.on('changeNote', (data) => {
        replaceRange(data.message);
    });

    io.on('getNote', (data) => {
        if (data.message !== null) {
            editor.getDoc().setValue(data.message);
        }
    });

    io.on('getDiff', (data) => {
        var patch = dmp.patch_fromText(data.message);
        var apply = dmp.patch_apply(patch, editor.getDoc().getValue());
        editor.getDoc().setValue(apply[0]);
    });

    function getNote(note_id) {
        io.emit('getNote', { note_id: note_id });
    }

    function changeSend(diff) {
        io.emit('changeNote', { message: diff });
    }

    function diffSend(diff) {
        io.emit('diffNote', { message: diff });
    }
</script>
@endsection
