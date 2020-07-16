<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'status', 'due_date', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item')
            ->withPivot('qtd');
    }
}
