<?php

namespace App\Swoole\Handlers\Task;

use Illuminate\Http\Request;

class PushHandler
{
    public function __contruct()
    {
        //
    }

    public function broadcast($server, $data)
    {
        foreach($server->connections as $fd) {
            if ($data['sender'] !== $fd) {
                $server->push($fd, $data['message'], $data['opcode']);
            }
        }
    }
}