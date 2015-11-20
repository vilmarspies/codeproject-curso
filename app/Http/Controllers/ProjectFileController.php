<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectService;


class ProjectFileController extends Controller
{
    /**
    *   @var ProjectService
    */
    private $service;

    function __construct(ProjectService $service) {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $file = $request->file('file');
        $data['file'] = $file;
        $data['extension'] = $file->getClientOriginalExtension();
        $data['name'] = $request->name; 
        $data['project_id'] = $id;
        $data['description'] = $request->description;

       return  $this->service->createFile($data);
        
        //return $this->service->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $fileId)
    {
        return $this->service->deleteFile($id, $fileId);
    }

    public function members($id)
    {
       return $this->service->members($id);
    }

    public function addMember(Request $request, $projectId)
    {
        return $this->service->addMember($projectId, $request->get('user_id'));
    }

    public function removeMember($projectId, $userId)
    {
       return $this->service->removeMember($projectId, $userId);
    }

    public function isMember($projectId, $userId)
    {
        return $this->service->isMember($projectId, $userId);
    }
}
