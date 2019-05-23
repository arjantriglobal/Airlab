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
      $status->messages = ["De luchtkwaliteit is uitstekend!"];
      $warn = [];
      $dang = [];
      //Check warning for temperature
      if($record['temperature'] <= 20 || $record['temperature'] >= 27){
        $warn[] = "De temperatuur is " . (round($record['temperature']) <= 20 ? "lager dan 20" : "hoger dan 27") . "℃";
      }
      //Check danger for temprature
      if($record['temperature'] <= 10 || $record['temperature'] >= 40){
        $dang[] = "De temperatuur is " . (round($record['temperature']) <= 20 ? "lager dan 10" : "hoger dan 40") . "℃";
      }
      //Check warning for relative humidity
      if($record['relative_humidity'] <= 30 || $record['relative_humidity'] >= 50){
        $warn[] = "De luchtvochtigheid is " . (round($record['temperature']) <= 20 ? "lager dan 30" : "hoger dan 50") . "%";
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
