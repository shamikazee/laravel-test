<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
Relation::morphMap([
    'categories'=>'App\Category',
    'courses'=>'App\Course',
]);
class Image extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}
