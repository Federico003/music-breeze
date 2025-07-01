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
use Carbon\Carbon;


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

    // Trova l'enrollment corrispondente per questo studente, corso e insegnante
    $enrollment = CourseEnrollment::where('student_id', $validated['student_id'])
        ->where('course_id', $validated['course_id'])
        ->where('teacher_id', $teacherId)
        ->first();

    if (!$enrollment) {
        return redirect()->back()->withErrors([
            'enrollment' => 'Nessuna iscrizione trovata per questo studente, corso e insegnante.'
        ]);
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

    // Controlla sovrapposizioni con altre lezioni dello stesso studente
    $overlappingStudentLesson = Lesson::whereDate('day', $validated['day'])
        ->whereHas('courseEnrollment', function ($query) use ($validated) {
            $query->where('student_id', $validated['student_id']);
        })
        ->get()
        ->first(function ($lesson) use ($newStart, $newEnd) {
            $existingStart = strtotime($lesson->day . ' ' . $lesson->time);
            $existingEnd = $existingStart + ($lesson->duration * 60);
            return $newStart < $existingEnd && $newEnd > $existingStart;
        });

    if ($overlappingStudentLesson) {
        return redirect()->back()->withErrors([
            'overlap_student' => 'Lo studente ha già una lezione sovrapposta in questo orario.',
        ]);
    }

    // Crea la nuova lezione
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

    public function showLessons()
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
            ->whereDate('day', '>=', $today) // ← questo filtra solo da oggi in poi
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
                'day' => $lesson->day,
                'time' => $lesson->time,
                'duration' => $lesson->duration,
                'course_name' => $courseName,
                'student_name' => $studentName,
                'student_full_name' => $studentFullName,
                'teacher_full_name' => $teacherFullName,
            ];
        });

        //dd($events);

        return view('teacher.lessons', ['events' => $events->toArray()]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'day' => 'required|date',
        'time' => 'required',
        'duration' => 'required|integer|min:1',
    ]);

    $lesson = Lesson::findOrFail($id);

    $start = Carbon::parse("{$request->day} {$request->time}");
    $end = $start->copy()->addMinutes($request->duration);

    $studentId = $lesson->courseEnrollment->student_id; // relazione esistente

    $teacherId = auth()->id(); // insegnante loggato

    // --- Controllo sovrapposizioni per lo studente ---
    // Cerco lezioni di questo studente (anche con altri insegnanti)
    $studentOverlap = Lesson::whereHas('courseEnrollment', function($q) use ($studentId) {
        $q->where('student_id', $studentId);
    })
    ->where('id', '!=', $lesson->id)
    ->where('day', $request->day)
    ->get()
    ->filter(function($l) use ($start, $end) {
        $lStart = Carbon::parse("{$l->day} {$l->time}");
        $lEnd = $lStart->copy()->addMinutes($l->duration);
        // Controllo sovrapposizione intervalli orari
        return $start < $lEnd && $end > $lStart;
    });

    if ($studentOverlap->count() > 0) {
        return response()->json([
            'message' => 'Errore: la lezione si sovrappone con un\'altra lezione dello studente.'
        ], 422);
    }

    // --- Controllo sovrapposizioni per l'insegnante ---
    // Prendo gli id degli iscritti ai corsi dell'insegnante
    $teacherCourseEnrollmentsIds = CourseEnrollment::whereHas('course', function($q) use ($teacherId) {
        $q->where('teacher_id', $teacherId);
    })->pluck('id');

    $teacherOverlap = Lesson::whereIn('course_enrollment_id', $teacherCourseEnrollmentsIds)
        ->where('id', '!=', $lesson->id)
        ->where('day', $request->day)
        ->get()
        ->filter(function($l) use ($start, $end) {
            $lStart = Carbon::parse("{$l->day} {$l->time}");
            $lEnd = $lStart->copy()->addMinutes($l->duration);
            return $start < $lEnd && $end > $lStart;
        });

    if ($teacherOverlap->count() > 0) {
        return response()->json([
            'message' => 'Errore: la lezione si sovrappone con un\'altra tua lezione.'
        ], 422);
    }

    // --- Nessun conflitto: aggiorno la lezione ---
    $lesson->day = $request->day;
    $lesson->time = $request->time;
    $lesson->duration = $request->duration;
    $lesson->save();

    return response()->json(['message' => 'Lezione aggiornata con successo']);
}






    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);

        $lesson->delete();
        return redirect()->back()->with('success', 'Lezione eliminata con successo.');
    }
}
