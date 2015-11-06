<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements IProjectRepository
{

	/**
     * Specify Model class name
     *
     * @return string
     */
	public function model()
	{
		return Project::class;
	}

	/**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function isOwner($projectId, $userId)
    {
    	if (count($this->findWhere(['id'=>$projectId, 'owner_id'=>$userId])))
    		return true;

    	return false;
    }

    public function hasMember($projectId, $memberId)
    {
        if($this->find($projectId)->members()->find($memberId))
            return true;
        return false;
    }
}