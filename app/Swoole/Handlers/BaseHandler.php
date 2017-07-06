<?php

namespace App\Swoole\Handlers;

class BaseHandler
{
    public function __contruct()
    {
        //
    }

    public function broadcast($server, $message)
    {
        foreach($server->connections as $fd) {
            $server->push($fd, $message);
        }
    }
}