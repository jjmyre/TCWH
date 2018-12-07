<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

	protected $fillable = [
    	'user_id', 'winery_id', 'order'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}