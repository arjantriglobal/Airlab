<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function devices()
    {
    	return $this->hasMany('App\Models\Device');
    }
}
