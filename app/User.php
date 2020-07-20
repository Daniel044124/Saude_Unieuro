<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;
    protected $fillable = ['username', 'email', 'password', 'remember_token', 'profiles_id'];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
