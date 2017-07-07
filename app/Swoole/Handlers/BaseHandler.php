<?php

namespace App\Swoole\Handlers;

use Illuminate\Http\Request;

class BaseHandler
{
    public function __contruct()
    {
        //
    }

    protected function broadcast($server, $message, $sender = null, $opcode = 1)
    {
        foreach($server->connections as $fd) {
            if ($sender !== $fd) {
                $server->push($fd, $message, $opcode);
            }
        }
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