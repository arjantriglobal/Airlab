<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model{
    public function device(){
        return $this->belongsTo('App\Models\Device');
    }
    
    public function getDeviceStatus(){
        /*
            -1 = No sensor attached
             0 = Sensor offline
             1 = Air quality OK
             2 = Air quality Warning
             3 = Air quality Danger
        */
        if(isset($this->device)){
            $status = $this->device->getStatus();
            if(isset($status)){
                return $status->value;
            }else{
                return 0;
            }
        }
        else{
            return -1;
        }
    }
}

