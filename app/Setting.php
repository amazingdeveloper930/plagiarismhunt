<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $table = 'setting';
    public static function getRecordByKey($key)
    {
        $entry = Setting:: where('key', $key) -> first();
        return $entry;
    }
}
