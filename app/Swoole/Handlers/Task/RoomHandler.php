<?php

namespace App\Swoole\Handlers\Task;

use Illuminate\Support\Facades\Redis;

class RoomHandler
{
    const PREFIX = 'swoole:room:';

    public function __contruct()
    {
        //
    }

    public function join($data)
    {
        Redis::sadd($this->getKey($data['room_id']), $data['fd']);
    }

    public function exit($data)
    {
        $key = $this->getKey($data['room_id']);
        $total = Redis::scard($key);

        // remove user fd
        Redis::srem($key , $data['fd']);

        // delete room if empty
        if ($total === 0) {
            Redis::del($key);
        }
    }

    public function getKey($room_id)
    {
        return static::PREFIX . $room_id;
    }
}