<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['members'];

	public function transform(Project $project)
	{
		return [
			'id'=>$project->id,
			'client_id'=>$project->client_id,
			'owner_id'=>$project->owner_id,

			'name' => $project->name,
			'client'=>[
				'id'=>$project->client->id,
				'name' => $project->client->name
			],
			'description' => $project->description,
			'progress' => (int) $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
			'is_member' => $project->owner_id != Authorizer::getResourceOwnerId()
		];
	}

	public function includeMembers(Project $project)
	{
		return $this->collection($project->members, new MemberTransformer());
	}

	public function includeClient(Project $project)
	{
		return $this->collection($project->client, new ClientTransformer());
	}
}