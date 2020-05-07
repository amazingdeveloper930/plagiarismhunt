<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Processing;
use App\Payment;

class Projects extends Model
{
    //
    protected $primaryKey = 'project_id';

    public function Processing()
    {
        return $this->hasMany('App\Processing');
    }

    public function Payment()
    {
        return $this->hasMany('App\Payment', 'project_token', 'project_token');
    }
}
