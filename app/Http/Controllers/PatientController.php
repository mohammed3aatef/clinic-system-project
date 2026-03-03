<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Requests\PatientRequest;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $gender = $request->input('gender');

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            })
            ->paginate(5)
            ->appends(['search' => $search, 'gender' => $gender]);

        return view('patients.index', compact('patients', 'search', 'gender'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(PatientRequest $request)
    {

        Patient::create($request->validated());

        return redirect()->route('patients.index')->with('success', 'The Patient has been added.') ;

    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Patient $patient , PatientRequest $request)
    {

        $patient->update($request->validated());

        return to_route('patients.index')
            ->with('info', 'The patient has been updated.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return to_route('patients.index')->with('danger', 'The Patient has been deleted.') ;

    }
}
