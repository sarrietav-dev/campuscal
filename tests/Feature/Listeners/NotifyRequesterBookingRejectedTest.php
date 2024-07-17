<?php

use App\Events\BookingRejected;
use App\Listeners\NotifyRequesterRejectedBooking;
use App\Models\Booking;
use App\Models\Requester;
use App\Notifications\RejectedBooking;
use Illuminate\Events\CallQueuedListener;

it('pushes the event listener to the queue', function () {
    Queue::fake();

    $booking = Booking::factory()->rejected()->create();

    event(new BookingRejected($booking));

    Queue::assertPushed(CallQueuedListener::class, function ($job) {
        return $job->class === NotifyRequesterRejectedBooking::class;
    });
});

it('sends the notification to the requester parties', function () {
    Notification::fake();

    $booking = Booking::factory()->rejected()->has(Requester::factory())->create();
    $listener = new NotifyRequesterRejectedBooking();

    $listener->handle(new BookingRejected($booking));

    Notification::assertSentOnDemand(RejectedBooking::class, function (RejectedBooking $notification, array $channels, object $notifiable) use ($booking) {
        return $notifiable->routes['mail'] === $booking->requester->email;
    });
});
