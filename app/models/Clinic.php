<?php

class Clinic extends Eloquent {

	protected $visible = ['id', 'address', 'latitude', 'longitude', 'email', 'phone1', 'phone2', 'phone3', 'clients', 'doctors', 'specialities', 'services'];

	public function clients()
    {
        return $this->belongsToMany('Client')->withPivot('active');
    }

    public function doctors()
    {
    	return $this->hasMany('Doctor');
    }

    public function catalogs()
    {
    	return $this->hasMany('Catalog');
    }

    public function specialities()
    {
    	return $this->hasMany('Speciality');
    }

    public function services()
    {
    	return $this->hasMany('Service');
    }

    public function user()
    {
        return $this->morphOne('User', 'relation');
    }

    public function tempcatalog()
    {
        return $this->hasMany('TempCatalog');
    }

    public function notifications()
    {
        return $this->hasMany('Notification');
    }

    public function calls()
    {
        return $this->hasMany('Call');
    }
}