<?php

use Illuminate\Http\Request;

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

Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');
    Route::post('refresh', 'LoginController@refresh');
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/users', 'UserController@getAll');
    Route::get('/users/{id}', 'UserController@getById');

    Route::get('/stats/{month}/patients', 'DashboardController@overallPatientStats');
    Route::get('/stats/{month}/beds', 'DashboardController@overallBedStats');
    Route::get('/stats/{month}/admit-day', 'DashboardController@admitDayStats');
    Route::get('/stats/{month}/collect-day', 'DashboardController@collectDayStats');

    Route::get('/wards', 'WardController@getAll');
    Route::get('/wards/{id}', 'WardController@getById');
    Route::post('/wards', 'WardController@store');
    Route::put('/wards/{id}', 'WardController@update');
    Route::delete('/wards/{id}', 'WardController@delete');
    Route::get('/wards/{ward}/beds', 'WardController@getWardBeds');
    Route::get('/wards/{id}/regises', 'WardController@getWardRegises');

    Route::get('/buildings', 'BuildingController@getAll');
    Route::get('/buildings/{id}', 'BuildingController@getById');
    Route::post('/buildings', 'BuildingController@store');
    Route::put('/buildings/{id}', 'BuildingController@update');
    Route::delete('/buildings/{id}', 'BuildingController@delete');    
    Route::get('/buildings/{id}/wards', 'BuildingController@getBuildingWards');

    Route::get('/schedulings', 'SchedulingController@getAll');
    Route::get('/schedulings/{id}', 'SchedulingController@getById');
    Route::get('/schedulings/add/init-form', 'SchedulingController@initForm');
    Route::post('/schedulings', 'SchedulingController@store');
    Route::put('/schedulings/{id}', 'SchedulingController@update');
    Route::delete('/schedulings/{id}', 'SchedulingController@delete');

    Route::get('/schedule-details/{scheduleId}/scheduling', 'SchedulingDetailController@getAll');
    Route::get('/schedule-details/{id}', 'SchedulingDetailController@getById');
    Route::put('/schedule-details/{id}', 'SchedulingDetailController@update');
    Route::put('/schedule-details/{id}/swap', 'SchedulingDetailController@swap');
    Route::put('/schedule-details/{id}/off', 'SchedulingDetailController@off');
    Route::put('/schedule-details/{id}/ot', 'SchedulingDetailController@ot');

    Route::get('/swappings', 'ShiftSwappingController@getAll');
    Route::put('/swappings/{id}/approve', 'ShiftSwappingController@approve');

    Route::get('/shift-offs', 'ShiftOffController@getAll');

    Route::get('/shifts', 'ShiftController@getAll');
    Route::get('/shifts/{id}', 'ShiftController@getById');
    Route::get('/shifts/{name}/name', 'ShiftController@getByName');

    Route::get('/holidays', 'HolidayController@getAll');
    Route::get('/holidays/{year}/year', 'HolidayController@getHolidaysOfYear');

    /** Routes to person db */
    Route::get('/factions', 'FactionController@getAll');
    Route::get('/factions/{id}', 'FactionController@getById');
    Route::get('/factions/{faction}/head-of', 'FactionController@getHeadOfFaction');

    Route::get('/departs', 'DepartController@getAll');
    Route::get('/departs/{id}', 'DepartController@getById');
    Route::get('/departs/{depart}/member-of', 'DepartController@getMemberOfDepart');
    
    
    Route::get('/divisions', 'DivisionController@getAll');
    Route::get('/divisions/{id}', 'DivisionController@getById');
    Route::get('/divisions/{division}/member-of', 'DivisionController@getMemberOfDivision');

    Route::get('/persons', 'PersonController@getAll');
    Route::get('/persons/{id}', 'PersonController@getById');
});
