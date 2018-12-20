<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCase extends Model
{
    public function SubCases() {
        return $this->hasMany('App\Models\SubCase');
    }

    public function CaseStatus() {
        return $this->belongsTo('App\Models\CaseStatus');
    }

    public function Customer() {
        return $this->belongsTo('App\Models\Customer');
    }
}
