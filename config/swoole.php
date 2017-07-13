<?php

return [
    'websocket' => [
        'server' => env('WS_SERVER', '0.0.0.0'),
        'port' => env('WS_PORT', 9000),
        'uri' => env('WS_URI'),
        'heartbeat_push' => env('WS_HEARTBEAT_PUSH', true),
        'heartbeat_server_interval' => env('WS_HARTBEAT_SERVER_INTERVAL', 30),
        'max_online_users' => env('WS_MAX_ONLINE_USERS', 2048),
        'max_online_notes' => env('WS_MAX_ONLINE_NOTES', 1024),
    ],
    'settings' => [
        'heartbeat_check_interval' => env('WS_HARTBEAT_INTERVAL', 60),
        'heartbeat_idle_time' => env('WS_HARTBEAT_IDLE', 120),
        'task_worker_num' => env('WS_TASKWORKER_NUMBER', 4),
    ],
    'dispatchers' => [
        'broadcast' => 'App\Swoole\Handlers\Task\PushHandler@broadcast',
        'joinRoom' => 'App\Swoole\Handlers\Task\RoomHandler@join',
        'exitRoom' => 'App\Swoole\Handlers\Task\RoomHandler@exit',
        'getNote' => 'App\Swoole\Handlers\NoteHandler@get',
        'changeNote' => 'App\Swoole\Handlers\NoteHandler@change',
        'diffNote' => 'App\Swoole\Handlers\NoteHandler@diff',
    ]
];
