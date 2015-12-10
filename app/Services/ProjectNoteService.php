<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectNoteService
{
	/**
	* @var IProjectNoteRepository
	*/
	protected $repository;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	/**
	*
	*/
	function __construct(IProjectNoteRepository $repository, ProjectNoteValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
	}

	public function all($id)
    {
        return $this->repository->skipPresenter()->findWhere(['project_id'=>$id]);
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
                'message' => 'Nota de Projeto não encontrado.'
            ];
        }
	}

	public function show($id, $noteId)
    {
    	try {
    		return $this->repository->skipPresenter()->find($noteId);
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,
    			'message' => 'Nota de Projeto não encontrado'];
    	}
        
    }

	public function destroy($id)
    {
    	try {
    		$this->repository->find($id);
    		$this->repository->delete($id);    		
    		return ['message'=>'Nota de Projeto removido com sucesso'];
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não encontrado'];
    	}
        
    }
}