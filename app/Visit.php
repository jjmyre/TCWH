<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
	// pivot with extra column 'tally'
    protected $fillable = [
    	'user_id', 'winery_id', 'tally'
    ];
}
