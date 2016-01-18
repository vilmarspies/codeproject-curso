<?php

namespace CodeProject\Providers;

use CodeProject\Repositories\ClientRepositoryEloquent;
use CodeProject\Repositories\IClientRepository;

use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Repositories\IProjectRepository;

use CodeProject\Repositories\ProjectNoteRepositoryEloquent;
use CodeProject\Repositories\IProjectNoteRepository;

use CodeProject\Repositories\ProjectTaskRepositoryEloquent;
use CodeProject\Repositories\IProjectTaskRepository;

use CodeProject\Repositories\ProjectFileRepositoryEloquent;
use CodeProject\Repositories\IProjectFileRepository;

use CodeProject\Repositories\ProjectMemberRepositoryEloquent;
use CodeProject\Repositories\IProjectMemberRepository;

use CodeProject\Repositories\UserRepositoryEloquent;
use CodeProject\Repositories\IUserRepository;


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
        $this->app->bind(IProjectRepository::class, ProjectRepositoryEloquent::class);
        $this->app->bind(IProjectNoteRepository::class, ProjectNoteRepositoryEloquent::class);
        $this->app->bind(IProjectTaskRepository::class, ProjectTaskRepositoryEloquent::class);
        $this->app->bind(IProjectFileRepository::class, ProjectFileRepositoryEloquent::class);
        $this->app->bind(IProjectMemberRepository::class, ProjectMemberRepositoryEloquent::class);
        $this->app->bind(IUserRepository::class, UserRepositoryEloquent::class);
    }
}
