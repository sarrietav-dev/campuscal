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
    $this->adminUser = User::factory()->create();
    $this->requesterUser = User::factory()->create();

    $this->adminUser->assignRole(AppRoles::ADMIN);
    $this->requesterUser->assignRole(AppRoles::REQUESTER);
});

it('renders the spaces page correctly', function () {
    $campus = Campus::factory()->hasSpaces(3)->create();

    actingAs($this->adminUser)
        ->get('/campuses/'.$campus->id)
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Campus/Show')
            ->has('spaces', 3, fn (AssertableInertia $page) => $page
                ->has('id')
                ->has('name')
                ->has('image'))
        );
});

it('throws forbidden if a non-admin try to access the page', function () {
    $campus = Campus::factory()->create();

    actingAs($this->requesterUser)
        ->get('/campuses/'.$campus->id)
        ->assertForbidden();
});

it('renders the show space page correctly', function () {
    $campus = Campus::factory()->hasSpaces(3)->create();

    $space = $campus->spaces->first();

    actingAs($this->adminUser)
        ->get(route('spaces.show', ['space' => $space->id]))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Space/Show')
            ->has('space', fn (AssertableInertia $page) => $page
                ->where('id', $space->id)
                ->where('name', $space->name)
                ->where('capacity', $space->capacity)
                ->where('campus_id', $space->campus_id)
                ->has('resources')
                ->has('images')
                ->etc()
            )
        );

});

it('renders the create space page correctly', function () {
    $campus = Campus::factory()->create();

    actingAs($this->adminUser)
        ->get(route('campuses.spaces.create', ['campus' => $campus->id]))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Space/Create')
            ->has('campus')
        );
});

it('creates a space correctly', function () {
    Storage::fake();

    $campus = Campus::factory()->create();

    $file = UploadedFile::fake()->image('image.jpg');

    actingAs($this->adminUser)
        ->post('/campuses/'.$campus->id.'/spaces', [
            'name' => fake()->name,
            'capacity' => fake()->numberBetween(1, 5),
            'images' => [$file],
            'campus_id' => $campus->id,
        ])
        ->assertRedirect(route('campuses.show', ['campus' => $campus->id]))
        ->assertValid();

    Storage::disk()->assertExists($file->hashName());
    expect($campus->spaces()->count())->toBe(1)
        ->and($campus->spaces()->first()->images()->count())
        ->toBe(1);
});

it('creates a space with 3 images', function () {
    Storage::fake();

    $campus = Campus::factory()->create();

    $images = collect(range(1, 3))
        ->map(fn () => UploadedFile::fake()->image('image.jpg'))
        ->all();

    actingAs($this->adminUser)
        ->post('/campuses/'.$campus->id.'/spaces', [
            'name' => fake()->name,
            'capacity' => fake()->numberBetween(1, 5),
            'images' => $images,
            'campus_id' => $campus->id,
        ])
        ->assertRedirect(route('campuses.show', ['campus' => $campus->id]))
        ->assertValid();

    collect($images)->each(fn ($image) => Storage::disk()->assertExists($image->hashName()));

    expect($campus->spaces()->count())
        ->toBe(1)
        ->and($campus->spaces()->first()->images()->count())
        ->toBe(3);
});

it('throws invalid if uploading more than 5 images', function () {
    Storage::fake();

    $campus = Campus::factory()->create();

    $images = collect(range(1, 6))
        ->map(fn () => UploadedFile::fake()->image('image.jpg'))
        ->all();

    actingAs($this->adminUser)
        ->post('/campuses/'.$campus->id.'/spaces', [
            'name' => fake()->name,
            'capacity' => fake()->numberBetween(1, 5),
            'images' => $images,
            'campus_id' => $campus->id,
        ])
        ->assertInvalid(['images']);

    collect($images)->each(fn ($image) => Storage::disk()->assertMissing($image->hashName()));
});

it('throws invalid if a file is not an image', function () {
    Storage::fake();

    $campus = Campus::factory()->create();

    $images = collect(range(1, 3))
        ->map(fn () => UploadedFile::fake()->image('image.jpg'))
        ->all();

    $images[] = UploadedFile::fake()->create('document.pdf');

    actingAs($this->adminUser)
        ->post('/campuses/'.$campus->id.'/spaces', [
            'name' => fake()->name,
            'capacity' => fake()->numberBetween(1, 5),
            'images' => $images,
            'campus_id' => $campus->id,
        ])
        ->assertInvalid(['images.3']);

    collect($images)->each(fn ($image) => Storage::disk()->assertMissing($image->hashName()));
});

it('throws invalid if an image is too big', function () {
    Storage::fake();

    $campus = Campus::factory()->create();

    $image = UploadedFile::fake()->image('image.jpg')->size(3000);

    actingAs($this->adminUser)
        ->post('/campuses/'.$campus->id.'/spaces', [
            'name' => fake()->name,
            'capacity' => fake()->numberBetween(1, 5),
            'images' => [
                $image,
            ],
            'campus_id' => $campus->id,
        ])
        ->assertInvalid(['images.0']);

    Storage::disk()->assertMissing($image->hashName());
});
