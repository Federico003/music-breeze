<?php

namespace App\Models;

use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Course extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];


    /**
     * User statuses
     *
     * @var array<int, string>
     */
    /*protected static $statuses = [
        1 => 'Attivo',
        0 => 'Disattivo',
    ];*/

    /**
     * Get the available user statuses.
     *
     * @return array<int, string> An array of user statuses where keys are status codes and values are status names.
     */
    /*public static function getStatuses(): array
    {
        return self::$statuses;
    }*/


    /**
     * Boot the User model and set up event listeners for creating, updating, and deleting actions.
     *
     * This method registers event listeners to log activities related to user records, such as creation, updating, and deletion.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function () {
            //Log::info('User creating');
        });

        self::created(function () {
            //Log::info('User created');
        });

        self::updating(function () {
            //Log::info('User updating');
        });

        self::updated(function () {
            //Log::info('User updated');
        });

        self::deleting(function () {
            //Log::info('User deleting');
        });

        self::deleted(function () {
            //Log::info('User deleted');
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
        ];
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teachers_courses'); // La tabella pivot è 'teachers_courses'
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }


    //     public function teachers()
    // {
    //     return $this->belongsToMany(User::class, 'teachers_courses', 'course_id', 'teacher_id');
    // }

    //     public function lessons()
    //     {
    //         return $this->hasMany(Lesson::class, 'course_enrollment_id');
    //     }

    //     public function enrollments()
    // {
    //     return $this->hasMany(CourseEnrollment::class);
    // }

}
