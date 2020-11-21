<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'status', 'due_date', 'due_time', 'dispatched'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lab()
    {
        return $this->belongsTo('App\Lab');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'items_orders')
            ->withPivot('qtd');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
}
