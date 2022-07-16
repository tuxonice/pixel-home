<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorController;

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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/point/push/{code}/{deviceId}/{sensorId}', [PointController::class, 'push'])->name('point.push');

Route::middleware('auth')->group(function () {

    Route::get('/users/list', [UserController::class, 'list']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/graph/show', [GraphController::class, 'show'])->name('graph.show');

    Route::get('/device/list', [DeviceController::class, 'index'])->name('device.list');
    Route::get('/device/create', [DeviceController::class, 'create'])->name('device.new');
    Route::post('/device', [DeviceController::class, 'store'])->name('device.save');
    Route::get('/device/{device}/edit', [DeviceController::class, 'edit'])->name('device.edit');
    Route::patch('/device/{device}', [DeviceController::class, 'update'])->name('device.update');
    Route::delete('/device/{device}', [DeviceController::class, 'destroy'])->name('device.delete');
    Route::patch('/device/{device}/sensor/delete', [DeviceController::class, 'deleteSensor'])->name('device.delete.sensor');

    Route::get('/sensor/list', [SensorController::class, 'index'])->name('sensor.list');
    Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensor.new');
    Route::post('/sensor', [SensorController::class, 'store'])->name('sensor.save');
    Route::get('/sensor/{sensor}/edit', [SensorController::class, 'edit'])->name('sensor.edit');
    Route::patch('/sensor/{sensor}', [SensorController::class, 'update'])->name('sensor.update');
    Route::delete('/sensor/{sensor}', [SensorController::class, 'destroy'])->name('sensor.delete');

    Route::get('/data-points/list', [PointController::class, 'index'])->name('data-points.list');
    Route::get('/data-points/getSensor', [PointController::class, 'getSensor'])->name('data-points.get-sensor');

});

require __DIR__.'/auth.php';
