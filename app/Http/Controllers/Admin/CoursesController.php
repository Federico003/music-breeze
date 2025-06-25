<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('admin.editCourse', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $id = $request->route('id'); // Assuming the route parameter is named 'id'

    $course = Course::findOrFail($id);
    $course->update($validatedData);

    return redirect()->route('admin.courses') // O dove vuoi reindirizzare dopo l'update
                     ->with('success', 'Corso modificato con successo.');
    }

    public function print($id){
        try {
            $course = Course::findOrFail($id);

            Log::info('Dati del corso:', [
                'name' => $course->name,
                'description' => $course->description,
                'created_at' => $course->created_at,
            ]);
            $pdf = Pdf::loadView('admin.pdf.course', compact('course'));
            //$pdf = PDF::loadView('admin.course.pdf.show', compact('course'));

            return $pdf->download('Course.pdf');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return Redirect::back()->with('success', 'Corso eliminato con successo.');
    }
}
