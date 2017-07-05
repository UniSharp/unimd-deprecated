<?php

namespace App\Swoole\Handlers;

class ExampleHandler
{
    public function index($server, $data, $fd)
    {
        $server->push($fd, json_encode($server));
        app('output')->writeln('push succeed');
    }
}