<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    public function ProjectCases() {
        return $this->hasMany('App\Models\ProjectCase');
    }
}
