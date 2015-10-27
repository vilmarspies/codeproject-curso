<?php
	namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator
{
	protected $rules = [
		'project_id' => 'required',
		'name' => 'required|max:255',
		'start_date' =>'required',
		'status' =>'required'
	];
}