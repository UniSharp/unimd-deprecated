<?php

namespace App\Swoole;

use Swoole\Table as SwooleTable;

class Table
{
    public $users;

    public function __construct()
    {
        $this->initUsers();
    }

    protected function initUsers()
    {
        $this->users = new SwooleTable(config('swoole.websocket.max_online_users'));
        $this->users->column('id', SwooleTable::TYPE_INT, 4);
        $this->users->column('name', SwooleTable::TYPE_STRING, 32);
        $this->users->column('room_id', SwooleTable::TYPE_INT, 8);
        $this->users->create();
    }
}