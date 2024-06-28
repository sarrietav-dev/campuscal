<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Audience;
use App\Models\Booking;
use App\Models\SpaceResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
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
    public function create(): Response
    {

        return Inertia::render('Booking/CreateBooking', [
            'audience' => Audience::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = Booking::create($request->validated());

        $booking->audience()->attach($request->audience);

        $booking->appointments()->createMany(
            collect($request->appointments)->map(function ($appointment) {
                return [
                    'space_id' => $appointment['id'],
                    'date_start' => $appointment['date']['start'],
                    'date_end' => $appointment['date']['end'],
                ];
            })->toArray()
        );

        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): Response
    {
        return Inertia::render('Booking/Index', [
            'booking' => $booking->load('requester', 'audience', 'appointments', 'appointments.space', 'appointments.space.images'),
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
