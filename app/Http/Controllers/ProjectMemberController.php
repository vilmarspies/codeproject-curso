<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

use CodeProject\Services\ProjectMemberService;

class ProjectMemberController extends Controller
{

    /**
    *   @var ProjectService
    */
    private $service;

    function __construct(ProjectMemberService $service) {
        $this->service = $service;
        $this->middleware('check-project-owner',['except'=>['index','show']]);
        $this->middleware('check-project-permission',['except'=>['store','destroy']]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;

        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $projectMemberId)
    {
        return $this->service->find($projectMemberId);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $projectMemberId)
    {
        $this->service->delete($projectMemberId);
    }
}
