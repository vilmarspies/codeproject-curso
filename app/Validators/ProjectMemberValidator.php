<?php
	namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{
	protected $rules = [
			'project_id' => 'required',
			'member_id' =>'required:unique'
	];
}