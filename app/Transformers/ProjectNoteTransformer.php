<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{

	public function transform(ProjectNote $note)
	{
		return [
			'note_id' => $note->id,
	    	'project_id' => $note->project_id,
	    	'title' => $note->title,
	    	'note' => $note->note,
		];
	}
}