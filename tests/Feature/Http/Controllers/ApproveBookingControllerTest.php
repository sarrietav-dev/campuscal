<?php

use App\Authorization\AppRoles;
use App\Models\Booking;
use App\Models\User;

it('returns 403 when a user is not an admin and is trying to approve and booking', function () {
    $booking = Booking::factory()->pending()->create();
    $requesterUser = User::factory()->create()->assignRole(AppRoles::REQUESTER);

    $response = $this->actingAs($requesterUser)
        ->patch(route('bookings.approve', $booking));

    $response->assertForbidden();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'pending',
    ]);
});

it('returns conflict when a user is trying to approve a booking that is already approved', function () {
    $booking = Booking::factory()->approved()->create();
    $adminUser = User::factory()->create()->assignRole(AppRoles::ADMIN);

    $response = $this->actingAs($adminUser)
        ->patch(route('bookings.approve', $booking));

    $response->assertConflict();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'approved',
    ]);
});

it('successfully approves a booking when the user is an admin', function () {
    $booking = Booking::factory()->pending()->create();
    $adminUser = User::factory()->create()->assignRole(AppRoles::ADMIN);

    $response = $this->actingAs($adminUser)
        ->patch(route('bookings.approve', $booking));

    $response->assertOk();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'approved',
    ]);
});
