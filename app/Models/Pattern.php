<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    /**
     * @var array
     */
    public $fillable = [ 'name', 'show_template', 'list_template', 'category_template' ];

    public $timestamps = false;
}
