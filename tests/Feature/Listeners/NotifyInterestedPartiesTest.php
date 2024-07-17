<?php

use App\Events\BookingApproved;
use App\Listeners\NotifyInterestedParties;
use App\Models\Booking;
use App\Models\InterestedParty;
use App\Notifications\ApprovedBookingForInterestedParties;
use Illuminate\Events\CallQueuedListener;

it('pushes the event listener to the queue', function () {
    Queue::fake();

    $booking = Booking::factory()->approved()->create();

    event(new BookingApproved($booking));

    Queue::assertPushed(CallQueuedListener::class, function ($job) {
        return $job->class === NotifyInterestedParties::class;
    });
});

it('sends the notification to the interested parties', function () {
    Notification::fake();

    InterestedParty::factory(3)->create();
    $booking = Booking::factory()->approved()->create();
    $listener = new NotifyInterestedParties();

    $listener->handle(new BookingApproved($booking));

    Notification::assertSentTimes(ApprovedBookingForInterestedParties::class, 3);
});
