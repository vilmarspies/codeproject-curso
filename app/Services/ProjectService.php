<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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

    private $userId;

	/**
	*
	*/
	function __construct(IProjectRepository $repository, ProjectValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
        $this->userId = Authorizer::getResourceOwnerId();
	}

	public function all()
    {
        return $this->repository->with(['owner','client'])->findWhere(['owner_id'=>Authorizer::getResourceOwnerId()]);
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
        if (!$this->repository->isOwner($id, $this->userId))
        {
            return ['success'=>false,'message'=>'Sem permissão para acessar o projeto'];
        }
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

    public function members($id)
    {
    	try {
    		return $this->repository->find($id)->members;
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não localizado'];
    	}
    }

    public function addMember($projectId, $userId)
    {
        try {

        	if ($this->repository->find($projectId)->members()->find($userId))
        		return ['success'=>false,'message'=>'membro já faz parte do projeto'];

            $this->repository->find($projectId)->members()->attach($userId);
            return ['success'=>true,'message'=>'membro adicionado ao projeto'];

        } catch (ModelNotFoundException $e) {
    		return [
    			'error'=>true,
    			'message'=>'Projeto não localizado'
    		];
    	}
    }

    public function removeMember($projectId, $userId)
    {
		try {
       		if ($this->repository->find($projectId)->members()->find($userId)) 
       		{
       			$this->repository->find($projectId)->members()->detach($userId);
       			return ['success'=>true,'message'=>'membro removido do projeto'];
       		}
       		return ['success'=>false,'message'=>'membro não faz parte do projeto'];

       	} catch (ModelNotFoundException $e) {
    		return [
    			'error'=>true,
    			'message'=>'Projeto não localizado'
    		];
    	}
    }

    public function isMember($projectId, $userId)
    {
    	try {
    		if ($this->repository->find($projectId)->members()->find($userId))
    			return ['success'=>true,'message' => 'Usuario faz parte do projeto'];
    		return ['success'=>false,'message'=>'Usuario não faz parte do projeto'];

    	} catch (ModelNotFoundException $e) {
    		return [
    			'error'=>true,
    			'message'=>'Projeto não localizado'
    		];
    	}
        
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        if(!$this->repository->isOwner($id, $userId))
        {
            return ['success'=>false,'message'=>'Sem permissão para acessar o projeto'];
        }
    }
}