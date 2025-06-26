<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\CourseEnrollment;
use App\Models\Month;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentController extends Controller
{

    public function viewCreatePayment()
    {
        $students = Student::all();
        $courseEnrollment = CourseEnrollment::all();
        $paymentsTypes = PaymentType::all();
        $months = Month::all();
        return view('admin.createPayment', compact('students', 'courseEnrollment', 'paymentsTypes', 'months'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'payment_type_id' => ['required', 'exists:payment_type,id'],
            'month' => ['nullable', 'exists:month,id'],
            'year_monthly' => ['digits:4', 'integer', 'min:1900', 'max:2100'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        Payment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'payment_type_id' => $validated['payment_type_id'],
            'month_id' => $validated['month'] ?? null,
            'year' => $validated['year_monthly'],
            'amount' => $validated['amount'],
        ]);

        return redirect()->back()->with('success', 'Pagamento registrato con successo.');
    }
}
