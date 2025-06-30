<?php

// File: app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Teacher;

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
        return view('teacher.dashboard');
    }

    public function viewCreateLesson()
    {
        $teacherId = Auth::id();

        // Prendi solo le iscrizioni dell'insegnante loggato
        $enrollments = CourseEnrollment::with(['student.user', 'course'])
            ->where('teacher_id', $teacherId)
            ->get();

        // Raggruppa studenti e corsi unici per popolare i select
        $students = $enrollments->pluck('student')->unique('id');
        //dd($students);
        $courses = $enrollments->pluck('course')->unique('id');
        //dd($courses);

        return view('teacher.createLesson', compact('students', 'courses'));
    }

    public function getCourses($studentId)
{
    $teacherId = Auth::id();

    $enrollments = CourseEnrollment::with('course')
        ->where('student_id', $studentId)
        ->where('teacher_id', $teacherId)
        ->get();

    $courses = $enrollments->pluck('course')->unique('id');

    // Debug temporaneo:
    dd($courses);

    return response()->json($courses->map(function ($course) {
        return ['id' => $course->id, 'name' => $course->name];
    })->values());
}




    public function store(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'course_id' => 'required|exists:courses,id',
        'day' => 'required|date',
        'time' => 'required|date_format:H:i',
        'duration' => 'required|integer|min:1',
    ]);

    $teacherId = Auth::id();

    // Trova l'enrollment corrispondente
    $enrollment = CourseEnrollment::where('student_id', $validated['student_id'])
        ->where('course_id', $validated['course_id'])
        ->where('teacher_id', $teacherId)
        ->first();

    if (!$enrollment) {
        return redirect()->back()->withErrors(['enrollment' => 'Nessuna iscrizione trovata per questo studente, corso e insegnante.']);
    }

    // Calcola orario inizio e fine della nuova lezione
    $newStart = strtotime($validated['day'] . ' ' . $validated['time']);
    $newEnd = $newStart + ($validated['duration'] * 60);

    // Controlla sovrapposizioni con altre lezioni dello stesso insegnante
    $overlappingLesson = Lesson::whereDate('day', $validated['day'])
        ->whereHas('courseEnrollment', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->get()
        ->first(function ($lesson) use ($newStart, $newEnd) {
            $existingStart = strtotime($lesson->day . ' ' . $lesson->time);
            $existingEnd = $existingStart + ($lesson->duration * 60);
            return $newStart < $existingEnd && $newEnd > $existingStart;
        });

    if ($overlappingLesson) {
        return redirect()->back()->withErrors([
            'overlap' => 'Esiste già una lezione sovrapposta per questo insegnante nello stesso orario.',
        ]);
    }

    // Crea la lezione
    Lesson::create([
        'course_enrollment_id' => $enrollment->id,
        'day' => $validated['day'],
        'time' => $validated['time'],
        'duration' => $validated['duration'],
    ]);

    return redirect()->back()->with('success', 'Lezione aggiunta con successo!');
}


    public function show()
    {
        $teacherId = Auth::id();
        $today = now()->startOfDay();

        $lessons = Lesson::with([
    'courseEnrollment.course',
    'courseEnrollment.student',
    'courseEnrollment.teacher',
])
    ->whereHas('courseEnrollment', function ($query) use ($teacherId) {
        $query->where('teacher_id', $teacherId);
    })
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

        return view('teacher.calendar', ['events' => $events->toArray()]);
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);

        $lesson->delete();
        return redirect()->back()->with('success', 'Lezione eliminata con successo.');
    }
    
}
