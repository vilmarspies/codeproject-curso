<?php
	namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
	protected $rules = [
		'project_id' => 'required',
		'title' => 'required|max:255',
		'note' =>'required|max:255'
	];
}