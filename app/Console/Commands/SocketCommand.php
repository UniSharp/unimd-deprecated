<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Swoole\WebSocket;

class SocketCommand extends Command
{
    protected $websocket;
    protected $server;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a swoole websocket server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Trying to start websocket server...');
        // initialize swoole server
        $this->init();
        // bind listen functions
        $this->register();
        // start server
        $this->server->start();
    }

    public function init()
    {
        $this->websocket = app('websocket');
        $this->server = app('websocket')->server;
    }

    public function register()
    {
        $this->server->on('start', [$this->websocket, 'onStart']);
        $this->server->on('open', [$this->websocket, 'onOpen']);
        $this->server->on('message', [$this->websocket, 'onMessage']);
        $this->server->on('close', [$this->websocket, 'onClose']);
    }
}
