<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Swoole\Handlers\WebSocketHandler;

class SocketCommand extends Command
{
    protected $handler;
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
        $this->handler = app()->make(WebSocketHandler::class);
        $this->server = app('websocket');
        $this->handler->initUsers();
    }

    public function register()
    {
        $this->server->on('start', [$this->handler, 'onStart']);
        $this->server->on('workerstart', [$this->handler, 'onWorkerStart']);
        $this->server->on('open', [$this->handler, 'onOpen']);
        $this->server->on('message', [$this->handler, 'onMessage']);
        $this->server->on('task', [$this->handler, 'onTask']);
        $this->server->on('finish', [$this->handler, 'onFinish']);
        $this->server->on('close', [$this->handler, 'onClose']);
    }
}
