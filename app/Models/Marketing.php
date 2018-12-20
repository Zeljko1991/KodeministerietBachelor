<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    public function CategorizedBy() {
        return $this->belongsToMany('App\Models\Category', 'category_marketing', 'marketing_id', 'category_id');
    }
}
