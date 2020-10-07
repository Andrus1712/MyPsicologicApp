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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('acudientes', 'acudienteAPIController');

Route::resource('estudiantes', 'estudianteAPIController');

Route::resource('docentes', 'docenteAPIController');

Route::resource('psicologos', 'psicologoAPIController');

Route::resource('grupos', 'grupoAPIController');

Route::resource('tipo_comportamientos', 'tipoComportamientoAPIController');

Route::resource('comportamientos', 'comportamientoAPIController');

Route::resource('actividades', 'actividadesAPIController');

Route::resource('avances', 'avancesAPIController');

Route::resource('roles', 'rolesAPIController');


Route::resource('modelo_seguimientos', 'modelo_seguimientoAPIController');