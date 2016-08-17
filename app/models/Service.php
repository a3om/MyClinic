<?php

class Service extends Eloquent {

	public function doctors()
	{
		return $this->belongsToMany('Doctor');
	}
}