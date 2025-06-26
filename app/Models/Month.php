<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'month';

    protected $fillable = ['id', 'name'];
}