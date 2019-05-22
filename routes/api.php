<?php

Route::group([
    'middleware' => 'api'
], function ($router) {

    //Routes for device api controller
    Route::get('devices','Api\DeviceApiController@devices');
    Route::get('devices/{id}', 'Api\DeviceApiController@device');
    Route::get('devices/{id}/lastrecord', 'Api\DeviceApiController@lastrecord');
    Route::get('devices/{id}/status', 'Api\DeviceApiController@status');

    //Routes for blueprint api controller
    Route::get('blueprints','Api\BlueprintApiController@blueprints');
    Route::get('blueprints/{id}', 'Api\BlueprintApiController@blueprint');
    Route::get('blueprints/{id}/devices', 'Api\BlueprintApiController@devices');

    /*
    
        the below routes are old and need to be refactored
    
    */

    // Routes for Airlab Blueprints
    Route::get('blueprint/get', 'BlueprintController@getBlueprint');
    Route::get('blueprint/fullscreen', 'BlueprintController@getBlueprintFullscreen');
    Route::get('blueprint/devices/get', 'BlueprintController@getUserDevices');
    Route::get('blueprint/db/devices/get', 'BlueprintController@getUserDBDevices');
    Route::post('blueprint/upload', 'BlueprintController@uploadBlueprint');
    Route::post('blueprint/admin/upload', 'BlueprintController@uploadBlueprintAdmin');
    Route::post('blueprint/update', 'BlueprintController@updateBlueprint');
    Route::post('blueprint/name/change', 'BlueprintController@changeBlueprintName');
    Route::post('blueprint/coordinations/get', 'BlueprintController@getCoordination');
    Route::post('blueprint/delete', 'BlueprintController@deleteBlueprint');
    Route::post('blueprint/device/remove', 'BlueprintController@removeDeviceFromBlueprint');
    Route::post('blueprint/records/device/get', 'BlueprintController@getRecordsForDevice');

    // Routes for Airlab API
    Route::get('airlab/devices/data/get', 'ApiController@getDevicesWithData');
    Route::get('airlab/records/id/get', 'ApiController@getRecordsById');
    Route::get('airlab/device/records/chart/get', 'ApiController@getRecordsByProperty');

    // Routes for Airlab Organizations
    Route::get('airlab/organizations/get', 'OrganizationController@getOrganizations');

    // Routes for Airlab Devices
    Route::get('airlab/devices/organization/get', 'DeviceController@getDevicesOrganization');
    Route::get('airlab/new/devices/get', 'DeviceController@getNewDevices');
    Route::post('airlab/device/organization/add', 'DeviceController@addDeviceOrg');
    Route::post('airlab/device/organization/delete', 'DeviceController@deleteDevicesOrganization');
    Route::post('airlab/device/edit', 'DeviceController@editDevice');

    // Routes for Uhoo API
    Route::post('uhoo/data/devices/get', 'ApiController@getUhooDevices');
    Route::get('uhoo/data/devices/get', 'ApiController@getUhooDevices');
    Route::post('uhoo/data/records/get', 'ApiController@getUhooData');
    Route::get('uhoo/data/records/get', 'ApiController@getUhooData');
});
