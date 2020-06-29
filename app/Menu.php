<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'path', 'icon'];

    public function profiles()
    {
        return $this->belongsToMany('App\Profile', 'menus_profiles', 'menus_id', 'profiles_id');
    }
}
