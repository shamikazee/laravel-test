<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
