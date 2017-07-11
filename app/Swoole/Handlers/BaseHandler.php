<?php

namespace App\Swoole\Handlers;

use Illuminate\Http\Request;
use Swoole\Table;

class BaseHandler
{
    protected $users;

    public function __contruct()
    {
        //
    }

    public function initUsers()
    {
        $this->users = new Table(config('swoole.websocket.max_online_users'));
        $this->users->column('id', Table::TYPE_INT, 4);
        $this->users->column('name', Table::TYPE_STRING, 64);
        $this->users->create();
    }

    protected function broadcast($server, $message, $sender = null, $opcode = 1)
    {
        $server->task([
            'action' => 'broadcast',
            'data' => $message,
            'options' => [
                'sender' => $sender,
                'opcode' => $opcode
            ]
        ]);
    }

    protected function heartbeat($server)
    {
        $this->broadcast($server, 0, null, 0x9);
    }

    protected function decryptCookies($cookies = [])
    {
        $result = [];
        foreach ($cookies as $key => $value) {
            $result[$key] = \Crypt::decrypt($value);
        }
        return $result;
    }

    protected function makeRequest(\Swoole\Http\Request $request)
    {
        return Request::create(
            $uri = '/',
            $method = 'get',
            $parameters = [],
            $cookies = $this->decryptCookies($request->cookie),
            $files = [],
            $server = $request->server,
            $content = ''
        );
    }
}