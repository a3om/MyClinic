<?php

class Speciality extends Eloquent {

	public function doctors()
	{
		return $this->belongsToMany('Doctor');
	}
}