<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCase extends Model
{
    public function ProjectCase(){
        return $this->belongsTo('App\Models\ProjectCase');
    }

    public function CaseStatus() {
        return $this->belongsTo('App\Models\CaseStatus');
    }

    public function Deliverables() {
        return $this->hasMany('App\Models\Deliverable')->orderBy('order', 'asc');
    }
}
