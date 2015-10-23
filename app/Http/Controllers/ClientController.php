<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
//use CodeProject\Http\Requests;
//use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\IClientRepository;
use CodeProject\Services\ClientService;

class ClientController extends Controller
{
    /**
    *   @var IClientRepository
    */
    private $repository;

    /**
    *   @var ClientService
    */
    private $service;

    /**
    * @param IClientRepository $repository
    * @param ClientService $service
    */
    function __construct(IClientRepository $repository, ClientService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
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
        
        $this->repository->find($id)->update($request->all());
        return $this->repository->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->find($id)->delete();
    }
}
