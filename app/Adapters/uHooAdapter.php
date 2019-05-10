<?php

namespace App\Adapters;

// An adapter for the uHoo API
// https://documenter.getpostman.com/view/180333/6n7UCtb

class uHooAdapter
{
    //This salts is always the same and cant be changed
    const SALT1 = "154f7c2e9bd94d5d90aa382ae199206a4048c9ce931c78680b0942355ca918b1";
    const SALT2 = "@uhooinc.com";
    const API_URL = "https://api.uhooinc.com/v1/";

    //This function will make the password as the API of uHoo wants.
    private static function makePassword($password){
        return hash("sha256", self::SALT1 . $password . self::SALT2);
    }

    private static function makeRequest($method, $data = []){
        //Prepare variables
        $username = env("UHOO_USERNAME") !== null ? env("UHOO_USERNAME") : "uhoo@theinnoventors.eu";
        $password = env("UHOO_PASSWORD") !== null ? makePassword(env("UHOO_PASSWORD")) : "3e24510760d65ee46ba631e4d2d2d04bb1f86fecf56ee2e1248dc59b6749be6e";
        
        //Fill username and password
        $data["username"] = $username;
        $data["password"] = $password;

        //Send POST request to uHoo API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::API_URL . $method);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        return json_decode($result);
    }

    public static function GetDevices()
    {
       return makeRequest("getdevicelist");
    }

    public static function GetLatestData($serialNumber)
    {
        $data = [ "serialNumber" => $serialNumber ];
        return makeRequest("getlatestdata", $data);
    }

    public static function GetHourlyData($serialNumber, $prevDateTime = null){
        $data = [ "serialNumber" => $serialNumber ];
        if($prevDateTime !== null) $data["prevDateTime"] = $prevDateTime;
        return makeRequest("gethourlydata", $data);
    }

    public static function GetDailyData($serialNumber, $prevDateTime = null){
        $data = [ "serialNumber" => $serialNumber ];
        if($prevDateTime !== null) $data["prevDateTime"] = $prevDateTime;
        return makeRequest("getdailydata", $data);
    }

}


?>