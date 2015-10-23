<?php
	namespace CodeProject\Services;

use CodeProject\Repositories\IClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
	/**
	* @var IClientRepository
	*/
	protected $repository;

	/**
	* @var ClientValidator
	*/
	protected $validator;

	/**
	*
	*/
	function __construct(IClientRepository $repository, ClientValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
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
		}
	}
}