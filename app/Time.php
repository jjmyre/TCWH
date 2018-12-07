<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	# Defines a one-to-one relationship
	public function winery() {
    	return $this->belongsTo('App\Winery');
	}
}
