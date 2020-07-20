<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];

    public function menus()
    {
        return $this->belongsToMany('App\Menu', 'menus_roles');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
