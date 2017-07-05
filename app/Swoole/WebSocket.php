<?php

namespace App\Swoole;

use Symfony\Component\Console\Output\ConsoleOutput;
use Swoole\WebSocket\Server;

class WebSocket
{
    const HANDLERS_NUMBER = 2;

    public $server;
    protected $dispatchers;

    public function __construct(Server $server) {
        $this->server = $server;
        $this->dispatchers = config('swoole.dispatchers');
        $this->register();
    }

    protected function register()
    {
        $this->server->on('start', function (Server $server) {
            app('output')->writeln("websocket server started: ws://{$server->host}:$server->port");
        });

        $this->server->on('open', function (Server $server, $request) {
            app('output')->writeln("server: handshake succeeed with client-{$request->fd}");
        });

        $this->server->on('message', function (Server $server, $frame) {
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
        });

        $this->server->on('close', function (Server $server, $fd) {
            app('output')->writeln("client-{$fd} is closed");
        });
    }
}