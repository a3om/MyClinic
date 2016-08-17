<?php

class AuthCode extends Eloquent {

	protected $table = 'auth_codes';
	protected $visible = ['id', 'phone', 'code'];
}