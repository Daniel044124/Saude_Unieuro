<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'path', 'icon'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'menus_roles');
    }
}
