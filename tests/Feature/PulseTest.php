<?php

use App\Models\User;

it('allows a developer to access the pulse dashboard', function () {
    $developer = User::factory()
        ->developer()
        ->create();

    $response = $this->actingAs($developer)->get('/pulse');

    $response->assertOk();
});

it('does not allow a non-developer to access the pulse dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/pulse');

    $response->assertForbidden();
});
