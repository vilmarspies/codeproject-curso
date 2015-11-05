<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ClientRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ClientRepositoryEloquent extends BaseRepository implements IClientRepository
{

	/**
     * Specify Model class name
     *
     * @return string
     */
	public function model()
	{
		return Client::class;
	}

	/**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}