<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectTaskService
{
	/**
	* @var IProjectTaskRepository
	*/
	protected $repository;

	/**
	* @var IProjectRepository
	*/
	protected $projectRepository;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	/**
	*
	*/
	function __construct(IProjectTaskRepository $repository,  ProjectTaskValidator $validator) {
		$this->repository = $repository;
		//$this->projectRepository = $projectRepository; IProjectRepository $projectRepository,
		$this->validator = $validator;
	}

	public function all($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

	public function store(array $data)
	{
	
		try {
			$this->validator->with($data)->passesOrFail();
/*			$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
			$projectTask = $project->tasks()->crate($data);
			return $projectTask;*/
			return $this->repository->create($data);
		} catch (ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
		
	}

	public function update(array $data, $taskId)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			return $this->repository->update($data, $taskId);
		} catch (ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		} catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => 'Tarefa não encontrada.'
            ];
        }
	}

	public function show($id, $taskId)
    {
    	try {
    		return $this->repository->find($taskId);
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,
    			'message' => 'Tarefa não encontrada.'];
    	}
        
    }

	public function destroy($taskId)
    {
    	try {
    		$projectTask = $this->repository->skipPresenter()->find($taskId);
    		$projectTask->delete();    		
    		return ['message'=>'Task de Projeto removido com sucesso'];
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Tarefa não encontrada.'];
    	}
        
    }
}