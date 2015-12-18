<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectFileService;


class ProjectFileController extends Controller
{
    /**
    *   @var ProjectService
    */
    private $service;

    function __construct(ProjectFileService $service) {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $this->service->all($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
       
        if (is_null($request->file('file'))){
            return ['error' =>true,
                    'message' => 'Informe o Arquivo'];
        }
        $file = $request->file('file');
        $data['file'] = $file;
        $data['extension'] = $file->getClientOriginalExtension();
        $data['name'] = $request->name; 
        $data['project_id'] = $id;
        $data['description'] = $request->description;

       return  $this->service->createFile($data);
        
        //return $this->service->store($request->all());
    }

    public function showFile($id, $fileId)
    {
        if($this->service->checkProjectPermissions($fileId) == false){
            return ['error' => 'Acesso Negado'];
        }
        return response()->download($this->service->getFilePath($fileId));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $fileId)
    {
        if($this->service->checkProjectPermissions($fileId) == false){
            return ['error' => 'Acesso Negado'];
        }
        return $this->service->show($fileId);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $fileId)
    {
        if($this->service->checkProjectPermissions($fileId) == false){
            return ['error' => 'Acesso Negado'];
        }
        return $this->service->update($request->all(), $fileId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $fileId)
    {
        if($this->service->checkProjectPermissions($fileId) == false){
            return ['error' => 'Acesso Negado'];
        }
        return $this->service->delete($fileId);
    }
}
