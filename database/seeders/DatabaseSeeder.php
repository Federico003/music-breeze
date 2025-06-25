<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UserTypeSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MonthSeeder::class);
        $this->call(PaymentTypeSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'surname' => 'User',
            'birth_date' => '2000-01-01',
            'birth_place' => 'Test City',
            'gender' => 'M', // Assuming
            'address' => '123 Test Street',
            'city' => 'Test City',
            'country' => 'Test Country',
            'postal_code' => '12345',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'user_type_id' => 1, // Assuming 'Admin' is the first user type
            'password' => bcrypt('password'), // Use bcrypt for password hashing

        ]);
    }
}
