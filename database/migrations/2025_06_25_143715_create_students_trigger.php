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
        // Trigger AFTER INSERT
        DB::unprepared('
            CREATE TRIGGER trg_after_insert_user_student
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF (SELECT name FROM user_types WHERE id = NEW.user_type_id) = "studente" THEN
                    INSERT INTO students (
                        id, name, surname, birth_date, birth_place, gender, address, city, country,
                        postal_code, phone, email, password, created_at, updated_at
                    ) VALUES (
                        NEW.id, NEW.name, NEW.surname, NEW.birth_date, NEW.birth_place,
                        NEW.gender, NEW.address, NEW.city, NEW.country, NEW.postal_code,
                        NEW.phone, NEW.email, NEW.password, NEW.created_at, NEW.updated_at
                    );
                END IF;
            END
        ');

        // Trigger AFTER UPDATE
        DB::unprepared('
            CREATE TRIGGER trg_after_update_user_student
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                DECLARE new_type VARCHAR(255);
                DECLARE old_type VARCHAR(255);

                SET new_type = (SELECT name FROM user_types WHERE id = NEW.user_type_id);
                SET old_type = (SELECT name FROM user_types WHERE id = OLD.user_type_id);

                IF new_type = "studente" THEN
                    IF old_type != "studente" THEN
                        INSERT INTO students (
                            id, name, surname, birth_date, birth_place, gender, address, city, country,
                            postal_code, phone, email, password, created_at, updated_at
                        ) VALUES (
                            NEW.id, NEW.name, NEW.surname, NEW.birth_date, NEW.birth_place,
                            NEW.gender, NEW.address, NEW.city, NEW.country, NEW.postal_code,
                            NEW.phone, NEW.email, NEW.password, NEW.created_at, NEW.updated_at
                        );
                    ELSE
                        UPDATE students
                        SET name = NEW.name, surname = NEW.surname, birth_date = NEW.birth_date,
                            birth_place = NEW.birth_place, gender = NEW.gender, address = NEW.address,
                            city = NEW.city, country = NEW.country, postal_code = NEW.postal_code,
                            phone = NEW.phone, email = NEW.email, password = NEW.password,
                            updated_at = NEW.updated_at
                        WHERE id = NEW.id;
                    END IF;
                ELSE
                    IF old_type = "studente" THEN
                        DELETE FROM students WHERE id = OLD.id;
                    END IF;
                END IF;
            END
        ');

        // Trigger AFTER DELETE
        DB::unprepared('
            CREATE TRIGGER trg_after_delete_user_student
            AFTER DELETE ON users
            FOR EACH ROW
            BEGIN
                IF (SELECT name FROM user_types WHERE id = OLD.user_type_id) = "studente" THEN
                    DELETE FROM students WHERE id = OLD.id;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_insert_user_student');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_update_user_student');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_delete_user_student');
    }
};
