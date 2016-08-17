<?php

class Client extends Eloquent {

	protected $visible = ['id', 'clinics', 'devices', 'first_name', 'last_name', 'patronymic', 'birthday', 'sex', 'tempcatalog', 'age', 'created_at', 'notifications', 'pivot'];

    public function clinics()
    {
        return $this->belongsToMany('Clinic');
    }

    public function getDates()
    {
        return ['birthday', 'created_at', 'updated_at'];
    }

    public function tempcatalog()
    {
    	return $this->hasOne('TempCatalog');
    }

    public function getAgeAttribute()
    {
        return date_diff($this->birthday, new DateTime('now'))->format('%y');
    }

    public function notifications()
    {
        return $this->belongsToMany('Notification')->withPivot('read', 'answer');
    }

    public function devices()
    {
        return $this->hasMany('Device');
    }

    public function catalogs()
    {
        return $this->belongsToMany('Catalog');
    }

    public function user()
    {
        return $this->morphOne('User', 'relation');
    }

    public function calls()
    {
        return $this->hasMany('Call');
    }
}