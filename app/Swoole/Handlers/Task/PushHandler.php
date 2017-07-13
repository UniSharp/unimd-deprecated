<?php

namespace App\Swoole\Handlers\Task;

use Illuminate\Support\Facades\Redis;

class PushHandler
{
    public function __contruct()
    {
        //
    }

    public function broadcast($server, $data)
    {
        $connections = $server->connections;

        if (!is_null($data['room_id'])) {
            $connections = Redis::smembers(RoomHandler::PREFIX . $data['room_id']);
        }

        foreach($connections as $fd) {
            if ($data['sender'] !== (integer) $fd) {
                $server->push($fd, $data['message'], $data['opcode']);
            }
        }
    }
}