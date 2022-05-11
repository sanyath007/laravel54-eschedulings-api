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

Route::get('/files/{id}', 'FileController@getFile');
Route::get('/files/{id}/print', 'FileController@printForm');
Route::get('/files/{id}/swap', 'FileController@swapForm');
Route::post('/files', 'FileController@saveFile');