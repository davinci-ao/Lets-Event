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

        \Validator::extend('is_later_than_today', function($attribute, $value, $parameters, $validator) {
            
            if ( $value === false || $value === -1 || strtotime("now") > $value ) {
                return false;
            }

            return true;
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
