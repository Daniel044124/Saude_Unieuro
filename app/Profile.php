<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function menus()
    {
        return $this->belongsToMany('App\Menu', 'menus_profiles', 'profiles_id', 'menus_id');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'profiles_id');
    }
}
