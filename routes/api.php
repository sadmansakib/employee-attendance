<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => ['cors', 'json.response']], function () {
    Route::post('login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('register', 'Auth\ApiAuthController@register')->name('register.api');
    Route::post('token/refresh', 'Auth\ApiAuthController@refresh')->name('refresh.api');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile','User\UserController@getEmployeeProfile')->name('employee.api');
        Route::get('logout', 'Auth\ApiAuthController@logout')->name('logout.api');
        Route::post('attend', 'Attendance\AttendanceController@giveAttendance')->name('attendance.api');
    });
});
