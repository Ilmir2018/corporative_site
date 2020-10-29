<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        //

        // @set($i, 10)
        Blade::directive('set', function ($exp) {

            list($name, $val) = explode(',', $exp);
            return "<?php $name = $val ?>";
        });

        //Прослушивание все sql запросов на странице и их вывод при необходимости
        DB::listen(function ($query) {

//            echo '<h1>' . $query->sql . '</h1>';

        });
    }
}
