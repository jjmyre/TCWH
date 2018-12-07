<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Customize reset link email 
  //  public function sendPasswordResetNotification($token)
  //  {
   //     $this->notify(new ResetPasswordNotification($token));
   // }

    #Define relationship of favorites, wishlists and visits
    public function favorites() {   
        return $this->belongsToMany('App\Winery', 'favorites')->withTimestamps();
    }

    public function wishlists() {   
        return $this->belongsToMany('App\Winery', 'wishlists')->withTimestamps();
    }

    public function visits() {   
        return $this->belongsToMany('App\Winery', 'visits')->withTimestamps();
    }

    // access pivot column 'order'
    public function plans() {   
        return $this->belongsToMany('App\Winery', 'plans')->withTimestamps()->withPivot('id', 'order');
    }

}
