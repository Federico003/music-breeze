<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creazione della tabella teacher
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->char('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();
        });

        // Popolare la tabella con i dati iniziali (senza user_type_id)
        DB::statement("
    INSERT INTO teachers (
        id, name, surname, birth_date, birth_place, gender, address, city, country,
        postal_code, phone, email, password, created_at, updated_at
    )
    SELECT
        users.id, users.name, users.surname, users.birth_date, users.birth_place,
        users.gender, users.address, users.city, users.country, users.postal_code,
        users.phone, users.email, users.password, users.created_at, users.updated_at
    FROM users
    JOIN user_types ON users.user_type_id = user_types.id
    WHERE user_types.name = 'insegnante'
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
