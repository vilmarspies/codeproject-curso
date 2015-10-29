<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token',function(){
	return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function ()
{
	Route::resource('client', 'ClientController', ['except' =>['create','edit']]);

	Route::group(['prefix'=>'project'], function()
	{
		Route::get('{id}', 'ProjectController@show'); //???????

		Route::resource('', 'ProjectController', ['except' =>['create','edit']]);


		Route::get('{id}/note', 'ProjectNoteController@index');
		Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
		Route::post('{id}/note', 'ProjectNoteController@store');
		Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
		Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

		Route::get('{id}/task', 'ProjectTaskController@index');
		Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
		Route::post('{id}/task', 'ProjectTaskController@store');
		Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
		Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');

		Route::get('{id}/members', 'ProjectController@members');
		Route::get('{id}/member/{userId}', 'ProjectController@isMember');
		Route::post('{id}/member', 'ProjectController@addMember');
		Route::delete('{id}/member/{userId}', 'ProjectController@removeMember');

	});

});
/*
Route::get('client', ['middleware'=>'oauth', 'uses'=>'ClientController@index']);
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');*/
/*
Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

Route::get('project/{id}/task', 'ProjectTaskController@index');
Route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
Route::post('project/{id}/task', 'ProjectTaskController@store');
Route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');
Route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');

Route::get('/project/{id}/members', 'ProjectController@members');
Route::get('/project/{id}/member/{userId}', 'ProjectController@isMember');
Route::post('/project/{id}/member', 'ProjectController@addMember');
Route::delete('/project/{id}/member/{userId}', 'ProjectController@removeMember');*/

/*Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');*/