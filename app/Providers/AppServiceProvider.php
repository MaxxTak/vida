<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!defined('VIDA')) {
           define('VIDA', config('variables.APP_VIDA', 'vida'));
        }
        
        Route::resourceVerbs([
            'create' => 'criar',
            'edit' => 'editar',
        ]);

        require_once base_path('resources/macros/form.php');
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
