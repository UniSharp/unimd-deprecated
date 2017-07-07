<?php

namespace App\Swoole\Handlers;

use Swoole\WebSocket\Server;
use Illuminate\Session\Middleware\StartSession;

class WebSocketHandler extends BaseHandler
{
    protected $dispatchers;
    protected $sessionMiddleware;

    public function __construct() {
        $this->dispatchers = config('swoole.dispatchers');
        $this->sessionMiddleware = app()->make(StartSession::class);
    }

    public function onStart(Server $server) {
        app('output')->writeln("websocket server started: <ws://{$server->host}:$server->port>");
    }

    public function onWorkerStart(Server $server) {
        // check heartbeat
        $interval = config('swoole.settings.heartbeat_check_interval') * 1000;
        $server->tick($interval, function ($id) use ($server) {
            foreach($server->connections as $fd){
                $server->push($fd, 0, 0x9);
            }
        });
    }

    public function onOpen(Server $server, $request) {
        app('output')->writeln("server: handshake succeeed with client-{$request->fd}");
        // auth user
        $request = $this->makeRequest($request);
        $request = $this->sessionMiddleware->handle($request, function ($pipe) {
            return response('');
        });
        // app('output')->writeln(json_encode(auth()->guard('websocket')->user()));
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