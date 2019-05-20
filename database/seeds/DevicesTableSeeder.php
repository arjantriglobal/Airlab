<?php

use App\Adapters\uHooAdapter;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = uHooAdapter::GetDevices();

        foreach ($response as $deviceResponse) {
            $device = Device::where('name', '=', $deviceResponse->deviceName)->get();
            if (count($device) < 1) {
                //Save new devices to DB
                $device = new Device;
                $device->name = $deviceResponse->deviceName;
                $device->mac_address = $deviceResponse->macAddress;
                $device->serial_number = $deviceResponse->serialNumber;
                $device->save();
            }
        }
    }
}
