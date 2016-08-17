<?php namespace Facades;

use Illuminate\Support\Facades\Facade;

class Clinic extends Facade {

    protected static function getFacadeAccessor()
    {
    	return '\Clinic';
    }
}