<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IProjectFileRepository;
use CodeProject\Repositories\IProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileService
{
	/**
	* @var IProjectFileRepository
	*/
	protected $repository;

	/**
	* @var IProjectRepository
	*/
	protected $projectRepository;


	/**
	* @var ProjectFileValidator
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

	/**
	*
	*/
	function __construct(IProjectFileRepository $repository, 
							IProjectRepository $projectRepository, 
							ProjectFileValidator $validator, 
							Filesystem $filesystem, 
							Storage $storage) {
		$this->repository = $repository;
		$this->validator = $validator;
		$this->projectRepository = $projectRepository;
		$this->filesystem = $filesystem;
        $this->storage = $storage;
	}

	public function all($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

	public function createFile(array $data)
    {
        try{
        	$this->validator->with($data)->passesOrFail();
            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));

            return $projectFile; 

        } catch(ValidatorException $ev){
        	return [
        		'error' => true,
        		'message' => $ev->getMessageBag()
        	];
        } catch (ModelNotFoundException $e) {
            return [ 'error' => true,'message' => 'Projeto não localizado'];
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

	public function show($id)
    {
    	try {
    		return $this->repository->find($id);
    	} catch (ModelNotFoundException $e) {
    		return [ 'error' => true,
    			'message' => 'Nota de Projeto não encontrado'];
    	}
        
    }

    public function getFilePath($id)
    {
    	$projectFile = $this->repository->skipPresenter()->find($id);
    	return $this->getBaseUrl($projectFile);
    }
    
    private function getBaseUrl($file)
    {
    	switch ($this->storage->getDefaultDriver()) {
    		case 'local':
    			return $this->storage->getDriver()->getAdapter()->getPathPrefix().'/'.$file->id . '.' . $file->extension;
    			break;

    	}
    }

    public function delete($id)
    {
        try {
            $file = $this->repository->skipPresenter()->find($id);
            if($this->storage->exists($file->id.'.'.$file->extension)){
                $this->storage->delete($file->id.'.'.$file->extension);
                
            }
            $file->delete();
            return [ 'success' => true,'message' => 'File removido'];
      
        } catch (ModelNotFoundException $e) {
            return [ 'error' => true,'message' => 'File não localizado'];
        }
    }

    public function checkProjectOwner($projectFileId)
    {

        $userId = Authorizer::getResourceOwnerId();

        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->projectRepository->isOwner($projectId, $userId);
    }

    public function checkProjectMember($projectFileId)
    {
    	$userId = Authorizer::getResourceOwnerId();

        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->projectRepository->hasMember($projectId, $userId);
       
    }

    public function checkProjectPermissions($projectFileId)
    {

    	if($this->checkProjectOwner($projectFileId) or $this->checkProjectMember($projectFileId))
    		return true;
    	return false;
    }

}