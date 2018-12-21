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
        return $this->hasMany('App\Models\Deliverable')->orderBy('stage', 'asc')->orderBy('order', 'asc');
    }

    public function UserWorksOn() {
        return $this->belongsToMany('App\Models\User', 'works_on', 'subcase_id', 'user_id')->withTimestamps()->withPivot('hrs');
    }
}
