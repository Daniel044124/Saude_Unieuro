<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    public $timestamps = false;
    protected $fillable = ['description', 'comment'];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
