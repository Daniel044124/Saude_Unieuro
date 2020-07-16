<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'brand', 'unit'];

    public function orders()
    {
        return $this->belongsToMany('App\Order')
            ->withPivot('qtd');
    }

    public function lots()
    {
        return $this->hasMany('App\Lot');
    }

}
