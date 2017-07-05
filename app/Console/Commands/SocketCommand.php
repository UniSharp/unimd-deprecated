<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SocketCommand extends Command
{
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
        $this->server = app('websocket')->server;
        // start server
        $this->server->start();
    }
}
