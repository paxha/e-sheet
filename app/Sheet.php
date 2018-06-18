<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    protected $fillable = ['name'];

    public function calculations()
    {
        return $this->hasMany('App\Calculation');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
}
