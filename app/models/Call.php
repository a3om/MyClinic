<?php

class Call extends Eloquent {

	protected $visible = ['id', 'client_id', 'client'];

	public function client()
	{
		return $this->belongsTo('Client');
	}
}