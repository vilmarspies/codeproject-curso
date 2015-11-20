<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\IProjectTaskRepository;
use CodeProject\Entities\ProjectTask;
use CodeProject\Presenters\ProjectTaskPresenter;

/**
 * Class ProjectTaskRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectTaskRepositoryEloquent extends BaseRepository implements IProjectTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return ProjectTaskPresenter::class;
    }
}
