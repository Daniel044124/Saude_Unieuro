<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'qtd', 'unity'];

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'orders_items', 'items_id', 'orders_id')
            ->withPivot('qtd');
    }

}
