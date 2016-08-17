<?php

class Activity extends Eloquent {

	// protected $visible = ['id'];

	public function manager()
	{
        return $this->belongsTo('Manager');
	}
}