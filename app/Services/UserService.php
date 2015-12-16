<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IUserRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
	/**
	* @var IUserRepository
	*/
	protected $repository;


	/**
	*
	*/
	function __construct(IUserRepository $repository) {
		$this->repository = $repository;
	}

	public function all()
	{
		return $this->repository->all();
	}

	public function create(array $data)
	{
	
		try {
			$this->validator->with($data)->passesOrFail();
			return $this->repository->create($data);
		} catch (ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
		
	}

	public function show($id)
    {
    	try {
    		return $this->repository->find($id);
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,
    			'message' => 'User não encontrado'];
    	}
        
    }

	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			return $this->repository->update($data, $id);
		} catch (ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		} catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => 'Cliente não encontrado.'
            ];
        }
	}

	public function destroy($id)
    {
    	try {
    		$this->repository->find($id);
    		$this->repository->delete($id);    		
    		return ['success'=>true,'message'=>'Cliente removido com sucesso'];
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Cliente não encontrado'];
    	}
        
    }
}