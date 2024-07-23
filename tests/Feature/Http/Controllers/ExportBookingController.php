<?php

use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('successfully exports all the bookings in excel format and sends it to the user through mail', closure: function () {
    Excel::fake();

    Str::createUuidsUsing(function () {
        return 'uuid';
    });

    $admin = User::factory()->admin()->create();

    actingAs($admin)->post(route('bookings.export'))->assertRedirect();

    Excel::assertQueued('uuid.xlsx');
    Excel::assertQueuedWithChain([
        new NotifyUserOfCompletedExport($admin, 'uuid.xlsx'),
    ]);
});
