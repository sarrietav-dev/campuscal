<?php

use App\Authorization\AppRoles;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('requesters can authenticate using the login screen', function () {
    $user = User::factory()->create();
    $user->assignRole(AppRoles::REQUESTER);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('bookings.create', absolute: false));
});

test('admins can authenticate using the login screen', function () {
    $user = User::factory()->create();
    $user->assignRole(AppRoles::ADMIN);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
