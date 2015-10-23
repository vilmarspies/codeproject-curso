<?php

namespace CodeProject\Providers;

use CodeProject\Repositories\ClientRepositoryEloquent;
use CodeProject\Repositories\IClientRepository;

use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IClientRepository::class, ClientRepositoryEloquent::class);
    }
}
