<?php

namespace Tests;

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::listen(DatabaseRefreshed::class, function () {
            $this->artisan('db:seed', ['--class' => RolePermissionSeeder::class]);
            $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }
}
