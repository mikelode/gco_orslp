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
Route::get('list/presup','Gco\PresupuestoController@list');
Route::post('importar/presup','Gco\PresupuestoController@importXls');

Route::post('nuevo/prs','Gco\PersonaController@store');
Route::get('check/person','Gco\PersonaController@exist');

Route::post('edit/statusteam','Gco\ProyectoController@postEditStatusTeam');
Route::post('edit/jobteam','Gco\ProyectoController@postEditJobTeam');
