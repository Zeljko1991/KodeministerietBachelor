<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function Customer() {
        return $this->belongsTo('App\Models\Address');
    }
}
