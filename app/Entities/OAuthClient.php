<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OAuthClient extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['id','secret','name'];

}
