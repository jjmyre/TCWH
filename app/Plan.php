<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	// pivot with extra columns 'order' and 'pending'
	protected $fillable = [
    	'user_id', 'winery_id', 'order', 'pending'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}