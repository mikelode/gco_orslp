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
})->middleware('auth');

Route::get('proyecto','Gco\ProyectoController@index')->middleware('auth');
Route::get('nuevo/pry','Gco\ProyectoController@create');
Route::post('nuevo/pry','Gco\ProyectoController@store');
Route::get('editar/pry','Gco\ProyectoController@edit');
Route::post('editar/pry','Gco\ProyectoController@update');
Route::post('eliminar/pry','Gco\ProyectoController@destroy');

Route::get('presupuesto','Gco\PresupuestoController@index')->middleware('auth');
Route::get('monto/presupuesto','Gco\PresupuestoController@getMontoItemResumen');
Route::get('ver/presupuesto','Gco\PresupuestoController@show');
Route::post('nuevo/presupuesto','Gco\PresupuestoController@store');
Route::post('actualizar/presupuesto','Gco\PresupuestoController@update');
Route::get('create/prestacion','Gco\PresupuestoController@createPrestacion');
Route::post('store/prestacion','Gco\PresupuestoController@storePrestacion');
Route::get('list/presupuesto','Gco\PresupuestoController@list');

Route::post('importar/partidas','Gco\PartidaController@importExcel');
Route::get('list/partidas','Gco\PartidaController@list');
Route::get('actualizar/partida','Gco\PartidaController@update');

Route::get('presupuesto/programacion','Gco\ProgramaFisicoController@index')->middleware('auth');
Route::get('check/programacion','Gco\ProgramaFisicoController@verify');
//Route::get('programacion/nuevo','Gco\ProgramaFisicoController@create');
Route::post('programacion/nuevo','Gco\ProgramaFisicoController@store');
Route::get('ver/programacion/{curva}','Gco\ProgramaFisicoController@show');
Route::post('actualizar/programacion','Gco\ProgramaFisicoController@update');
Route::get('curvas','Gco\ProgramaFisicoController@indexCurva')->middleware('auth');
Route::get('curvas/desplegar/{curva}','Gco\ProgramaFisicoController@show');
Route::get('export/sheet','Gco\ProgramaFisicoController@generateSheet');

Route::get('presupuesto/avance','Gco\AvanceController@index')->middleware('auth');
Route::get('avance/nuevo','Gco\AvanceController@create');
Route::post('avance/nuevo','Gco\AvanceController@store');
Route::get('list/avance','Gco\AvanceController@list');
Route::post('almacenar/avance/{close}','Gco\AvanceController@update');
Route::get('ver/avance','Gco\AvanceController@show');

Route::get('configuracion','Gco\ConfiguracionController@index')->middleware('auth');
Route::get('settings/new_user', 'Gco\ConfiguracionController@getRegisterUser');
Route::post('settings/new_user', 'Gco\ConfiguracionController@postRegisterUser');
Route::get('settings/list_users', 'Gco\ConfiguracionController@getListUsers');
Route::post('settings/updt_profile', 'Gco\ConfiguracionController@postUpdateProfile');
Route::get('settings/updt_state', 'Gco\ConfiguracionController@postUpdateStateUser');
Route::get('settings/updt_pass', 'Gco\ConfiguracionController@getUpdatePasswordUser');
Route::post('settings/updt_pass', 'Gco\ConfiguracionController@postUpdatePasswordUser');
Route::get('settings/reset_pass', 'Gco\ConfiguracionController@getResetPasswordUser');
Route::get('getProfile/{id}', 'Gco\ConfiguracionController@showProfileUser');

Route::post('nuevo/prs','Gco\PersonaController@store');
Route::get('check/person','Gco\PersonaController@exist');

Route::post('edit/statusteam','Gco\ProyectoController@postEditStatusTeam');
Route::post('edit/jobteam','Gco\ProyectoController@postEditJobTeam');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
