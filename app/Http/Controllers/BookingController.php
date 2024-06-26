<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $bookings = Booking::with(
            'requester:id,name,surname,email,booking_id',
        )->select(['id', 'details', 'assistance', 'created_at', 'status'])->get();

        return Inertia::render('Booking/Bookings', [
            'bookings' => $bookings,
        ]);
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
    public function show(Booking $booking): Response
    {
        return Inertia::render('Bookings/Index', [
            'booking' => $booking->load('requester', 'audience', 'appointments'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
