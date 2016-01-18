<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectMemberService
{
	/**
	* @var IProjectMemberRepository
	*/
	protected $repository;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	/**
	*
	*/
	function __construct(IProjectMemberRepository $repository, ProjectMemberValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
	}

	public function all($id)
	{
		$members =  $this->repository->with(['project','member'])->findWhere(['project_id'=>$id]);
		$result[] = $members['data'][0];
		foreach ($members['data'] as $member) {
			$achou = false;
			foreach ($result as $o) {
				if ($member['member']['id'] == $o['member']['id'])
					$achou = true;
			}
			if (!$achou )
				$result[] = $member;
		}
		return $result;
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

	public function find($id)
	{
		return $this->repository->find($id);
	}


	public function delete($id)
    {
    	try {
    		$projectMember = $this->repository->skipPresenter()->find($id);
    		return $projectMember->delete();
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não encontrado'];
    	}
        
    }
}