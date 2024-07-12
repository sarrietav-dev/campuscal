<?php

use App\Authorization\AppRoles;
use App\Models\Booking;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('successfully rejects a booking when a user is an admin', function () {
    $booking = Booking::factory()->pending()->create();
    $adminUser = User::factory()->create();
    $adminUser->assignRole(AppRoles::ADMIN);

    $response = actingAs($adminUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertOk();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
    ]);
});

it('returns 403 when a user is not an admin and is trying to reject and booking', function () {
    $booking = Booking::factory()->pending()->create();

    $requesterUser = User::factory()->create();
    $requesterUser->assignRole(AppRoles::REQUESTER);
    $response = actingAs($requesterUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertForbidden();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'pending',
    ]);
});

it('returns conflict when a user is trying to reject a booking that is already rejected', function () {
    $booking = Booking::factory()->rejected()->create();
    $adminUser = User::factory()->create();
    $adminUser->assignRole(AppRoles::ADMIN);

    $response = actingAs($adminUser)
        ->patch(route('bookings.reject', $booking));

    $response->assertConflict();
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
    ]);
});
