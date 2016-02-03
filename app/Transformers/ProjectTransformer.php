<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['members','tasks','notes','files'];

	public function transform(Project $project)
	{
		return [
			'id'=>$project->id,
			'client_id'=>$project->client_id,
			'owner'=> [
					'id'=> $project->owner_id,
					'name'=>$project->owner->name
			],
			'name' => $project->name,
			'client'=>[
				'id'=>$project->client->id,
				'name' => $project->client->name
			],
			'description' => $project->description,
			'progress' => (int) $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
			'is_member' => $project->owner_id != Authorizer::getResourceOwnerId(),
			'tasks_count' => $project->tasks->count(),
			'tasks_opened' => $this->countTaskOpened($project)
		];
	}

	public function includeMembers(Project $project)
	{
		return $this->collection($project->members, new MemberTransformer());
	}

	public function includeClient(Project $project)
	{
		return $this->item($project->client, new ClientTransformer());
	}

	public function includeTasks(Project $project)
	{
		return $this->collection($project->tasks, new ProjectTaskTransformer());
	}

	public function includeNotes(Project $project)
	{
		return $this->collection($project->notes, new ProjectNoteTransformer());
	}

	public function includeFiles(Project $project)
	{
		return $this->collection($project->files, new ProjectFileTransformer());
	}

	private function countTaskOpened(Project $project){
		$opens = 0;
		foreach ($project->tasks as $task) {
			if ($task->status != 3)
				$opens +=1;
		}

		return $opens;
	}
}