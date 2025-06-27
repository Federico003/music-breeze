<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER delete_course_enrollments_after_teacher_course_deleted
        AFTER DELETE ON teachers_courses
        FOR EACH ROW
        DELETE FROM course_enrollments
        WHERE course_id = OLD.course_id AND teacher_id = OLD.teacher_id;

        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
