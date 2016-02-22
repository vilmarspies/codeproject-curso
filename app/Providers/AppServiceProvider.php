<?php

namespace CodeProject\Providers;

use CodeProject\Entities\ProjectTask;
use CodeProject\Events\TaskWasIncluded;
use CodeProject\Events\TaskWasUpdated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ProjectTask::created(function($task){
            Event::fire(new TaskWasIncluded($task));
        });

        ProjectTask::updated(function($task){
            Event::fire(new TaskWasUpdated($task));
            //event();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function(){
            return FakerFactory::create('pt_BR');
        });
    }
}
