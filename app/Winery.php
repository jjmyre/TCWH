<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winery extends Model
{
    public function avas() {
    	# Many-to-many relationship
    	return $this->belongsToMany('App\Ava')->withTimestamps();
    }	

    public function times() {
    	# One-to-one relationship
    	return $this->hasOne('App\Time')->withTimestamps();
    }

}
