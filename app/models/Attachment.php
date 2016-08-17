<?php

class Attachment extends Eloquent {

	protected $visible = ['id', 'file'];

	public function relation()
	{
        return $this->morphTo();
	}
}