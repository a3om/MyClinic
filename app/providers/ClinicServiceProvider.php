<?php namespace Providers;

use Illuminate\Support\ServiceProvider;

class ClinicServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Clinic', function()
        {
            return new \Clinic;
        });
    }
}