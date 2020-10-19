<?php

namespace App\Providers;





use App\Models\Comportamiento;
use App\Models\Actividade;
use App\Models\actividades;
use App\Models\Estudiante;
use App\Models\TipoComportamiento;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\Acudiente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['avances.fields'], function ($view) {
            $comportamientoItems = Comportamiento::pluck('id')->toArray();
            $view->with('comportamientoItems', $comportamientoItems);
        });
        View::composer(['avances.fields'], function ($view) {
            $actividadeItems = Actividades::pluck('id')->toArray();
            $view->with('actividadeItems', $actividadeItems);
        });
        View::composer(['comportamientos.fields'], function ($view) {
            $estudianteItems = Estudiante::pluck('id')->toArray();
            $view->with('estudianteItems', $estudianteItems);
        });
        View::composer(['comportamientos.fields'], function ($view) {
            $tipo_comportamientoItems = TipoComportamiento::pluck('id')->toArray();
            $view->with('tipo_comportamientoItems', $tipo_comportamientoItems);
        });
        View::composer(['grupos.fields'], function ($view) {
            $docenteItems = Docente::pluck('id')->toArray();
            $view->with('docenteItems', $docenteItems);
        });
        View::composer(['estudiantes.fields'], function ($view) {
            $grupoItems = Grupo::pluck('id')->toArray();
            $view->with('grupoItems', $grupoItems);
        });
        View::composer(['estudiantes.fields'], function ($view) {
            $acudienteItems = Acudiente::pluck('id')->toArray();
            $view->with('acudienteItems', $acudienteItems);
        });
        View::composer(['estudiantes.fields'], function ($view) {
            $acudienteItems = Acudiente::pluck('nombres', 'id')->toArray();
            $view->with('acudienteItems', $acudienteItems);
        });
        //
    }
}
