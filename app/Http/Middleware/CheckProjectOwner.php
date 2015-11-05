<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\IProjectRepository;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectOwner
{
    private $repository;
    public function __construct(IProjectRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = Authorizer::getResourceOwnerId();

        $id = $request->project;

        if(!$this->repository->isOwner($id, $userId))
        {
            return ['success'=>false,'message'=>'Sem permissão para acessar o projeto'];
        }
        return $next($request);
    }
}
