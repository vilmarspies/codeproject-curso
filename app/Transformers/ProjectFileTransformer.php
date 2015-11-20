<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract
{

	public function transform(ProjectFile $file)
	{
		return [
			'file_id' => $file->id,
	    	'project_id' => $file->project_id,
	    	'name' => $file->name,
	    	'description' => $file->description,
	    	'extension' => $file->extension,
		];
	}
}