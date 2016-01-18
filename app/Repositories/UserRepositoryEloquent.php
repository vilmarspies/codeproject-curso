<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\User;


use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ClientRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements IUserRepository
{

    protected $fieldSearchable = [
                            'name'
                        ];

	/**
     * Specify Model class name
     *
     * @return string
     */
	public function model()
	{
		return User::class;
	}

	/**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}