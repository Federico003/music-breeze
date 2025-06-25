<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNotIn('user_type_id', [2, 3])->get(); // Exclude teachers (2) and students (3)
        return view('admin.users', compact('users'));
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
    public function show(User $user)
    {
        //
    }

    public function viewOtherUsers()
    {
        $users = User::whereNotIn('user_type_id', [2, 3])->get(); // Exclude admin (1)
        return view('admin.otherUsers', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        //dd($user);
        return view('admin.editUser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:M,F,X', // Aggiunto 'X' per genere non specificato
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Se la password è stata compilata, la hashiamo e la aggiungiamo ai dati validati
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Se l'email è cambiata rispetto a quella attuale, validiamo l'unicità
        if ($request->input('email') == $user->email) {
            unset($validatedData['email']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Utente modificato con successo.');
    }

    public function print($id){
        try {
            $user = User::findOrFail($id);

            Log::info('Dati del corso:', [
                'name' => $user->name,
                'surname' => $user->surname,
                'birth_date' => $user->birth_date,
                'birth_place' => $user->birth_place,
                'phone' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'city' => $user->city,
                'country' => $user->country,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,                
            ]);
            $pdf = Pdf::loadView('admin.pdf.user', compact('user'));

            return $pdf->download('User.pdf');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Utente eliminato con successo.');
    }
    
}
