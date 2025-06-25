<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create user types if they don't exist
        UserType::firstOrCreate(['name' => 'admin']);
        UserType::firstOrCreate(['name' => 'insegnante']);
        UserType::firstOrCreate(['name' => 'studente']);

        // Create some users

        User::create([
            'name' => 'Federico',
            'surname' => 'Bonini',
            'birth_date' => '2003-05-08',
            'birth_place' => 'Mantova',
            'gender' => 'M',
            'address' => 'via Colombano 1904/B',
            'city' => 'Castelnovo Bariano',
            'country' => 'Italia',
            'postal_code' => '45030',
            'phone' => '1234567890',
            'email' => 'federico.bonini@email.com',
            'password' => bcrypt('password'),
            'user_type_id' => 3, // Studente
        ]);

        User::create([
            'name' => 'Ilaria',
            'surname' => 'Conforto',
            'birth_date' => '2003-01-09',
            'birth_place' => 'Adria',
            'gender' => 'F',
            'address' => 'via Campagna 1',
            'city' => 'San Martino di Venezze',
            'country' => 'Italia',
            'postal_code' => '45030',
            'phone' => '1234567890',
            'email' => 'ilaria.conforto@email.com',
            'password' => bcrypt('password'),
            'user_type_id' => 3, // Studente
        ]);

        User::create([
            'name' => 'Linda',
            'surname' => 'Orsini',
            'birth_date' => '2003-11-19',
            'birth_place' => 'Bologna',
            'gender' => 'F',
            'address' => 'via Campagna 2',
            'city' => 'San Pietro in Casale',
            'country' => 'Italia',
            'postal_code' => '36070',
            'phone' => '0987654321',
            'email' => 'linda.orsini@email.com',
            'password' => bcrypt('password'),
            'user_type_id' => 3, // Studente
        ]);


        User::create([
            'name' => 'Marco',
            'surname' => 'Rossi',
            'birth_date' => '2002-05-15',
            'birth_place' => 'Ferrara',
            'gender' => 'M',
            'address' => 'via Roma 10',
            'city' => 'Ferrara',
            'country' => 'Italia',
            'postal_code' => '44100',
            'phone' => '1122334455',
            'email' => 'marco.rossi@email.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2, // Insegnante
        ]);

        User::create([
            'name' => 'Giulia',
            'surname' => 'Bianchi',
            'birth_date' => '2001-03-22',
            'birth_place' => 'Ravenna',
            'gender' => 'F',
            'address' => 'via Milano 20',
            'city' => 'Ravenna',
            'country' => 'Italia',
            'postal_code' => '48100',
            'phone' => '2233445566',
            'email' => 'giulia.bianchi@email.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2, // Insegnante
        ]);

    }
}