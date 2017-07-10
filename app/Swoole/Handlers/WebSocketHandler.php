<?php

namespace App\Swoole\Handlers;

use Swoole\WebSocket\Server;
use Illuminate\Session\Middleware\StartSession;

class WebSocketHandler extends BaseHandler
{
    protected $dispatchers;
    protected $sessionMiddleware;
    protected $heartbeatInterval;
    protected $heartbeatPush;

    public function __construct() {
        $this->dispatchers = config('swoole.dispatchers');
        $this->sessionMiddleware = app()->make(StartSession::class);
        $this->heartbeatInterval = config('swoole.websocket.heartbeat_server_interval') * 1000;
        $this->heartbeatPush = config('swoole.websocket.heartbeat_push');
    }

    public function onStart(Server $server) {
        app('output')->writeln("websocket server started: <ws://{$server->host}:$server->port>");
    }

    public function onWorkerStart(Server $server) {
        // server push heartbeat
        if ($this->heartbeatPush && $server->worker_id === 0) {
            $server->tick($this->heartbeatInterval, function ($id) use ($server) {
                $this->heartbeat($server);
             });
        }
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

        // filter illegal actions
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

    public function onTask(Server $server, $task_id, $from_id, $data)
    {
        // filter illegal actions
        $action = trim($data['action']);
        if (!array_key_exists($action, $this->dispatchers)) {
            app('output')->writeln("illegal task action `{$action}` from client-{$frame->fd} has been denied");
            return false;
        }
        // dispatch by action
        app()->call($this->dispatchers[$action], compact('server', 'data', 'task_id', 'from_id'));
    }

    public function onFinish(Server $server, $task_id, $data)
    {
        // taskworker callback
    }

    public function onClose(Server $server, $fd) {
        app('output')->writeln("client-{$fd} is closed");
    }
}