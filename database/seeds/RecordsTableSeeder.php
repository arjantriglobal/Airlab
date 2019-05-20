<?php

use App\Adapters\uHooAdapter;
use Illuminate\Database\Seeder;
use App\Models\Record;
use App\Models\Device;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('max_execution_time', 300);
        $devices = Device::all();
        // Save new records data to DB
        foreach ($devices as $device) {
            if (isset($device->serial_number)) {
                $response = uHooAdapter::GetLatestData($device->serial_number);
                $Timestamp = new \DateTime("@$response->Timestamp");
                $r = Record::where('created_at', '=', $Timestamp)
                    ->where('id', '=', $device->id)
                    ->get();
                if(count($r) < 1){
                    $record = new Record;
                    $record->device_id = $device->id;
                    $record->temperature = $response->Temperature;
                    $record->relative_humidity = $response->{'Relative Humidity'};
                    $record->pm2_5 = $response->{'PM2.5'};
                    $record->tvoc = $response->TVOC;
                    $record->co2 = $response->CO2;
                    $record->co = $response->CO;
                    $record->air_pressure = $response->{'Air Pressure'};
                    $record->ozone = $response->Ozone;
                    $record->no2 = $response->NO2;
                    $record->created_at = $Timestamp;
                    $record->save();
                }
            }
        }
    }
}
