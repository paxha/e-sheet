<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = [
        'sheet_id', 'description', 'height', 'width', 'qty', 'type'
    ];

    public function sheet(){
        return $this->belongsTo('App\Sheet');
    }
}
