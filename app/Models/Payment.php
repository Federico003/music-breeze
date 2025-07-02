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

public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
