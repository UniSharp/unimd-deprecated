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
        $this->broadcast($server, 'test');
        app('output')->writeln('push succeed');
    }
}