<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = ['name', 'brand', 'unit', 'formula', 'molecular_weight', 'concentration'];

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'items_orders')
            ->withPivot('qtd');
    }

    public function lots()
    {
        return $this->hasMany('App\Lot');
    }

}
