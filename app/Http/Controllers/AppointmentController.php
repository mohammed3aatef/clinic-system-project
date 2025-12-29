<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Http\Requests\AppointmentRequest;
use App\Notifications\AppointmentStatusNotification;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Appointment::with('patient');

        if ($request->filled('patient_name')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date_time', $request->date);
        }

        $query->orderBy('date_time', 'asc');

        $appointments = $query->paginate(5);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        return view('appointments.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {

        Appointment::create($request->validated());

        return redirect()->route('appointments.index')->with('success', 'The appointment has been added.');
    }

    /**
     * Display the specified resource.
     */

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        return view('appointments.edit', compact('appointment', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {

        $appointment->update($request->validated());

        $message = match ($appointment->status) {
            'done' => 'Your appointment has been successfully confirmed.',
            'canceled' => 'Your appointment has been canceled. Please contact the clinic.',
            default => 'Your appointment has been rescheduled.',
        };

        $appointment->patient->user->notify(new AppointmentStatusNotification($appointment, $message));

        return redirect()->route('appointments.index')->with('info', 'The appointment has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('danger', 'The appointment has been deleted.');
    }

    /**
     * Self-booking.
     */
    public function createForPatient()
    {
        return view('appointments.book');
    }

    public function storeForPatient(Request $request)
    {
        $request->validate([
            'date_time' => 'required|date|after:now',
            'notes'     => 'nullable|string|max:255',
        ]);

        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(403, 'You are not registered as a patient.');
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'date_time'  => $request->date_time,
            'status'     => 'pending',
            'notes'      => $request->notes,
        ]);

        Auth::user()->notify(
            new AppointmentStatusNotification(
                $appointment,
                'Your appointment has been successfully booked and is awaiting confirmation.'
            )
        );

        return redirect()
            ->route('my.appointments')
            ->with('success', 'The appointment has been successfully booked!');
    }

    public function myAppointments()
    {
        $user = request()->user();

        $appointments = Appointment::whereHas('patient', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest()->get();

        return view('appointments.my', compact('appointments'));
    }
}
