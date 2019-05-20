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

  public function getStatus(){
    $status = (Object)["value" => 0, "messages" => ["Device is offline."]];
    $record = $this->getLastRecord();
    if(isset($record)){
      $status->value = 1;
      $status->messages = ["All values are great!"];
      $warn = [];
      $dang = [];
      //Check warning for temperature
      if($record['temperature'] <= 20 || $record['temperature'] >= 27){
        $warn[] = "Temprature is " . (round($record['temperature']) <= 20 ? "less then 20" : "greater then 27") . "℃";
      }
      //Check danger for temprature
      if($record['temperature'] <= 10 || $record['temperature'] >= 40){
        $dang[] = "Temprature is " . (round($record['temperature']) <= 20 ? "less then 10" : "greater then 40") . "℃";
      }
      //Check warning for relative humidity
      if($record['relative_humidity'] <= 30 || $record['relative_humidity'] >= 50){
        $warn[] = "Relative humidity is " . (round($record['temperature']) <= 20 ? "less then 30" : "greater then 50") . "%";
      }

      if(count($warn) > 0 || count($dang) > 0){
        $status->value = 2;
        if(count($dang) > 0) $status->value = 3;
        $status->messages = array_merge($dang, $warn);
      }
    } 
    return $status;  
  }
}
