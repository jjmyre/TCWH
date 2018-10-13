<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	public function winery() {
		# One-to-one relationship
    	return $this->belongsToMany('App\Winery', 'foreign_key')->withTimestamps();
	}
}
