<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function Address() {
        return $this->belongsTo('App\Models\Address');
    }

    public function ProjectCase() {
        return $this->hasMany('App\Models\ProjectCase');
    }

    public function getFullNameAttribute() {
        return $this->firstName.' '.$this->lastName;
    }

}
