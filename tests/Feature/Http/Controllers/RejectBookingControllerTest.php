<?php

use App\Authorization\AppRoles;
use App\Events\BookingRejected;
use App\Models\Booking;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->adminUser = User::factory()->create();
    $this->adminUser->assignRole(AppRoles::ADMIN);

    $this->requesterUser = User::factory()->create();
    $this->requesterUser->assignRole(AppRoles::REQUESTER);
});

it('successfully rejects a booking when a user is an admin', function () {
    Event::fake();

    $booking = Booking::factory()->pending()->create();

    $response = actingAs($this->adminUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertOk();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
    ]);
});

it('returns 403 when a user is not an admin and is trying to reject and booking', function () {
    $booking = Booking::factory()->pending()->create();

    $response = actingAs($this->requesterUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertForbidden();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'pending',
    ]);
});

it('returns conflict when a user is trying to reject a booking that is already rejected', function () {
    $booking = Booking::factory()->rejected()->create();

    $response = actingAs($this->adminUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertConflict();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
    ]);
});

it('dispatches BookingRejected event when a booking is rejected', function () {
    Event::fake();

    $booking = Booking::factory()->pending()->create();

    $this->actingAs($this->adminUser)
        ->patch(route('bookings.reject', $booking));

    Event::assertDispatched(BookingRejected::class);
});
