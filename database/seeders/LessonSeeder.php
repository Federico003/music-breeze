<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $enrollments = CourseEnrollment::all();

        if ($enrollments->isEmpty()) {
            $this->command->warn('Nessun course_enrollment trovato. Popola prima la tabella course_enrollments.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $enrollment = $enrollments->random();

            Lesson::create([
                'course_enrollment_id' => $enrollment->id,
                'day' => Carbon::create(2025, rand(6, 7), rand(1, 28))->format('Y-m-d'),
                'time' => Carbon::createFromTime(rand(8, 17), [0, 15, 30, 45][rand(0, 3)])->format('H:i:s'),
                'duration' => rand(30, 120),
            ]);
        }
    }
}
