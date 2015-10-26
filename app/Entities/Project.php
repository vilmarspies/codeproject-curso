<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
            'owner_id', 
            'client_id', 
            'name', 
            'description', 
            'progress', 
            'status', 
            'due_date'];


    public function owner()
    {
        return $this->belongsTo('\CodeProject\Entities\User', 'owner_id');
    }

    public function client()
    {
        return $this->belongsTo('\CodeProject\Entities\Client');
    }

    public function notes()
    {
        return $this->hasMany(ProjectNote::class);
    }
}
