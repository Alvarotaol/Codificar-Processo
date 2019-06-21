<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verba extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function deputado()
    {
        return $this->belongsTo('App\Models\Deputado');
    }
}
