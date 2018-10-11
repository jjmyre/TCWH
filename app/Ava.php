<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ava extends Model
{
    public function wineries()
	{
		# Many-to-many relationship
	    return $this->belongsToMany('\App\Winery')->withTimestamps();
	}
}
