<?php

return [
    'websocket' => [
        'server' => env('WS_SERVER', '0.0.0.0'),
        'port' => env('WS_PORT', 9000),
    ],
    'dispatchers' => [
        'action' => 'App\Swoole\Handlers\ExampleHandler@index',
        'chat' => 'App\Swoole\Handlers\ExampleHandler@chat',
    ]
];
