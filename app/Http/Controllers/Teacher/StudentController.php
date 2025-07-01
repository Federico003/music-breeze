<?php

// File: app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Teacher;

use App\Models\CourseEnrollment;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function index()
    {
        //
    }


    public function show()
    {
        $teacher = Auth::id();

        if (!$teacher) {
            abort(403, 'Utente non associato ad alcun insegnante.');
        }

        // Recupera tutti gli ID degli studenti associati a quel teacher tramite course_enrollments
        $studentIds = CourseEnrollment::where('teacher_id', $teacher)
            ->pluck('student_id')
            ->unique();

        // Recupera i nomi degli studenti (puoi anche fare ->pluck('name') se ti serve solo quello)
       $students = Student::whereIn('id', $studentIds)->get();


        //dd($students);

        return view('teacher.students', compact('students'));
    }
}
