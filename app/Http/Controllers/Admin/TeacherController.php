<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::where('user_type_id', 2)->get(); // 3 is the user_type_id for students
        return view('admin.teachers', compact('teachers'));
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

    $validatedData['user_type_id'] = 2; //Insegnante
    $validatedData['password'] = bcrypt($validatedData['password']);

    User::create($validatedData);

    return redirect()->route('admin.dashboard')->with('success', 'Insegnante creato con successo.');
}


    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }

    public function courses()
    {
        $teachers = Teacher::with('courses')->get(); // Assuming you want the first teacher, adjust as necessary
        $courses = Course::all(); // Assuming you have a relationship defined in the User model

        //dd($teachers, $courses); // For debugging purposes, remove this in production

        return view('admin.teacherCourses', compact('teachers', 'courses'));
    }

    public function updateCoursesTeacher(Request $request, Teacher $teacher)
    {
        //dd($request->all());
        $courses = $request->input('corsi', []); // array di corsi selezionati o vuoto
        //dd($courses); // For debugging purposes, remove this in production
        $teacher->courses()->sync($courses);
        return redirect()->route('admin.teacher-courses')->with('success', 'Corsi aggiornati con successo per l\'insegnante.');
    }

//     public function updateIngredientiPizza(Request $request, Pizza $pizza)
// {
//     $ingredienti = $request->input('ingredienti', []); // array di ingredienti selezionati o vuoto
//     $pizza->ingredienti()->sync($ingredienti);

//     return redirect()->back()->with('success', 'Ingredienti aggiornati per la pizza ' . $pizza->nome);
// }
}
