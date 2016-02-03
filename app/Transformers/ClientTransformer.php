<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['projects'];

	public function transform(Client $client)
	{
		return [
			'id' => (int)$client->id,
			'name' => $client->name,
	    	'responsible' => $client->responsible,
	    	'email' => $client->email,
	    	'phone' => $client->phone,
	    	'address' => $client->address,
	    	'obs' => $client->obs,
		];
	}

	public function includeProjects(Client $client)
	{
		$transformer = new ProjectTransformer();
		$transformer->setDefaultIncludes([]);
		return $this->collection($client->projects, $transformer);
	}
}