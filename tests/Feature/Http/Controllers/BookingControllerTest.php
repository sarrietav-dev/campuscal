<?php

use App\Authorization\AppRoles;
use App\Models\Audience;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->adminUser = User::factory()->create();
    $this->adminUser->assignRole(AppRoles::ADMIN);

    $this->requesterUser = User::factory()->create();
    $this->requesterUser->assignRole(AppRoles::REQUESTER);
});

it('renders the create booking page correctly for all user roles', function (User $user) {
    actingAs($user)->get(route('bookings.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Booking/Create'));
})->with('users provider');

it('successfully creates a new booking with valid data', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audiences = Audience::factory(2)->create();

    $agreementFile = UploadedFile::fake()->create('contract.pdf', 1024, 'application/pdf');

    $booking = bookingData($campuses, $audiences, $agreementFile);
    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), $booking);

    $response->assertValid();
    $response->assertRedirect(route('bookings.create'));
    $this->assertDatabaseHas('bookings', [
        'details' => $booking['details'],
    ]);
});

it('returns invalid when external audience details are missing for an external audience', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audience = Audience::create(['name' => 'external']);

    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), array_merge(
            bookingData($campuses, collect([$audience]), UploadedFile::fake()->create('contract.pdf', 1024, 'application/pdf')),
            ['audience' => [$audience->id]]
        ));

    $response->assertInvalid(['external_audience_details']);
    $this->assertDatabaseCount('bookings', 0);
});

it('returns invalid if the phone number contains non-numeric characters', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audiences = Audience::factory(2)->create();

    $agreementFile = UploadedFile::fake()->create('contract.pdf', 1024, 'application/pdf');

    $booking = bookingData($campuses, $audiences, $agreementFile);
    $booking['requester']['phone'] = '123456789a';

    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), $booking);

    $response->assertInvalid(['requester.phone']);
    $this->assertDatabaseCount('bookings', 0);
});

it('returns invalid for booking creation with invalid email', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audiences = Audience::factory(2)->create();

    $agreementFile = UploadedFile::fake()->create('contract.pdf', 1024, 'application/pdf');

    $booking = bookingData($campuses, $audiences, $agreementFile);
    $booking['requester']['email'] = 'invalid-email';

    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), $booking);

    $response->assertInvalid(['requester.email']);
    $this->assertDatabaseCount('bookings', 0);
});

it('returns invalid for booking creation when the agreement contract file is not a PDF', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audiences = Audience::factory(2)->create();

    $agreementFile = UploadedFile::fake()->create('contract.txt', 1024, 'text/plain');

    $booking = bookingData($campuses, $audiences, $agreementFile);

    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), $booking);

    $response->assertInvalid(['agreement_contract_file']);
    $this->assertDatabaseCount('bookings', 0);
});

it('returns invalid for booking creation with invalid requester identification', function () {
    Storage::fake();

    $campuses = Campus::factory(2)->hasSpaces(2)->create();
    $audiences = Audience::factory(2)->create();

    $agreementFile = UploadedFile::fake()->create('contract.pdf', 1024, 'application/pdf');

    $booking = bookingData($campuses, $audiences, $agreementFile);
    $booking['requester']['identification'] = 'invalid-identification';

    $response = actingAs($this->requesterUser)
        ->post(route('bookings.store'), $booking);

    $response->assertInvalid(['requester.identification']);
    $this->assertDatabaseCount('bookings', 0);
});

function bookingData($campuses, $audiences, $agreementFile): array
{
    return [
        'details' => fake()->sentence(),
        'assistance' => 2,
        'minors' => false,
        'audience' => $audiences->pluck('id')->toArray(),
        'agreement_contract' => true,
        'agreement_contract_file' => $agreementFile,
        'appointments' => [
            [
                'id' => $campuses->first()->spaces->first()->id,
                'date' => [
                    'start' => now()->addDay()->format('Y-m-d H:i:s'),
                    'end' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
                ],
            ],
            [
                'id' => $campuses->last()->spaces->last()->id,
                'date' => [
                    'start' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
                    'end' => now()->addDay()->addHour()->addHour()->format('Y-m-d H:i:s'),
                ],
            ],
        ],
        'requester' => [
            'name' => fake()->name(),
            'surname' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->numberBetween(1, 9999999999),
            'identification' => fake()->numberBetween(1, 9999999999),
            'institution' => \App\Models\Institution::factory()->create()->id,
            'company_role' => fake()->jobTitle(),
            'academic_unit' => fake()->company(),
        ],
    ];
}

dataset('users provider', function () {
    yield fn () => $this->adminUser;
    yield fn () => $this->requesterUser;
});
