<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $fillable = ['name', 'display_name', 'description'];

    public $timestamps = false;
}
