<?php

class Device extends Eloquent {

	// protected $visible = ['id', 'clinics', 'devices', 'first_name', 'last_name', 'patronymic', 'birthday', 'sex', 'tempcatalog', 'age', 'created_at'];

    public function client()
    {
        return $this->hasOne('Client');
    }
}