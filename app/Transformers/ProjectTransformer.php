<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['members'];

	public function transform(Project $project)
	{
		return [
			'project_id'=>$project->id,
			'project' => $project->name,
			'client'=>[
				'id'=>$project->client->id,
				'name' => $project->client->name
			],
			'description' => $project->description,
			'progress' => $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date
		];
	}

	public function includeMembers(Project $project)
	{
		return $this->collection($project->members, new ProjectMemberTransformer());
	}
}