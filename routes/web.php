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

Route::any('/', 'Home\IndexController@index');
Route::any('point', 'Home\IndexController@point');
Route::any('test1', 'Home\IndexController@test');

Route::any('qu', 'Home\Qu\IndexController@index');
Route::any('qutest', 'Home\Qu\IndexController@mail');
Route::any('qu/submit', 'Home\Qu\IndexController@index_submit');

//users routes
require __DIR__ . '/web/backstage.php';
require __DIR__ . '/web/qu_backstage.php';
