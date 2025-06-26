<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
 protected $table = 'payment';

    protected $fillable = [
    'student_id',
    'course_id',
    'payment_type_id',
    'month_id',
    'year',
    'amount',
];
}
