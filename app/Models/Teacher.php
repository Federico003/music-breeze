<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
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

    public $timestamps = true;

    protected $table = 'teachers';

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teachers_courses');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }
}
