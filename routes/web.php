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
Route::get('/getEstudiantes', 'estudianteController@getEstudiantes');


Route::resource('docentes', 'docenteController');

Route::resource('psicologos', 'psicologoController');

Route::resource('grupos', 'grupoController');

Route::resource('tipoComportamientos', 'tipoComportamientoController');

Route::resource('comportamientos', 'comportamientoController');
Route::post('/add_comportamientos', 'comportamientoController@add_comportamientos');
Route::get('/getComportamientos', 'comportamientoController@getComportamientos');
Route::get('/getCountComp', 'comportamientoController@getCountComp');


Route::resource('actividades', 'actividadesController');
Route::post('/add_actividades', 'actividadesController@store');
Route::get('/getActividades', 'actividadesController@getActividades');
Route::get('/getCountAct', 'actividadesController@getCountAct');

Route::resource('avances', 'avancesController');

// Route::get('/roles', 'rolesController@index');

Route::resource('modeloSeguimientos', 'modelo_seguimientoController');


Route::resource('usuarios', 'UsuariosController');



Route::get('markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');

Route::post('readNotification/{id}', function ($id) {
    $notify_id = $id;

    $notification = auth()->user()->unreadNotifications->find($notify_id);
    if ($notification) {
        $notification->markAsRead();
    }
    return redirect()->back();
});
