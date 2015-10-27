<?php
	namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $rules = [
		'owner_id' => 'required|integer',
		'client_id'=>'required|integer',
		'name' => 'required|max:255',
		'description' =>'required|max:255',
		'progress' =>'required',
		'status' => 'required',
		'due_date' => 'required'
	];
}