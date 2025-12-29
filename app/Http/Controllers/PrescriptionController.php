<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Http\Requests\PrescriptionRequest;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'appointment']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $prescriptions = $query->latest()->paginate(5)->appends(
            $request->only(['search', 'patient_id', 'date'])
        );

        $patientsForFilter = \App\Models\Patient::select('id', 'name')->orderBy('name')->get();

        $search = $request->input('search', null);
        $patient_id = $request->input('patient_id', null);
        $date = $request->input('date', null);

        return view('prescriptions.index', compact(
            'prescriptions',
            'patientsForFilter',
            'search',
            'patient_id',
            'date'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'done')->get();
        $medicines = Medicine::all();

        return view('prescriptions.create', compact('patients', 'appointments', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'doctor_notes' => $request->doctor_notes,
        ]);

        if ($request->filled('medicines')) {
            $toAttach = [];
            foreach ($request->medicines as $id => $m) {
                if (!isset($m['selected'])) continue;
                $toAttach[$id] = [
                    'dosage' => $m['dosage'],
                    'duration' => $m['duration'],
                ];
            }
            if ($toAttach) $prescription->medicines()->attach($toAttach);
        }

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription Created Successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescription = Prescription::with('patient')->findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prescription = Prescription::findOrFail($id);
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'done')->get();
        $medicines = Medicine::all();

        return view('prescriptions.edit', compact('prescription', 'patients', 'appointments', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $prescription->update([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'doctor_notes' => $request->doctor_notes,
        ]);

        $sync = [];
        if ($request->filled('medicines')) {
            foreach ($request->medicines as $id => $m) {
                if (!isset($m['selected'])) continue;
                $sync[$id] = [
                    'dosage' => $m['dosage'],
                    'duration' => $m['duration'],
                ];
            }
        }
        $prescription->medicines()->sync($sync);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return to_route('prescriptions.index')
            ->with('danger', 'The prescription has been deleted.');
    }

    /**
     * Print.
     */
    public function print(Prescription $prescription)
    {
        $prescription->load('patient', 'appointment', 'medicines');
        return view('prescriptions.show', compact('prescription'));
    }
}
