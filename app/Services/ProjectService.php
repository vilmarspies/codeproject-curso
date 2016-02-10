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

	public function index($limit)
    {
        //return $this->repository->findWithOwnerAndMember2($this->userId);
        return $this->repository->findOwner($this->userId, $limit);
    }

    public function indexMember($limit)
    {
        //return $this->repository->findWithOwnerAndMember2($this->userId);
        return $this->repository->findMembers($this->userId, $limit );
    }

    public function all()
    {
        return $this->repository->findWithOwnerAndMember($this->userId);
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
        if (!$this->checkProjectPermissions($id))
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
        if(!$this->checkProjectOwner($id))
        {
            return ['error' => 'Access Forbidden'];
        }
    	try {
    		$this->repository->skipPresenter()->find($id)->delete($id);    		
    		return ['message'=>'Projeto removido com sucesso'];
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não encontrado'];
    	}
        
    }

    public function members($id)
    {
    	try {
    		return $this->repository->skipPresenter()->find($id)->members;
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,'message' => 'Projeto não localizado'];
    	}
    }

    public function addMember($projectId, $memberId)
    {
        if ($this->checkMemberId($memberId))
        {
            return ['success'=>false, 'message'=>'Informe o Id do Membro'];
        }
        if (!$this->checkProjectOwner($projectId)){
            return ['success'=>false,'message'=>'Sem permissão para adicionar Membros. Motivo: Voce nao e Owner'];
        }
        try {

        	if ($this->repository->skipPresenter()->find($projectId)->members()->find($memberId))
        		return ['success'=>false,'message'=>'membro já faz parte do projeto'];

            $this->repository->skipPresenter()->find($projectId)->members()->attach($memberId);
            return ['success'=>true,'message'=>'membro adicionado ao projeto'];

        } catch (ModelNotFoundException $e) {
    		return [
    			'error'=>true,
    			'message'=>'Projeto não localizado'
    		];
    	}
    }

    public function removeMember($projectId, $memberId)
    {
        if ($this->checkMemberId($memberId))
        {
            return ['success'=>false, 'message'=>'Informe o Id do Membro'];
        }
        if (!$this->checkProjectOwner($projectId)){
            return ['success'=>false,'message'=>'Sem permissão para remover Membros. Motivo: Voce nao e Owner'];
        }
		try {
       		if ($this->repository->skipPresenter()->find($projectId)->members()->find($memberId)) 
       		{
       			$this->repository->skipPresenter()->find($projectId)->members()->detach($memberId);
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

    public function isMember($projectId, $memberId)
    {
    	try {
    		if ($this->repository->skipPresenter()->find($projectId)->members()->find($memberId))
    			return ['success'=>true,'message' => 'Usuario faz parte do projeto'];
    		return ['success'=>false,'message'=>'Usuario não faz parte do projeto'];

    	} catch (ModelNotFoundException $e) {
    		return [
    			'error'=>true,
    			'message'=>'Projeto não localizado'
    		];
    	}
        
    }

    public function checkProjectOwner($projectId)
    {
       // $userId = Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $this->userId);
    }

    public function checkProjectMember($projectId)
    {
       // $userId = Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $this->userId);
    }

    public function checkProjectPermissions($projectId)
    {
        //$userId = Authorizer::getResourceOwnerId();

        if ($this->repository->isOwner($projectId, $this->userId) or $this->repository->hasMember($projectId, $this->userId))
            return true;
        return false;
    }

    private function checkMemberId($memberId)
    {
        if(is_null($memberId) or $memberId == '' or $memberId == '0')
            return true;
        return false;
    }
}