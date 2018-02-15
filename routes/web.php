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

Route::get('/', function () {
    return view('app');
});

Route::get('proyecto','Gco\ProyectoController@index');
Route::get('nuevo/pry','Gco\ProyectoController@create');
Route::post('nuevo/pry','Gco\ProyectoController@store');
Route::get('editar/pry','Gco\ProyectoController@edit');
Route::post('editar/pry','Gco\ProyectoController@update');

Route::get('presupuesto','Gco\PresupuestoController@index');
Route::post('importar/partidas','Gco\PartidaController@importXls');

Route::get('list/partidas','Gco\PartidaController@list');

Route::get('presupuesto/avance','Gco\AvanceController@index');
Route::get('avance/nuevo','Gco\AvanceController@create');
Route::post('avance/nuevo','Gco\AvanceController@store');
Route::get('list/avance','Gco\AvanceController@list');

Route::post('detallado/avance','Gco\AvanceController@edit');
Route::post('almacenar/avance','Gco\AvanceController@update');

Route::post('nuevo/prs','Gco\PersonaController@store');
Route::get('check/person','Gco\PersonaController@exist');

Route::post('edit/statusteam','Gco\ProyectoController@postEditStatusTeam');
Route::post('edit/jobteam','Gco\ProyectoController@postEditJobTeam');
