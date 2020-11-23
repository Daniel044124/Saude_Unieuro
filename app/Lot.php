<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    protected $fillable = ['description', 'expiration', 'qtd', 'item_id', 'open'];

    public function items()
    {
        return $this->belongsTo('App\Item');
    }
}
