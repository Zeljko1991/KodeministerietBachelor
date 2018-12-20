<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function CategorizesCase() {
        return $this->belongsToMany('App\Models\ProjectCase', 'category_projectcase', 'category_id',  'projectcase_id');
    }

    public function CategorizesMarketing() {
        return $this->belongsToMany('App\Models\Marketing', 'category_marketing', 'category_id', 'marketing_id');
    }
}
