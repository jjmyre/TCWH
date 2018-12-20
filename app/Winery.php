<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winery extends Model
{
    public function avas() {
    	// Many-to-many relationship
    	return $this->belongsToMany('App\Ava');
    }	

    public function time() {
    	// One-to-one relationship
    	return $this->hasOne('App\Time');
    }

    public function plans() {   
        return $this->belongsToMany('App\User', 'plans')->withTimestamps()->withPivot('id', 'order');
    }

}
