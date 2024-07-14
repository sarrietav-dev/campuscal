<?php

use App\Authorization\AppRoles;
use App\Models\User;
use App\Notifications\TeamInvite;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;

it('renders the team page correctly when the user is an admin', function () {
    $admin = User::factory()->superAdmin()->create();
    User::factory(3)->admin()->create();
    User::factory(3)->requester()->create();

    $response = actingAs($admin)->get(route('team.index'));

    $response->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Team/Index')
            ->has('roles')
            ->has('users', 4));
});

it('redirects to the dashboard when the admin is not authorized to view the team page', function () {
    $user = User::factory()->admin()->create();

    $response = actingAs($user)->get(route('team.index'));

    $response->assertRedirect(route('dashboard'));
});

it('throws forbidden error when a requester tries to access the team page', function () {
    $requester = User::factory()->requester()->create();

    $response = actingAs($requester)->get(route('team.index'));

    $response->assertForbidden();
});

it('invites a new user to the team by sending them a notification', function () {
    Notification::fake();

    $admin = User::factory()->superAdmin()->create();
    $fakeEmail = fake()->email;

    $response = actingAs($admin)->post(route('team.store'), [
        'email' => $fakeEmail,
        'role' => AppRoles::ADMIN->value,
    ]);

    $response->assertRedirect();
    Notification::assertSentOnDemand(TeamInvite::class, function (TeamInvite $notification, array $channels, object $notifiable) use ($fakeEmail) {
        return $notifiable->routes['mail'] === $fakeEmail;
    });
});

it('throws validation error when the email is not valid', function () {
    $admin = User::factory()->superAdmin()->create();

    $response = actingAs($admin)->post(route('team.store'), [
        'email' => 'invalid-email',
        'role' => AppRoles::ADMIN->value,
    ]);

    $response->assertInvalid('email');
});

it('throws validation error when the role is not valid', function () {
    $admin = User::factory()->superAdmin()->create();

    $response = actingAs($admin)->post(route('team.store'), [
        'email' => fake()->email,
        'role' => 'invalid-role',
    ]);

    $response->assertInvalid('role');
});

it('throws forbidden error when a requester tries to invite a new user to the team', function () {
    $requester = User::factory()->requester()->create();

    $response = actingAs($requester)->post(route('team.store'), [
        'email' => fake()->email,
        'role' => AppRoles::ADMIN->value,
    ]);

    $response->assertForbidden();
});

it('invites an existing user to the team by sending them a notification', function () {
    Notification::fake();

    $admin = User::factory()->superAdmin()->create();
    $existingUser = User::factory()->admin()->create();

    $response = actingAs($admin)->post(route('team.store'), [
        'email' => $existingUser->email,
        'role' => AppRoles::ADMIN->value,
    ]);

    $response->assertRedirect();
    Notification::assertSentOnDemand(TeamInvite::class, function (TeamInvite $notification, array $channels, object $notifiable) use ($existingUser) {
        return $notifiable->routes['mail'] === $existingUser->email;
    });
});

it('successfully updates a user role if logged as super admin', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create();

    $response = actingAs($superAdmin)->put(route('team.update', $admin->id), [
        'role' => AppRoles::REQUESTER->value,
    ]);

    $response->assertRedirect();
    expect($admin->refresh()->hasRole(AppRoles::REQUESTER))->toBeTrue();
});

it('cannot update a user role if logged as a requester', function () {
    $requester = User::factory()->requester()->create();
    $anotherAdmin = User::factory()->admin()->create();

    $response = actingAs($requester)->put(route('team.update', $anotherAdmin->id), [
        'role' => AppRoles::REQUESTER->value,
    ]);

    $response->assertStatus(403);
});

it('cannot update a user role if logged as an admin', function () {
    $admin = User::factory()->admin()->create();
    $anotherAdmin = User::factory()->admin()->create();

    $response = actingAs($admin)->put(route('team.update', $anotherAdmin->id), [
        'role' => AppRoles::REQUESTER->value,
    ]);

    $response->assertRedirect();
});

it('successfully removes a user from the team if logged as an admin', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create();

    $response = actingAs($superAdmin)->delete(route('team.destroy', $admin->id));

    $response->assertRedirect();
    expect($admin->refresh()->hasRole(AppRoles::REQUESTER))->toBeTrue();
});

it('cannot remove a user from the team if logged as a requester', function () {
    $requester = User::factory()->requester()->create();
    $anotherAdmin = User::factory()->admin()->create();

    $response = actingAs($requester)->delete(route('team.destroy', $anotherAdmin->id));

    $response->assertStatus(403);
});

it('cannot remove a developer from the team', function () {
    $superAdmin = User::factory()->superAdmin()->create();
    $developer = User::factory()->developer()->create();

    $response = actingAs($superAdmin)->delete(route('team.destroy', $developer->id));

    $response->assertRedirect();
});

it('cannot remove a user from the team if logged as an admin', function () {
    $admin = User::factory()->admin()->create();
    $anotherAdmin = User::factory()->admin()->create();

    $response = actingAs($admin)->delete(route('team.destroy', $anotherAdmin->id));

    $response->assertRedirect();
});
