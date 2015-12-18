<?php
	namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'project_id' => 'required',
		'name' => 'required|max:255',
		'description' =>'required'/*,
		'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip,rar,JPEG,JPG,PNG,GIF,PDF,ZIP,RAR'*/
	];
}