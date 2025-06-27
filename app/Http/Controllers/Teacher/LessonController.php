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
        //dd($request);
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'day' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1',
        ]);

        //dd($validated);

        $teacherId = Auth::id();

        // Trova l'enrollment corrispondente
        $enrollment = CourseEnrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('teacher_id', $teacherId)
            ->first();

        if (!$enrollment) {
            return redirect()->back()->withErrors(['enrollment' => 'Nessuna iscrizione trovata per questo studente, corso e insegnante.']);
        }

        // Crea la lezione
        Lesson::create([
            'course_enrollment_id' => $enrollment->id,
            'day' => $validated['day'],
            'time' => $validated['time'],
            'duration' => $validated['duration'],
        ]);

        return redirect()->back()
        ->withErrors(['error' => 'Errore durante l\'aggiunta della lezione.'])
        ->with('success', 'Lezione aggiunta con successo!');
    }
    
}
