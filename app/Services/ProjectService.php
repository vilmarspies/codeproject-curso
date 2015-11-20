<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

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
    * @var Filesystem
    */
    protected $filesystem;

    /**
    * @var Storage
    */
    protected $storage;

    private $userId;

	/**
	*
	*/
	function __construct(IProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage) {
		$this->repository = $repository;
		$this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;

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

    public function createFile(array $data)
    {
        try{
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));
        } catch (ModelNotFoundException $e) {
            return [ 'error' => true,'message' => 'Projeto não localizado'];
        }
        
    }

    public function deleteFile($projectId, $fileId)
    {
        try {
            if ($this->repository->skipPresenter()->find($projectId)->files()->find($fileId)) {
                $file = $this->repository->skipPresenter()->find($projectId)->files()->find($fileId);
                $this->repository->skipPresenter()->find($projectId)->files()->delete($fileId);
                $this->storage->delete($file->id.'.'.$file->extension);
            }
            else{
                return [ 'error' => true,'message' => 'File não localizado'];
            }        
        } catch (ModelNotFoundException $e) {
            return [ 'error' => true,'message' => 'Projeto não localizado'];
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

    public function addMember($projectId, $memberId)
    {
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

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        if(!$this->repository->isOwner($id, $userId))
        {
            return ['success'=>false,'message'=>'Sem permissão para acessar o projeto'];
        }
    }

    public function checkProjectPermissions($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();
        if ($this->repository->isOwner($projectId, $userId) or $this->repository->hasMember($projectId, $userId))
            return true;
        return false;
    }
}