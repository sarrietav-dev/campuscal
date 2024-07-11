<?php

use App\Authorization\AppRoles;
use App\Models\Campus;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->seed(RolePermissionSeeder::class);

    $this->user = User::factory()->create();
});

it('renders the campus page when user is', function (AppRoles $roles) {
    $this->user->assignRole($roles);

    $response = $this->actingAs($this->user)->get(route('campuses.index'));

    $response->assertStatus(200);
})->with([
    'admin' => AppRoles::ADMIN,
    'super admin' => AppRoles::SUPER_ADMIN,
]);

it('throws forbidden if the user is not an admin', function () {
    $this->user->assignRole(AppRoles::REQUESTER);

    $response = $this->actingAs($this->user)->get(route('campuses.index'));

    $response->assertForbidden();
});

it('renders the correct amount of campuses', function () {
    Campus::factory(5)->create();
    $this->user->assignRole(AppRoles::ADMIN);

    actingAs($this->user)->get(route('campuses.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Campus/Index')
            ->has('campuses', 5));
});

it('returns with images', function () {
    Campus::factory(5)->hasImages(3)->create();

    $this->user->assignRole(AppRoles::ADMIN);

    actingAs($this->user)->get(route('campuses.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Campus/Index')
            ->has('campuses', 5, fn (AssertableInertia $page) => $page
                ->has('id')
                ->has('name')
                ->has('image')
            ));
});

it('renders the create view correctly', function () {
    $this->user->assignRole(AppRoles::ADMIN);

    actingAs($this->user)->get('/campuses/create')
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Campus/Create'));
});

it('stores a campus correctly', function () {
    Storage::fake();
    $this->user->assignRole(AppRoles::ADMIN);

    $file = UploadedFile::fake()->image('image.jpg');

    actingAs($this->user)->post(route('campuses.store'), [
        'name' => 'Campus',
        'images' => [
            $file,
        ],
    ])->assertValid();

    Storage::disk()->assertExists($file->hashName());
});

it('returns invalid for empty form', function () {
    $this->user->assignRole(AppRoles::ADMIN);

    actingAs($this->user)->post(route('campuses.store'))->assertInvalid();
});

it('returns invalid for more than one image', function () {
    $this->user->assignRole(AppRoles::ADMIN);

    $file = UploadedFile::fake()->image('image.jpg');

    actingAs($this->user)->post(route('campuses.store'), [
        'name' => 'Campus',
        'images' => [
            $file,
            $file,
        ],
    ])->assertInvalid(['images']);
});

it('returns invalid for high mb images', function () {
    $this->user->assignRole(AppRoles::ADMIN);

    $file = UploadedFile::fake()->image('image.jpg')->size(3000);

    actingAs($this->user)->post(route('campuses.store'), [
        'name' => 'Campus',
        'images' => [
            $file,
        ],
    ])->assertInvalid(['images.0']);
});

it('returns invalid for non-image files', function () {
    $this->user->assignRole(AppRoles::ADMIN);

    $file = UploadedFile::fake()->create('document.pdf', 1024);

    actingAs($this->user)->post(route('campuses.store'), [
        'name' => 'Campus',
        'images' => [
            $file,
        ],
    ])->assertInvalid(['images.0']);
});
