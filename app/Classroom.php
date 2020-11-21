<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'description'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject', 'class_id');
    }
}
