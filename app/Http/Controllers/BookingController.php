<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Audience;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $bookings = cache()->remember('bookings', 60, function () {
            return Booking::with(
                'requester:id,name,surname,email,booking_id',
            )->select(['id', 'details', 'assistance', 'created_at', 'status'])->get();
        });

        return Inertia::render('Booking/Bookings', [
            'bookings' => $bookings,
        ]);
    }

    public function approveBooking(Request $request, Booking $booking): void
    {
        $validated = $request->validate([
            'observations' => ['string', 'max:255'],
        ]);

        $booking->approve($validated['observations']);
    }

    public function rejectBooking(Request $request, Booking $booking): void
    {
        $validated = $request->validate([
            'observations' => ['string', 'max:255'],
        ]);

        $booking->reject($validated['observations']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = Booking::create($request->safe()->except(['agreement_contract_file']));

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

        $booking->agreementContracts()->create([
            'path' => Storage::url($request->file('agreement_contract_file')->store()),
        ]);

        $booking->requester()->create([
            'name' => $request->requester['name'],
            'surname' => $request->requester['surname'],
            'email' => $request->requester['email'],
            'phone' => $request->requester['phone'],
            'identification' => $request->requester['identification'],
            'company_name' => $request->requester['company_name'],
            'company_role' => $request->requester['company_role'],
            'academic_unit' => $request->requester['academic_unit'],
        ]);

        return redirect()->route('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        return Inertia::render('Booking/CreateBooking', [
            'audience' => Audience::get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): Response
    {
        return Inertia::render('Booking/Show', [
            'booking' => $booking->load(['requester', 'audience', 'appointments:id,date_start,date_end,space_id,booking_id', 'appointments.space:name,id', 'appointments.space.images' => function ($query) {
                $query->select(['path'])->limit(1);
            }, 'agreementContracts']),
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
