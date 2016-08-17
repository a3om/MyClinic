<?php

class Doctorentry extends Eloquent {

	protected $visible = ['id', 'to', 'from', 'client_id', 'client'];

	public function getDates()
    {
        return ['from', 'to', 'created_at', 'updated_at'];
    }

	public function client()
	{
		return $this->belongsTo('Client');
	}

	public function place()
	{
        return $this->morphTo();
	}
}