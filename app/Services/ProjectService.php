<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
	/**
	* @var IProjectRepository
	*/
	protected $repository;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	/**
	*
	*/
	function __construct(IProjectRepository $repository, ProjectValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
	}

	public function all()
    {
        return $this->repository->with(['owner','client'])->all();
    }

	public function store(array $data)
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
                'message' => 'Projeto não encontrado.'
            ];
        }
	}

	public function show($id)
    {
    	try {
    		return $this->repository->with(['owner','client'])->find($id);
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,
    			'message' => 'Projeto não encontrado'];
    	}
        
    }

	public function destroy($id)
    {
    	try {
    		$this->repository->find($id);
    		$this->repository->delete($id);    		
    		return ['message'=>'Projeto removido com sucesso'];
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não encontrado'];
    	}
        
    }
}