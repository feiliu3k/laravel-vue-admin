<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['name', 'alias', 'pattern_id'];

    public $timestamps = false;

    public function pattern()
    {
        return $this->belongsTo('App\Models\Pattern');
    }
}
