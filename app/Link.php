<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function link()
    {
        return $this->belongsToMany('App\User');
    }
}
