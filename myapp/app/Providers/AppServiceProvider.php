<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        \Validator::extend('less_than_equal', function($attribute, $value, $parameters, $validator) {
            $other = $parameters[0];
            $value = intval($value);
            $toCompare = intval($other);

            return ($value >= $other);
        });
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
