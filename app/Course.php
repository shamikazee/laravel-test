<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
