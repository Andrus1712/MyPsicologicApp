<?php

namespace App\Providers;
use App\Models\Acudiente;

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
        View::composer(['estudiantes.fields'], function ($view) {
            $acudienteItems = Acudiente::pluck('nombres','id')->toArray();
            $view->with('acudienteItems', $acudienteItems);
        });
        //
    }
}