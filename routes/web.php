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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('acudientes', 'acudienteController');

Route::resource('estudiantes', 'estudianteController');

Route::resource('docentes', 'docenteController');

Route::resource('psicologos', 'psicologoController');

Route::resource('grupos', 'grupoController');

Route::resource('tipoComportamientos', 'tipoComportamientoController');

Route::resource('comportamientos', 'comportamientoController');

Route::resource('actividades', 'actividadesController');

Route::resource('avances', 'avancesController');

Route::resource('roles', 'rolesController');

Route::resource('modeloSeguimientos', 'modelo_seguimientoController');