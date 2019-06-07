<?php

namespace App\Http\Controllers;

use App\Adapters\uHooAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Record;
use App\Device;
use App\Organization;
use App\Http\Controllers\AuthController;

class ApiController extends Controller
{
    /**
     * Method to get records by device ID
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getRecordsById(Request $request)
    {
        if ($request->id) {
            $records = Record::where('device_id', $request->id)->orderBy('updated_at', 'desc')->get();
        }
        return $records;
    }

    /**
     * Get all records from device id by record properties. (Example: co2)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getRecordsByProperty(Request $request){
        $id = $request->id;
        $nameProp = $request->name;
        $data = Record::where('device_id', $id)->select($nameProp)->get()->toArray();
        return $data;
    }

    /**
     * function to get all devices with values
     * Colors:
        green = bg-success
        orange = bg-warning
        red = bg-danger
        undefiend = secondary
     * @return [type] [description]
     */
    public function getDevicesWithData(Request $request){
        if ($request->id) {
            $device = array();
            $orgDevices = Device::where('organization_id', $request->id)->get();
            $orgDeviceData = array();

            foreach ($orgDevices as $device) {
                $deviceData = Record::where('device_id', $device['id'])->orderByRaw('created_at DESC')->first();
                if(isset($deviceData)){
                    $color = "bg-success";
                    $message = "Alle waarden zijn geweldig!";
                    //Check warning for temperature
                    if($deviceData['temperature'] <= 20 || $deviceData['temperature'] >= 27){
                        $color = "bg-warning";
                        $message = "De temperatuur is onder de 20 graden of boven de 27 graden";
                    }
                    //Check danger for temprature
                    if($deviceData['temperature'] <= 10 || $deviceData['temperature'] >= 40){
                        $color = "bg-danger";
                        $message = "De temperatuur ligt onder de 10 graden of boven de 40 graden";
                    }
                    //Check warning for relative humidity
                    if($deviceData['relative_humidity'] <= 30 || $deviceData['relative_humidity'] >= 50){
                        $color = "bg-warning";
                        $message = "De luchtvochtigheid is onder de 30% of boven de 50%";
                    }
                }else{
                    $color = "bg-secondary";
                    $message = "Er is geen data voor dit apparaat";
                }

                //set color by device
                $orgDeviceData[] = array(
                    'name' => $device['name'],
                    'color' => $color,
                    'message' => $message,
                );
            }
        }
        return $orgDeviceData;
    }

    /**
     * Method for getting a list of all available devices.
     *
     * [getUhooData description]
     * @return [type] [description]
     * @return \Illuminate\Http\Response
     */
    public function getUhooDevices()
    {
        $response = uHooAdapter::GetDevices();

        $newDevices = [];
        foreach ($response as $deviceResponse) {
            $device = Device::where('name', '=', $deviceResponse->deviceName)->get();
            if (count($device) < 1) {
                //Save new devices to DB
                $device = new Device;
                $device->name = $deviceResponse->deviceName;
                $device->mac_address = $deviceResponse->macAddress;
                $device->serial_number = $deviceResponse->serialNumber;
                array_push($newDevices, $device);
                $device->save();
            }
        }
        return json_encode($newDevices);
    }

    /**
     * Method for getting a data per minute.
     *
     * [getUhooData description]
     * @return [type] [description]
     * @return \Illuminate\Http\Response
     */
    public function getUhooData()
    {
        ini_set('max_execution_time', 300);
        $devices = Device::all();
        $records = [];
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
                    array_push($records, $record);
                }
            }
        }
        return json_encode($records);
    }
}
