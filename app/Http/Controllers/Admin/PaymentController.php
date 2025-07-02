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

    public function index(Request $request)
{
    $payments = \App\Models\Payment::with(['student', 'course', 'paymentType', 'month'])
        ->when($request->get('sort_by'), function ($query) use ($request) {
            $direction = $request->get('direction', 'asc');
            switch ($request->get('sort_by')) {
                case 'student':
                    $query->join('students', 'payments.student_id', '=', 'students.id')
                          ->orderBy('students.name', $direction)
                          ->select('payments.*');
                    break;
                case 'course':
                    $query->join('courses', 'payments.course_id', '=', 'courses.id')
                          ->orderBy('courses.name', $direction)
                          ->select('payments.*');
                    break;
                case 'date':
                    $query->orderBy('created_at', $direction);
                    break;
            }
        })
        ->paginate(20); // Optional: paginazione

        //dd($payments);

    return view('admin.payments', compact('payments'));
    return view('admin.payments', [
        'payments' => $payments,
        'currentSort' => request('sort'),
        'currentDirection' => request('direction'),
    ]);
}


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
        'year_monthly' => ['exclude_unless:payment_type_id,1', 'required_if:payment_type_id,1', 'digits:4', 'integer', 'min:1900', 'max:2100'],
        'year_annual' => ['exclude_unless:payment_type_id,2', 'required_if:payment_type_id,2', 'digits:4', 'integer', 'min:1900', 'max:2100'],
        'amount' => ['required', 'numeric', 'min:0'],
    ]);

    $studentId = $validated['student_id'];
    $courseId = $validated['course_id'];
    $paymentType = $validated['payment_type_id'];
    $year = $paymentType == 1 ? $validated['year_monthly'] : $validated['year_annual'];

    // 🚫 Controllo duplicati per lo stesso tipo
    $query = Payment::where('student_id', $studentId)
        ->where('course_id', $courseId)
        ->where('payment_type_id', $paymentType)
        ->where('year', $year);

    if ($paymentType == 1) {
        $query->where('month_id', $validated['month']);
    }

    if ($query->exists()) {
        return redirect()->back()->withErrors([
            'duplicate' => 'Esiste già un pagamento di questo tipo per questo studente, corso e anno.',
        ])->withInput();
    }

    // 🔄 Controlli incrociati tra mensile e annuale
    if ($paymentType == 1) {
        // Mensile: non deve esistere già un annuale
        $existsAnnual = Payment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('payment_type_id', 2) // Annuale
            ->where('year', $year)
            ->exists();

        if ($existsAnnual) {
            return redirect()->back()->withErrors([
                'conflict' => 'Non puoi inserire un pagamento mensile per un anno in cui esiste già un pagamento annuale.',
            ])->withInput();
        }
    } elseif ($paymentType == 2) {
        // Annuale: non deve esistere già un mensile
        $existsMonthly = Payment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('payment_type_id', 1) // Mensile
            ->where('year', $year)
            ->exists();

        if ($existsMonthly) {
            return redirect()->back()->withErrors([
                'conflict' => 'Non puoi inserire un pagamento annuale per un anno in cui esistono già pagamenti mensili.',
            ])->withInput();
        }
    }

    // ✅ Se tutto ok, salva
    Payment::create([
        'student_id' => $studentId,
        'course_id' => $courseId,
        'payment_type_id' => $paymentType,
        'month_id' => $validated['month'] ?? null,
        'year' => $year,
        'amount' => $validated['amount'],
    ]);

    return redirect()->back()->with('success', 'Pagamento registrato con successo.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:0.01',
    ]);

    $payment = Payment::find($id);

    if (!$payment) {
        return response()->json(['message' => 'Pagamento non trovato'], 404);
    }

    $payment->amount = $request->input('amount');
    $payment->save();

    return response()->json(['message' => 'Pagamento aggiornato con successo']);
}

public function destroy($id)
{
    $payment = Payment::find($id);

    if (!$payment) {
        return redirect()->back()->with('error', 'Pagamento non trovato.');
    }

    $payment->delete();

    return redirect()->back()->with('success', 'Pagamento eliminato con successo.');
}



}
