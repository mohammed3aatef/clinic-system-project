<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $patientsCount = Patient::count();
        $appointmentsToday = Appointment::whereDate('date_time', Carbon::today())->count();
        $appointmentsUpcoming = Appointment::whereDate('date_time', '>', Carbon::today())->count();
        $prescriptionsToday = Prescription::whereDate('created_at', Carbon::today())->count();

        return view('dashboard.index', compact(
            'patientsCount',
            'appointmentsToday',
            'appointmentsUpcoming',
            'prescriptionsToday'
        ));
    }
}
