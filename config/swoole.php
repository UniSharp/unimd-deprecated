<?php

return [
    'websocket' => [
        'server' => env('WS_SERVER', '0.0.0.0'),
        'port' => env('WS_PORT', 9000),
        'heartbeat_push' => env('WS_HEARTBEAT_PUSH', true),
    ],
    'settings' => [
        'heartbeat_check_interval' => env('WS_HARTBEAT_INTERVAL', 5),
        'heartbeat_idle_time' => env('WS_HARTBEAT_IDLE', 10),
    ],
    'dispatchers' => [
        'action' => 'App\Swoole\Handlers\ExampleHandler@index',
        'chat' => 'App\Swoole\Handlers\ExampleHandler@chat',
        'changeNote' => 'App\Swoole\Handlers\NoteHandler@changeNote',
    ]
];
