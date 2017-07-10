<?php

return [
    'websocket' => [
        'server' => env('WS_SERVER', '0.0.0.0'),
        'port' => env('WS_PORT', 9000),
        'heartbeat_push' => env('WS_HEARTBEAT_PUSH', true),
        'heartbeat_server_interval' => env('WS_HARTBEAT_SERVER_INTERVAL', 5),
    ],
    'settings' => [
        'heartbeat_check_interval' => env('WS_HARTBEAT_INTERVAL', 10),
        'heartbeat_idle_time' => env('WS_HARTBEAT_IDLE', 20),
    ],
    'dispatchers' => [
        'action' => 'App\Swoole\Handlers\ExampleHandler@index',
        'chat' => 'App\Swoole\Handlers\ExampleHandler@chat',
        'changeNote' => 'App\Swoole\Handlers\NoteHandler@changeNote',
    ]
];
