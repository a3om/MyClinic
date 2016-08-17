<?php

class TempCatalog extends Eloquent {

	protected $table = 'temp_catalog';
	protected $visible = ['id', 'client_id', 'client'];

	public function client()
	{
		return $this->belongsTo('Client');
	}
}