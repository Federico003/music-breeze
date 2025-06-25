<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\CourseEnrollment;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('user_type_id', 3)->get(); // 3 is the user_type_id for students
        return view('admin.students', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['user_type_id'] = 3; // Studente
        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Studente creato con successo.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function indexStudentCourses()
    {
        $students = Student::with('courseEnrollments')->get();
        $courses = Course::with('teachers')->get(); // ⬅️ carica i docenti per ogni corso

        return view('admin.studentCourses', compact('students', 'courses'));
    }

    public function updateStudentCourses(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $data = $request->input('courses_teachers', []);

        // Cancella le vecchie iscrizioni
        CourseEnrollment::where('student_id', $student->id)->delete();

        // Aggiunge le nuove iscrizioni
        foreach ($data as $course_id => $teacher_id) {
            if (!empty($teacher_id)) {
                CourseEnrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course_id,
                    'teacher_id' => $teacher_id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Iscrizioni aggiornate con successo.');
    }
}
