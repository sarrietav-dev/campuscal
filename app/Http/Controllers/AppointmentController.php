<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use function Pest\Laravel\json;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        $appointments = Appointment::whereMonth('date_start', $month)
            ->whereYear('date_start', $year)
            ->with(['booking'])
            ->get();

        return response()->json($appointments);
    }
}
