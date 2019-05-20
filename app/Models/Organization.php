<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function devices()
    {
    	return $this->hasMany('App\Models\Device');
    }

    public function blueprints()
    {
    	return $this->hasMany('App\Models\Blueprint');
    }

    public function users()
    {
    	return $this->hasMany('App\Models\User');
    }
}
