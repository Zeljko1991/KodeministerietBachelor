<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    public $fillable = ['title', 'order', 'sub_case_id', 'price'];
    public $timestamps = false;

    public function SubCase() {
        return $this->belongsTo('App\Models\SubCase');
    }
}
