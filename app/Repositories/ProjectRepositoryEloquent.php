<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use CodeProject\Presenters\ProjectPresenter;
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
    	if (count($this->skipPresenter()->findWhere(['id'=>$projectId, 'owner_id'=>$userId]))){
    		return true;
        }
    	return false;
    }

    public function hasMember($projectId, $memberId)
    {
        if($this->skipPresenter()->find($projectId)->members()->find($memberId)){
            return true;
        }
        return false;
    }

    public function findOwner($userId, $limit = null, $columns = array())
    {
      return $this->scopeQuery(function($query) use($userId){
            return $query->select('projects.*')
                  ->where('owner_id','=',$userId);
        })->paginate($limit, $columns);
    }

    public function findMembers($userId, $limit = null, $columns = array())
    {
      return $this->scopeQuery(function($query) use($userId){
            return $query->select('projects.*')
                  ->leftJoin('project_members','project_members.project_id','=','projects.id')
                  ->where('project_members.member_id','=', $userId);
        })->paginate($limit, $columns);
    }

    public function findWithOwnerAndMember($userId)
    {
        return $this->scopeQuery(function($query) use($userId){
            return $query->select('projects.*')
                  ->leftJoin('project_members','project_members.project_id','=','projects.id')
                  ->where('project_members.member_id','=', $userId)
                  ->union($this->model->query()->getQuery()->where('owner_id','=',$userId));
        })->all();
    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }
}