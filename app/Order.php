<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['users_id', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'orders_items', 'orders_id', 'items_id')
            ->withPivot('qtd');
    }
}
