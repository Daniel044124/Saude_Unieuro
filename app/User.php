<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $fillable = ['username', 'email', 'password', 'remember_token', 'profiles_id'];

    public function profile()
    {
        return $this->belongsTo('App\Profile', 'profiles_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'users_id');
    }
}
