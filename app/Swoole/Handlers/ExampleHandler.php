<?php

namespace App\Swoole\Handlers;

class ExampleHandler extends BaseHandler
{
    public function __construct()
    {
        //
    }

    public function index($server, $data, $fd)
    {
        $this->broadcast($server, $data);
        app('output')->writeln('push succeed');
    }

    public function chat($server, $data, $fd)
    {
        $this->broadcast($server, "user {$fd}: " . $data->message);
    }
}