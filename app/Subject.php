<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'description'
    ];

    public function classroom()
    {
        return $this->belongsTo('App\Classroom', 'class_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
