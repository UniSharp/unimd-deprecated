<?php

namespace App\Swoole\Handlers;

class NoteHandler extends BaseHandler
{
    public function __construct()
    {
        //
    }

    public function changeNote($server, $data, $fd)
    {
        $this->broadcast($server, json_encode($data->message), $fd);
    }
}