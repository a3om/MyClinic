<?php

class Notification extends Eloquent {

	public function clients()
	{
		return $this->belongsToMany('Client')->withPivot('read', 'answer');
	}
}