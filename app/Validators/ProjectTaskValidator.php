<?php
	namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator
{
	protected $rules = [
		'name' => 'required|max:255',
		'status' =>'required'
	];
}