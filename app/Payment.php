<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Projects;

class Payment extends Model
{
    //
    protected $table = 'payment';
    public function project()
    {
        return $this -> belongsTo('App\Projects', 'project_token', 'project_token');
    }
}
