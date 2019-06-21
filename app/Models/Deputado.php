<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function verbas()
    {
        return $this->hasMany('App\Models\Verba');
    }
}
