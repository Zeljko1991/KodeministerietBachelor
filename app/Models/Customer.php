<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function Address() {
        return $this->hasMany('App\Models\Address');
    }
}
