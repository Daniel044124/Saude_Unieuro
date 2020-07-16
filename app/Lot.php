<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public $timestamps = false;
    protected $fillable = ['description', 'expiration', 'qtd', 'item_id'];

    public function items()
    {
        return $this->belongsTo('App\Item');
    }
}
