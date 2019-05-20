<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function device()
    {
    	return $this->belongsTo('App\Models\Device');
    }
}
