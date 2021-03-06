<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/point/push/{code}/{deviceId}/{sensorId}', 'PointController@push')->name('point.push');

Route::middleware('auth')->group(function () {

    Route::get('/users/list', 'UserController@list');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/graph/show', 'GraphController@show')->name('graph.show');
    
    Route::get('/device/list', 'DeviceController@index')->name('device.list');
    Route::get('/device/create', 'DeviceController@create')->name('device.new');
    Route::post('/device', 'DeviceController@store')->name('device.save');
    Route::get('/device/{device}/edit', 'DeviceController@edit')->name('device.edit');
    Route::patch('/device/{device}', 'DeviceController@update')->name('device.update');
    Route::delete('/device/{device}', 'DeviceController@destroy')->name('device.delete');
    Route::patch('/device/{device}/sensor/delete', 'DeviceController@deleteSensor')->name('device.delete.sensor');
    
    Route::get('/sensor/list', 'SensorController@index')->name('sensor.list');
    Route::get('/sensor/create', 'SensorController@create')->name('sensor.new');
    Route::post('/sensor', 'SensorController@store')->name('sensor.save');
    Route::get('/sensor/{sensor}/edit', 'SensorController@edit')->name('sensor.edit');
    Route::patch('/sensor/{sensor}', 'SensorController@update')->name('sensor.update');
    Route::delete('/sensor/{sensor}', 'SensorController@destroy')->name('sensor.delete');
    
    Route::get('/data-points/list', 'PointController@index')->name('data-points.list');
    Route::get('/data-points/getSensor', 'PointController@getSensor')->name('data-points.get-sensor');
    
    
});
