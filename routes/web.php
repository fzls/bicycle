<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

Route::get('/', 'BicycleController@showDashboard');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');