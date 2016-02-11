<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectTaskRepository;
use CodeProject\Repositories\IProjectRepository;
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
	function __construct(IProjectTaskRepository $repository, IProjectRepository $projectRepository,  ProjectTaskValidator $validator) {
		$this->repository = $repository;
		$this->projectRepository = $projectRepository;
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
			$task =  $this->repository->skipPresenter()->create($data);
			
			$this->updateProgressProject($task);
			

			return $task;
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
			$task = $this->repository->skipPresenter()->update($data, $taskId);
			
			$this->updateProgressProject($task);

			return $task;
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

    private function updateProgressProject($task){
    	
    	$project = $task->project;
		$ttlTasks = count($project->tasks);
		//$completed = count($this->getComplete($project->id));

		$completed = $this->getComplete($project->id);

		$progress = ($completed*100)/$ttlTasks;
		$project->progress = round($progress);

		$project->save();
    }

    private function getComplete($id)
    {
    	//return $this->repository->skipPresenter()->findWhere(['project_id'=>$id,'status'=>3);
    	return $this->repository->skipPresenter()->findWhere(['project_id'=>$id,'status'=>3])->count();
    }
}