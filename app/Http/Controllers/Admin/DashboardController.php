<?php

// File: app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Models\Ingrediente;
use App\Models\Pizza;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }

    public function viewProfile()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function viewCreateCourse(){
        return view('admin.createCourse');
    }

    public function viewCreateStudent()
    {
        return view('admin.createStudent');
    }

    public function viewCreateTeacher()
    {
        return view('admin.createTeacher');
    }

    public function viewCourses()
    {
        $courses = Course::all();
        //dd($courses);

        return view('admin.courses', compact('courses'));

    }

}
