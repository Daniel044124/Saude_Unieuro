<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function classes()
    {
        return $this->hasMany('App\Classroom');
    }
}
