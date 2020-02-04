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

Route::get('/sensor/push/{hash}', 'SensorController@push');

Route::middleware('auth')->group(function () {

    Route::get('/users/list', 'UserController@list');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/sensor/show', 'SensorController@show');
});
