<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public function organization()
  {
    return $this->belongsTo('App\Models\Organization');
  }

  public function blueprint()
  {
    return $this->belongsTo('App\Models\Blueprint');
  }

  public function records()
  {
    return $this->hasMany('App\Models\Record');
  }

  public function getLastRecord(){
    return Record::where("device_id", "=", $this->id)->orderBy("created_at", "DESC")->first();
  }
}
