<?php

use Illuminate\Database\Seeder;
use App\Record;
use App\Device;

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
                $data = array(
                    'username' => 'uhoo@theinnoventors.eu', 
                    'password' => '3e24510760d65ee46ba631e4d2d2d04bb1f86fecf56ee2e1248dc59b6749be6e', 
                    'serialNumber' => $device->serial_number
                );
                // Receive API by doing an 'POST' request
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "https://api.uhooinc.com/v1/getlatestdata");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_ENCODING, "");
                curl_setopt($curl, CURLOPT_TIMEOUT, 60);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $result = null;
                try{
                    $result = curl_exec($curl);
                }
                catch(\Exception $e){
                    $result = null;
                }
                if($result != null){
                    $response = json_decode($result);
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
}
