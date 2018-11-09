<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winery extends Model
{
    public function avas() {
    	# Many-to-many relationship
    	return $this->belongsToMany('App\Ava')->withTimestamps();
    }	

    public function time() {
    	# One-to-one relationship
    	return $this->hasOne('App\Time');
    }

     public function users() {
    	# One-to-one relationship
    	return $this->hasMany('App\User'); 
    }

}
