<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Audience;
use App\Models\Booking;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        return Inertia::render('Booking/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $booking = Booking::create($request->safe()->except(['agreement_contract_file']));

        $booking->audience()->attach($validated['audience']);

        $booking->appointments()->createMany(
            collect($validated['appointments'])->map(function ($appointment) {
                return [
                    'space_id' => $appointment['id'],
                    'date_start' => $appointment['date']['start'],
                    'date_end' => $appointment['date']['end'],
                ];
            })->toArray()
        );

        if ($validated['agreement_contract']) {
            $path = $request->file('agreement_contract_file')->store('agreement_contracts', 'public');
            $booking->agreementContracts()->create([
                'url' => Storage::path($path),
            ]);
        }

        $institution = $validated['requester']['institution'];
        if ($validated['requester']['institution'] === -1) {
            $institution = Institution::create([
                'name' => $validated['requester']['new_institution'],
            ]);
        }

        $booking->requester()->create([
            'name' => $validated['requester']['name'],
            'surname' => $validated['requester']['surname'],
            'email' => $validated['requester']['email'],
            'phone' => $validated['requester']['phone'],
            'identification' => $validated['requester']['identification'],
            'company_role' => $validated['requester']['company_role'],
            'academic_unit' => $validated['requester']['academic_unit'],
            'institution_id' => $institution,
        ]);

        Log::info('Booking created', ['booking' => $booking->id, 'requester' => $booking->requester->id]);

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        return Inertia::render('Booking/Create', [
            'institutions' => Institution::get(),
            'audience' => Audience::get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): Response
    {
        return Inertia::render('Booking/Show', [
            'booking' => $booking->load([
                'audience',
                'requester',
                'requester.institution',
                'appointments:id,date_start,date_end,space_id,booking_id',
                'appointments.space:name,id',
                'agreementContracts',
                'appointments.space.images' => function ($query) {
                    $query->select(['url', 'imageable_id'])->limit(1);
                },
            ]),
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
