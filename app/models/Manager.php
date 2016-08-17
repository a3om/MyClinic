<?php

class Manager extends Eloquent {

    public function user()
    {
        return $this->morphOne('User', 'relation');
    }

    public function activities()
    {
        return $this->hasMany('Activity');
    }
}