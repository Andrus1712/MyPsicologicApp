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

Route::get('/reportes', function () {
    return view('reporte');
});

Route::get('/legal', function () {
    return view('legal');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('acudientes', 'acudienteController');
Route::get('/getAcudientes', 'acudienteController@getAcudientes');

Route::resource('estudiantes', 'estudianteController');
Route::get('/getEstudiantes', 'estudianteController@getEstudiantes');


Route::resource('docentes', 'docenteController');
Route::get('/getDocentes', 'docenteController@getDocentes');

Route::resource('psicologos', 'psicologoController');
Route::get('/getPsicologos', 'psicologoController@getPsicologos');

Route::resource('grupos', 'grupoController');
Route::get('/getGrupos', 'grupoController@getGrupos');

Route::resource('tipoComportamientos', 'tipoComportamientoController');

Route::resource('comportamientos', 'comportamientoController');
Route::post('/add_comportamientos', 'comportamientoController@add_comportamientos');
Route::get('/getComportamientos', 'comportamientoController@getComportamientos');
Route::get('/getCountComp', 'comportamientoController@getCountComp');
Route::get('/comportamientosPdf', 'comportamientoController@createPDF')->name('report');

Route::resource('actividades', 'actividadesController');
Route::post('/add_actividades', 'actividadesController@store');
Route::get('/getActividades', 'actividadesController@getActividades');
Route::get('/getCountAct', 'actividadesController@getCountAct');
Route::get('/get_historial/{id}', 'actividadesController@getHistorial');

Route::resource('avances', 'avancesController');
Route::get('/getAvances', 'avancesController@getAvances');

Route::resource('roles', 'rolesController');
Route::get('/getRoles', 'rolesController@getRoles');

Route::resource('modeloSeguimientos', 'modelo_seguimientoController');
Route::get('/getModeloSeguimiento', 'modelo_seguimientoController@getModeloSeguimiento');
Route::get('/modelo_seguimientoPdf', 'modelo_seguimientoController@createPDF');


Route::resource('usuarios', 'UsuariosController');
Route::get('/getUsuarios', 'UsuariosController@getUsuarios');
Route::get('/profile', 'UsuariosController@getProfile');



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
