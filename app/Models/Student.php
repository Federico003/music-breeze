<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;
use App\Models\CourseEnrollment;


class Student extends Model
{
    use HasFactory;

    // Seleziona i campi che possono essere assegnati in massa
    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'city',
        'country',
        'postal_code',
        'phone',
        'email',
        'password',
        'user_type_id'
    ];

    /**
     * The attributes that should be encrypted/decrypted.
     *
     * @var array<int, string>
     */
    protected $encryptable = [
        'name',
        'surname',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'city',
        'country',
        'postal_code',
        'phone',
        'email',
        'password',
    ];


    protected function casts(): array
    {
        return [
            'name' => 'string',
            'surname' => 'string',
            'birth_date' => 'date',
            'birth_place' => 'string',
            'gender' => 'string',
            'address' => 'string',
            'city' => 'string',
            'country' => 'string',
            'postal_code' => 'string',
            'phone' => 'string',
            'email' => 'string',

        ];
    }

    // public function lessons()
    // {
    //     return $this->hasMany(Lesson::class, 'course_enrollment_id');
    // }

public function courseEnrollments()
{
    return $this->belongsToMany(Course::class, 'course_enrollments')
                ->withPivot('teacher_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}


}
