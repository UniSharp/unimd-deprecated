<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\EloquentUserProvider;
use App\Swoole\Auth\Guards\WebsocketGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Auth::extend('websocket', function ($app) {
            $provider = new EloquentUserProvider($app['hash'], config('auth.providers.users.model'));
            return new WebsocketGuard('web', $provider, app()->make('session.store'), request());
        });
    }
}
