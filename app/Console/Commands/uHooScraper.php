<?php

namespace App\Console\Commands;

use App\Adapters\uHooAdapter;
use App\Models\Device;
use App\Models\Record;
use Illuminate\Console\Command;

class uHooScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uhoo:scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Getting the data which we not scraped yet.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Set max execution time to 5 minutes
        ini_set('max_execution_time', 300);

        /**
         * Get uHoo Devices
         */
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

        /**
         * Get uHoo latest data
         */
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
    }
}
