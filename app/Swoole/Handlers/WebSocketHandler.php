<?php

namespace App\Swoole\Handlers;

use Symfony\Component\Console\Output\ConsoleOutput;
use Swoole\WebSocket\Server;

class WebSocketHandler
{
    protected $dispatchers;

    public function __construct() {
        $this->dispatchers = config('swoole.dispatchers');
    }

    public function onStart(Server $server) {
        app('output')->writeln("websocket server started: <ws://{$server->host}:$server->port>");
    }

    public function onOpen(Server $server, $request) {
        app('output')->writeln("server: handshake succeeed with client-{$request->fd}");
    }

    public function onMessage(Server $server, $frame) {
        // decode message
        $data = json_decode($frame->data);

        if (!isset($data->action)) {
            app('output')->writeln("illegal request from client-{$frame->fd} has been denied");
            return false;
        }
        $action = trim($data->action);
        if (!array_key_exists($action, $this->dispatchers)) {
            app('output')->writeln("illegal action `{$action}` from client-{$frame->fd} has been denied");
            return false;
        }
        // dispatch by action
        $fd = $frame->fd;
        app()->call($this->dispatchers[$action], compact('server', 'data', 'fd'));
    }

    public function onClose(Server $server, $fd) {
        app('output')->writeln("client-{$fd} is closed");
    }
}