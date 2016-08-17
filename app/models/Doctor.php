<?php

class Doctor extends Eloquent {

	protected $visible = ['id', 'first_name', 'last_name', 'patronymic', 'photo', 'phone', 'address', 'description'];

	public function specialities()
	{
		return $this->belongsToMany('Speciality');
	}

	public function services()
	{
		return $this->belongsToMany('Service');
	}
}