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
Route::post('eliminar/pry','Gco\ProyectoController@destroy');

Route::get('presupuesto','Gco\PresupuestoController@index');
Route::get('monto/presupuesto','Gco\PresupuestoController@getMontoItemResumen');
Route::get('ver/presupuesto','Gco\PresupuestoController@show');
Route::post('nuevo/presupuesto','Gco\PresupuestoController@store');
Route::post('actualizar/presupuesto','Gco\PresupuestoController@update');

Route::post('importar/partidas','Gco\PartidaController@importXls');
Route::get('list/partidas','Gco\PartidaController@list');
Route::get('actualizar/partida','Gco\PartidaController@update');

Route::get('presupuesto/programacion','Gco\ProgramaFisicoController@index');
Route::get('check/programacion','Gco\ProgramaFisicoController@verify');
//Route::get('programacion/nuevo','Gco\ProgramaFisicoController@create');
Route::post('programacion/nuevo','Gco\ProgramaFisicoController@store');
Route::get('ver/programacion/{curva}','Gco\ProgramaFisicoController@show');
Route::post('actualizar/programacion','Gco\ProgramaFisicoController@update');
Route::get('curvas','Gco\ProgramaFisicoController@indexCurva');
Route::get('curvas/desplegar/{curva}','Gco\ProgramaFisicoController@show');

Route::get('presupuesto/avance','Gco\AvanceController@index');
Route::get('avance/nuevo','Gco\AvanceController@create');
Route::post('avance/nuevo','Gco\AvanceController@store');
Route::get('list/avance','Gco\AvanceController@list');
Route::post('almacenar/avance/{close}','Gco\AvanceController@update');
Route::get('ver/avance','Gco\AvanceController@show');

Route::post('nuevo/prs','Gco\PersonaController@store');
Route::get('check/person','Gco\PersonaController@exist');

Route::post('edit/statusteam','Gco\ProyectoController@postEditStatusTeam');
Route::post('edit/jobteam','Gco\ProyectoController@postEditJobTeam');
