<?php

use App\Events\BookingApproved;
use App\Listeners\NotifyRequesterBookingApproved;
use App\Models\Booking;
use App\Models\Requester;
use App\Notifications\ApprovedBookingForRequester;
use Illuminate\Events\CallQueuedListener;

it('pushes the event listener to the queue', function () {
    Queue::fake();

    $booking = Booking::factory()->rejected()->create();

    event(new BookingApproved($booking));

    Queue::assertPushed(CallQueuedListener::class, function ($job) {
        return $job->class === NotifyRequesterBookingApproved::class;
    });
});

it('sends the notification to the requester parties', function () {
    Notification::fake();

    $booking = Booking::factory()->rejected()->has(Requester::factory())->create();
    $listener = new NotifyRequesterBookingApproved();

    $listener->handle(new BookingApproved($booking));

    Notification::assertSentOnDemand(ApprovedBookingForRequester::class, function (ApprovedBookingForRequester $notification, array $channels, object $notifiable) use ($booking) {
        return $notifiable->routes['mail'] === $booking->requester->email;
    });
});
