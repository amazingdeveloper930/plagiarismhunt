<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Projects;
use App\Method;

class Processing extends Model
{
    //
    protected $table = 'processing';
    protected $primaryKey = 'processing_id';
    
    public function project()
    {
        return $this->belongsTo('App\Projects', 'project_id', 'project_id');
    }

    public function method()
    {
        return $this->belongsTo('App\Method', 'method_id', 'method_id');
    }

}
