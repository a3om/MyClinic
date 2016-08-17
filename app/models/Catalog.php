<?php

class Catalog extends Eloquent {

	protected $visible = ['id', 'name'];

	public function clients()
	{
		return $this->belongsToMany('Client');
	}
}