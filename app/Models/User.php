<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    /**
     * Get the user type associated with the user.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}
