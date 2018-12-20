<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function Address() {
        return $this->belongsTo('App\Models\Address');
    }

    public function ProjectCase() {
        return $this->belongsToMany('App\Models\ProjectCase');
    }
}
