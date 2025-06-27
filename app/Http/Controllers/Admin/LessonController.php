<?php

// File: app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Models\CourseEnrollment;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{

    public function index()
    {
        return view('admin.show-lessons');
    }

    public function show()
    {
        $today = now()->startOfDay();

        $lessons = Lesson::with([
            'courseEnrollment.course',
            'courseEnrollment.student',
            'courseEnrollment.teacher',
        ])
            ->whereDate('day', '>=', $today->toDateString())
            ->orderBy('day')
            ->get();

        $events = $lessons->map(function ($lesson) {
            $start = $lesson->day . 'T' . substr($lesson->time, 0, 5) . ':00';
            $startTimestamp = strtotime($lesson->day . ' ' . $lesson->time);
            $endTimestamp = $startTimestamp + ($lesson->duration * 60);
            $end = date('Y-m-d\TH:i:s', $endTimestamp);

            $enrollment = $lesson->courseEnrollment;

            $courseName = $enrollment?->course?->name ?? 'Corso sconosciuto';
            $student = $enrollment?->student;
            $studentName = $student?->name ?? 'Studente sconosciuto';
            $studentFullName = $student ? "{$student->name} {$student->surname}" : 'Studente sconosciuto';

            $teacher = $enrollment?->teacher;
            $teacherFullName = $teacher ? "{$teacher->name} {$teacher->surname}" : 'Insegnante sconosciuto';


            return [
                'id' => $lesson->id,
                'title' => "$courseName - $studentName",
                'start' => $start,
                'end' => $end,
                'course_name' => $courseName,
                'student_name' => $studentName,
                'student_full_name' => $studentFullName,
                'teacher_full_name' => $teacherFullName,
            ];
        });

        //dd($events);

        return view('admin.calendar', ['events' => $events->toArray()]);
    }
}
