<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	public function wineries() {
		# One-to-one relationship
    	return $this->belongsTo('App\Winery', 'foreign_key')->withTimestamps();
	}
}
